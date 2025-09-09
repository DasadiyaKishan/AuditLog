<?php

namespace Kishan\AuditLog\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Kishan\AuditLog\Models\AuditLog;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->latest();

        // 🔹 Apply Filters
        if ($request->filled('model')) {
            $query->where('model', 'LIKE', "%{$request->model}%");
        }

        if ($request->filled('action')) {
            $query->where('action', $request->action);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $logs = $query->paginate(20);

        return view('audit-log::index', compact('logs'));
    }
}
