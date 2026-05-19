<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Exception;

class PhoneCatalogService
{
    private string $apiUrl = 'http://35.255.40.205/api/mostPurchasedPhones';

    public function getMostPurchasedPhones(): array
    {
        try {
            $response = Http::timeout(5)->get($this->apiUrl);

            return [
                'success' => $response->successful(),
                'data' => $response->successful() ? $response->json() : [],
            ];
        } catch (Exception $e) {
            return ['success' => false, 'data' => []];
        }
    }
}
