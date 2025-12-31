<?php

namespace App\Livewire;

use Livewire\Component;
use App\Services\Optimization\WhaleOptimizationService;
use App\Services\Optimization\ParticleSwarmOptimizationService;
use App\Services\Optimization\GreyWolfOptimizerService;
use App\Services\Optimization\GeneticAlgorithmService;
use App\Services\Optimization\Helpers\ObjectiveFunctions;
use App\Services\Optimization\Helpers\MathExpressionParser;
use App\Services\Optimization\Helpers\CodeGenerator;

class OptimizationDashboard extends Component
{
    // ==================== PARAMETRELER ====================
    public string $selectedAlgorithm = 'woa';
    public $populationSize = 30;
    public $maxIterations = 100;
    public $dimension = 2;
    public string $objectiveFunction = 'sphere';
    public $lowerBound = -10.0;
    public $upperBound = 10.0;
    
    // PSO spesifik
    public $psoInertia = 0.7;
    public $psoCognitive = 2.0;
    public $psoSocial = 2.0;
    
    // GA spesifik
    public $gaCrossoverRate = 0.8;
    public $gaMutationRate = 0.1;
    public $gaTournamentSize = 3;
    
    // ==================== VERSUS MODE ====================
    public bool $versusMode = false;
    public array $versusAlgorithms = ['woa', 'pso'];
    public string $algorithm1 = 'woa';
    public string $algorithm2 = 'pso';
    public ?int $versusSeed = null;
    public bool $useSameSeed = true;
    
    // ==================== CUSTOM FUNCTION ====================
    public bool $useCustomFunction = false;
    public string $customExpression = '';
    public array $expressionErrors = [];
    public bool $expressionValid = false;
    
    // ==================== ÇALIŞMA DURUMU ====================
    public bool $isRunning = false;
    public int $currentIteration = 0;
    public float $currentBestFitness = 0;
    
    // ==================== SONUÇLAR ====================
    public array $convergenceHistory = [];
    public array $positions = [];
    public array $bestPosition = [];
    public array $results = [];
    
    // Versus sonuçları
    public array $versusResults = [];
    public ?string $winner = null;
    
    // ==================== KOD GENERATOR ====================
    public string $codeLanguage = 'python';
    public string $generatedCode = '';

    /**
     * Mevcut algoritmaları döndür
     */
    public function getAlgorithmsProperty(): array
    {
        return [
            'woa' => ['name' => '🐋 Whale Optimization (WOA)', 'color' => '#3b82f6', 'colorClass' => 'blue'],
            'pso' => ['name' => '🔵 Particle Swarm (PSO)', 'color' => '#f97316', 'colorClass' => 'orange'],
            'gwo' => ['name' => '🐺 Grey Wolf Optimizer (GWO)', 'color' => '#94a3b8', 'colorClass' => 'slate'],
            'ga' => ['name' => '🧬 Genetic Algorithm (GA)', 'color' => '#10b981', 'colorClass' => 'green'],
        ];
    }

    /**
     * Mevcut amaç fonksiyonlarını döndür
     */
    public function getObjectiveFunctionsProperty(): array
    {
        return ObjectiveFunctions::getAvailableFunctions();
    }

    /**
     * Örnek ifadeleri döndür
     */
    public function getExpressionExamplesProperty(): array
    {
        return MathExpressionParser::getExamples();
    }

    /**
     * Custom expression değiştiğinde doğrula
     */
    public function updatedCustomExpression($value)
    {
        if (empty(trim($value))) {
            $this->expressionErrors = [];
            $this->expressionValid = false;
            return;
        }

        $validation = MathExpressionParser::validate($value);
        $this->expressionErrors = $validation['errors'];
        $this->expressionValid = $validation['valid'];
    }

    /**
     * Örnek ifade seç
     */
    public function selectExample(string $expression)
    {
        $this->customExpression = $expression;
        $this->updatedCustomExpression($expression);
    }

    /**
     * Kod dilini değiştir - Button için
     */
    public function setCodeLanguage(string $language)
    {
        $this->codeLanguage = $language;
        $this->generateCode();
    }

