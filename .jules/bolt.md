
## 2024-05-18 - [Optimized Homepage Queries]
**Learning:** In Laravel, grouping multiple related read queries that power a high-traffic entry point (like the homepage) into a single `Cache::rememberForever` block is highly effective, provided cache invalidation is automated. Using a dedicated Trait (`bootClearsHomePageCache`) with `static::saved` and `static::deleted` events across all involved Eloquent models cleanly handles this without duplicating invalidation logic.
**Action:** When caching multi-model dashboard or homepage data, consistently use a Trait injected into the relevant models to guarantee the cache is busted upon any create/update/delete actions, ensuring data stays fresh without manual intervention.
