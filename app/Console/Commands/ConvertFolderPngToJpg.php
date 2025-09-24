<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ConvertFolderPngToJpg extends Command
{
    protected $signature = 'convert:folder-png-to-jpg';
    protected $description = 'Convert all PNG images in a folder to JPG format';

    public function handle()
    {
        // ✅ specify GD driver
        $manager = new ImageManager(new Driver());

        $directory = storage_path('app/public/billboards_2');

        if (!is_dir($directory)) {
            $this->error("❌ Directory not found: {$directory}");
            return Command::FAILURE;
        }

        $files = glob($directory . '/*.png');
        $converted = 0;

        foreach ($files as $pngPath) {
            $jpgPath = str_replace('.png', '.jpg', $pngPath);

            try {
                $image = $manager->read($pngPath);
                $image->toJpeg(100)->save($jpgPath);

                unlink($pngPath); // delete old PNG

                $this->info("✅ Converted: " . basename($pngPath));
                $converted++;
            } catch (\Throwable $e) {
                $this->error("⚠️ Failed to convert " . basename($pngPath) . ": " . $e->getMessage());
            }
        }

        $this->info("🎉 Done! Converted {$converted} PNG files to JPG.");
        return Command::SUCCESS;
    }
}