    /**
     * Kod dilini değiştir
     */
    public function updatedCodeLanguage($value)
    {
        $this->generateCode();
    }

    /**
     * Parametreler değiştiğinde kod güncelle
     */
    public function updatedSelectedAlgorithm($value)
    {
        $this->generateCode();
    }

    public function updatedPopulationSize($value)
    {
        $this->generateCode();
    }

    public function updatedMaxIterations($value)
    {
        $this->generateCode();
    }

    public function updatedDimension($value)
    {
        $this->generateCode();
    }

    public function updatedObjectiveFunction($value)
    {
        $this->generateCode();
    }

    public function updatedLowerBound($value)
    {
        $this->generateCode();
    }

    public function updatedUpperBound($value)
    {
        $this->generateCode();
    }

    /**
     * Kod üret
     */
    public function generateCode()
    {
        $customExpr = $this->useCustomFunction && $this->expressionValid 
            ? $this->customExpression 
            : null;

        $algorithm = $this->versusMode ? $this->algorithm1 : $this->selectedAlgorithm;

        // Değerleri güvenli hale getir (boş ise varsayılan değerleri kullan)
        $popSize = (int) ($this->populationSize !== '' && $this->populationSize !== null ? $this->populationSize : 30);
        $maxIter = (int) ($this->maxIterations !== '' && $this->maxIterations !== null ? $this->maxIterations : 100);
        $dim = (int) ($this->dimension !== '' && $this->dimension !== null ? $this->dimension : 2);
        $lb = (float) ($this->lowerBound !== '' && $this->lowerBound !== null ? $this->lowerBound : -10);
        $ub = (float) ($this->upperBound !== '' && $this->upperBound !== null ? $this->upperBound : 10);

        if ($this->codeLanguage === 'python') {
            $this->generatedCode = CodeGenerator::generatePython(
                $algorithm,
                $popSize,
                $maxIter,
                $dim,
                $lb,
                $ub,
                $this->objectiveFunction,
                $customExpr
            );
        } else {
            $this->generatedCode = CodeGenerator::generateMatlab(
                $algorithm,
                $popSize,
                $maxIter,
                $dim,
                $lb,
                $ub,
                $this->objectiveFunction,
                $customExpr
            );
        }

        $this->dispatch('code-updated');
    }

    /**
     * Optimizasyonu başlat
     */
    public function startOptimization()
    {
        $this->isRunning = true;
        $this->convergenceHistory = [];
        $this->positions = [];
        $this->bestPosition = [];
        $this->currentIteration = 0;
        $this->results = [];

        // Güvenli parametreler
        $popSize = (int) ($this->populationSize !== '' && $this->populationSize !== null ? $this->populationSize : 30);
        $maxIter = (int) ($this->maxIterations !== '' && $this->maxIterations !== null ? $this->maxIterations : 100);
        $dim = (int) ($this->dimension !== '' && $this->dimension !== null ? $this->dimension : 2);
        $lb = (float) ($this->lowerBound !== '' && $this->lowerBound !== null ? $this->lowerBound : -10);
        $ub = (float) ($this->upperBound !== '' && $this->upperBound !== null ? $this->upperBound : 10);

        // Amaç fonksiyonunu al
        if ($this->useCustomFunction && $this->expressionValid) {
            $objectiveFn = MathExpressionParser::createFunction($this->customExpression, $dim);
        } else {
            $objectiveFn = ObjectiveFunctions::getFunction($this->objectiveFunction);
        }

        $bounds = [
            'lower' => array_fill(0, $dim, $lb),
            'upper' => array_fill(0, $dim, $ub)
        ];

        // Optimizer oluştur
        $optimizer = $this->createOptimizer($this->selectedAlgorithm);
        $optimizer->init($popSize, $dim, $bounds, $objectiveFn);

        // İterasyon döngüsü
        for ($i = 1; $i <= $maxIter; $i++) {
            $result = $optimizer->iterate($i, $maxIter);
            
            $this->currentIteration = $i;
            $this->currentBestFitness = $result['bestFitness'];
            $this->bestPosition = $optimizer->getBestPosition();
            
            // Tüm bireylerin pozisyonlarını al (Scatter plot için)
            $this->positions = $optimizer->getPositions();
            
            $this->convergenceHistory[] = [
                'iteration' => $i,
                'fitness' => $result['bestFitness'],
                'avgFitness' => $result['avgFitness']
            ];
        }

        // Final sonuçları
        $this->results = [
            'algorithm' => $optimizer->getName(),
            'bestFitness' => $optimizer->getBestFitness(),
            'bestPosition' => $optimizer->getBestPosition(),
            'totalIterations' => $maxIter,
            'populationSize' => $popSize,
            'dimension' => $dim,
            'objectiveFunction' => $this->useCustomFunction ? 'custom' : $this->objectiveFunction,
            'bounds' => ['lower' => $lb, 'upper' => $ub]
        ];

        $this->isRunning = false;
        
        $this->dispatch('optimization-complete', [
            'convergence' => $this->convergenceHistory,
            'positions' => $this->positions,
            'bestPosition' => $this->bestPosition,
            'bounds' => $bounds
        ]);
    }

