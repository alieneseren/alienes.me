
## 2024-05-18 - Replacing count() with exists() for Existence Checks
**Learning:** Checking existence in Laravel views using `count() > 0` directly on an Eloquent model executes a `SELECT COUNT(*)` query. This forces the database to count all matching rows, which is slow for large tables. Using `exists()` compiles into a much more efficient `SELECT EXISTS(...)` or `LIMIT 1` query. This is particularly important when evaluating model existence globally on every page (like in `resources/views/layouts/frontend.blade.php`).
**Action:** When checking if at least one record exists in the database for rendering layout sections, always use `exists()` instead of `count() > 0`.
