<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Recipe;
use App\Models\Review;

class ReviewController extends Controller
{
     public function store(Request $request, Recipe $recipe)
    {
        $request->validate([
            'author_name' => 'required|string|max:255',
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string'
        ]);

        Review::create([
            'recipe_id' => $recipe->id,
            'user_id' => auth()->id(),
            'author_name' => $request->author_name,
            'rating' => $request->rating,
            'comment' => $request->comment
        ]);

        return redirect()->back()->with('success', 'Merci pour votre avis!');
    }
}
