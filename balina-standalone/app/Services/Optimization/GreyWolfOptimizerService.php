<?php

namespace App\Services\Optimization;

use App\Services\Optimization\Contracts\OptimizationInterface;

/**
 * Grey Wolf Optimizer (GWO)
 * Mirjalili, Mirjalili & Lewis, 2014
 * 
 * Gri kurtların avlanma davranışını simüle eder:
 * - Alpha (α): En iyi çözüm - Lider
 * - Beta (β): İkinci en iyi - Yardımcı lider
 * - Delta (δ): Üçüncü en iyi - Alt lider
 * - Omega (ω): Geri kalan kurtlar - Takipçiler
 */
class GreyWolfOptimizerService implements OptimizationInterface
{
    protected int $populationSize;
    protected int $dimension;
    protected array $bounds;
    protected $objectiveFunction;
    
    // Kurt pozisyonları ve fitness değerleri
    protected array $wolves = [];
    protected array $fitness = [];
    
    // Hiyerarşi - Alpha, Beta, Delta
    protected array $alpha = [];
    protected float $alphaFitness = PHP_FLOAT_MAX;
    
    protected array $beta = [];
    protected float $betaFitness = PHP_FLOAT_MAX;
    
    protected array $delta = [];
    protected float $deltaFitness = PHP_FLOAT_MAX;
    
    // Yakınsama geçmişi
    protected array $convergenceHistory = [];
    
    protected string $name = 'Grey Wolf Optimizer (GWO)';

    public function getName(): string
    {
        return $this->name;
    }

    public function init(int $populationSize, int $dimension, array $bounds, callable $objectiveFunction): void
    {
        $this->populationSize = $populationSize;
        $this->dimension = $dimension;
        $this->bounds = $bounds;
        $this->objectiveFunction = $objectiveFunction;
        
        $this->wolves = [];
        $this->fitness = [];
        $this->convergenceHistory = [];
        
        // Hiyerarşiyi sıfırla
        $this->alphaFitness = PHP_FLOAT_MAX;
        $this->betaFitness = PHP_FLOAT_MAX;
        $this->deltaFitness = PHP_FLOAT_MAX;
        
        // Kurtları rastgele başlat
        for ($i = 0; $i < $populationSize; $i++) {
            $wolf = [];
            for ($d = 0; $d < $dimension; $d++) {
                $lower = $bounds['lower'][$d] ?? $bounds['lower'][0];
                $upper = $bounds['upper'][$d] ?? $bounds['upper'][0];
                $wolf[$d] = $lower + (mt_rand() / mt_getrandmax()) * ($upper - $lower);
            }
            $this->wolves[$i] = $wolf;
            $this->fitness[$i] = ($this->objectiveFunction)($wolf);
            
            // Hiyerarşiyi güncelle
            $this->updateHierarchy($i);
        }
    }

    /**
     * Alpha, Beta, Delta hiyerarşisini güncelle
     */
    protected function updateHierarchy(int $index): void
    {
        $fit = $this->fitness[$index];
        
        if ($fit < $this->alphaFitness) {
            // Yeni Alpha bulundu - eski hiyerarşiyi kaydır
            $this->deltaFitness = $this->betaFitness;
            $this->delta = $this->beta;
            
            $this->betaFitness = $this->alphaFitness;
            $this->beta = $this->alpha;
            
            $this->alphaFitness = $fit;
            $this->alpha = $this->wolves[$index];
        } elseif ($fit < $this->betaFitness) {
            // Yeni Beta bulundu
            $this->deltaFitness = $this->betaFitness;
            $this->delta = $this->beta;
            
            $this->betaFitness = $fit;
            $this->beta = $this->wolves[$index];
        } elseif ($fit < $this->deltaFitness) {
            // Yeni Delta bulundu
            $this->deltaFitness = $fit;
            $this->delta = $this->wolves[$index];
        }
    }

