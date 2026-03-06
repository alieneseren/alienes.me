## 2026-03-06 - N+1 Query in Sitemap Generation
**Learning:** Generating the `sitemap.xml` using Laravel Eloquent triggers an N+1 query problem if relationships (like `$note->category`) are accessed within a loop without eager loading. Given the potential size of a sitemap (e.g. 50,000 links maximum), generating it dynamically could exhaust database resources.
**Action:** Always inspect loops in dynamically generated XML or JSON outputs for implicit relationship access and use `with()` to eager load relations.
