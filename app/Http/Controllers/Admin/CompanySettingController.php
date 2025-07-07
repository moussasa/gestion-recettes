<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CompanySettingController extends Controller
{
    public function edit()
    {
        $company = CompanySetting::firstOrNew();
        return view('admin.settings.edit', compact('company'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'required|email',
            'about' => 'required|string',
            'logo' => 'nullable|image|max:2048',
            'remove_logo' => 'nullable|boolean',
        ]);

        $company = CompanySetting::firstOrNew();

        // Handle logo update/removal
        if ($request->has('remove_logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
                $validated['logo'] = null;
            }
        } elseif ($request->hasFile('logo')) {
            if ($company->logo) {
                Storage::disk('public')->delete($company->logo);
            }
            $validated['logo'] = $request->file('logo')->store('company', 'public');
        }

        $company->fill($validated)->save();

        return redirect()->route('admin.settings.edit')->with('success', 'Paramètres mis à jour avec succès');
    }
}