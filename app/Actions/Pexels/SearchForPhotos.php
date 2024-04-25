<?php 

namespace App\Actions\Pexels;

use Illuminate\Database\Eloquent\Casts\Json;
use Illuminate\Support\Facades\Http;

class SearchForPhotos
{
    public function execute(String $searchQuery) {
        $response = Http::withHeaders([
            'Authorization' => env('PEXELS_API_KEY')
        ])->get("https://api.pexels.com/v1/search", [
            'query' => $searchQuery,
            'per_page' => 20,
            'total_results' => 20
        ]);

        if ($response->successful()) {
            $response = $response->json();
            array_push($response, "Succesful");

            return $response;
        }

        if ($response->failed()) {
            $response = $response->json();
            array_push($response, "Failed");

            return $response;
        }       
    }
}
