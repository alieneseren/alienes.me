## 2026-05-20 - Cache Invalidation without Cache Tags
**Learning:** The default caching system in this repository is 'file', which does not support cache tags. Attempting to use tags will result in exceptions.
**Action:** Always use simple string keys (e.g., `home.data`) for caching and invalidate them manually using `Cache::forget()` via Eloquent model events (like `saved` and `deleted`) in `AppServiceProvider::boot()`.
