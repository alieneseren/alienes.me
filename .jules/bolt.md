## 2026-07-09 - Storage Artifacts in PR
**Learning:** Local caching and view generation creates artifacts in `storage/framework/cache/data` and `storage/framework/views`. Using `git add .` or indiscriminately staging files can accidentally include these environment-specific binary/text blobs in the commit, causing repository bloat and potential insecure deserialization vulnerabilities in production.
**Action:** Always strictly use precise `git add <file>` commands when staging changes, specifically avoiding any generated framework directories. Check `git status` thoroughly before committing.
