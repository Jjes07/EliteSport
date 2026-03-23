<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request): View
    {
        $viewData = [];
        $viewData['title'] = 'Home - Products';
        $viewData['products'] = Product::all();
        $viewData['showCleanButton'] = false;
        $viewData['categories'] = Category::all();

        $searchTerm = $request->input('name', '');
        $category = $request->input('category', '');

        $searchResult = Product::searchByNameAndCategory($searchTerm, $category);

        $viewData = array_merge($viewData, $searchResult);

        return view('home.index')->with('viewData', $viewData);
    }
}
