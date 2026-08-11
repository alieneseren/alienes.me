## 2024-08-11 - Optimize Blade View Database Checks
**Learning:** Checking for model existence in Blade views using `Model::count() > 0` directly runs a `SELECT COUNT(*)` query, which is inefficient for a simple existence check. Furthermore, calling `$collection->count() > 0` on an already loaded collection is suboptimal compared to `$collection->isNotEmpty()`.
**Action:** Replace `Model::count() > 0` with `Model::exists()` for database-level checks (to utilize `LIMIT 1`), and replace `$collection->count() > 0` with `$collection->isNotEmpty()` for memory-level checks to enhance performance.
