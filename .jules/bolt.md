## 2025-02-18 - Model Event Based Cache Invalidation
**Learning:** When using `Cache::rememberForever` in controllers, it's crucial to tie cache invalidation to Eloquent's `saved` and `deleted` model events rather than creating complex manual flushing rules or using unsupported cache tags in file drivers.
**Action:** Always bind cache clearing functions to model events in a central service provider (`AppServiceProvider`) so that any modifications (via admin panels or elsewhere) automatically clear stale public-facing cache keys, ensuring high read performance without risking outdated data.
