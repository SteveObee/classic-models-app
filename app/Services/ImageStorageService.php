<?php

namespace App\Services;

use Domains\Images\Models\Image;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

class ImageStorageService
{
    private $baseStoragePath = "public/images";

    public function __construct(private Image $image) {

    }

    function StoreAll(String $size = '') : void {
        $images = $this->image->select('id', 'src', 'product_line_id')
            ->get()
            ->each( fn ($img) => $img->src = $img->src[$size]);

        $images->each( function ($img) use ($size) {
            $imgFilePath = $this->baseStoragePath . '/' . $size . '/';
            $imgFilename = $img->id . '.jpg';
            

            if (Storage::exists($imgFilePath . $imgFilename)) {
                echo($imgFilename . ' already exists in storage' . ' ...Skipping' . "\r\n");
            }

            if (Storage::missing($imgFilePath . $imgFilename)) {
                echo('Storing ' . $imgFilename . "\r\n");
                $resp = Http::get($img->src);
    
                Storage::put($imgFilePath . $imgFilename, $resp);
            }
        });
    }
}
