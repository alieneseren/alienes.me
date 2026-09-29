## 2024-05-24 - N+1 Query in views
**Learning:** Found multiple instances of `Model::count() > 0` in layout files (like `resources/views/layouts/frontend.blade.php`), which generates a full `SELECT COUNT(*)` query every time the view is rendered.
**Action:** Replace `Model::count() > 0` with `Model::exists()` to use a much faster `SELECT EXISTS(SELECT 1 ... LIMIT 1)` query. Also, cache these relatively static layout checks using Laravel's `Cache::remember` to avoid hitting the database entirely for every page load.
