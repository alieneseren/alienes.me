
## 2023-10-27 - View Composer Cache Stale Data Risk
**Learning:** Caching data inside a View Composer using `Cache::remember` with a high TTL (like 1 hour) for dynamic database content (e.g. Profile updates, CV publish status) causes severe regression as the user's updates will not be visible for a long time. This is especially risky in Laravel when you aren't invalidating cache via Eloquent Model events.
**Action:** When caching database-driven View Composer data without setting up explicit cache invalidation (like model observers or events), use a very short TTL (e.g., 60 seconds) or build the invalidation logic explicitly to prevent stale state regressions.
