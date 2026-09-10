## 2025-02-23 - Use exists() instead of count() > 0 for checking if models exist
**Learning:** Using `count() > 0` queries the database to count all records, whereas `exists()` uses a `LIMIT 1` query which is significantly faster for simple existence checks.
**Action:** Replace `Model::count() > 0` with `Model::exists()` in Blade layout templates (e.g., `resources/views/layouts/frontend.blade.php`) and controllers to improve performance by skipping full table scans.
