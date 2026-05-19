
## 2024-05-18 - Caching Homepage Queries Causes N+1 on Model Events
**Learning:** When using `Cache::rememberForever` on collections, modifying models clears the cache properly, but returning raw DB collections can lead to high memory consumption if relationships aren't eager loaded properly. While caching 5 DB queries into 1 cache hit is optimal, the cache invalidation via model events must clear the entire cache key, requiring the next hit to rebuild it.
**Action:** Always ensure that cached objects (like collections of models) are light and fast to query initially, and apply eager loading where necessary before caching. Ensure Model events are tracked properly to invalidate on any change.
