<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller {

    public function index() {
        $settings = Setting::orderBy('group')->get()->groupBy('group');
        return view('admin.settings', compact('settings'));
    }

    public function update(Request $request) {
        $allowedKeys = Setting::pluck('key')->toArray();

        foreach ($request->except(['_token', '_method']) as $key => $value) {
            if (!in_array($key, $allowedKeys)) {
                continue;
            }
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                $value = match ($setting->type) {
                    'boolean' => filter_var($value, FILTER_VALIDATE_BOOLEAN),
                    'number'  => is_numeric($value) ? (float) $value : $value,
                    default   => strip_tags($value),
                };
                $setting->update(['value' => $value]);
            }
        }
        return back()->with('success', 'Settings saved successfully!');
    }
}