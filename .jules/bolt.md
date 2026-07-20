## 2024-05-18 - [Window Functions ile N+1 Optimizasyonu]
**Learning:** [GameScore::getTopScores gibi döngü içerisinde atılan tekrarlı veritabanı sorguları (N+1), SQL Window Functions (`ROW_NUMBER() OVER(PARTITION BY ...)`) ile Eloquent'in `fromSub` metodu birleştirilerek tek bir etkili sorguya indirgenebiliyor.]
**Action:** [Herhangi bir Eloquent koleksiyonunu iterasyona sokup her döngüde ayrı bir filtre/sıralama sorgusu atılıyorsa, bunu her zaman Window function temelli bir SubQuery olarak refactor etmeyi düşün.]
