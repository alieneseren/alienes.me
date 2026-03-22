
## 2024-03-22 - Cache Invalidation Without Tags Support
**Learning:** Default cache driver in this application is `file`, which does not support Cache Tags (`Cache::tags()`). Attempting to use tags blindly will cause fatal errors.
**Action:** When caching collections that need group invalidation (like paginated project lists), always check `Cache::getStore() instanceof \Illuminate\Cache\TaggableStore` and provide a fallback invalidation strategy for simple drivers (like a loop to clear expected page keys). Also, NEVER add long TTL caching without hooking into Model `booted` events (`saved`, `deleted`) to clear the cache, otherwise the admin panel updates won't reflect live.
