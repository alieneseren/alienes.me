## 2024-05-24 - [Sitemap N+1 Query Optimization]
**Learning:** SitemapController was executing an N+1 query problem due to a loop over `StudyNote` fetching the `category` relationship without eager loading.
**Action:** Always check `.get()` queries that loop through models and access relationships for missing `with()` eager loading clauses, particularly in site-wide features like sitemap generation.
