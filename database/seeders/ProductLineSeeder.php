<?php

namespace Database\Seeders;

use Domains\Products\Models\ProductLine;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductLineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pexelsCollectionReference = [
            "Classic Cars" => "fdu5idb",
            "Motorcycles" => "uuhdrzv",
            "Planes" => "wvvaint",
            "Ships" => "pkfjbkf",
            "Trains" => "vtuiqjp",
            "Trucks and Buses" => "tdhshh0",
            "Vintage Cars" => "fdu5idb",
        ];

        $prdoductLines = ProductLine::select("productLine")
            ->get()
            ->each(function ($line, $key) use ($pexelsCollectionReference) {
                $line->pexels_collection_id = $pexelsCollectionReference[$line->productLine];
            });

        foreach ($prdoductLines as $line) {
            $line->save();
        }
    }
}
