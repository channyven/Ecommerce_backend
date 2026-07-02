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
     * Real skincare product images from brands (COSRX, CeraVe, Skin1004, etc.)
     * and Pexels stock photos as fallback.
     *
     * String keys reference $realProductUrls; integer IDs reference Pexels photos.
     */
    private array $categoryPhotos = [
        'cleanser'    => ['cosrx-snail-mucin-cleanser', 'cosrx-low-ph-cleanser', 'cosrx-ac-foam-cleanser', 'cerave-air-foam-cleanser'],
        'moisturizer' => ['cerave-cream', 'cerave-lotion', 4465124, 3735649],
        'serum'       => ['cosrx-peptide-serum', 3750077, 4041386, 4041392],
        'sunscreen'   => ['cerave-mineral-spf50', 'cerave-spf30-tint', 5632330],
        'mask'        => [7520460, 4465124, 4041392],
        'toner'       => ['skin1004-toner-pad', 4041386, 4041392],
        'eye'         => [4465124, 3750077],
        'body'        => [11635437, 3735649, 5632330],
        'hand'        => [4465124, 3735649],
    ];

    /**
     * Direct URLs for real brand product images.
     * Keys are string identifiers used in $categoryPhotos.
     * Sources: COSRX, CeraVe, Skin1004 official websites.
     */
    private array $realProductUrls = [
        'skin1004-toner-pad'    => 'https://www.skin1004.com/cdn/shop/products/skin1004-mask-pad-70-pads-130ml-centella-quick-calming-pad-38642832474358_1440x.png?v=1677149423',
        'cosrx-snail-mucin-cleanser' => 'https://www.cosrx.com/cdn/shop/files/advanced-snail-mucin-gel-cleanser-cosrx-official-1_360x.png?v=1724835788',
        'cosrx-low-ph-cleanser'      => 'https://www.cosrx.com/cdn/shop/files/low-ph-good-morning-gel-cleanser-cosrx-official-1_360x.jpg?v=1768785801',
        'cosrx-ac-foam-cleanser'     => 'https://www.cosrx.com/cdn/shop/files/ac-collection-calming-foam-cleanser-cosrx-official-1_360x.jpg?v=1724835747',
        'cerave-air-foam-cleanser'   => 'https://www.cerave.com/-/media/project/loreal/brand-sites/cerave/americas/us/skincare/cleansers/air-foam-foaming-facial-cleanser/700x785/airfoam-cleanser-us-front-li-badge-700x785-v2.jpg?rev=d1d3dcc5700e4cd38ac40fa2109c6241&w=380&hash=66F9103D6924F0E3B941356D978C021C',
        'cerave-cream'               => 'https://www.cerave.com/-/media/project/loreal/brand-sites/cerave/americas/us/products/intensive-moisturizing-cream-pdp/intensive-moisturizing-cream-front-700x875-pdp_v1.png?rev=f50e22b351454a998913046d6d5a4447&w=380&hash=0AAD5FF7F96452D094EC27A41ADAE755',
        'cerave-lotion'              => 'https://www.cerave.com/-/media/project/loreal/brand-sites/cerave/americas/us/skincare/2026/05/iml/12oz/700x785/09-iml-12oz-pdp-700x785-v1.jpg?rev=12e577d453cb434483501d421c4703c6&w=380&hash=7A144ED28A50CE6128F009DF6857A564',
        'cosrx-peptide-serum'        => 'https://www.cosrx.com/cdn/shop/files/1_23a79a66-a967-4533-9e71-cd88b0c6efb2.jpg?v=1724837008',
        'cerave-mineral-spf50'       => 'https://www.cerave.com/-/media/project/loreal/brand-sites/cerave/americas/us/cerave-x-love-island-2026---temporary-pdp-packshots/700x785/invisible-mineral-sunscreen-love-island-700x785-v2.jpg?rev=4b53960737a44a62b667874efb25e314&w=900&hash=C0232F224203653CB572928BC59E4D82',
        'cerave-spf30-tint'          => 'https://www.cerave.com/-/media/project/loreal/brand-sites/cerave/americas/us/sunscreen/face/sheer-tint-light/image---08/desktop/hydrating-mineral-sunscreen-light-packshot-front-700x785-v1.jpg?rev=31893dd94a5c414dae49191414c6b5ce&w=900&hash=F28724706A20BB6134D3D766C4AD3B3E',
    ];

    /**
     * Secondary gallery images (Pexels skincare photos as fallback).
     */
    private array $secondaryPhotos = [
        4041392, 5632330, 3735649, 4041386, 3750077,
    ];

    /**
     * Base URL for Pexels image downloads.
     */
    private string $pexelsBaseUrl = 'https://images.pexels.com/photos';

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

        // Map each product slug to a photo category & index
        $photoIndex = [
            'gentle-foaming-facial-cleanser'       => ['cleanser', 0],
            'rose-petal-foaming-wash'               => ['cleanser', 1],
            'vitamin-c-brightening-oil-cleanser'    => ['cleanser', 0],
            'deep-pore-cleansing-balm'              => ['cleanser', 1],
            'hydrating-micellar-water-500ml'        => ['cleanser', 0],
            'daily-dewy-moisture-cream-spf-30'      => ['moisturizer', 0],
            'collagen-boosting-day-cream'            => ['moisturizer', 1],
            'retinol-night-renewal-cream'            => ['moisturizer', 0],
            'deep-moisture-sleep-recovery'           => ['moisturizer', 1],
            'waterburst-hydrating-gel'              => ['moisturizer', 0],
            'cica-soothing-gel-moisturizer'         => ['moisturizer', 1],
            '20-vitamin-c-brightening-serum'        => ['serum', 0],
            'glow-booster-vitamin-c-drops'          => ['serum', 1],
            'triple-hyaluronic-acid-serum'          => ['serum', 2],
            'hyaluronic-acid-peptide-plump'         => ['serum', 0],
            '05-retinol-smoothing-serum'            => ['serum', 1],
            'bakuchiol-retinol-alternative'         => ['serum', 2],
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
            $photoIds = $this->categoryPhotos[$category] ?? $this->categoryPhotos['cleanser'];
            $primaryIdx = $idx % count($photoIds);
            $primaryPhoto = $photoIds[$primaryIdx];

            // Check if this is a real product image URL or a Pexels photo ID
            if (is_string($primaryPhoto) && isset($this->realProductUrls[$primaryPhoto])) {
                $primaryUrl = $this->realProductUrls[$primaryPhoto];
            } else {
                $primaryUrl = $this->buildPexelsUrl((int) $primaryPhoto);
            }
            $alt = $product->name;

            // Download primary image and store locally
            $localPath = $this->downloadImage($primaryUrl, $product->id, 'primary');
            if (! $localPath) {
                // Fallback: use a Pexels photo instead of hotlinking
                $fallbackUrl = $this->buildPexelsUrl(4465124);
                $localPath = $this->downloadImage($fallbackUrl, $product->id, 'primary') ?? $fallbackUrl;
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
                $secondaryIdx = ($idx + 2) % count($this->secondaryPhotos);
                $secondaryPhotoId = $this->secondaryPhotos[$secondaryIdx];
                $secondaryUrl = $this->buildPexelsUrl($secondaryPhotoId);

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
     * Build a Pexels direct download URL for a given photo ID.
     * Uses a single dimension to avoid cropping product packaging badly.
     */
    private function buildPexelsUrl(int $photoId): string
    {
        return "{$this->pexelsBaseUrl}/{$photoId}/pexels-photo-{$photoId}.jpeg?auto=compress&cs=tinysrgb&w=600";
    }

    /**
     * Download an image from a URL and store it locally.
     * Returns the local storage path on success, or null on failure.
     */
    private function downloadImage(string $url, int $productId, string $suffix): ?string
    {
        try {
            $response = Http::timeout(30)
                ->withOptions([
                    'verify' => false,
                    'allow_redirects' => true,
                    'headers' => [
                        'User-Agent' => 'Mozilla/5.0 (compatible; Laravel/11; Ecommerce/1.0)',
                    ],
                ])
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
