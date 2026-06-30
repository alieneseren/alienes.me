## 2026-06-30 - [In-memory SQLite for Cache Invalidaton Testing]
**Learning:** [When standard test frameworks are missing and migration scripts fail, using an in-memory SQLite database dynamically via Schema::create within a temporary PHP script (like test_cache.php) is a highly reliable way to assert Laravel cache invalidation logic.]
**Action:** [Always bootstrap Laravel and manually create only the required schemas in-memory when testing database-dependent features locally without PHPUnit.]
