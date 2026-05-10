## 2026-05-10 - Models Boot vs Events Invalidation
**Learning:** Invalidation events for Eloquent models using `Model::saved` in `AppServiceProvider::boot()` works perfectly and effectively clears cache. Caching the home.data prevents multiple duplicate queries across 5 different models per view.
**Action:** Use model events in boot process for easy centralized cache invalidation across different models when caching composed views.
