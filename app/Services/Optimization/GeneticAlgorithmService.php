<?php

namespace App\Services\Optimization;

use App\Services\Optimization\Contracts\OptimizationInterface;

/**
 * Genetic Algorithm (GA)
 * Holland, 1975
 * 
 * Doğal seçilim ve genetik mekanizmaları simüle eder:
 * - Seçilim (Selection): Turnuva seçilimi
 * - Çaprazlama (Crossover): Tek noktalı ve BLX-α
 * - Mutasyon (Mutation): Gaussian mutasyon
 */
class GeneticAlgorithmService implements OptimizationInterface
{
    protected int $populationSize;
    protected int $dimension;
    protected array $bounds;
    protected $objectiveFunction;
    
    // Popülasyon ve fitness
    protected array $population = [];
    protected array $fitness = [];
    
    // En iyi birey
    protected array $bestIndividual = [];
    protected float $bestFitness = PHP_FLOAT_MAX;
    
    // GA Parametreleri
    protected float $crossoverRate = 0.9;
    protected float $mutationRate = 0.1;
    protected int $tournamentSize = 3;
    protected float $elitismRate = 0.1; // En iyi %10'u koru
    
    // Yakınsama geçmişi
    protected array $convergenceHistory = [];
    
    protected string $name = 'Genetic Algorithm (GA)';

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * GA parametrelerini ayarla
     */
    public function setParameters(
        float $crossoverRate = 0.9,
        float $mutationRate = 0.1,
        int $tournamentSize = 3,
        float $elitismRate = 0.1
    ): self {
        $this->crossoverRate = $crossoverRate;
        $this->mutationRate = $mutationRate;
        $this->tournamentSize = $tournamentSize;
        $this->elitismRate = $elitismRate;
        return $this;
    }

    public function init(int $populationSize, int $dimension, array $bounds, callable $objectiveFunction): void
    {
        $this->populationSize = $populationSize;
        $this->dimension = $dimension;
        $this->bounds = $bounds;
        $this->objectiveFunction = $objectiveFunction;
        
        $this->population = [];
        $this->fitness = [];
        $this->convergenceHistory = [];
        $this->bestFitness = PHP_FLOAT_MAX;
        
        // Popülasyonu rastgele başlat
        for ($i = 0; $i < $populationSize; $i++) {
            $individual = [];
            for ($d = 0; $d < $dimension; $d++) {
                $lower = $bounds['lower'][$d] ?? $bounds['lower'][0];
                $upper = $bounds['upper'][$d] ?? $bounds['upper'][0];
                $individual[$d] = $lower + (mt_rand() / mt_getrandmax()) * ($upper - $lower);
            }
            $this->population[$i] = $individual;
            $this->fitness[$i] = ($this->objectiveFunction)($individual);
            
            // En iyi bireyi güncelle
            if ($this->fitness[$i] < $this->bestFitness) {
                $this->bestFitness = $this->fitness[$i];
                $this->bestIndividual = $individual;
            }
        }
    }

    /**
     * Turnuva Seçilimi
     * En iyi bireyi seçmek için rastgele turnuva
     */
    protected function tournamentSelection(): array
    {
        $bestIndex = mt_rand(0, $this->populationSize - 1);
        $bestFit = $this->fitness[$bestIndex];
        
        for ($i = 1; $i < $this->tournamentSize; $i++) {
            $candidateIndex = mt_rand(0, $this->populationSize - 1);
            if ($this->fitness[$candidateIndex] < $bestFit) {
                $bestIndex = $candidateIndex;
                $bestFit = $this->fitness[$candidateIndex];
            }
        }
        
        return $this->population[$bestIndex];
    }

    /**
     * BLX-α Çaprazlama (Blend Crossover)
     * Sürekli değerler için uygun çaprazlama
     */
    protected function blxCrossover(array $parent1, array $parent2): array
    {
        $alpha = 0.5;
        $child1 = [];
        $child2 = [];
        
        for ($d = 0; $d < $this->dimension; $d++) {
            $min = min($parent1[$d], $parent2[$d]);
            $max = max($parent1[$d], $parent2[$d]);
            $range = $max - $min;
            
            $lower = $this->bounds['lower'][$d] ?? $this->bounds['lower'][0];
            $upper = $this->bounds['upper'][$d] ?? $this->bounds['upper'][0];
            
            // BLX-α aralığı
            $blxMin = $min - $alpha * $range;
            $blxMax = $max + $alpha * $range;
            
            // Sınırları uygula
            $blxMin = max($lower, $blxMin);
            $blxMax = min($upper, $blxMax);
            
            $child1[$d] = $blxMin + (mt_rand() / mt_getrandmax()) * ($blxMax - $blxMin);
            $child2[$d] = $blxMin + (mt_rand() / mt_getrandmax()) * ($blxMax - $blxMin);
        }
        
        return [(mt_rand() / mt_getrandmax()) < 0.5 ? $child1 : $child2];
    }

    /**
     * Tek Noktalı Çaprazlama
     */
    protected function singlePointCrossover(array $parent1, array $parent2): array
    {
        $crossoverPoint = mt_rand(1, $this->dimension - 1);
        
        $child = [];
        for ($d = 0; $d < $this->dimension; $d++) {
            $child[$d] = ($d < $crossoverPoint) ? $parent1[$d] : $parent2[$d];
        }
        
        return [$child];
    }

