<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogService
{
    public static function log(
        string $action,
        string $module,
        array $details = [],
        ?int $userId = null
    ): void {
        try {
            $request = request();

            ActivityLog::create([
                'user_id'    => $userId ?? auth()->id(),
                'action'     => $action,
                'module'     => $module,
                'details'    => !empty($details) ? $details : null,
                'ip_address' => $request->ip(),
                'user_agent' => $request->userAgent(),
            ]);
        } catch (\Exception $e) {
            // Log silently fails, app should not break
            \Log::error('ActivityLog Error: ' . $e->getMessage());
        }
    }
}