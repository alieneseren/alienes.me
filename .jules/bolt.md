## 2024-06-11 - Database Cache Invalidation
**Learning:** Using Eloquent's model events (`saved`, `deleted`) inside a Service Provider is a clean and decoupled way to implement cache invalidation for large collection caches without muddying the controllers.
**Action:** Always prefer observing model events over manually clearing caches in controllers where data mutations happen to ensure consistency across the application.
