## 2025-01-20 - Eloquent Collection vs Query Builder Optimization
**Learning:** Checking for records existence in layout files using `count() > 0` directly on the Eloquent model (`\App\Models\Model::count() > 0`) executes a `SELECT count(*) FROM table` query. While functionally correct, it forces the database to scan/count all rows.
**Action:** Replace `\App\Models\Model::count() > 0` with `\App\Models\Model::exists()` in Blade layout files where only the existence of records is needed, as `exists()` generates a faster `SELECT exists(select * from table) as "exists"` or `LIMIT 1` query.
