<?php

namespace Database\Seeders;

use App\Models\Listing;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ListingImageSeeder extends Seeder
{
    public function run(): void
    {
        foreach (Listing::all() as $listing) {
            for ($i = 1; $i <= 3; $i++) {
                $seed = "listing-{$listing->id}-{$i}";
                $url = "https://picsum.photos/seed/{$seed}/800/600";

                try {
                    $response = Http::timeout(10)->get($url);

                    if ($response->successful()) {
                        $filename = "images/listing-{$listing->id}-{$i}.jpg";
                        Storage::disk('public')->put($filename, $response->body());
                        $listing->images()->create(['filename' => $filename]);
                    }
                } catch (\Exception $e) {
                    $this->command->warn("Skipped image {$seed}: {$e->getMessage()}");
                }
            }
        }
    }
}
