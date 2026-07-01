<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds — creates 32 skincare products.
     */
    public function run(): void
    {
        $childCategories = Category::whereNotNull('parent_id')->get();

        if ($childCategories->isEmpty()) {
            $this->command->warn('No child categories found. Run CategorySeeder first.');
            return;
        }

        $products = [
            // ── Foaming Cleansers ──
            ['name' => 'Gentle Foaming Facial Cleanser', 'category' => 'Foaming Cleansers', 'price' => 24.99, 'compare_price' => 32.00, 'qty' => 60, 'sku' => 'CLN-FOA-001', 'featured' => true, 'desc' => 'A lightweight, sulfate-free foaming cleanser that removes impurities without stripping your skin\'s natural moisture barrier. Enriched with green tea extract and aloe vera to soothe and refresh.' , 'short' => 'Sulfate-free foaming cleanser with green tea & aloe vera for a gentle daily cleanse.'],
            ['name' => 'Rose Petal Foaming Wash', 'category' => 'Foaming Cleansers', 'price' => 28.00, 'qty' => 45, 'sku' => 'CLN-FOA-002', 'featured' => true, 'desc' => 'Infused with real rose petal extract and glycerin, this luxurious foaming wash gently cleanses while leaving your skin soft, hydrated, and delicately scented.' , 'short' => 'Luxurious rose-infused foaming wash for soft, hydrated skin.'],

            // ── Oil-Based Cleansers ──
            ['name' => 'Vitamin C Brightening Oil Cleanser', 'category' => 'Oil-Based Cleansers', 'price' => 32.00, 'compare_price' => 38.00, 'qty' => 35, 'sku' => 'CLN-OIL-001', 'featured' => true, 'desc' => 'This gentle oil cleanser dissolves makeup, sunscreen, and excess sebum while delivering vitamin C antioxidants to brighten and even skin tone. Suitable for all skin types.' , 'short' => 'Brightening oil cleanser with Vitamin C — melts makeup & evens skin tone.'],
            ['name' => 'Deep Pore Cleansing Balm', 'category' => 'Oil-Based Cleansers', 'price' => 36.00, 'qty' => 30, 'sku' => 'CLN-OIL-002', 'featured' => false, 'desc' => 'A silky cleansing balm that transforms into a luxurious oil to deeply cleanse pores and remove waterproof makeup. Formulated with jojoba oil and vitamin E.' , 'short' => 'Silky cleansing balm with jojoba oil for deep pore cleansing.'],

            // ── Micellar Water ──
            ['name' => 'Hydrating Micellar Water 500ml', 'category' => 'Micellar Water', 'price' => 18.99, 'qty' => 80, 'sku' => 'CLN-MIC-001', 'featured' => false, 'desc' => 'Ultra-gentle micellar water with hyaluronic acid to cleanse and hydrate in one step. No rinsing required. Perfect for sensitive skin and quick refresh.' , 'short' => 'Gentle micellar water with hyaluronic acid — no rinse needed.'],

            // ── Day Creams ──
            ['name' => 'Daily Dewy Moisture Cream SPF 30', 'category' => 'Day Creams', 'price' => 38.00, 'compare_price' => 45.00, 'qty' => 50, 'sku' => 'MST-DAY-001', 'featured' => true, 'desc' => 'A lightweight day cream with SPF 30 that hydrates, protects, and gives your skin a natural dewy glow. Packed with ceramides, niacinamide, and vitamin E.' , 'short' => 'Lightweight SPF 30 day cream for dewy hydration & sun protection.'],
            ['name' => 'Collagen Boosting Day Cream', 'category' => 'Day Creams', 'price' => 42.00, 'qty' => 40, 'sku' => 'MST-DAY-002', 'featured' => false, 'desc' => 'Formulated with marine collagen and peptides, this day cream helps restore skin firmness and elasticity while providing all-day moisture.' , 'short' => 'Marine collagen day cream for firmness, elasticity & all-day moisture.'],

            // ── Night Creams ──
            ['name' => 'Retinol Night Renewal Cream', 'category' => 'Night Creams', 'price' => 48.00, 'compare_price' => 58.00, 'qty' => 35, 'sku' => 'MST-NGT-001', 'featured' => true, 'desc' => 'A powerful night cream with encapsulated retinol, bakuchiol, and peptides to reduce fine lines and improve skin texture while you sleep.' , 'short' => 'Retinol & bakuchiol night cream for overnight skin renewal.'],
            ['name' => 'Deep Moisture Sleep Recovery', 'category' => 'Night Creams', 'price' => 44.00, 'qty' => 30, 'sku' => 'MST-NGT-002', 'featured' => false, 'desc' => 'Rich, velvety night cream with shea butter, squalane, and ceramides that deeply nourishes and repairs your skin barrier overnight.' , 'short' => 'Rich shea butter night cream for deep nourishment & barrier repair.'],

            // ── Gel Moisturizers ──
            ['name' => 'Waterburst Hydrating Gel', 'category' => 'Gel Moisturizers', 'price' => 34.00, 'compare_price' => 40.00, 'qty' => 55, 'sku' => 'MST-GEL-001', 'featured' => true, 'desc' => 'An oil-free gel moisturizer that delivers an instant burst of hydration with hyaluronic acid and bamboo water. Perfect for oily and combination skin.' , 'short' => 'Oil-free gel moisturizer with hyaluronic acid — instant hydration burst.'],
            ['name' => 'Cica Soothing Gel Moisturizer', 'category' => 'Gel Moisturizers', 'price' => 30.00, 'qty' => 50, 'sku' => 'MST-GEL-002', 'featured' => false, 'desc' => 'Calming gel moisturizer with centella asiatica (cica) and panthenol to soothe irritated, sensitive skin while providing lightweight hydration.' , 'short' => 'Cica soothing gel for sensitive, irritated skin.'],

            // ── Vitamin C Serums ──
            ['name' => '20% Vitamin C Brightening Serum', 'category' => 'Vitamin C Serums', 'price' => 42.00, 'compare_price' => 52.00, 'qty' => 40, 'sku' => 'SRM-VTC-001', 'featured' => true, 'desc' => 'A potent 20% L-ascorbic acid serum with vitamin E and ferulic acid that brightens dark spots, evens skin tone, and protects against environmental damage.' , 'short' => '20% Vitamin C serum with ferulic acid — brightens & protects.'],
            ['name' => 'Glow Booster Vitamin C Drops', 'category' => 'Vitamin C Serums', 'price' => 36.00, 'qty' => 45, 'sku' => 'SRM-VTC-002', 'featured' => false, 'desc' => 'Lightweight vitamin C derivative (SAP) serum that is gentle enough for sensitive skin. Boosts radiance and fades hyperpigmentation over time.' , 'short' => 'Gentle vitamin C drops for radiance & fading dark spots.'],

            // ── Hyaluronic Acid ──
            ['name' => 'Triple Hyaluronic Acid Serum', 'category' => 'Hyaluronic Acid', 'price' => 38.00, 'compare_price' => 44.00, 'qty' => 60, 'sku' => 'SRM-HYA-001', 'featured' => true, 'desc' => 'A lightweight serum featuring three molecular weights of hyaluronic acid that penetrates multiple layers of skin for deep, long-lasting hydration.' , 'short' => 'Triple-weight hyaluronic acid serum for deep multi-layer hydration.'],
            ['name' => 'Hyaluronic Acid + Peptide Plump', 'category' => 'Hyaluronic Acid', 'price' => 40.00, 'qty' => 50, 'sku' => 'SRM-HYA-002', 'featured' => false, 'desc' => 'Plumping serum combining hyaluronic acid with copper peptides to hydrate, firm, and reduce the appearance of fine lines.' , 'short' => 'HA + peptide plumping serum for hydration & firmness.'],

            // ── Retinol Treatments ──
            ['name' => '0.5% Retinol Smoothing Serum', 'category' => 'Retinol Treatments', 'price' => 44.00, 'compare_price' => 54.00, 'qty' => 30, 'sku' => 'SRM-RET-001', 'featured' => true, 'desc' => 'A gentle yet effective 0.5% retinol serum in a time-release formula that minimizes irritation while smoothing fine lines and refining pores.' , 'short' => 'Time-release 0.5% retinol serum for smooth, refined skin.'],
            ['name' => 'Bakuchiol Retinol Alternative', 'category' => 'Retinol Treatments', 'price' => 38.00, 'qty' => 35, 'sku' => 'SRM-RET-002', 'featured' => false, 'desc' => 'A plant-based retinol alternative using bakuchiol, ideal for sensitive skin. Delivers similar anti-aging benefits without irritation or photosensitivity.' , 'short' => 'Plant-based bakuchiol — retinol alternative for sensitive skin.'],

            // ── SPF 50+ ──
            ['name' => 'Invisible Daily Sunscreen SPF 50+ PA++++', 'category' => 'SPF 50+', 'price' => 28.00, 'qty' => 65, 'sku' => 'SUN-SPF-001', 'featured' => true, 'desc' => 'Weightless, invisible chemical sunscreen with SPF 50+ and PA++++ protection. Dries down matte with zero white cast. Perfect under makeup.' , 'short' => 'Weightless SPF 50+ PA++++ — invisible, zero white cast, matte finish.'],
            ['name' => 'Water-Resistant Sport Sunscreen SPF 50', 'category' => 'SPF 50+', 'price' => 24.99, 'compare_price' => 30.00, 'qty' => 50, 'sku' => 'SUN-SPF-002', 'featured' => false, 'desc' => 'Water-resistant SPF 50 sunscreen that stays put during swimming and sports. Non-greasy formula enriched with vitamin E and aloe vera.' , 'short' => 'Water-resistant SPF 50 — stays put through swimming & sport.'],

            // ── Sheet Masks ──
            ['name' => 'Hyaluronic Acid Sheet Mask (10pk)', 'category' => 'Sheet Masks', 'price' => 22.00, 'qty' => 100, 'sku' => 'MSK-SHT-001', 'featured' => true, 'desc' => 'A pack of 10 ultra-thin, biodegradable sheet masks soaked in hyaluronic acid serum for an intense hydration boost. Suitable for all skin types.' , 'short' => '10 biodegradable HA sheet masks for intense hydration.'],
            ['name' => 'Collagen Firming Sheet Mask (5pk)', 'category' => 'Sheet Masks', 'price' => 18.00, 'compare_price' => 24.00, 'qty' => 75, 'sku' => 'MSK-SHT-002', 'featured' => false, 'desc' => 'Five collagen-infused sheet masks that help improve skin elasticity and firmness. Leaves skin plump, smooth, and radiant.' , 'short' => '5 collagen sheet masks for firm, plump, radiant skin.'],

            // ── Hydrating Toners ──
            ['name' => 'Rose Water Hydrating Toner', 'category' => 'Hydrating Toners', 'price' => 22.00, 'qty' => 70, 'sku' => 'TON-HYD-001', 'featured' => true, 'desc' => 'A soothing rose water toner that balances pH levels, tightens pores, and preps the skin for better product absorption. Alcohol-free and suitable for all skin types.' , 'short' => 'Alcohol-free rose water toner for pH balance & pore tightening.'],
            ['name' => 'Milky Rice Water Brightening Toner', 'category' => 'Hydrating Toners', 'price' => 26.00, 'compare_price' => 32.00, 'qty' => 55, 'sku' => 'TON-HYD-002', 'featured' => false, 'desc' => 'A milky, nourishing toner with fermented rice water and niacinamide that brightens and hydrates while strengthening the skin barrier.' , 'short' => 'Fermented rice water & niacinamide toner for brightening.'],

            // ── Eye Creams ──
            ['name' => 'Caffeine Eye Cream for Dark Circles', 'category' => 'Eye Creams', 'price' => 32.00, 'compare_price' => 38.00, 'qty' => 45, 'sku' => 'EYE-CRM-001', 'featured' => true, 'desc' => 'An energizing eye cream with caffeine and peptides that reduces the appearance of dark circles, puffiness, and fine lines around the delicate eye area.' , 'short' => 'Caffeine & peptide eye cream for dark circles & puffiness.'],
            ['name' => 'Retinol Eye Cream for Fine Lines', 'category' => 'Eye Creams', 'price' => 36.00, 'qty' => 35, 'sku' => 'EYE-CRM-002', 'featured' => false, 'desc' => 'A gentle retinol eye cream that targets crow\'s feet and fine lines while hydrating and strengthening the under-eye area.' , 'short' => 'Gentle retinol eye cream targeting crow\'s feet & fine lines.'],

            // ── Body Lotions ──
            ['name' => 'Shea Butter Rich Body Lotion', 'category' => 'Body Lotions', 'price' => 26.00, 'compare_price' => 32.00, 'qty' => 50, 'sku' => 'BDY-LOT-001', 'featured' => false, 'desc' => 'A rich, fast-absorbing body lotion with shea butter, cocoa butter, and vitamin E that provides 24-hour deep hydration and leaves skin silky smooth.' , 'short' => 'Rich shea & cocoa butter body lotion for 24h hydration.'],
            ['name' => 'AHA Brightening Body Lotion', 'category' => 'Body Lotions', 'price' => 30.00, 'qty' => 40, 'sku' => 'BDY-LOT-002', 'featured' => true, 'desc' => 'Exfoliating body lotion with 10% glycolic acid and ceramides to smooth rough texture, fade dark spots, and reveal brighter, more even-toned skin.' , 'short' => '10% glycolic acid body lotion for smooth, bright skin.'],

            // ── Hand Creams ──
            ['name' => 'Lavender & Shea Hand Cream', 'category' => 'Hand Creams', 'price' => 14.99, 'qty' => 90, 'sku' => 'BDY-HND-001', 'featured' => false, 'desc' => 'A non-greasy hand cream with shea butter and calming lavender essential oil that heals dry hands and leaves a soothing light scent.' , 'short' => 'Calming lavender & shea hand cream for dry hands.'],
            ['name' => 'Ultra-Repair Hand Cream Trio', 'category' => 'Hand Creams', 'price' => 28.00, 'compare_price' => 36.00, 'qty' => 60, 'sku' => 'BDY-HND-002', 'featured' => false, 'desc' => 'A set of three hand creams in Rose, Lavender, and Citrus — each enriched with shea butter, glycerin, and vitamin E for intensive hand care.' , 'short' => 'Trio of hand creams — Rose, Lavender & Citrus with shea butter.'],

            // ── Sleeping Masks ──
            ['name' => 'Overnight Hydration Sleeping Mask', 'category' => 'Sleeping Masks', 'price' => 34.00, 'compare_price' => 40.00, 'qty' => 40, 'sku' => 'MSK-SLP-001', 'featured' => true, 'desc' => 'An overnight gel sleeping mask with squalane and ceramides that locks in moisture while you sleep, so you wake up with plump, glowing skin.' , 'short' => 'Overnight gel mask with squalane for plump, glowing AM skin.'],
            ['name' => 'Brightening Vitamin Sleeping Pack', 'category' => 'Sleeping Masks', 'price' => 32.00, 'qty' => 35, 'sku' => 'MSK-SLP-002', 'featured' => false, 'desc' => 'A leave-on sleeping mask with niacinamide and licorice root extract that works overnight to brighten dull skin and even out skin tone.' , 'short' => 'Niacinamide sleeping mask for overnight brightening.'],

            // ── Body Washes ──
            ['name' => 'Honey & Oat Milk Body Wash', 'category' => 'Body Washes', 'price' => 20.00, 'qty' => 55, 'sku' => 'BDY-WSH-001', 'featured' => false, 'desc' => 'A gentle, sulfate-free body wash with honey and colloidal oat milk that nourishes and soothes dry, sensitive skin with every shower.' , 'short' => 'Sulfate-free honey & oat milk body wash for sensitive skin.'],
        ];

        foreach ($products as $data) {
            $category = $childCategories->firstWhere('name', $data['category']);

            if (! $category) {
                $this->command->warn("Category '{$data['category']}' not found. Skipping '{$data['name']}'.");
                continue;
            }

            Product::create([
                'category_id'       => $category->id,
                'name'              => $data['name'],
                'slug'              => Str::slug($data['name']),
                'description'       => $data['desc'],
                'short_description' => $data['short'],
                'price'             => $data['price'],
                'compare_price'     => $data['compare_price'] ?? null,
                'quantity'          => $data['qty'],
                'sku'               => $data['sku'],
                'is_featured'       => $data['featured'],
                'is_active'         => true,
                'status'            => 'active',
            ]);
        }
    }
}
