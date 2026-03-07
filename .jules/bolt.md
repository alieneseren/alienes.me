
## 2024-03-07 - N+1 in SSE Stream Loops
**Learning:** Real-time components utilizing SSE (`response()->stream()` with `while(true)`) create dangerous implicit N+1 query loops. In this project, `VisitorCountController@stream` called `VisitorCount::getTodayCount()` every 3 seconds, leading to a relentless continuous stream of DB queries for each connected client.
**Action:** When working with long-running SSE streams, always cache DB query results queried within the `while(true)` loops and update the cache upon mutating the data (`increment()` operation), removing DB interactions from the stream's loop.
