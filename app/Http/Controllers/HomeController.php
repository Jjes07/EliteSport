<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\View\View;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $viewData = [];
        $viewData['title'] = 'Home - Products';
        $viewData['categories'] = Product::select('category')->distinct()->pluck('category');

        $searchTerm = $request->input('name', '');
        $category = $request->input('category', '');

        $searchResult = Product::searchByNameAndCategory($searchTerm, $category);

        $viewData = array_merge($viewData, $searchResult);

        return view('home.index')->with('viewData', $viewData);
    }
}
