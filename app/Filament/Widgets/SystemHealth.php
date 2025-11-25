<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class SystemHealth extends Widget
{
    protected static string $view = 'filament.widgets.system-health';
    protected int|string|array $columnSpan = 2;

    public static function canView(): bool
    {
        return auth()->user()?->hasRole('super_admin') ?? false;
    }

    protected function getViewData(): array
    {
        
        try {
            DB::connection()->getPdo();
            $dbStatus = '✅ Connected';
        } catch (\Exception $e) {
            $dbStatus = '❌ Database error: ' . $e->getMessage();
        }

       
        $storagePath = storage_path('app/public');
        $used = $this->getFolderSize($storagePath);
        $total = 40 * 1024 * 1024 * 1024; 
        $usagePercent = $total > 0 ? round(($used / $total) * 100, 2) : 0;

       
        $usedFormatted = $this->formatBytes($used);

     
        $logFile = storage_path('logs/laravel.log');
        $errors = [];
        if (File::exists($logFile)) {
            $lines = array_slice(file($logFile), -5);
            $errors = array_reverse($lines);
        }

        return [
            'dbStatus' => $dbStatus,
            'storageUsage' => "{$usedFormatted} ({$usagePercent}%)",
            'errors' => $errors,
        ];
    }

   
    private function getFolderSize(string $dir): int
    {
        $size = 0;
        if (!File::exists($dir)) {
            return 0;
        }

        foreach (File::allFiles($dir) as $file) {
            $size += $file->getSize();
        }

        return $size;
    }

   
    private function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }
}
