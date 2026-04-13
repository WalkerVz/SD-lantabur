<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\VisitorLog;

class VisitorLogController extends Controller
{
    public function index(Request $request)
    {
        $query = VisitorLog::query();

        // Filter IP Address (Partial Match)
        if ($request->filled('ip')) {
            $query->where('ip_address', 'like', '%' . $request->ip . '%');
        }

        // Filter Date
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        $logs = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();
        
        return view('admin.visitor-log.index', compact('logs'));
    }
}
