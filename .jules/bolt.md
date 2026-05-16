## 2024-05-16 - Homepage Caching & Events
**Learning:** By caching the primary database queries (`Profile`, `Experience`, `Education`, `Skill`, `Project`) in `HomeController` and relying on Eloquent `saved`/`deleted` events in `AppServiceProvider` for invalidation, we remove N database hits on every homepage load while ensuring no stale data is served.
**Action:** Always prefer caching aggregate/read-heavy views like the homepage, coupled with model event-driven cache invalidation to maintain a 100% cache hit rate during passive traffic.
