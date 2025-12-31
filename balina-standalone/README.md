# Balina Optimization Dashboard 🐋

Metasezgisel optimizasyon algoritmalarını görselleştiren ve karşılaştıran interaktif bir Laravel/Livewire uygulaması.

## Özellikler

- **4 Farklı Algoritma:**
  - 🐋 WOA (Whale Optimization Algorithm) - Balina Optimizasyon Algoritması
  - 🔵 PSO (Particle Swarm Optimization) - Parçacık Sürüsü Optimizasyonu
  - 🐺 GWO (Grey Wolf Optimizer) - Gri Kurt Optimizasyonu
  - 🧬 GA (Genetic Algorithm) - Genetik Algoritma

- **Önceden Tanımlı Fonksiyonlar:**
  - Sphere, Rastrigin, Rosenbrock, Ackley, Griewank, Schwefel

- **Özel Fonksiyon Desteği:**
  - Kendi matematiksel ifadelerinizi yazabilirsiniz

- **Versus Modu:**
  - Algoritmaları yan yana karşılaştırın

- **Kod Üreteci:**
  - Python ve MATLAB kodu otomatik oluşturma

## Kurulum

```bash
# Bağımlılıkları yükle
composer install
npm install

# .env dosyasını düzenle (gerekirse)
cp .env.example .env
php artisan key:generate

# Geliştirme sunucusunu başlat
php artisan serve
```

## Kullanım

Tarayıcınızda `http://localhost:8000` adresine gidin.

## Proje Yapısı

```
app/
├── Livewire/
│   └── OptimizationDashboard.php    # Ana Livewire komponenti
└── Services/Optimization/
    ├── WhaleOptimizationService.php  # WOA implementasyonu
    ├── ParticleSwarmOptimizationService.php  # PSO implementasyonu
    ├── GreyWolfOptimizerService.php  # GWO implementasyonu
    ├── GeneticAlgorithmService.php   # GA implementasyonu
    └── Helpers/
        ├── ObjectiveFunctions.php    # Benchmark fonksiyonları
        ├── MathExpressionParser.php  # Özel ifade parser
        └── CodeGenerator.php         # Python/MATLAB kod üreteci

resources/views/
├── optimization/
│   └── dashboard.blade.php           # Ana layout
└── livewire/
    └── optimization-dashboard.blade.php  # Livewire view
```

## Gereksinimler

- PHP >= 8.1
- Composer
- Node.js & NPM (opsiyonel, frontend build için)

## Lisans

MIT License
