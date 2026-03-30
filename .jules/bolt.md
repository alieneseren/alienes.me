
## 2026-03-30 - Home Page Multiple Queries Optimization
**Learning:** Found an opportunity where the home page executed 5 separate database queries for `Profile`, `Experience`, `Education`, `Skill`, and `Project` models on every single visit.
**Action:** Wrapped the data retrieval in `HomeController@index` within a `Cache::remember` block for 24 hours, and created an elegant invalidation mechanism via the `ClearsHomePageCache` trait attached to the models to clear the cache upon updates/deletions.
