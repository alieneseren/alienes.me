## 2025-02-13 - N+1 Optimizations with Window Functions in SQLite
**Learning:** For fetching "top N per group" (e.g., top scores for multiple games), SQL window functions (`ROW_NUMBER() OVER(PARTITION BY...)`) inside a subquery are highly effective and are fully supported by the PHP SQLite testing environment in this repository, bypassing the need for complex `UNION ALL` or loop-based multiple queries.
**Action:** Use `fromSub` with window functions for future grouped-limit N+1 optimization problems, rather than making separate queries inside a PHP loop.
