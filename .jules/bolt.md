
## 2024-05-14 - Missed Views during DB Optimization
**Learning:** Blade layout files often contain direct queries (e.g. `$profile = \App\Models\Profile::first();`) inline within `@php` tags. Simply searching for `.php` files or controllers is insufficient to catch all query bottlenecks.
**Action:** Always `grep` for the model and method name (e.g., `Profile::first()`) across the *entire* codebase, including `resources/views/`, to ensure complete rollout of caching refactors.
