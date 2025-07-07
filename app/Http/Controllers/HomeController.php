<?php

namespace App\Http\Controllers;


use App\Models\Recipe;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $recipes = Recipe::latest()->take(6)->get();
        $company = CompanySetting::first();
        
        return view('home', compact('recipes', 'company'));
    }

    public function about()
    {
        $company = CompanySetting::first();
        return view('about', compact('company'));
    }

    public function recipes(Request $request)
    {
        // dd('ok');

        $query = Recipe::query();
        
        if ($request->has('type')) {
            $query->where('type', $request->type);
        }
        
        if ($request->has('search')) {
            $query->where('title', 'like', '%'.$request->search.'%')
                  ->orWhere('description', 'like', '%'.$request->search.'%');
        }
        
        $recipes = $query->paginate(12);
        $company = CompanySetting::first();
        
        return view('recipes.index', compact('recipes', 'company'));
    }
}
