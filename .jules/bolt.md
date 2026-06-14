## 2025-06-14 - [Frontend Homepage Cache]
**Learning:** The frontend homepage (`HomeController@index`) was executing 5 separate queries on every single page load for data that rarely changes (Profile, Experiences, Educations, Skills, Projects).
**Action:** Implemented caching for the entire dataset (`Cache::rememberForever`) and utilized model lifecycle events (`saved` and `deleted`) within `AppServiceProvider` to selectively invalidate cache keys (`profile.data` and `home_collections.data`), reducing read queries to 0 while maintaining consistency.
