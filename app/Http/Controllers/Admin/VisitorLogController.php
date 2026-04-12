<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\VisitorLog;

class VisitorLogController extends Controller
{
    public function index()
    {
        $logs = VisitorLog::orderBy('created_at', 'desc')->paginate(50);
        return view('admin.visitor-log.index', compact('logs'));
    }
}
