<?php

namespace App\Services\Optimization;

use App\Services\Optimization\Contracts\OptimizationInterface;

/**
 * Particle Swarm Optimization (PSO) Service
 * 
 * Kuş ve balık sürülerinin sosyal davranışlarından esinlenen
 * metaheuristik optimizasyon algoritması implementasyonu.
 * 
 * Referans: Kennedy, J., & Eberhart, R. (1995). Particle swarm optimization.
 * 
 * @package App\Services\Optimization
 */
class ParticleSwarmOptimizationService implements OptimizationInterface
{
    /** @var int Popülasyon (sürü) büyüklüğü */
    protected int $populationSize;

    /** @var int Problem boyutu */
    protected int $dimension;

    /** @var array Sınır değerleri */
    protected array $bounds;

    /** @var callable Amaç fonksiyonu */
    protected $objectiveFunction;

    /** @var array Parçacık pozisyonları */
    protected array $positions = [];

    /** @var array Parçacık hızları */
    protected array $velocities = [];

    /** @var array Kişisel en iyi pozisyonlar (pBest) */
    protected array $personalBestPositions = [];

    /** @var array Kişisel en iyi fitness değerleri */
    protected array $personalBestFitness = [];

    /** @var array Global en iyi pozisyon (gBest) */
    protected array $globalBestPosition = [];

    /** @var float Global en iyi fitness */
    protected float $globalBestFitness = PHP_FLOAT_MAX;

    /** @var array Fitness değerleri */
    protected array $fitness = [];

    /** @var array Yakınsama geçmişi */
    protected array $convergenceHistory = [];

    /** @var float Atalet ağırlığı (inertia weight) */
    protected float $w = 0.7;

    /** @var float Maksimum atalet ağırlığı */
    protected float $wMax = 0.9;

    /** @var float Minimum atalet ağırlığı */
    protected float $wMin = 0.4;

    /** @var float Bilişsel katsayı (cognitive coefficient) - c1 */
    protected float $c1 = 2.0;

    /** @var float Sosyal katsayı (social coefficient) - c2 */
    protected float $c2 = 2.0;

    /** @var float Maksimum hız katsayısı */
    protected float $vMaxRatio = 0.2;

    /**
     * PSO parametrelerini ayarla
     *
     * @param float $inertia Atalet ağırlığı (0.4 - 0.9 arası önerilir)
     * @param float $cognitive Bilişsel katsayı (genellikle 2.0)
     * @param float $social Sosyal katsayı (genellikle 2.0)
     * @return self
     */
    public function setParameters(float $inertia = 0.7, float $cognitive = 2.0, float $social = 2.0): self
    {
        $this->w = $inertia;
        $this->c1 = $cognitive;
        $this->c2 = $social;
        return $this;
    }

    /**
     * Dinamik atalet ağırlığı için min/max değerlerini ayarla
     *
     * @param float $wMax Maksimum atalet (başlangıç)
     * @param float $wMin Minimum atalet (bitiş)
     * @return self
     */
    public function setInertiaRange(float $wMax = 0.9, float $wMin = 0.4): self
    {
        $this->wMax = $wMax;
        $this->wMin = $wMin;
        return $this;
    }

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
        $this->globalBestFitness = PHP_FLOAT_MAX;
        $this->globalBestPosition = [];

        // Parçacıkları ve hızları başlat
        $this->initializeSwarm();
        
