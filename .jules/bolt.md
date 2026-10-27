
## 2025-02-12 - Layout Query Optimization
**Learning:** Checking for the existence of records (e.g., to conditionally render layout sections) using Eloquent's `count() > 0` causes the database to count all rows. Replacing it with `exists()` utilizes a `LIMIT 1` query which is significantly faster and more memory-efficient.
**Action:** When conditionally rendering layout sections based on whether ANY records exist in a table, use `exists()` instead of `count() > 0`.
