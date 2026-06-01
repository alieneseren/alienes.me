## 2023-10-27 - Manual Model Table Creation in Tests
**Learning:** When writing temporary scripts to test Laravel Models locally, the built-in database migrations may fail due to duplicate or conflicting schemas in this codebase.
**Action:** Always use `Schema::create` to manually define the minimal required tables directly within the temporary test script to avoid migration conflicts.
