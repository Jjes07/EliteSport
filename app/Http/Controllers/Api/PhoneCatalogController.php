<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\PhoneCatalogService;
use Illuminate\View\View;

class PhoneCatalogController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Teléfonos Aliados';
        $viewData['phones'] = (new PhoneCatalogService)->getMostPurchasedPhones();

        return view('phone.index')->with('viewData', $viewData);
    }
}
