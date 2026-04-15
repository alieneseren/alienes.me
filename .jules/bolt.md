## 2026-04-15 - [Cache Driver Limitations in Production Environments]
**Learning:** The default `file` cache driver in Laravel does not support cache tags (`Cache::tags()`). Attempting to use tags on systems without Redis or Memcached will result in errors.
**Action:** Always verify tag support using `Cache::getStore() instanceof \Illuminate\Cache\TaggableStore` or stick to simple key-based invalidation (e.g., `Cache::forget()`) combined with Eloquent Model events/traits for applications deployed on shared hosting or standard environments.
