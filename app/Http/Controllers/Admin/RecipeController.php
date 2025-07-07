<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ingredient;
use App\Models\Recipe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class RecipeController extends Controller
{
    public function index()
    {
        $recipes = Recipe::withCount('reviews')->latest()->get();
        return view('admin.recipes.index', compact('recipes'));
    }

    public function create()
    {
        $ingredients = Ingredient::all();
        return view('admin.recipes.create', compact('ingredients'));
    }

   public function store(Request $request)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'instructions' => 'required|string',
        'prep_time' => 'nullable|integer',
        'cook_time' => 'nullable|integer',
        'servings' => 'nullable|integer',
        'type' => 'required|string',
        'image' => 'nullable|image|max:2048',
        'ingredients' => 'required|array',
        'ingredients.*.quantity' => 'required_with:ingredients.*.selected|numeric|min:0.1',
    ]);

    if ($request->hasFile('image')) {
        $validated['image'] = $request->file('image')->store('recipes', 'public');
    }

    $recipe = Recipe::create($validated);

    // Attach ingredients with quantities
    $ingredientsData = [];
    foreach ($request->ingredients as $ingredientId => $ingredientData) {
        if (isset($ingredientData['selected'])) {
            $ingredientsData[$ingredientId] = ['quantity' => $ingredientData['quantity']];
        }
    }
    $recipe->ingredients()->attach($ingredientsData);

    return redirect()->route('admin.recipes.index')->with('success', 'Recette créée avec succès');
}

public function update(Request $request, Recipe $recipe)
{
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'instructions' => 'required|string',
        'prep_time' => 'nullable|integer',
        'cook_time' => 'nullable|integer',
        'servings' => 'nullable|integer',
        'type' => 'required|string',
        'image' => 'nullable|image|max:2048',
        'remove_image' => 'nullable|boolean',
        'ingredients' => 'required|array',
        'ingredients.*.quantity' => 'required_with:ingredients.*.selected|numeric|min:0.1',
    ]);

    // Handle image update/removal
    if ($request->hasFile('image')) {
        // Delete old image if exists
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }
        $validated['image'] = $request->file('image')->store('recipes', 'public');
    } elseif ($request->remove_image && $recipe->image) {
        Storage::disk('public')->delete($recipe->image);
        $validated['image'] = null;
    }

    $recipe->update($validated);

    // Sync ingredients with quantities
    $ingredientsData = [];
    foreach ($request->ingredients as $ingredientId => $ingredientData) {
        if (isset($ingredientData['selected'])) {
            $ingredientsData[$ingredientId] = ['quantity' => $ingredientData['quantity']];
        }
    }
    $recipe->ingredients()->sync($ingredientsData);

    return redirect()->route('admin.recipes.index')->with('success', 'Recette mise à jour avec succès');
}

    public function show(Recipe $recipe)
    {
        $recipe->load(['ingredients', 'reviews.user']);
        return view('admin.recipes.show', compact('recipe'));
    }

    public function edit(Recipe $recipe)
    {
        $ingredients = Ingredient::all();
        $recipe->load('ingredients');
        return view('admin.recipes.edit', compact('recipe', 'ingredients'));
    }

    // public function update(Request $request, Recipe $recipe)
    // {
    //     $validated = $request->validate([
    //         'title' => 'required|string|max:255',
    //         'description' => 'required|string',
    //         'instructions' => 'required|string',
    //         'prep_time' => 'nullable|integer',
    //         'cook_time' => 'nullable|integer',
    //         'servings' => 'nullable|integer',
    //         'type' => 'required|string',
    //         'image' => 'nullable|image|max:2048',
    //         'remove_image' => 'nullable|boolean',
    //         'ingredients' => 'required|array',
    //         'ingredients.*.id' => 'required|exists:ingredients,id',
    //         'ingredients.*.quantity' => 'required|numeric|min:0.1',
    //     ]);

    //     // Handle image update/removal
    //     if ($request->has('remove_image')) {
    //         if ($recipe->image) {
    //             Storage::disk('public')->delete($recipe->image);
    //             $validated['image'] = null;
    //         }
    //     } elseif ($request->hasFile('image')) {
    //         if ($recipe->image) {
    //             Storage::disk('public')->delete($recipe->image);
    //         }
    //         $validated['image'] = $request->file('image')->store('recipes', 'public');
    //     }

    //     $recipe->update($validated);

    //     // Sync ingredients with quantities
    //     $ingredientsData = [];
    //     foreach ($request->ingredients as $ingredient) {
    //         $ingredientsData[$ingredient['id']] = ['quantity' => $ingredient['quantity']];
    //     }
    //     $recipe->ingredients()->sync($ingredientsData);

    //     return redirect()->route('admin.recipes.index')->with('success', 'Recette mise à jour avec succès');
    // }

    public function destroy(Recipe $recipe)
    {
        if ($recipe->image) {
            Storage::disk('public')->delete($recipe->image);
        }
        
        $recipe->delete();
        return redirect()->route('admin.recipes.index')->with('success', 'Recette supprimée avec succès');
    }
}