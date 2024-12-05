<?php

namespace App\Http\Controllers;

use App\Models\Employer;
use App\Models\JobPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class EmployerController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function index()
    {
        $user = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();
        
        if (!$employer) {
            return redirect()->route('employer.create')->with('error', 'Please complete your profile first.');
        }

        return view('dashboard.employer.employer-profile', compact('employer'));
    }

    public function create()
    {
        $user = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();
        if (!$employer) {
            return view('dashboard.employer.employer-profile');
        }
        return redirect()->route('employer.edit', $employer->id);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_description' => 'nullable|string',
            'industry' => 'nullable|string|max:255',
            'website' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'address' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $user = Auth::user();
        $profilePicturePath = null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_picture', 'public');
            $data['profile_picture'] = $profilePicturePath;
        }

        Employer::create([
            'user_id' => $user->id,
            'company_name' => $validated['company_name'],
            'company_description' => $validated['company_description'],
            'industry' => $validated['industry'],
            'website' => $validated['website'],
            'phone' => $validated['contact'],
            'address' => $validated['address'],
            'profile_picture' => $profilePicturePath,
        ]);

        return redirect()->route('employer.create')->with('success', 'Pekerjaan Berhasil di Buat');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(int $id)
    {
        $employer = Employer::findOrFail($id);
        return view('dashboard.employer.edit-profile-employer', compact('employer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Employer $employer)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'company_description' => 'nullable|string',
            'industry' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'contact' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048'
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($employer->profile_picture) {
                Storage::delete('public/' . $employer->profile_picture);
            }
            $profilePicturePath = $request->file('profile_picture')->store('profile_picture', 'public');
            $validated['profile_picture'] = $profilePicturePath;
        }

        $employer->update($validated);

        return redirect()->route('employer.index')->with('success', 'Profil perusahaan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Employer $employer)
    {
        //
    }

    public function listJobs($id)
    {
        $employer = Employer::findOrFail($id);
        $jobPosts = JobPost::where('employer_id', $employer->id)->get();
        return view('dashboard.admin.list-jobs', compact('jobPosts', 'employer'));
    }
}