    public function iterate(int $currentIteration, int $maxIterations): array
    {
        // 'a' parametresi: 2'den 0'a doğrusal azalma
        $a = 2 - $currentIteration * (2 / $maxIterations);
        
        for ($i = 0; $i < $this->populationSize; $i++) {
            $newPosition = [];
            
            for ($d = 0; $d < $this->dimension; $d++) {
                // Alpha etkisi
                $r1 = mt_rand() / mt_getrandmax();
                $r2 = mt_rand() / mt_getrandmax();
                $A1 = 2 * $a * $r1 - $a;
                $C1 = 2 * $r2;
                $D_alpha = abs($C1 * ($this->alpha[$d] ?? 0) - $this->wolves[$i][$d]);
                $X1 = ($this->alpha[$d] ?? 0) - $A1 * $D_alpha;
                
                // Beta etkisi
                $r1 = mt_rand() / mt_getrandmax();
                $r2 = mt_rand() / mt_getrandmax();
                $A2 = 2 * $a * $r1 - $a;
                $C2 = 2 * $r2;
                $D_beta = abs($C2 * ($this->beta[$d] ?? 0) - $this->wolves[$i][$d]);
                $X2 = ($this->beta[$d] ?? 0) - $A2 * $D_beta;
                
                // Delta etkisi
                $r1 = mt_rand() / mt_getrandmax();
                $r2 = mt_rand() / mt_getrandmax();
                $A3 = 2 * $a * $r1 - $a;
                $C3 = 2 * $r2;
                $D_delta = abs($C3 * ($this->delta[$d] ?? 0) - $this->wolves[$i][$d]);
                $X3 = ($this->delta[$d] ?? 0) - $A3 * $D_delta;
                
                // Yeni pozisyon: Alpha, Beta, Delta'nın ortalaması
                $newPosition[$d] = ($X1 + $X2 + $X3) / 3;
                
                // Sınır kontrolü
                $lower = $this->bounds['lower'][$d] ?? $this->bounds['lower'][0];
                $upper = $this->bounds['upper'][$d] ?? $this->bounds['upper'][0];
                $newPosition[$d] = max($lower, min($upper, $newPosition[$d]));
            }
            
            // Pozisyonu güncelle ve değerlendir
            $this->wolves[$i] = $newPosition;
            $this->fitness[$i] = ($this->objectiveFunction)($newPosition);
            
            // Hiyerarşiyi güncelle
            $this->updateHierarchy($i);
        }
        
        // Yakınsama geçmişine ekle
        $this->convergenceHistory[] = $this->alphaFitness;
        
        return [
            'bestFitness' => $this->alphaFitness,
            'avgFitness' => array_sum($this->fitness) / count($this->fitness),
            'alpha' => $this->alpha,
            'beta' => $this->beta,
            'delta' => $this->delta
        ];
    }

    public function getBestFitness(): float
    {
        return $this->alphaFitness;
    }

    public function getBestPosition(): array
    {
        return $this->alpha;
    }

    public function getPositions(): array
    {
        return $this->wolves;
    }

    public function getDimension(): int
    {
        return $this->dimension;
    }

    public function getConvergenceHistory(): array
    {
        return $this->convergenceHistory;
    }

    /**
     * Hiyerarşi bilgilerini döndür
     */
    public function getHierarchy(): array
    {
        return [
            'alpha' => ['position' => $this->alpha, 'fitness' => $this->alphaFitness],
            'beta' => ['position' => $this->beta, 'fitness' => $this->betaFitness],
            'delta' => ['position' => $this->delta, 'fitness' => $this->deltaFitness]
        ];
    }

    /**
     * Tam optimizasyon döngüsü
     */
    public function optimize(int $maxIterations): array
    {
        $startTime = microtime(true);
        
        for ($i = 1; $i <= $maxIterations; $i++) {
            $this->iterate($i, $maxIterations);
        }
        
        $executionTime = microtime(true) - $startTime;
        
        return [
            'bestFitness' => $this->alphaFitness,
            'bestPosition' => $this->alpha,
            'convergenceHistory' => $this->convergenceHistory,
            'executionTime' => $executionTime,
            'hierarchy' => $this->getHierarchy()
        ];
    }
}
