# Online Lecture Platform — Student Support System

A Laravel 10 + Tailwind CSS lecture platform with 4 role dashboards (Admin, Instructor, Student, Support Staff), a fully normalized MySQL schema, and end-to-end CRUD for every module.

## Features

**Auth & users**
- Login, register, forgot/reset password
- New accounts require admin approval before sign-in (`approved` middleware)
- Profile editing, password change, avatar upload
- Roles, permissions, `role:` and `permission:` middleware, seeders
- Activity logging on every write request

**Admin**
- Dashboard with live stats, Chart.js enrollment/ticket charts, recent activity feed
- User management (create, approve, suspend, assign roles)
- Course & course-category CRUD, manual enroll/unenroll
- Announcements CRUD, Roles & permissions management
- Support ticket queue — assign, view
- Reports (PDF via barryvdh/laravel-dompdf, Excel via maatwebsite/excel) with download
- Settings, activity logs, DB backup & restore

**Instructor**
- Dashboard with course/assignment/submission stats
- Course management (edit courses, manage enrollments)
- Lecture material uploads (PDF/DOC/PPT/video) and **course modules** — organize lessons into structured course content
- Assignment CRUD, view submissions, grade & give feedback
- Student progress analytics

**Student**
- Dashboard with upcoming work and recent grades
- Course catalog with enroll/unenroll, module-based course content with lecture browsing & file download
- Mark lessons **complete/incomplete** with live course and per-module progress lines
- Assignment submission (file upload, late/editable), grade book
- Academic progress charts
- Support tickets (create, track, close)

**Support Staff**
- Ticket queue, assign to self, respond, update status

**Shared**
- Messaging inbox/sent/attachments
- Notifications (mark read)
- Global search across courses, students, instructors, assignments, lectures

## Setup (XAMPP / local)

```bash
composer install
npm install
cp .env.example .env
php artisan key:generate
# Create a MySQL database named lecture_platform (or edit .env)
php artisan migrate
php artisan db:seed
php artisan storage:link
npm run build   # or `npm run dev` while developing
php artisan serve
```

Default admin login after seeding:
- **Email:** admin@lectureplatform.com
- **Password:** Password123!

## Project structure

```
app/
  Models/                  # 22 Eloquent models, all relationships defined
  Http/
    Controllers/
      Admin/               # Dashboard, User, Course, CourseCategory, Announcement,
                           # Role, SupportTicket, Report, Setting
      Instructor/          # Dashboard, LectureMaterial, Assignment, StudentProgress
      Student/             # Dashboard, AssignmentSubmission, SupportTicket
      SupportStaff/        # Dashboard, Ticket
      Auth/                # Login, Register (incl. forgot/reset)
      CourseController, MessageController, NotificationController,
      ProfileController, SearchController
    Middleware/
      RoleMiddleware.php       # role:admin,instructor style route guards
      PermissionMiddleware.php
      EnsureUserIsApproved.php # blocks pending accounts
      LogActivity.php          # writes to activity_logs on every write request
database/
  migrations/               # all 20 tables, fully normalized, FKs + soft deletes
  seeders/                  # roles, permissions, support categories, admin user
routes/web.php              # every route grouped by role + middleware
resources/views/
  layouts/app.blade.php     # shared shell: sidebar, topbar, notifications, search
  layouts/nav/*.blade.php   # per-role sidebar menus
  admin/                    # full admin module views
  instructor/               # full instructor module views
  student/                  # full student module views
  support/                  # full support-staff views
  messages/, notifications/, profile/, search/
  auth/*.blade.php          # login, register, forgot/reset, approval notice
tailwind.config.js          # your exact color tokens + radii
```

## Design tokens

| Token | Value |
|---|---|
| Primary | `#1B4332` |
| Secondary | `#40916C` |
| Background | `#B7E4C7` |
| Cards | White, `16px` radius |
| Buttons | `12px` radius |
| Icons | Heroicons (inlined as Blade partial, no extra dependency) |
| Charts | Chart.js |

## Tests

```bash
php artisan test
```

## Next steps

1. Run the setup above to confirm migrations and dashboards render correctly.
2. Add feature tests for each module (currently only the default Laravel examples exist).
3. Seed richer demo data (courses, students, submissions) to exercise the dashboards.
