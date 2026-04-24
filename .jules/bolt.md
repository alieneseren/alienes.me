## 2026-04-24 - [Cache Strategy for Dynamic Portfolios]
**Learning:** In portfolio architectures where data (skills, projects, experiences) changes infrequently but is read constantly on the main page, synchronously fetching from multiple tables causes unnecessary N+1-like cumulative database latency.
**Action:** Group these reads into a single 24-hour cache block (`home_page_data`) and invalidate using a unified model Trait (`ClearsHomePageCache`) on save/delete events.
