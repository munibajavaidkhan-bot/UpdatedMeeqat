<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    /**
     * Display a listing of activity logs.
     */
    public function index(Request $request)
    {
        $query = ActivityLog::with('user');

        // Search
        if ($search = $request->search) {
            $query->where(function ($q) use ($search) {
                $q->where('action', 'like', "%{$search}%")
                  ->orWhere('module', 'like', "%{$search}%")
                  ->orWhere('ip_address', 'like', "%{$search}%");
            });
        }

        // Filter by action type
        if ($action = $request->action) {
            $query->where('action', $action);
        }

        $logs = $query->latest()->paginate(25);

        $actionTypes = ActivityLog::select('action')
            ->distinct()
            ->pluck('action')
            ->toArray();

        return view('admin.logs.index', compact('logs', 'actionTypes'));
    }
}
