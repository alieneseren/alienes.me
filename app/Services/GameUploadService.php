<?php

namespace App\Services;

use App\Models\Game;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use ZipArchive;

class GameUploadService
{
    /**
     * ZIP dosyasını işle ve çıkart
     */
    public function processZipUpload(UploadedFile $zipFile, Game $game): void
    {
        // ZIP'i storage'a kaydet
        $zipPath = $zipFile->store('game-zips', 'local');
        $absoluteZipPath = storage_path('app/' . $zipPath);

        // Çıkarma yolunu oluştur
        $extractPath = public_path('games/' . $game->slug);
        
        // Eski dosyaları temizle
        if (File::isDirectory($extractPath)) {
            File::deleteDirectory($extractPath);
        }
        
        // Klasörü oluştur
        File::makeDirectory($extractPath, 0755, true, true);

        // ZIP'i aç ve çıkart
        $zip = new ZipArchive;
        if ($zip->open($absoluteZipPath) === true) {
            $zip->extractTo($extractPath);
            $zip->close();

            // Entry file'ı bul
            $entryFile = $this->findEntryFile($extractPath);
            
            // Game modelini güncelle
            $game->update([
                'zip_path' => $zipPath,
                'extracted_path' => 'games/' . $game->slug,
                'entry_file' => $entryFile,
            ]);

            Log::info("Game uploaded successfully: {$game->slug}");
        } else {
            Log::error("ZIP açılamadı: {$zipPath}");
            throw new \Exception('ZIP dosyası açılamadı.');
        }
    }

    /**
     * Çıkarılmış dosyalarda entry file'ı bul
     */
    protected function findEntryFile(string $extractPath): string
    {
        // Önce kök dizinde index.html ara
        if (File::exists($extractPath . '/index.html')) {
            return 'index.html';
        }

        // Subdirectory'de ara (Unity build'leri bazen alt klasörde)
        $directories = File::directories($extractPath);
        foreach ($directories as $dir) {
            $indexPath = $dir . '/index.html';
            if (File::exists($indexPath)) {
                return basename($dir) . '/index.html';
            }
        }

        // index.htm dene
        if (File::exists($extractPath . '/index.htm')) {
            return 'index.htm';
        }

        // Hiçbir şey bulunamazsa default
        return 'index.html';
    }

    /**
     * Oyun silindiğinde dosyaları temizle
     */
    public function deleteExtractedFiles(Game $game): void
    {
        if ($game->extracted_path) {
            $extractPath = public_path($game->extracted_path);
            if (File::isDirectory($extractPath)) {
                File::deleteDirectory($extractPath);
            }
        }

        if ($game->zip_path) {
            Storage::disk('local')->delete($game->zip_path);
        }
    }

    /**
     * ZIP dosyasını doğrula
     */
    public function validateZip(UploadedFile $zipFile): bool
    {
        $zip = new ZipArchive;
        $tempPath = $zipFile->getRealPath();
        
        if ($zip->open($tempPath) !== true) {
            return false;
        }

        // En az bir HTML dosyası olmalı
        $hasHtml = false;
        for ($i = 0; $i < $zip->numFiles; $i++) {
            $filename = $zip->getNameIndex($i);
            if (preg_match('/\.html?$/i', $filename)) {
                $hasHtml = true;
                break;
            }
        }

        $zip->close();
        return $hasHtml;
    }
}
