<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ProductImageSeeder extends Seeder
{
    /**
     * Picsum.photos seeds curated for skincare products.
     * Each seed produces a consistent, unique image every time.
     */
    private array $categorySeeds = [
        'cleanser'    => ['foaming-cleanser', 'rose-foaming', 'oil-cleanser', 'cleansing-balm', 'micellar-water'],
        'moisturizer' => ['day-cream-dewy', 'collagen-cream', 'night-cream', 'sleep-recovery', 'waterburst-gel'],
        'serum'       => ['vitamin-c-serum', 'glow-booster', 'hyaluronic-serum', 'peptide-plump', 'retinol-serum'],
        'sunscreen'   => ['daily-sunscreen', 'sport-sunscreen'],
        'mask'        => ['sheet-mask', 'sleeping-mask'],
        'toner'       => ['rose-toner', 'rice-toner'],
        'eye'         => ['caffeine-eye', 'retinol-eye'],
        'body'        => ['shea-body', 'aha-body'],
        'hand'        => ['lavender-hand', 'repair-hand'],
    ];

    /**
     * Seeds for secondary gallery images.
     */
    private array $secondarySeeds = [
        'skincare-alt1', 'skincare-alt2', 'skincare-alt3',
        'skincare-alt4', 'skincare-alt5',
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $this->command->warn('No products found. Run ProductSeeder first.');
            return;
        }

        $baseUrl = 'https://picsum.photos/seed/';

        $photoIndex = [
            'gentle-foaming-facial-cleanser'       => ['cleanser', 0],
            'rose-petal-foaming-wash'               => ['cleanser', 1],
            'vitamin-c-brightening-oil-cleanser'    => ['cleanser', 2],
            'deep-pore-cleansing-balm'              => ['cleanser', 3],
            'hydrating-micellar-water-500ml'        => ['cleanser', 4],
            'daily-dewy-moisture-cream-spf-30'      => ['moisturizer', 0],
            'collagen-boosting-day-cream'            => ['moisturizer', 1],
            'retinol-night-renewal-cream'            => ['moisturizer', 2],
            'deep-moisture-sleep-recovery'           => ['moisturizer', 3],
            'waterburst-hydrating-gel'              => ['moisturizer', 4],
            'cica-soothing-gel-moisturizer'         => ['moisturizer', 0],
            '20-vitamin-c-brightening-serum'        => ['serum', 0],
            'glow-booster-vitamin-c-drops'          => ['serum', 1],
            'triple-hyaluronic-acid-serum'          => ['serum', 2],
            'hyaluronic-acid-peptide-plump'         => ['serum', 3],
            '05-retinol-smoothing-serum'            => ['serum', 4],
            'bakuchiol-retinol-alternative'         => ['serum', 0],
            'invisible-daily-sunscreen-spf-50-pa'   => ['sunscreen', 0],
            'water-resistant-sport-sunscreen-spf-50' => ['sunscreen', 1],
            'hyaluronic-acid-sheet-mask-10pk'       => ['mask', 0],
            'collagen-firming-sheet-mask-5pk'       => ['mask', 1],
            'rose-water-hydrating-toner'             => ['toner', 0],
            'milky-rice-water-brightening-toner'     => ['toner', 1],
            'caffeine-eye-cream-for-dark-circles'   => ['eye', 0],
            'retinol-eye-cream-for-fine-lines'      => ['eye', 1],
            'shea-butter-rich-body-lotion'          => ['body', 0],
            'aha-brightening-body-lotion'           => ['body', 1],
            'lavender-shea-hand-cream'              => ['hand', 0],
            'ultra-repair-hand-cream-trio'          => ['hand', 1],
            'overnight-hydration-sleeping-mask'     => ['mask', 1],
            'brightening-vitamin-sleeping-pack'     => ['mask', 0],
            'honey-oat-milk-body-wash'              => ['body', 1],
        ];

        $count = 0;

        foreach ($products as $product) {
            $key = $product->slug;

            if (! isset($photoIndex[$key])) {
                $this->command->warn("No image mapping for product: {$product->name} (slug: {$key})");
                continue;
            }

            [$category, $idx] = $photoIndex[$key];
            $seeds = $this->categorySeeds[$category] ?? $this->categorySeeds['cleanser'];
            $primaryIdx = $idx % count($seeds);
            $primarySeed = $seeds[$primaryIdx];

            $primaryUrl = $baseUrl . $primarySeed . '/600/600';
            $alt = $product->name;

            // Download primary image and store locally
            $localPath = $this->downloadImage($primaryUrl, $product->id, 'primary');
            if (! $localPath) {
                // Fallback: store the URL as-is (will be handled by the str_starts_with check)
                $localPath = $primaryUrl;
            }

            // Create primary image
            ProductImage::create([
                'product_id' => $product->id,
                'path' => $localPath,
                'alt' => $alt,
                'is_primary' => true,
                'sort_order' => 0,
            ]);

            // For featured products, add a secondary gallery image
            if ($product->is_featured) {
                $secondaryIdx = ($idx + 2) % count($this->secondarySeeds);
                $secondarySeed = $this->secondarySeeds[$secondaryIdx];
                $secondaryUrl = $baseUrl . $secondarySeed . '/600/600';

                $secondaryPath = $this->downloadImage($secondaryUrl, $product->id, 'secondary');
                if (! $secondaryPath) {
                    $secondaryPath = $secondaryUrl;
                }

                ProductImage::create([
                    'product_id' => $product->id,
                    'path' => $secondaryPath,
                    'alt' => $alt . ' (alternate view)',
                    'is_primary' => false,
                    'sort_order' => 10,
                ]);
            }

            $count++;
        }

        $this->command->info("Created/downloaded images for {$count} products.");
    }

    /**
     * Download an image from a URL and store it locally.
     * Returns the local storage path on success, or null on failure.
     */
    private function downloadImage(string $url, int $productId, string $suffix): ?string
    {
        try {
            $response = Http::timeout(15)
                ->withOptions(['verify' => false, 'allow_redirects' => true])
                ->get($url);

            if (! $response->successful()) {
                $this->command->warn("  HTTP {$response->status()} for {$url}");
                return null;
            }

            $body = $response->body();
            if (empty($body)) {
                return null;
            }

            // Detect content type and set extension
            $contentType = $response->header('Content-Type') ?? 'image/jpeg';
            $ext = match (true) {
                str_contains($contentType, 'png')  => 'png',
                str_contains($contentType, 'webp') => 'webp',
                str_contains($contentType, 'gif')  => 'gif',
                default                            => 'jpg',
            };

            $filename = "products/{$productId}-{$suffix}.{$ext}";
            Storage::disk('public')->put($filename, $body);

            return $filename;
        } catch (\Throwable $e) {
            $this->command->warn("  Error downloading {$url}: {$e->getMessage()}");
            return null;
        }
    }
}
