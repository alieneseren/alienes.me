## 2026-05-07 - [Homepage Database Query Caching Optimization]
**Learning:** This codebase lacked caching on the main landing page, causing 5 separate database queries (`Profile`, `Experience`, `Education`, `Skill`, `Project`) to be executed on every single page load.
**Action:** Replaced individual queries with a single `Cache::remember` block using a 24-hour TTL, and handled cache invalidation (forgetting the cache) via Eloquent model events (`saved`, `deleted`) in the `AppServiceProvider`.
