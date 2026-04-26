## 2026-04-26 - [Homepage Query Caching]
**Learning:** The application heavily queries portfolio models (Profile, Experience, Education, Skill, Project) on the homepage. Standard caching requires automated invalidation to prevent stale data.
**Action:** Implemented a unified `ClearsHomePageCache` Trait on all portfolio models that triggers on save/delete events, successfully combining 5 individual db queries into 1 cache hit for all subsequent page loads.