        // İlk fitness değerlerini hesapla ve pBest/gBest'i güncelle
        $this->evaluateSwarm();
    }

    /**
     * Sürüyü rastgele pozisyon ve hızlarla başlat
     */
    protected function initializeSwarm(): void
    {
        $this->positions = [];
        $this->velocities = [];
        $this->personalBestPositions = [];
        $this->personalBestFitness = [];
        
        for ($i = 0; $i < $this->populationSize; $i++) {
            $position = [];
            $velocity = [];
            
            for ($j = 0; $j < $this->dimension; $j++) {
                $min = $this->bounds[$j]['min'] ?? -10;
                $max = $this->bounds[$j]['max'] ?? 10;
                $range = $max - $min;
                
                // Pozisyonu rastgele başlat
                $position[$j] = $min + (mt_rand() / mt_getrandmax()) * $range;
                
                // Hızı küçük rastgele değerlerle başlat
                $vMax = $range * $this->vMaxRatio;
                $velocity[$j] = -$vMax + (mt_rand() / mt_getrandmax()) * 2 * $vMax;
            }
            
            $this->positions[$i] = $position;
            $this->velocities[$i] = $velocity;
            $this->personalBestPositions[$i] = $position;
            $this->personalBestFitness[$i] = PHP_FLOAT_MAX;
        }
    }

    /**
     * Tüm sürünün fitness değerlerini hesapla ve en iyileri güncelle
     */
    protected function evaluateSwarm(): void
    {
        for ($i = 0; $i < $this->populationSize; $i++) {
            $this->fitness[$i] = ($this->objectiveFunction)($this->positions[$i]);
            
            // Kişisel en iyi güncelle
            if ($this->fitness[$i] < $this->personalBestFitness[$i]) {
                $this->personalBestFitness[$i] = $this->fitness[$i];
                $this->personalBestPositions[$i] = $this->positions[$i];
            }
            
            // Global en iyi güncelle
            if ($this->fitness[$i] < $this->globalBestFitness) {
                $this->globalBestFitness = $this->fitness[$i];
                $this->globalBestPosition = $this->positions[$i];
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function iterate(int $currentIteration, int $maxIterations): array
    {
        // Dinamik atalet ağırlığı (lineer azalma)
        $this->w = $this->wMax - ($this->wMax - $this->wMin) * ($currentIteration / $maxIterations);

        for ($i = 0; $i < $this->populationSize; $i++) {
            for ($j = 0; $j < $this->dimension; $j++) {
                $min = $this->bounds[$j]['min'] ?? -10;
                $max = $this->bounds[$j]['max'] ?? 10;
                $range = $max - $min;
                $vMax = $range * $this->vMaxRatio;

                // Rastgele katsayılar
                $r1 = mt_rand() / mt_getrandmax();
                $r2 = mt_rand() / mt_getrandmax();

                // Hız güncelleme formülü:
                // v(t+1) = w*v(t) + c1*r1*(pBest - x(t)) + c2*r2*(gBest - x(t))
                $cognitive = $this->c1 * $r1 * ($this->personalBestPositions[$i][$j] - $this->positions[$i][$j]);
                $social = $this->c2 * $r2 * ($this->globalBestPosition[$j] - $this->positions[$i][$j]);
                
                $this->velocities[$i][$j] = $this->w * $this->velocities[$i][$j] + $cognitive + $social;

                // Hız sınırlama (velocity clamping)
                $this->velocities[$i][$j] = max(-$vMax, min($vMax, $this->velocities[$i][$j]));

                // Pozisyon güncelleme formülü:
                // x(t+1) = x(t) + v(t+1)
                $this->positions[$i][$j] = $this->positions[$i][$j] + $this->velocities[$i][$j];

                // Pozisyon sınırlama (boundary handling)
                if ($this->positions[$i][$j] < $min) {
                    $this->positions[$i][$j] = $min;
                    $this->velocities[$i][$j] *= -0.5; // Sınırda yansıma
                }
                if ($this->positions[$i][$j] > $max) {
                    $this->positions[$i][$j] = $max;
                    $this->velocities[$i][$j] *= -0.5;
                }
            }
        }

        // Yeni fitness değerlerini hesapla
        $this->evaluateSwarm();
        
        // Yakınsama geçmişine ekle
        $this->convergenceHistory[] = $this->globalBestFitness;

        return [
            'iteration' => $currentIteration,
            'bestFitness' => $this->globalBestFitness,
            'avgFitness' => array_sum($this->fitness) / count($this->fitness),
            'bestPosition' => $this->globalBestPosition,
            'inertia' => $this->w
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getBestFitness(): float
    {
        return $this->globalBestFitness;
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
        return $this->globalBestPosition;
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
        return 'Particle Swarm Optimization (PSO)';
    }

    /**
     * Parçacık hızlarını döndür
     *
     * @return array Tüm parçacıkların hızları
     */
    public function getVelocities(): array
    {
        return $this->velocities;
    }

    /**
     * Kişisel en iyi pozisyonları döndür
     *
     * @return array Tüm parçacıkların pBest pozisyonları
     */
    public function getPersonalBests(): array
    {
        return [
            'positions' => $this->personalBestPositions,
            'fitness' => $this->personalBestFitness
        ];
    }

    /**
     * Mevcut PSO parametrelerini döndür
     *
     * @return array Parametre değerleri
     */
    public function getParameters(): array
    {
        return [
            'inertia' => $this->w,
            'cognitive' => $this->c1,
            'social' => $this->c2,
            'vMaxRatio' => $this->vMaxRatio
        ];
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
            'bestFitness' => $this->globalBestFitness,
            'bestPosition' => $this->globalBestPosition,
            'convergenceHistory' => $this->convergenceHistory,
            'iterations' => $maxIterations,
            'populationSize' => $this->populationSize,
            'dimension' => $this->dimension,
            'parameters' => $this->getParameters(),
            'executionTime' => round(($endTime - $startTime) * 1000, 2) . ' ms'
        ];
    }
}
