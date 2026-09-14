## 2025-01-24 - Layouts and Blade Collections N+1 Issue
**Learning:** Checking `$collection->count() > 0` directly on Eloquent Collections fetched via `get()` iterates unnecessarily inside Blade templates. Also `Model::count() > 0` inside layout files initiates full row counts when `exists()` is much faster (using `LIMIT 1`).
**Action:** Replace `count() > 0` with `isNotEmpty()` for loaded collections, and `Model::count() > 0` with `Model::exists()` for static layout checks.
