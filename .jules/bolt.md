## 2023-11-20 - [Eloquent Collection Check Optimization in Blade]
**Learning:** Checking for elements in an Eloquent collection loaded in memory via `$collection->count() > 0` is less efficient and readable than `$collection->isNotEmpty()`. Similarly, running `count() > 0` on Eloquent Models like `Model::count() > 0` triggers a `SELECT count(*)` whereas `Model::exists()` correctly translates to `SELECT 1 LIMIT 1`.
**Action:** Always prefer `isNotEmpty()` for Collections in Blade views and `exists()` for database presence checks instead of using `count() > 0`.
