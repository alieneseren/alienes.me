## 2024-05-14 - N+1 Query on GameController::getAllLeaderboards()

**Learning:** The `getAllLeaderboards` method in `GameController` makes 10 distinct database queries (one for each game's leaderboard). This is an N+1 like query situation on the API endpoint that serves the `/api/games/leaderboards` request. Since the list of games is static and scores aren't updating every single millisecond in a way that breaks if cached for a minute or two, we can cache the result of `getTopScores`.

**Action:** Whenever fetching leaderboard rankings for multiple games simultaneously or even single game leaderboards, always implement caching. The results don't need real-time precision up to the millisecond for most views. Use `Cache::remember` to store the output for a short duration like 1-5 minutes to mitigate the database load significantly.
