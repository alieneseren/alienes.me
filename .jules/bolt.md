## 2024-11-10 - [Optimization: Replace count() > 0 with exists() in Blade Layouts]
**Learning:** Checking for records existence with `count() > 0` results in SQL `SELECT count(*) FROM table`, executing a full index or table scan depending on conditions. `exists()` results in `SELECT exists(SELECT * FROM table LIMIT 1)` causing early query exit and significantly faster results. Specifically, `layouts/frontend.blade.php` has a few `count() > 0` directly fetching from DB.
**Action:** Replace `count() > 0` with `exists()` for static UI database checks where only presence needs to be verified.
