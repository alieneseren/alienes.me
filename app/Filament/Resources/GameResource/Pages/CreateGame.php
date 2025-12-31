<?php

namespace App\Filament\Resources\GameResource\Pages;

use App\Filament\Resources\GameResource;
use App\Services\GameUploadService;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CreateGame extends CreateRecord
{
    protected static string $resource = GameResource::class;

    protected function afterCreate(): void
    {
        $this->processZipUpload();
    }

    protected function processZipUpload(): void
    {
        $zipPath = $this->data['zip_upload'] ?? null;
        
        if ($zipPath) {
            $fullPath = Storage::disk('local')->path($zipPath);
            
            if (file_exists($fullPath)) {
                $uploadedFile = new UploadedFile(
                    $fullPath,
                    basename($zipPath),
                    'application/zip',
                    null,
                    true
                );

                $service = app(GameUploadService::class);
                $service->processZipUpload($uploadedFile, $this->record);
                
                // Temp dosyayı sil
                Storage::disk('local')->delete($zipPath);
            }
        }
    }
}
