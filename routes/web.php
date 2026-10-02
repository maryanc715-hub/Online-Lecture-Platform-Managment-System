<?php

use App\Http\Controllers\Admin\AnnouncementController as AdminAnnouncementController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\SupportTicketController as AdminSupportTicketController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\Instructor\AssignmentController as InstructorAssignmentController;
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;
use App\Http\Controllers\Instructor\LectureMaterialController;
use App\Http\Controllers\Instructor\LectureModuleController;
use App\Http\Controllers\Instructor\LiveSessionController as InstructorLiveSessionController;
use App\Http\Controllers\Instructor\StudentController as InstructorStudentController;
use App\Http\Controllers\Instructor\StudentProgressController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\Student\AssignmentSubmissionController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Student\LiveSessionController as StudentLiveSessionController;
use App\Http\Controllers\Student\SupportTicketController as StudentSupportTicketController;
use App\Http\Controllers\SupportStaff\DashboardController as SupportDashboardController;
use App\Http\Controllers\SupportStaff\TicketController as SupportTicketController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public / Guest
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('dashboard')
        : redirect()->route('login');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store']);
    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/forgot-password', [LoginController::class, 'forgotPassword'])->name('password.request');
    Route::post('/forgot-password', [LoginController::class, 'sendResetLink'])->name('password.email');
    Route::get('/reset-password/{token}', [LoginController::class, 'resetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [LoginController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Authenticated - shared across all roles
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/approval', fn () => view('auth.approval'))->name('approval.notice');
});

Route::middleware(['auth', 'approved'])->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');
    Route::post('/profile/avatar', [ProfileController::class, 'updateAvatar'])->name('profile.avatar');

    Route::get('/messages', [MessageController::class, 'index'])->name('messages.index');
    Route::post('/messages', [MessageController::class, 'store'])->name('messages.store');
    Route::get('/messages/{message}', [MessageController::class, 'show'])->name('messages.show');
    Route::get('/messages/{message}/attachment', [MessageController::class, 'downloadAttachment'])->name('messages.attachment');

    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markRead'])->name('notifications.read');

    Route::get('/search', [SearchController::class, 'index'])->name('search');

    // Route by role after login
    Route::get('/dashboard', function () {
        return match (auth()->user()->role->name) {
            'admin' => redirect()->route('admin.dashboard'),
            'instructor' => redirect()->route('instructor.dashboard'),
            'student' => redirect()->route('student.dashboard'),
            'support_staff' => redirect()->route('support.dashboard'),
        };
    })->name('dashboard');
});

