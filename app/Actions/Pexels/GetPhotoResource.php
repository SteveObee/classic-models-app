<?php

namespace App\Actions\Pexels;

use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Support\Facades\Http;

class GetPhotoResource
{
    public function execute(Int $id) : Json {
        $response = Http::withHeaders([
            'Authorization' => env('PEXELS_API_KEY')
        ])->get("https://api.pexels.com/v1/photos/{$id}");

        return $response->json();
    }
}