    /**
     * Versus mode - Algoritmaları karşılaştır (çoklu destek)
     */
    public function startVersus()
    {
        $this->isRunning = true;
        $this->versusResults = [];
        $this->winner = null;
        $this->convergenceHistory = [];

        // Güvenli parametreler
        $popSize = (int) ($this->populationSize !== '' && $this->populationSize !== null ? $this->populationSize : 30);
        $maxIter = (int) ($this->maxIterations !== '' && $this->maxIterations !== null ? $this->maxIterations : 100);
        $dim = (int) ($this->dimension !== '' && $this->dimension !== null ? $this->dimension : 2);
        $lb = (float) ($this->lowerBound !== '' && $this->lowerBound !== null ? $this->lowerBound : -10);
        $ub = (float) ($this->upperBound !== '' && $this->upperBound !== null ? $this->upperBound : 10);

        // Same seed için seed oluştur
        if ($this->useSameSeed) {
            $this->versusSeed = $this->versusSeed ?? random_int(1, 999999);
        }

        // Amaç fonksiyonunu al
        if ($this->useCustomFunction && $this->expressionValid) {
            $objectiveFn = MathExpressionParser::createFunction($this->customExpression, $dim);
        } else {
            $objectiveFn = ObjectiveFunctions::getFunction($this->objectiveFunction);
        }

        $bounds = [
            'lower' => array_fill(0, $dim, $lb),
            'upper' => array_fill(0, $dim, $ub)
        ];

        // Seçilen tüm algoritmaları çalıştır
        $results = [];
        $algorithmsToRun = count($this->versusAlgorithms) >= 2 
            ? $this->versusAlgorithms 
            : [$this->algorithm1, $this->algorithm2];

        foreach ($algorithmsToRun as $alg) {
            // Same seed kullan
            if ($this->useSameSeed && $this->versusSeed) {
                mt_srand($this->versusSeed);
            }
            
            $startTime = microtime(true);
            
            $optimizer = $this->createOptimizer($alg);
            $optimizer->init($popSize, $dim, $bounds, $objectiveFn);
            
            $convergence = [];
            for ($i = 1; $i <= $maxIter; $i++) {
                $result = $optimizer->iterate($i, $maxIter);
                $convergence[] = [
                    'iteration' => $i,
                    'fitness' => $result['bestFitness']
                ];
            }
            
            $executionTime = microtime(true) - $startTime;
            
            $algInfo = $this->algorithms[$alg] ?? ['name' => strtoupper($alg), 'color' => '#fff'];
            
            $results[$alg] = [
                'name' => $algInfo['name'],
                'shortName' => strtoupper($alg),
                'bestFitness' => $optimizer->getBestFitness(),
                'bestPosition' => $optimizer->getBestPosition(),
                'convergence' => $convergence,
                'executionTime' => round($executionTime * 1000, 2),
                'positions' => $optimizer->getPositions(),
                'color' => $algInfo['color'] ?? '#ffffff',
                'finalIteration' => $maxIter
            ];
        }

        $this->versusResults = $results;

        // Kazananı belirle (en düşük fitness)
        $bestFitness = PHP_FLOAT_MAX;
        $this->winner = null;
        
        foreach ($results as $alg => $result) {
            if ($result['bestFitness'] < $bestFitness) {
                $bestFitness = $result['bestFitness'];
                $this->winner = $alg;
            }
        }

        // Eşitlik kontrolü
        $fitnesses = array_column($results, 'bestFitness');
        if (count(array_unique($fitnesses)) === 1) {
            $this->winner = 'tie';
        }

        $this->isRunning = false;

        $this->dispatch('versus-complete', [
            'results' => $this->versusResults,
            'winner' => $this->winner,
            'bounds' => $bounds,
            'seed' => $this->versusSeed
        ]);
    }

