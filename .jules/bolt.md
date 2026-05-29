
## 2025-05-29 - SQLite Migration Failures with Existing Tables
**Learning:** Running `php artisan migrate:fresh` on a locally created SQLite database can sometimes fail if tables already exist and the migration throws a "table already exists" exception (e.g. `projects` table) or if a migration fails halfway.
**Action:** When manually testing and migrating SQLite in this codebase, if `migrate:fresh --force` fails due to existing tables or missing columns, you may need to recreate the `database.sqlite` file completely using `rm -f database/database.sqlite && touch database/database.sqlite` and then rerun the migration, or gracefully handle existing data via `DB::table(...)->insertOrIgnore(...)` or manual table alterations during test scripts instead of depending solely on migrations.
