<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Review;
class RecipeController extends Controller
{
    public function show(Recipe $recipe)
    {
        $reviews = $recipe->reviews()->latest()->paginate(5);
        $averageRating = $recipe->averageRating();
        
        return view('recipes.show', compact('recipe', 'reviews', 'averageRating'));
    }
}
