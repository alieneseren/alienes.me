## 2024-05-04 - [Global Layout Cache]
**Learning:** Each page load was running 5+ synchronous database queries via Blade layouts just to check for empty tables or get global profiles.
**Action:** When working with global app layouts in Laravel, always cache the results and invalidate through model events, rather than raw inline queries, to save up to 5 db hits.
