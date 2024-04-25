<?php

namespace Database\Seeders;

use App\Actions\Pexels\GetCollection;
use Domains\Images\Models\Image;
use Domains\Products\Models\ProductLine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ImageSeeder extends Seeder
{
    public function __construct(private GetCollection $getCollection) {

    }
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $prdoductLines = ProductLine::select('productLine', 'pexels_collection_id')
            ->get();
        

        $prdoductLines->each( function ($line) {
            $imageResourceCollection = $this->getCollection->execute($line->pexels_collection_id);

            $imageResourceCollection->each( function ($imageResource) use($line) {
                $image = new Image();
                $image->alt = $imageResource["alt"];
                $image->src = $imageResource["src"];
                $image->product_line_id = $line->productLine;

                $image->save();
            });
        });
    }
}
