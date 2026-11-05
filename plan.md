1. **resources/views/layouts/frontend.blade.php Optimizasyonu**
   - `@php` bloğu içinde `$profile` değişkeni controller'dan gelmişse tekrar veritabanına sorgu atılmaması için `??` operatörü (null coalescing) eklenecek: `$profile = $profile ?? \App\Models\Profile::first();`
   - `$hasExperiences`, `$hasSkills`, `$hasProjects` değişkenlerinde `.count() > 0` yerine performanslı olan `.exists()` kullanılacak: `\App\Models\Experience::exists();` vb.
   - `\App\Models\Cv::where('is_published', true)->exists()` sorgusu menülerde (masaüstü ve mobil) 2 kez çalışıyor. Bu durumu önlemek için `@php` bloğunda `$hasPublishedCv` adlı bir değişken oluşturulacak ve bu değişken her iki yerde kullanılacak.

2. **resources/views/frontend/home.blade.php Optimizasyonu**
   - Zaten yüklenmiş collection'lar için `@if($experiences->count() > 0)` vb. kontroller yerine Laravel'in collection metodu olan `@if($experiences->isNotEmpty())` kullanılacak (4 yerde: experiences, educations, skills, featuredProjects).

3. **Verifikasyon**
   - Yapılan değişiklikleri doğrulayacağım (`npm run build` gibi komutlar ile, Laravel view cache'ini temizleyerek ya da özel bir php betiği oluşturup view'ı derleyerek test edeceğim).

4. **Pre-commit ve Submission**
   - Complete pre-commit steps to ensure proper testing, verification, review, and reflection are done.
   - Submit the PR with the required details.
