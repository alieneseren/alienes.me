## 2025-02-23 - [Frontend Layout Cache Optimization]
**Learning:** Frontend layout dosyalarında, her sayfa yüklendiğinde Profile, Experience, Skill, Project ve Cv gibi modellerden yapılan birden fazla statik veritabanı sorgusu, tekrarlanan gereksiz işlem ve veritabanı yüküne neden oluyordu.
**Action:** Bu sorguları tek bir ilişkilendirilmiş dizi içinde birleştirip `Cache::remember` kullanarak önbelleğe almak ve ilgili modellerde veri değiştiğinde önbelleği temizleyen bir Trait (ClearsFrontendCache) kullanmak, hem veritabanı yükünü düşürür hem de uygulamanın yanıt süresini iyileştirir.
