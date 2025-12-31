<?php

namespace App\Services\Optimization;

use App\Services\Optimization\Contracts\OptimizationInterface;

/**
 * Whale Optimization Algorithm (WOA) Service
 * 
 * Kambur balinaların avlanma davranışlarından esinlenen
 * metaheuristik optimizasyon algoritması implementasyonu.
 * 
 * Referans: Mirjalili, S., & Lewis, A. (2016). The whale optimization algorithm.
 * 
 * @package App\Services\Optimization
 */
class WhaleOptimizationService implements OptimizationInterface
{
    /** @var int Popülasyon büyüklüğü */
    protected int $populationSize;

    /** @var int Problem boyutu */
    protected int $dimension;

    /** @var array Sınır değerleri */
    protected array $bounds;

    /** @var callable Amaç fonksiyonu */
    protected $objectiveFunction;

    /** @var array Balina pozisyonları */
    protected array $positions = [];

    /** @var array Fitness değerleri */
    protected array $fitness = [];

    /** @var array En iyi pozisyon (lider balina) */
    protected array $bestPosition = [];

    /** @var float En iyi fitness */
    protected float $bestFitness = PHP_FLOAT_MAX;

    /** @var array Yakınsama geçmişi */
    protected array $convergenceHistory = [];

    /** @var float Spiral sabiti */
    protected float $b = 1.0;

    /**
     * {@inheritdoc}
     */
    public function init(int $populationSize, int $dimension, array $bounds, callable $objectiveFunction): void
    {
        $this->populationSize = $populationSize;
        $this->dimension = $dimension;
        $this->bounds = $bounds;
        $this->objectiveFunction = $objectiveFunction;
        $this->convergenceHistory = [];
        $this->bestFitness = PHP_FLOAT_MAX;
        $this->bestPosition = [];

        // Popülasyonu rastgele başlat
        $this->initializePopulation();
        
        // İlk fitness değerlerini hesapla
        $this->evaluatePopulation();
    }

    /**
     * Popülasyonu rastgele pozisyonlarla başlat
     */
    protected function initializePopulation(): void
    {
        $this->positions = [];
        
        for ($i = 0; $i < $this->populationSize; $i++) {
            $position = [];
            for ($j = 0; $j < $this->dimension; $j++) {
                $min = $this->bounds[$j]['min'] ?? -10;
                $max = $this->bounds[$j]['max'] ?? 10;
                $position[$j] = $min + (mt_rand() / mt_getrandmax()) * ($max - $min);
            }
            $this->positions[$i] = $position;
        }
    }

    /**
     * Tüm popülasyonun fitness değerlerini hesapla
     */
    protected function evaluatePopulation(): void
    {
        for ($i = 0; $i < $this->populationSize; $i++) {
            $this->fitness[$i] = ($this->objectiveFunction)($this->positions[$i]);
            
            // En iyi çözümü güncelle
            if ($this->fitness[$i] < $this->bestFitness) {
                $this->bestFitness = $this->fitness[$i];
                $this->bestPosition = $this->positions[$i];
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function iterate(int $currentIteration, int $maxIterations): array
    {
        // a parametresi: 2'den 0'a doğru azalır (keşiften sömürüye geçiş)
        $a = 2 - $currentIteration * (2.0 / $maxIterations);
        $a2 = -1 + $currentIteration * (-1.0 / $maxIterations);

        for ($i = 0; $i < $this->populationSize; $i++) {
            $r1 = mt_rand() / mt_getrandmax();
            $r2 = mt_rand() / mt_getrandmax();
            
            $A = 2 * $a * $r1 - $a;  // Katsayı vektörü
            $C = 2 * $r2;             // Katsayı vektörü
            
            $p = mt_rand() / mt_getrandmax();
            $l = ($a2 - 1) * (mt_rand() / mt_getrandmax()) + 1;

            for ($j = 0; $j < $this->dimension; $j++) {
                $min = $this->bounds[$j]['min'] ?? -10;
                $max = $this->bounds[$j]['max'] ?? 10;

                if ($p < 0.5) {
                    if (abs($A) < 1) {
                        // Çevreleyen davranış (Encircling prey)
                        $D = abs($C * $this->bestPosition[$j] - $this->positions[$i][$j]);
                        $this->positions[$i][$j] = $this->bestPosition[$j] - $A * $D;
                    } else {
                        // Keşif aşaması (Exploration - rastgele balina seç)
                        $randIndex = mt_rand(0, $this->populationSize - 1);
                        $D = abs($C * $this->positions[$randIndex][$j] - $this->positions[$i][$j]);
                        $this->positions[$i][$j] = $this->positions[$randIndex][$j] - $A * $D;
                    }
                } else {
                    // Spiral güncelleme (Bubble-net attacking)
                    $D_prime = abs($this->bestPosition[$j] - $this->positions[$i][$j]);
                    $this->positions[$i][$j] = $D_prime * exp($this->b * $l) * cos(2 * M_PI * $l) 
                                              + $this->bestPosition[$j];
                }

                // Sınırları kontrol et
                $this->positions[$i][$j] = max($min, min($max, $this->positions[$i][$j]));
            }
        }

        // Yeni fitness değerlerini hesapla
        $this->evaluatePopulation();
        
        // Yakınsama geçmişine ekle
        $this->convergenceHistory[] = $this->bestFitness;

        return [
            'iteration' => $currentIteration,
            'bestFitness' => $this->bestFitness,
            'avgFitness' => array_sum($this->fitness) / count($this->fitness),
            'bestPosition' => $this->bestPosition
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getBestFitness(): float
    {
        return $this->bestFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function getPositions(): array
    {
        return $this->positions;
    }

    /**
     * {@inheritdoc}
     */
    public function getBestPosition(): array
    {
        return $this->bestPosition;
    }

    /**
     * {@inheritdoc}
     */
    public function getConvergenceHistory(): array
    {
        return $this->convergenceHistory;
    }

    /**
     * {@inheritdoc}
     */
    public function getName(): string
    {
        return 'Whale Optimization Algorithm (WOA)';
    }

    /**
     * {@inheritdoc}
     */
    public function optimize(int $maxIterations): array
    {
        $startTime = microtime(true);

        for ($iter = 1; $iter <= $maxIterations; $iter++) {
            $this->iterate($iter, $maxIterations);
        }

        $endTime = microtime(true);

        return [
            'algorithm' => $this->getName(),
            'bestFitness' => $this->bestFitness,
            'bestPosition' => $this->bestPosition,
            'convergenceHistory' => $this->convergenceHistory,
            'iterations' => $maxIterations,
            'populationSize' => $this->populationSize,
            'dimension' => $this->dimension,
            'executionTime' => round(($endTime - $startTime) * 1000, 2) . ' ms'
        ];
    }
}