    /**
     * Gaussian Mutasyon
     */
    protected function gaussianMutation(array $individual): array
    {
        for ($d = 0; $d < $this->dimension; $d++) {
            if ((mt_rand() / mt_getrandmax()) < $this->mutationRate) {
                $lower = $this->bounds['lower'][$d] ?? $this->bounds['lower'][0];
                $upper = $this->bounds['upper'][$d] ?? $this->bounds['upper'][0];
                $range = $upper - $lower;
                
                // Box-Muller dönüşümü ile Gaussian rastgele sayı
                $u1 = (mt_rand() / mt_getrandmax());
                $u2 = (mt_rand() / mt_getrandmax());
                $gaussian = sqrt(-2 * log($u1)) * cos(2 * M_PI * $u2);
                
                // Mutasyon uygula (standart sapma = range * 0.1)
                $individual[$d] += $gaussian * $range * 0.1;
                
                // Sınır kontrolü
                $individual[$d] = max($lower, min($upper, $individual[$d]));
            }
        }
        
        return $individual;
    }

    /**
     * Uniform Mutasyon
     */
    protected function uniformMutation(array $individual): array
    {
        for ($d = 0; $d < $this->dimension; $d++) {
            if ((mt_rand() / mt_getrandmax()) < $this->mutationRate) {
                $lower = $this->bounds['lower'][$d] ?? $this->bounds['lower'][0];
                $upper = $this->bounds['upper'][$d] ?? $this->bounds['upper'][0];
                $individual[$d] = $lower + (mt_rand() / mt_getrandmax()) * ($upper - $lower);
            }
        }
        
        return $individual;
    }

    public function iterate(int $currentIteration, int $maxIterations): array
    {
        // Elitizm: En iyi bireyleri koru
        $eliteCount = (int)($this->populationSize * $this->elitismRate);
        
        // Fitness'a göre sırala (indekslerle)
        $sortedIndices = array_keys($this->fitness);
        usort($sortedIndices, fn($a, $b) => $this->fitness[$a] <=> $this->fitness[$b]);
        
        $newPopulation = [];
        $newFitness = [];
        
        // Elit bireyleri koru
        for ($i = 0; $i < $eliteCount; $i++) {
            $eliteIndex = $sortedIndices[$i];
            $newPopulation[] = $this->population[$eliteIndex];
            $newFitness[] = $this->fitness[$eliteIndex];
        }
        
        // Yeni nesil oluştur
        while (count($newPopulation) < $this->populationSize) {
            // Ebeveyn seçimi
            $parent1 = $this->tournamentSelection();
            $parent2 = $this->tournamentSelection();
            
            // Çaprazlama
            if ((mt_rand() / mt_getrandmax()) < $this->crossoverRate) {
                $children = $this->blxCrossover($parent1, $parent2);
            } else {
                $children = [$parent1];
            }
            
            foreach ($children as $child) {
                if (count($newPopulation) >= $this->populationSize) break;
                
                // Mutasyon
                $child = $this->gaussianMutation($child);
                
                // Değerlendir
                $childFitness = ($this->objectiveFunction)($child);
                
                $newPopulation[] = $child;
                $newFitness[] = $childFitness;
                
                // En iyi bireyi güncelle
                if ($childFitness < $this->bestFitness) {
                    $this->bestFitness = $childFitness;
                    $this->bestIndividual = $child;
                }
            }
        }
        
        // Popülasyonu güncelle
        $this->population = $newPopulation;
        $this->fitness = $newFitness;
        
        // Yakınsama geçmişine ekle
        $this->convergenceHistory[] = $this->bestFitness;
        
        return [
            'bestFitness' => $this->bestFitness,
            'avgFitness' => array_sum($this->fitness) / count($this->fitness),
            'bestIndividual' => $this->bestIndividual
        ];
    }

    public function getBestFitness(): float
    {
        return $this->bestFitness;
    }

    public function getBestPosition(): array
    {
        return $this->bestIndividual;
    }

    public function getPositions(): array
    {
        return $this->population;
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
     * Popülasyon istatistiklerini döndür
     */
    public function getPopulationStats(): array
    {
        $fitnessValues = $this->fitness;
        sort($fitnessValues);
        
        return [
            'best' => $fitnessValues[0],
            'worst' => end($fitnessValues),
            'average' => array_sum($fitnessValues) / count($fitnessValues),
            'median' => $fitnessValues[(int)(count($fitnessValues) / 2)],
            'diversity' => $this->calculateDiversity()
        ];
    }

    /**
     * Popülasyon çeşitliliğini hesapla
     */
    protected function calculateDiversity(): float
    {
        $centroid = array_fill(0, $this->dimension, 0);
        
        // Centroid hesapla
        foreach ($this->population as $individual) {
            for ($d = 0; $d < $this->dimension; $d++) {
                $centroid[$d] += $individual[$d] / $this->populationSize;
            }
        }
        
        // Ortalama mesafe
        $totalDistance = 0;
        foreach ($this->population as $individual) {
            $distance = 0;
            for ($d = 0; $d < $this->dimension; $d++) {
                $distance += pow($individual[$d] - $centroid[$d], 2);
            }
            $totalDistance += sqrt($distance);
        }
        
        return $totalDistance / $this->populationSize;
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
            'bestFitness' => $this->bestFitness,
            'bestPosition' => $this->bestIndividual,
            'convergenceHistory' => $this->convergenceHistory,
            'executionTime' => $executionTime,
            'populationStats' => $this->getPopulationStats()
        ];
    }
}
