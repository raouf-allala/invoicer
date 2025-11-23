<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller
{
	//
	public function edit()
	{
		$settings = Auth::user()->settings()->first();

		if (!$settings) {
			$settings = Settings::make([
				'name' => '',
				'email' => '',
				'phone' => '',
				'address' => '',
				'website' => '',
			]);
		}

		return view('settings.edit', compact('settings'));
	}

	public function update(Request $request)
	{
		// Validate the incoming request data
		$validated = $request->validate([
			'name' => 'required|string|max:255',
			'email' => 'required|email|max:255',
			'phone' => 'required|string|max:20',
			'address' => 'required|string',
			'website' => 'nullable|url|max:255',
			'logo' => 'nullable|image|max:2048',
			'rc' => 'nullable|string|max:255',
			'nif' => 'nullable|string|max:255',
			'ai' => 'nullable|string|max:255',
			'nis' => 'nullable|string|max:255',
			'capital' => 'nullable|string|max:255',
			'bank_account' => 'nullable|string|max:255',
            'stamp' => 'nullable|image|max:2048',
		]);

		// Check if a new logo file is uploaded
		if ($request->hasFile('logo')) {
			$file = $request->file('logo');
			$path = $file->store('uploads', 'public');
			$validated['logo'] = $path;
		}

        // Check if a new stamp file is uploaded
        if ($request->hasFile('stamp')) {
            $file = $request->file('stamp');
            $path = $file->store('uploads', 'public');
            $validated['stamp'] = $path;
        }

		$user = Auth::user();
		$settings = $user->settings;

		// If there is an existing logo, delete the old one
		if ($settings && $settings->logo && $request->hasFile('logo')) {
			Storage::disk('public')->delete($settings->logo);
		}

        // If there is an existing stamp, delete the old one
        if ($settings && $settings->stamp && $request->hasFile('stamp')) {
            Storage::disk('public')->delete($settings->stamp);
        }

		// Update or create the settings
		$user->settings()->updateOrCreate(
			['user_id' => $user->id],
			$validated
		);

		// Redirect back with a success message
		return redirect()
			->route('settings.edit')
			->with('alert', alertify('All set! Invoice information is up to date.'));
	}

}
