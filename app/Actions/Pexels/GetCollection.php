<?php

namespace App\Actions\Pexels;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;

class GetCollection
{
    public function execute(String $id) : Collection {
        $response = Http::withHeaders([
            'Authorization' => env('PEXELS_API_KEY')
        ])->get("https://api.pexels.com/v1/collections/{$id}", [
            "per_page" => 10
        ]);

        $status = $response->status();
        $response = $response->json();

        $response["status"] = $status;
        return collect($response["media"]);
    }
}
