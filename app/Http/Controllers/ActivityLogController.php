<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ActivityLog;

class ActivityLogController extends Controller
{
    public function index()
    {
        $logs = ActivityLog::orderBy('created_at', 'desc')->paginate(50);
        return view('activity_logs.index', compact('logs'));
    }

    public function show(ActivityLog $activityLog)
    {
        return view('activity_logs.show', ['log' => $activityLog]);
    }
}
