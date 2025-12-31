<?php

namespace App\Services\Optimization\Helpers;

/**
 * Optimizasyon Algoritmalarını Test Etmek İçin Benchmark Fonksiyonları
 * 
 * Bu sınıf, metaheuristik optimizasyon algoritmalarının performansını
 * değerlendirmek için kullanılan klasik matematiksel test fonksiyonlarını içerir.
 * 
 * @package App\Services\Optimization\Helpers
 */
class ObjectiveFunctions
{
    /**
     * Sphere Function (Küre Fonksiyonu)
     * 
     * Unimodal, sürekli, dışbükey ve separable bir fonksiyon.
     * Global minimum: f(0,0,...,0) = 0
     * Arama alanı: genellikle [-5.12, 5.12]^n
     * 
     * Formül: f(x) = Σ(xi²)
     *
     * @param array $x Koordinat dizisi
     * @return float Fitness değeri
     */
    public static function sphere(array $x): float
    {
        $sum = 0.0;
        foreach ($x as $xi) {
            $sum += $xi * $xi;
        }
        return $sum;
    }

    /**
     * Rastrigin Function (Rastrigin Fonksiyonu)
     * 
     * Çok sayıda yerel minimum içeren multimodal bir fonksiyon.
     * Algoritmaların yerel minimumlardan kaçma yeteneğini test eder.
     * Global minimum: f(0,0,...,0) = 0
     * Arama alanı: genellikle [-5.12, 5.12]^n
     * 
     * Formül: f(x) = 10n + Σ[xi² - 10*cos(2πxi)]
     *
     * @param array $x Koordinat dizisi
     * @return float Fitness değeri
     */
    public static function rastrigin(array $x): float
    {
        $n = count($x);
        $sum = 10 * $n;
        
        foreach ($x as $xi) {
            $sum += ($xi * $xi) - (10 * cos(2 * M_PI * $xi));
        }
        
        return $sum;
    }

    /**
     * Ackley Function (Ackley Fonksiyonu)
     * 
     * Geniş ve neredeyse düz bir dış bölge ile derin bir merkezi 
     * çukur içeren multimodal bir fonksiyon.
     * Global minimum: f(0,0,...,0) = 0
     * Arama alanı: genellikle [-32.768, 32.768]^n
     * 
     * Formül: f(x) = -20*exp(-0.2*sqrt(1/n * Σxi²)) - exp(1/n * Σcos(2πxi)) + 20 + e
     *
     * @param array $x Koordinat dizisi
     * @param float $a Parametre (varsayılan: 20)
     * @param float $b Parametre (varsayılan: 0.2)
     * @param float $c Parametre (varsayılan: 2π)
     * @return float Fitness değeri
     */
    public static function ackley(array $x, float $a = 20, float $b = 0.2, float $c = 2 * M_PI): float
    {
        $n = count($x);
        
        if ($n === 0) {
            return 0.0;
        }
        
        $sumSq = 0.0;
        $sumCos = 0.0;
        
        foreach ($x as $xi) {
            $sumSq += $xi * $xi;
            $sumCos += cos($c * $xi);
        }
        
        $term1 = -$a * exp(-$b * sqrt($sumSq / $n));
        $term2 = -exp($sumCos / $n);
        
        return $term1 + $term2 + $a + M_E;
    }

    /**
     * Rosenbrock Function (Rosenbrock Fonksiyonu)
     * 
     * "Banana function" veya "Rosenbrock's valley" olarak da bilinir.
     * Dar, parabolik bir vadi içinde global minimuma sahiptir.
     * Global minimum: f(1,1,...,1) = 0
     * Arama alanı: genellikle [-5, 10]^n veya [-2.048, 2.048]^n
     * 
     * Formül: f(x) = Σ[100(xi+1 - xi²)² + (xi - 1)²]
     *
     * @param array $x Koordinat dizisi
     * @return float Fitness değeri
     */
    public static function rosenbrock(array $x): float
    {
        $n = count($x);
        $sum = 0.0;
        
        for ($i = 0; $i < $n - 1; $i++) {
            $sum += 100 * pow($x[$i + 1] - $x[$i] * $x[$i], 2) + pow($x[$i] - 1, 2);
        }
        
        return $sum;
    }

    /**
     * Griewank Function (Griewank Fonksiyonu)
     * 
     * Çok sayıda yerel minimum içeren multimodal bir fonksiyon.
     * Global minimum: f(0,0,...,0) = 0
     * Arama alanı: genellikle [-600, 600]^n
     * 
     * Formül: f(x) = 1 + (1/4000)*Σxi² - Πcos(xi/√i)
     *
     * @param array $x Koordinat dizisi
     * @return float Fitness değeri
     */
    public static function griewank(array $x): float
    {
        $n = count($x);
        $sumSq = 0.0;
        $product = 1.0;
        
        for ($i = 0; $i < $n; $i++) {
            $sumSq += $x[$i] * $x[$i];
            $product *= cos($x[$i] / sqrt($i + 1));
        }
        
        return 1 + ($sumSq / 4000) - $product;
    }

