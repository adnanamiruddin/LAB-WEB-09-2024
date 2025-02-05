<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Employer;
use App\Models\JobPost;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->input('search');
        $users = User::when($search, function ($query, $search) {
            return $query->where('username', 'like', "%{$search}%")
                ->orWhere('email', 'like', "%{$search}%");
        })->paginate(10);

        return view('dashboard.admin.user-admin', compact('users', 'search'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.admin.create-user');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users',
            'email' => 'required|unique:users|email',
            'password' => 'required|min:8',
            'role' => 'required|in:admin,employer,job_seeker',
        ]);

        User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('dashboard.admin.edit-user', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'username' => 'required|unique:users,username,' . $id,
            'email' => 'required|unique:users,email,' . $id . '|email',

        ]);

        $user = User::findOrFail($id);
        $user->update([
            'username' => $request->username,
            'email' => $request->email,

        ]);

        return redirect()->route('admin.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.index')->with('success', 'User deleted successfully.');
    }

    public function listJobsAdmin()
    {
        $employer = Employer::first(); // Adjust this line to get the correct employer
        $jobPosts = JobPost::where('employer_id', $employer->id)->get();
        return view('dashboard.admin.list-jobs', compact('jobPosts', 'employer'));
    }

    public function listJobsByEmployer($id)
    {
        $employer = Employer::findOrFail($id);
        $jobPosts = JobPost::where('employer_id', $employer->id)->get();
        return view('dashboard.admin.list-jobs', compact('jobPosts', 'employer'));
    }

    public function listApplicants($id)
    {
        $jobPost = JobPost::with('jobAplications.jobSeeker')->findOrFail($id);
        return view('dashboard.admin.list-aplicant', compact('jobPost'));
    }

    public function listEmployers(Request $request)
    {
        $search = $request->input('search');
        $employers = Employer::when($search, function ($query, $search) {
            return $query->where('company_name', 'like', "%{$search}%")
                ->orWhere('industry', 'like', "%{$search}%");
        })->paginate(10);

        return view('dashboard.admin.list-employer', compact('employers', 'search'));
    }
}
