<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $viewData = [];
        $viewData['title'] = 'Home - Products';
        $viewData['products'] = Product::all();

        return view('home.index')->with('viewData', $viewData);
    }
}
