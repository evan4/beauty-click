<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\{Category, Service};

class HomeController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        /* $this->middleware('auth')->except('index');
        $this->middleware('permission:edit users')->only('features'); */
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $categories = Category::with('services')->orderBy('title')->get();
        
        return view('home.index', compact('categories'));
    }

    public function category(Category $category)
    {
        $services = Service::where('category_id', $category->id)->paginate();

        return view('home.category', compact('services'));
    }

    public function service(Service $service)
    {
        return view('home.category', compact('service'));
    }

    public function features()
    {
        return view('home.features');
    }
}