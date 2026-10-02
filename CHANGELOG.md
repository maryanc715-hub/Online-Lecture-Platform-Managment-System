# Changelog

## 2026-09-15

### Added
- Live Sessions feature: instructors schedule real-time Jitsi video lectures per course; students browse and join sessions for enrolled courses.
- `live_sessions` table (migration `2026_09_15_000001`): course + instructor FKs (cascade delete), title, description, `scheduled_at`, `duration_minutes`, unique `jitsi_room_id` (auto-generated from title + random suffix), `status` enum (`scheduled|live|completed|cancelled`), and `started_at`/`ended_at` tracking.
- `App\Models\LiveSession` with `course`/`instructor` relationships, `isUpcoming()`/`isLive()` helpers, and `jitsiUrl()`; room/session helpers on `Course::liveSessions()` and `User::liveSessionsConducted()`.
- `Instructor\LiveSessionController`: full CRUD (`instructor.live-sessions.*`) with course-ownership checks, plus `start`, `end`, `cancel`, and `join` actions; notifies all enrolled students when a session is scheduled.
- `Student\LiveSessionController`: index/show/join (`student.live-sessions.*`) with course-enrollment authorization; join gated to live/scheduled-past sessions.
- Instructor + student views: list (search + course/status filters), create/edit forms (`datetime-local` start + duration), detail pages with live status + countdown, and Jitsi Meet embed rooms via the External API (`config/services.php` → `services.jitsi`, `JITSI_SERVER` env).
- Nav items: "Live Sessions" in both instructor and student sidebars (`video` icon).
- Dashboard widgets: upcoming/live sessions on instructor and student dashboards with join links; live sessions highlighted with a pulsing red banner.
- Flash message support for `error` and `warning` keys in the shared layout (`layouts/app.blade.php`).

### Changed
- `database/lecture_platform_schema.sql` regenerated from the live database.
- Frontend assets rebuilt (`public/build/assets/app-Bvk7fGIM.css`).

## 2026-08-06

### Added
- Lecture modules (`lecture_modules` table, migration batch 5) with title, description, sort order; `module_id` + `sort_order` columns added to `lecture_materials`.
- Lecture completions (`lecture_completions` table) tracking per-student lesson completion; `StudentProgress` recalculated on every toggle.
- Instructor module CRUD: `Instructor\LectureModuleController` with course-ownership checks, `instructor.modules.*` routes, and module index/create/edit/show views.
- Lecture material form module select with course-aware filtering (`getModules()` / `resolveModule()` in `Instructor\LectureMaterialController`).
- "Course Modules" nav item (instructor) with `menu` icon.
- Chevron icons (`chevron-down`, `chevron-right`) to `layouts/nav/icon.blade.php`.

### Changed
- Lecture Materials: replaced the `slides` type with `notes` (enum swap, migration `2026_08_06_000004`); existing `slides` records converted to `notes`.
- Added `notes` text column + Notes textarea on the create/edit lecture forms (shown only when Type = Notes).
- Student lesson rows render a Notes block (`whitespace-pre-wrap`) for note-type materials.
- Student course page (`student/courses/show.blade.php`) rewritten with a course progress line, per-module progress bars, and module-grouped lesson lists.
- Lessons render via reusable `student/partials/lesson-row.blade.php` (complete/incomplete toggle, lazy-load video iframe, download links).
- Modules are collapsible: clicking the header toggles `hidden` on `#module-lessons-{id}` and rotates the chevron.
- Collapsing a module now pauses `<video>` playback, unloads open YouTube/Vimeo iframes, hides the open player, and hides the module progress line; expanding restores it.
- Instructor course show includes a "Course Content" module block with module labels on lecture materials.
- Instructor lecture show/index display the module column.
- Instructor index pages unified with the "My Courses" design: shared search/filter bar (search icon + dropdown + Filter button) in the card header, consistent table rows (hover state, pill action buttons), pagination below the card.
  - **Lecture Materials**: added search (title/course) + type filter.
  - **Course Modules**: converted from card list to the shared table design (Module / Course / Sort / Lessons / Actions) with search + course filter.
  - **My Assignments**: added search (title/course) + status filter.
  - **Student Progress**: added student name/email search; switched from `->get()` to pagination (15/page).
- Assignments: added a `sort_order` column (migration `2026_08_06_000005`) with an **Order** input on the create/edit forms; the assignments list now sorts by `sort_order` (falling back to newest) and shows an Order column; new assignments default to `max(sort_order)+1`.
- Student "Submit Your Work" file input restyled to match the instructor upload forms (`file:bg-secondary/10 file:text-secondary hover:file:bg-secondary/20` pill button).
- Applied the same styled file input to every upload across the app (profile avatar, message attachments, course thumbnails, admin backup restore, student submissions, lecture materials) — all 9 file inputs now share one design.
- Admin "Run Backup Now" now actually runs `mysqldump` (via `shell_exec`, auto-locating the XAMPP binary) and downloads the database as a timestamped `.sql` file instead of just logging a stub event.
- Frontend assets rebuilt (`public/build/assets/app-D0ob7_E3.css`) with `rotate-180`, `transition-transform`, `group-hover`, `bg-emerald-100`, `text-emerald-800`, `bg-red-50`, and `hover:bg-red-100` utilities.
- `database/lecture_platform_schema.sql` regenerated from the live database.

### Fixed
- Lecture material file downloads: files were being stored under a nested `public/lectures/` path but downloads/links looked under `lectures/`, so every download 404'd. Storage now uses `storeAs('lectures', $filename, 'public')`; existing files moved to the correct location; delete/update paths use `Storage::disk('public')`.
- Download filenames sanitized via `Str::slug` (titles containing `:` or other Windows-invalid characters no longer break downloads).
- Video iframes stay `data-src`-lazy until first opened (no pre-rendered black frame).

### Known issues
- Pre-existing: `tests/Feature/ExampleTest.php` `the application returns a successful response` fails (GET `/` returns 404; app routes to login/dashboard). Unrelated to these changes.
