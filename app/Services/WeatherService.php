<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WeatherService
{
    public function getMedellinWeather(): array
    {
        $apiKey = config('services.openweather.key');

        if (! empty($apiKey)) {
            $response = Http::withoutVerifying()->get('https://api.openweathermap.org/data/2.5/weather', [
                'q' => 'Medellin,CO',
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => app()->getLocale(),
            ]);

            if ($response->successful()) {
                $data = $response->json();
                $temp = round($data['main']['temp']);
                $weatherId = $data['weather'][0]['id'];

                return [
                    'temp' => $temp,
                    'description' => ucfirst($data['weather'][0]['description']),
                    'icon' => $data['weather'][0]['icon'],
                    'suggestion' => $this->getActivitySuggestion($temp, $weatherId),
                ];
            }
        }

        return [];
    }

    private function getActivitySuggestion(int $temp, int $weatherId): string
    {
        // Weather condition codes: https://openweathermap.org/weather-conditions
        if ($weatherId < 700) {
            return __('weather.suggestion_rain');
        }

        if ($temp >= 25) {
            return __('weather.suggestion_hot');
        }

        if ($temp >= 18) {
            return __('weather.suggestion_perfect');
        }

        return __('weather.suggestion_cold');
    }
}
