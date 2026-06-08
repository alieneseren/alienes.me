## 2024-06-08 - Caching Eloquent Models and Fixing N+1 Queries
**Learning:** In Laravel without standard test frameworks, temporary test scripts mimicking the bootstrapping process are crucial for validating backend changes like checking `DB::getQueryLog()` to count queries. When adding caching, invalidation logic must be added via model events (`saved`, `deleted`) to prevent stale data.
**Action:** When implementing model caching in Laravel without Redis/Memcached (using the file store by default), tag support isn't available. Therefore, explicit keys (`profile.data`, `home_collections.data`) must be cleared using `Cache::forget()`.

## 2024-06-08 - Caching Paginated Queries and Git Management
**Learning:** Caching paginated data (`Project::ordered()->paginate(12)`) under a single static key (`projects.all`) breaks pagination, as all pages will load the identical cached page 1 result. Cache files generated locally in `storage/framework/cache/data/` must never be added to version control.
**Action:** Parameterize cache keys for paginated queries using the page number (e.g., `projects.page.' . request()->get('page', 1)`). To invalidate them without tag support, iterate through a reasonable number of expected pages (e.g., 1 to 50) and call `Cache::forget()`. Always use targeted `git add <file>` or `git rm --cached` to prevent committing ephemeral storage files.
