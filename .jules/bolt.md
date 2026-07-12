## 2025-02-12 - [Laravel Cache Invalidation Trait Naming]
**Learning:** [When creating a trait for Eloquent models to hook into boot methods (like saved/deleted), the method must be named `boot[TraitName]()` (e.g. `bootClearsPortfolioCache()`). Using just `booted()` in a trait overrides other boot methods or fails to register correctly across multiple models.]
**Action:** [Always use the `boot[TraitName]()` convention when adding model event listeners via traits to ensure proper cache invalidation without breaking existing model logic.]