    /**
     * PDF raporu oluştur
     */
    public function downloadPdf()
    {
        $data = [
            'results' => $this->results,
            'convergenceHistory' => $this->convergenceHistory,
            'versusResults' => $this->versusResults,
            'winner' => $this->winner,
            'parameters' => [
                'populationSize' => $this->populationSize,
                'maxIterations' => $this->maxIterations,
                'dimension' => $this->dimension,
                'lowerBound' => $this->lowerBound,
                'upperBound' => $this->upperBound,
                'objectiveFunction' => $this->useCustomFunction ? $this->customExpression : $this->objectiveFunction
            ],
            'generatedAt' => now()->format('Y-m-d H:i:s')
        ];

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('optimization.report-pdf', $data);
        
        return response()->streamDownload(function() use ($pdf) {
            echo $pdf->output();
        }, 'optimization_report_' . date('Y-m-d_His') . '.pdf');
    }

    /**
     * CSV indir
     */
    public function downloadCsv()
    {
        $filename = 'optimization_data_' . date('Y-m-d_His') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"$filename\"",
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            
            // Header
            fputcsv($file, ['Tarih', 'Iterasyon', 'En İyi Fitness', 'Ortalama Fitness']);
            
            // Data
            $date = date('Y-m-d H:i:s');
            foreach ($this->convergenceHistory as $row) {
                fputcsv($file, [
                    $date,
                    $row['iteration'],
                    $row['fitness'],
                    $row['avgFitness'] ?? ''
                ]);
            }
            
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Sıfırla
     */
    public function resetDashboard()
    {
        $this->isRunning = false;
        $this->currentIteration = 0;
        $this->currentBestFitness = 0;
        $this->convergenceHistory = [];
        $this->positions = [];
        $this->bestPosition = [];
        $this->results = [];
        $this->versusResults = [];
        $this->winner = null;
        
        $this->dispatch('dashboard-reset');
    }

    /**
     * Optimizer oluştur
     */
    protected function createOptimizer(string $algorithm)
    {
        return match ($algorithm) {
            'woa' => new WhaleOptimizationService(),
            'pso' => (new ParticleSwarmOptimizationService())
                ->setParameters($this->psoInertia, $this->psoCognitive, $this->psoSocial),
            'gwo' => new GreyWolfOptimizerService(),
            'ga' => (new GeneticAlgorithmService())
                ->setParameters($this->gaCrossoverRate, $this->gaMutationRate, $this->gaTournamentSize),
            default => new WhaleOptimizationService()
        };
    }

    /**
     * Toggle versus algorithm
     */
    public function toggleVersusAlgorithm(string $alg)
    {
        if (in_array($alg, $this->versusAlgorithms)) {
            if (count($this->versusAlgorithms) > 2) {
                $this->versusAlgorithms = array_values(array_diff($this->versusAlgorithms, [$alg]));
            }
        } else {
            $this->versusAlgorithms[] = $alg;
        }
    }

    /**
     * Mount
     */
    public function mount()
    {
        $this->generateCode();
    }

    public function render()
    {
        return view('livewire.optimization-dashboard');
    }
}
