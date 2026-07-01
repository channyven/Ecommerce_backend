<?php

namespace App\Console\Commands;

use App\Models\ProductImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class DownloadProductImages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'products:download-images
        {--force : Re-download images even if already local}
        {--timeout=30 : Timeout in seconds per image download}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Download all external product images to local storage';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $force = $this->option('force');
        $timeout = (int) $this->option('timeout');

        $images = ProductImage::where('path', 'like', 'http%')->get();

        if ($images->isEmpty()) {
            $this->warn('No external product images found.');
            return self::SUCCESS;
        }

        $this->info("Found {$images->count()} external image(s) to download.");
        $bar = $this->output->createProgressBar($images->count());
        $bar->start();

        $downloaded = 0;
        $failed = 0;

        foreach ($images as $image) {
            try {
                $url = $image->path;

                // Generate a unique filename
                $ext = 'jpg';
                $filename = 'products/' . md5($url . $image->id) . '.' . $ext;

                // Skip if already exists locally and not forcing
                if (! $force && Storage::disk('public')->exists($filename)) {
                    // Just update the path to the local one
                    $image->update(['path' => $filename]);
                    $downloaded++;
                    $bar->advance();
                    continue;
                }

                // Download the image
                $response = Http::timeout($timeout)
                    ->withOptions(['verify' => false])
                    ->get($url);

                if (! $response->successful()) {
                    $this->warn("\nFailed to download: {$url} (HTTP {$response->status()})");
                    $failed++;
                    $bar->advance();
                    continue;
                }

                $body = $response->body();

                // Try to detect the actual content type
                $contentType = $response->header('Content-Type');
                if (str_contains($contentType, 'png')) {
                    $filename = 'products/' . md5($url . $image->id) . '.png';
                } elseif (str_contains($contentType, 'webp')) {
                    $filename = 'products/' . md5($url . $image->id) . '.webp';
                }

                // Store the image
                Storage::disk('public')->put($filename, $body);

                // Update the database path
                $image->update(['path' => $filename]);

                $downloaded++;
            } catch (\Throwable $e) {
                $this->warn("\nError downloading image ID {$image->id}: {$e->getMessage()}");
                $failed++;
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine(2);

        $this->info("Done! Downloaded: {$downloaded}, Failed: {$failed}");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
