## 2024-05-15 - Missing DB Index for Visitor Analytics
**Learning:** Found frequent queries scanning `visitor_logs` by `created_at` in controllers but no index existed, causing a performance degradation.
**Action:** Always verify if frequently queried timestamp columns like `created_at` or `recorded_at` have database indexes.
