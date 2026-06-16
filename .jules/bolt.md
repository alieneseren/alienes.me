## 2024-05-30 - Dinamik Limitlerle Cache Temizliği
**Learning:** Cache temizliği yaparken (`booted` metodunda vb.) parametrelere (örneğin limitler) bağlı cache anahtarlarını hardcode etmek kırılgandır ve sisteme dinamik değerler eklendiğinde hatalara yol açar.
**Action:** Tag desteklemeyen cache sürücülerinde (örneğin file cache) tüm olası anahtarları temizlemek zordur, bu yüzden bu tür sorguları cache'lerken ya tag destekleyen bir sürücü kullanılmalı (Redis vb.) veya model için genel bir "son güncellenme tarihi" kontrol edilerek cache oluşturulmalıdır.
