<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\PhoneCatalogService;
use Illuminate\View\View;

class PhoneCatalogController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = __('phone.title');

        $result = (new PhoneCatalogService)->getMostPurchasedPhones();
        $phones = $result['data'];

        /* Sanitize URLs to resolve any typos in the partner API response before passing to the view */
        foreach ($phones as &$phone) {
            if (isset($phone['url'])) {
                if (str_contains($phone['url'], '35.255.40.205phone')) {
                    $phone['url'] = str_replace('35.255.40.205phone', '35.255.40.205/phone', $phone['url']);
                }
            }
        }

        $viewData['phones'] = $phones;
        $viewData['connectionError'] = ! $result['success'];

        return view('phone.index')->with('viewData', $viewData);
    }
}
