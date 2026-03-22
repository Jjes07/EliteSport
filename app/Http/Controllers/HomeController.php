<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Product;

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
