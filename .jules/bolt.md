## 2024-05-18 - count() > 0 vs exists()
**Learning:** Using `count() > 0` on Eloquent models in Blade templates executes a `SELECT COUNT(*)` query, counting all records in the table. This is unnecessarily slow when we only need to check if ANY record exists.
**Action:** Always use `exists()` instead of `count() > 0` when checking if a database table contains records to improve performance and avoid counting thousands of rows, as `exists()` executes `SELECT EXISTS(SELECT * ...)` which is much faster. Also use `isNotEmpty()` on collections instead of `count() > 0`.
