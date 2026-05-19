<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class PhoneCatalogService
{
    private string $apiUrl = 'http://35.255.40.205/api/mostPurchasedPhones';

    public function getMostPurchasedPhones(): array
    {
        $response = Http::get($this->apiUrl);

        return $response->successful() ? $response->json() : [];
    }
}