/*
|--------------------------------------------------------------------------
| ADMIN MODULE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'approved', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::resource('users', UserController::class);
    Route::post('users/{user}/approve', [UserController::class, 'approve'])->name('users.approve');
    Route::resource('course-categories', CourseCategoryController::class);
    Route::resource('courses', CourseController::class);
    Route::post('courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::post('courses/{course}/unenroll', [CourseController::class, 'unenroll'])->name('courses.unenroll');
    Route::resource('announcements', AdminAnnouncementController::class);
    Route::resource('roles', RoleController::class);

    Route::get('support-tickets', [AdminSupportTicketController::class, 'index'])->name('tickets.index');
    Route::get('support-tickets/{ticket}', [AdminSupportTicketController::class, 'show'])->name('tickets.show');
    Route::post('support-tickets/{ticket}/assign', [AdminSupportTicketController::class, 'assign'])->name('tickets.assign');

    Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
    Route::post('reports/generate', [AdminReportController::class, 'generate'])->name('reports.generate');
    Route::get('reports/{report}/download', [AdminReportController::class, 'download'])->name('reports.download');

    Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
    Route::put('settings', [SettingController::class, 'update'])->name('settings.update');

    Route::get('logs', [AdminDashboardController::class, 'logs'])->name('logs');
    Route::get('backup', [AdminDashboardController::class, 'backup'])->name('backup');
    Route::post('backup/run', [AdminDashboardController::class, 'runBackup'])->name('backup.run');
    Route::post('backup/restore', [AdminDashboardController::class, 'restore'])->name('backup.restore');
});

/*
|--------------------------------------------------------------------------
| INSTRUCTOR MODULE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'approved', 'role:instructor'])->prefix('instructor')->name('instructor.')->group(function () {
    Route::get('/dashboard', [InstructorDashboardController::class, 'index'])->name('dashboard');

    Route::resource('students', InstructorStudentController::class);
    Route::post('students/{student}/approve', [InstructorStudentController::class, 'approve'])->name('students.approve');

    Route::resource('courses', CourseController::class)->only(['index', 'show', 'edit', 'update']);
    Route::post('courses/{course}/enroll', [CourseController::class, 'enroll'])->name('courses.enroll');
    Route::post('courses/{course}/unenroll', [CourseController::class, 'unenroll'])->name('courses.unenroll');
    Route::resource('lectures', LectureMaterialController::class);
    Route::resource('modules', LectureModuleController::class);
    Route::resource('assignments', InstructorAssignmentController::class);

    Route::get('assignments/{assignment}/submissions', [InstructorAssignmentController::class, 'submissions'])->name('assignments.submissions');
    Route::post('submissions/{submission}/grade', [InstructorAssignmentController::class, 'grade'])->name('submissions.grade');
    Route::get('submissions/{submission}/download', [InstructorAssignmentController::class, 'downloadSubmission'])->name('submissions.download');

    Route::get('live-sessions', [InstructorLiveSessionController::class, 'index'])->name('live-sessions.index');
    Route::get('live-sessions/create', [InstructorLiveSessionController::class, 'create'])->name('live-sessions.create');
    Route::post('live-sessions', [InstructorLiveSessionController::class, 'store'])->name('live-sessions.store');
    Route::get('live-sessions/{session}', [InstructorLiveSessionController::class, 'show'])->name('live-sessions.show');
    Route::get('live-sessions/{session}/edit', [InstructorLiveSessionController::class, 'edit'])->name('live-sessions.edit');
    Route::put('live-sessions/{session}', [InstructorLiveSessionController::class, 'update'])->name('live-sessions.update');
    Route::post('live-sessions/{session}/start', [InstructorLiveSessionController::class, 'start'])->name('live-sessions.start');
    Route::get('live-sessions/{session}/join', [InstructorLiveSessionController::class, 'join'])->name('live-sessions.join');
    Route::post('live-sessions/{session}/end', [InstructorLiveSessionController::class, 'end'])->name('live-sessions.end');
    Route::post('live-sessions/{session}/cancel', [InstructorLiveSessionController::class, 'cancel'])->name('live-sessions.cancel');
    Route::delete('live-sessions/{session}', [InstructorLiveSessionController::class, 'destroy'])->name('live-sessions.destroy');

    Route::get('progress', [StudentProgressController::class, 'index'])->name('progress.index');
    Route::get('progress/{student}', [StudentProgressController::class, 'show'])->name('progress.show');
});

/*
|--------------------------------------------------------------------------
| STUDENT MODULE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'approved', 'role:student'])->prefix('student')->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    Route::get('courses', [StudentDashboardController::class, 'courses'])->name('courses.index');
    Route::get('courses/{course}', [StudentDashboardController::class, 'showCourse'])->name('courses.show');
    Route::post('courses/{course}/enroll', [StudentDashboardController::class, 'enroll'])->name('courses.enroll');
    Route::post('courses/{course}/unenroll', [StudentDashboardController::class, 'unenroll'])->name('courses.unenroll');
    Route::get('lectures/{material}/download', [StudentDashboardController::class, 'downloadLecture'])->name('lectures.download');
    Route::post('lectures/{material}/complete', [StudentDashboardController::class, 'completeLesson'])->name('lectures.complete');
    Route::delete('lectures/{material}/complete', [StudentDashboardController::class, 'uncompleteLesson'])->name('lectures.uncomplete');

    Route::get('assignments', [AssignmentSubmissionController::class, 'index'])->name('assignments.index');
    Route::get('assignments/{assignment}', [AssignmentSubmissionController::class, 'show'])->name('assignments.show');
    Route::post('assignments/{assignment}/submit', [AssignmentSubmissionController::class, 'store'])->name('assignments.submit');
    Route::get('assignments/{assignment}/submission/download', [AssignmentSubmissionController::class, 'download'])->name('assignments.submission.download');

    Route::get('grades', [AssignmentSubmissionController::class, 'grades'])->name('grades.index');
    Route::get('progress', [StudentDashboardController::class, 'progress'])->name('progress.index');

    Route::resource('support-tickets', StudentSupportTicketController::class)->only(['index', 'create', 'store', 'show'])
        ->parameters(['support-tickets' => 'ticket']);
    Route::post('support-tickets/{ticket}/close', [StudentSupportTicketController::class, 'close'])->name('support-tickets.close');

    Route::get('live-sessions', [StudentLiveSessionController::class, 'index'])->name('live-sessions.index');
    Route::get('live-sessions/{session}', [StudentLiveSessionController::class, 'show'])->name('live-sessions.show');
    Route::get('live-sessions/{session}/join', [StudentLiveSessionController::class, 'join'])->name('live-sessions.join');
});

/*
|--------------------------------------------------------------------------
| SUPPORT STAFF MODULE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'approved', 'role:support_staff'])->prefix('support')->name('support.')->group(function () {
    Route::get('/dashboard', [SupportDashboardController::class, 'index'])->name('dashboard');

    Route::get('tickets', [SupportTicketController::class, 'index'])->name('tickets.index');
    Route::get('tickets/{ticket}', [SupportTicketController::class, 'show'])->name('tickets.show');
    Route::post('tickets/{ticket}/respond', [SupportTicketController::class, 'respond'])->name('tickets.respond');
    Route::post('tickets/{ticket}/status', [SupportTicketController::class, 'updateStatus'])->name('tickets.status');
    Route::post('tickets/{ticket}/assign-self', [SupportTicketController::class, 'assignSelf'])->name('tickets.assign-self');
});
