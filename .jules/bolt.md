## 2025-03-05 - [Paket Dosyaları ve Yorum Satırları]
**Learning:** Kod inceleme aşamasında, npm paketlerinin yüklenmesi sırasında istemeden değişen `package-lock.json` dosyası reddedildi. Ayrıca, yönergeler doğrultusunda yapılan optimizasyonu açıklayan kod içi yorum satırlarının eksikliği geri bildirildi.
**Action:** Bundan sonra `git add` işlemi yaparken, sadece manuel olarak değiştirilen dosyaları özenle seçmeliyim (`git add .` veya `git commit -am` kullanmamalıyım). Optimizasyon kodu yazarken mutlaka amacını belirten `// ⚡ Bolt: ...` formatında açıklayıcı yorum satırları eklemeliyim.
