<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\WorkDistribution; // Uncomment if model exists

class WorkDistributionController extends Controller
{
    public function index()
    {
        // $distributions = WorkDistribution::all();
        // return view('admin.work_distribution.index', compact('distributions'));
        return view('admin.work_distribution.index');
    }

    public function create()
    {
        $users = \App\Models\User::where('role', '!=', 'administrator')->get();
        // Gather all unique skills from users
        $allSkills = $users->pluck('skills')->flatten()->unique()->filter()->values();
        return view('admin.work_distribution.create', compact('users', 'allSkills'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'assignee' => 'required|string|max:255',
            'description' => 'required|string',
            'due_date' => 'required|date|after:today',
        ]);
        // Here you would save to the database if a model existed
        // WorkDistribution::create($validated);
        return redirect()->route('admin.work-distribution.index')->with('success', 'Work distribution created successfully (demo).');
    }
} 