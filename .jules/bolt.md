## 2026-05-30 - SQLite Migration Conflicts
**Learning:** Standard fresh database migrations may fail during local setup due to conflicting migration scripts (e.g. duplicate `projects` table creation).
**Action:** When testing database-dependent code locally, bypass the full migration suite by defining required tables manually via `Schema::create` within a temporary PHP test script.
