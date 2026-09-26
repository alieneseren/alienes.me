## 2026-09-26 - Eloquent count() vs exists()
**Learning:** Checking model existence via `count() > 0` is a common anti-pattern in Laravel which compiles to `select count(*) from table`, scanning the entire table/index. For simple existence checks (like rendering layout menus), this is unnecessarily slow.
**Action:** Always use `exists()` instead of `count() > 0` when checking for record presence, as it utilizes a `LIMIT 1` query, completing much faster by returning immediately upon the first match.
