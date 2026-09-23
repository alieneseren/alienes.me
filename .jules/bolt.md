## 2024-09-24 - Layout Check Optimizations
**Learning:** Using `count() > 0` on Eloquent models directly in layout files creates a `SELECT count(*) FROM table` query which is less efficient than `exists()` which creates `SELECT 1 FROM table LIMIT 1`. Also, using `count() > 0` on Eloquent collections in views is slightly slower than `isNotEmpty()`.
**Action:** Replace `Model::count() > 0` with `Model::exists()` for layout-level boolean checks and `$collection->count() > 0` with `$collection->isNotEmpty()` in view files.
