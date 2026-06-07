## 2024-01-26 - Prevent Multiple Queries via Collection Caching
**Learning:** In scenarios like the homepage where multiple independent collections (Experience, Education, Skill, Project) are loaded, caching them individually creates multiple cache reads. Grouping them into a single associative array cache entry (`home_collections.data`) reduces overhead.
**Action:** Always look for opportunities to group related cached data for views, ensuring cache invalidation occurs when any of the underlying models change.
