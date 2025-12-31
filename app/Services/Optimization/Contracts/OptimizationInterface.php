<?php

namespace App\Services\Optimization\Contracts;

/**
 * Optimizasyon algoritmalarının ortak arayüzü
 * 
 * Bu interface, tüm metaheuristik optimizasyon algoritmalarının
 * (WOA, PSO, GWO vb.) uyması gereken kontratı tanımlar.
 * 
 * @package App\Services\Optimization\Contracts
 */
interface OptimizationInterface
{
    /**
     * Algoritmayı başlat ve popülasyonu initialize et
     *
     * @param int $populationSize Popülasyon/Parçacık sayısı
     * @param int $dimension Problem boyutu (değişken sayısı)
     * @param array $bounds Alt ve üst sınırlar [['min' => x, 'max' => y], ...]
     * @param callable $objectiveFunction Amaç fonksiyonu (minimize edilecek)
     * @return void
     */
    public function init(int $populationSize, int $dimension, array $bounds, callable $objectiveFunction): void;

    /**
     * Tek bir iterasyon gerçekleştir
     *
     * @param int $currentIteration Mevcut iterasyon numarası
     * @param int $maxIterations Maksimum iterasyon sayısı
     * @return array Iterasyon sonuç bilgileri ['bestFitness' => float, 'avgFitness' => float]
     */
    public function iterate(int $currentIteration, int $maxIterations): array;

    /**
     * En iyi fitness değerini döndür
     *
     * @return float En iyi (minimum) fitness değeri
     */
    public function getBestFitness(): float;

    /**
     * Tüm pozisyonları döndür
     *
     * @return array Tüm bireylerin/parçacıkların pozisyonları
     */
    public function getPositions(): array;

    /**
     * En iyi çözümü (pozisyonu) döndür
     *
     * @return array En iyi çözümün koordinatları
     */
    public function getBestPosition(): array;

    /**
     * Yakınsama geçmişini döndür
     *
     * @return array Her iterasyondaki en iyi fitness değerleri
     */
    public function getConvergenceHistory(): array;

    /**
     * Algoritma adını döndür
     *
     * @return string Algoritma adı
     */
    public function getName(): string;

    /**
     * Tam optimizasyon döngüsünü çalıştır
     *
     * @param int $maxIterations Maksimum iterasyon sayısı
     * @return array Sonuç bilgileri
     */
    public function optimize(int $maxIterations): array;
}