    /**
     * Schwefel Function (Schwefel Fonksiyonu)
     * 
     * Çok sayıda yerel minimum ve global minimumun arama alanının
     * merkezinden uzakta olduğu zorlu bir fonksiyon.
     * Global minimum: f(420.9687,...,420.9687) ≈ 0
     * Arama alanı: genellikle [-500, 500]^n
     * 
     * Formül: f(x) = 418.9829*n - Σ[xi*sin(√|xi|)]
     *
     * @param array $x Koordinat dizisi
     * @return float Fitness değeri
     */
    public static function schwefel(array $x): float
    {
        $n = count($x);
        $sum = 0.0;
        
        foreach ($x as $xi) {
            $sum += $xi * sin(sqrt(abs($xi)));
        }
        
        return 418.9829 * $n - $sum;
    }

    /**
     * Booth Function (Booth Fonksiyonu)
     * 
     * 2 boyutlu basit bir test fonksiyonu.
     * Global minimum: f(1, 3) = 0
     * Arama alanı: genellikle [-10, 10]²
     * 
     * Formül: f(x,y) = (x + 2y - 7)² + (2x + y - 5)²
     *
     * @param array $x Koordinat dizisi (2 boyutlu)
     * @return float Fitness değeri
     */
    public static function booth(array $x): float
    {
        if (count($x) < 2) {
            return PHP_FLOAT_MAX;
        }
        
        return pow($x[0] + 2 * $x[1] - 7, 2) + pow(2 * $x[0] + $x[1] - 5, 2);
    }

    /**
     * Matyas Function (Matyas Fonksiyonu)
     * 
     * 2 boyutlu basit, düz bir vadiye sahip fonksiyon.
     * Global minimum: f(0, 0) = 0
     * Arama alanı: genellikle [-10, 10]²
     * 
     * Formül: f(x,y) = 0.26(x² + y²) - 0.48xy
     *
     * @param array $x Koordinat dizisi (2 boyutlu)
     * @return float Fitness değeri
     */
    public static function matyas(array $x): float
    {
        if (count($x) < 2) {
            return PHP_FLOAT_MAX;
        }
        
        return 0.26 * ($x[0] * $x[0] + $x[1] * $x[1]) - 0.48 * $x[0] * $x[1];
    }

    /**
     * Belirli bir fonksiyon için varsayılan sınırları döndür
     *
     * @param string $functionName Fonksiyon adı
     * @param int $dimension Boyut sayısı
     * @return array Sınır değerleri
     */
    public static function getDefaultBounds(string $functionName, int $dimension): array
    {
        $boundsMap = [
            'sphere' => ['min' => -5.12, 'max' => 5.12],
            'rastrigin' => ['min' => -5.12, 'max' => 5.12],
            'ackley' => ['min' => -32.768, 'max' => 32.768],
            'rosenbrock' => ['min' => -5, 'max' => 10],
            'griewank' => ['min' => -600, 'max' => 600],
            'schwefel' => ['min' => -500, 'max' => 500],
            'booth' => ['min' => -10, 'max' => 10],
            'matyas' => ['min' => -10, 'max' => 10],
        ];

        $bounds = $boundsMap[$functionName] ?? ['min' => -10, 'max' => 10];
        
        return array_fill(0, $dimension, $bounds);
    }

    /**
     * Mevcut fonksiyonların listesini döndür
     *
     * @return array Fonksiyon listesi
     */
    public static function getAvailableFunctions(): array
    {
        return [
            'sphere' => [
                'name' => 'Sphere Function',
                'description' => 'Unimodal, sürekli, dışbükey fonksiyon',
                'globalMinimum' => 0,
                'optimalPosition' => 'Origin (0,0,...,0)',
            ],
            'rastrigin' => [
                'name' => 'Rastrigin Function',
                'description' => 'Çok sayıda yerel minimum içeren multimodal fonksiyon',
                'globalMinimum' => 0,
                'optimalPosition' => 'Origin (0,0,...,0)',
            ],
            'ackley' => [
                'name' => 'Ackley Function',
                'description' => 'Derin merkezi çukurlu multimodal fonksiyon',
                'globalMinimum' => 0,
                'optimalPosition' => 'Origin (0,0,...,0)',
            ],
            'rosenbrock' => [
                'name' => 'Rosenbrock Function',
                'description' => 'Dar parabolik vadili banana fonksiyonu',
                'globalMinimum' => 0,
                'optimalPosition' => '(1,1,...,1)',
            ],
            'griewank' => [
                'name' => 'Griewank Function',
                'description' => 'Çok sayıda düzenli yerel minimum',
                'globalMinimum' => 0,
                'optimalPosition' => 'Origin (0,0,...,0)',
            ],
            'schwefel' => [
                'name' => 'Schwefel Function',
                'description' => 'Global minimum merkezden uzakta',
                'globalMinimum' => 0,
                'optimalPosition' => '(420.9687,...,420.9687)',
            ],
        ];
    }

    /**
     * Fonksiyon adından callable döndür
     *
     * @param string $name Fonksiyon adı
     * @return callable Fonksiyon referansı
     */
    public static function getFunction(string $name): callable
    {
        return match ($name) {
            'sphere' => [self::class, 'sphere'],
            'rastrigin' => [self::class, 'rastrigin'],
            'ackley' => [self::class, 'ackley'],
            'rosenbrock' => [self::class, 'rosenbrock'],
            'griewank' => [self::class, 'griewank'],
            'schwefel' => [self::class, 'schwefel'],
            'booth' => [self::class, 'booth'],
            'matyas' => [self::class, 'matyas'],
            default => [self::class, 'sphere'],
        };
    }
}
