<?php

namespace App\Http\Controllers;

use App\Models\jobSeeker;
use App\Models\JobPost;
use App\Models\JobAplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobSeekerController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function index()
    {
        $user = Auth::user();
        $jobSeeker = jobSeeker::where('user_id', $user->id)->first();
        return view('dashboard.jobSeeker.jobSeeker-profile', compact('jobSeeker'));
    }
    public function create()
    {
        $user = Auth::user();
        $jobSeeker = jobSeeker::where('user_id', $user->id)->first();
        return view('dashboard.jobSeeker.jobSeeker-profile', compact('jobSeeker'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'contact' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'skills' => 'nullable|string',
            'certificates' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:2048',
            'education_history' => 'nullable|string',
            'profile_picture' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg|max:2048',
        ]);

        $user = Auth::user();
        $jobSeeker = jobSeeker::where('user_id', $user->id)->first();

        $certificatesPath = $jobSeeker->certificates ?? null;
        if ($request->hasFile('certificates')) {
            $certificatesPath = $request->file('certificates')->store('certificates', 'public');
        }

        $profilePicturePath = $jobSeeker->profile_picture ?? null;
        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        $data = [
            'user_id' => $user->id,
            'full_name' => $validate['full_name'],
            'date_of_birth' => $validate['date_of_birth'],
            'gender' => $validate['gender'],
            'address' => $validate['address'],
            'contact' => $validate['contact'],
            'bio' => $validate['bio'],
            'skills' => $validate['skills'],
            'certificates' => $certificatesPath,
            'education_history' => $validate['education_history'],
            'profile_picture' => $profilePicturePath,
        ];

        if ($jobSeeker) {
            $jobSeeker->update($data);
            $message = 'Profile updated successfully.';
        } else {
            jobSeeker::create($data);
            $message = 'Profile created successfully.';
        }

        return redirect()->route('jobSeeker.create')->with('success', $message);
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $jobSeeker = jobSeeker::findOrFail($id);
        return view('dashboard.jobseeker.jobSeeker-profile', compact('jobSeeker'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $jobSeeker = jobSeeker::find($id);
        if (!$jobSeeker) {
            return redirect()->route('jobSeeker.create')->with('error', 'Job Seeker not found.');
        }
        return view('dashboard.jobSeeker.edit-profile', compact('jobSeeker'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $jobSeeker = jobSeeker::find($id);
        if (!$jobSeeker) {
            return redirect()->route('jobSeeker.create')->with('error', 'Job Seeker not found.');
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'date_of_birth' => 'nullable|date',
            'gender' => 'nullable|in:male,female',
            'contact' => 'nullable|string|max:15',
            'address' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'skills' => 'nullable|string',
            'certificates' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:2048',
            'education_history' => 'nullable|string',
            'profile_picture' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('certificates')) {
            $certificatesPath = $request->file('certificates')->store('certificates', 'public');
            $data['certificates'] = $certificatesPath;
        }

        if ($request->hasFile('profile_picture')) {
            $profilePicturePath = $request->file('profile_picture')->store('profile_pictures', 'public');
            $data['profile_picture'] = $profilePicturePath;
        }

        $jobSeeker->update($data);

        return redirect()->route('jobSeeker.index', $jobSeeker->id)->with('success', 'Profile updated successfully.');
    }

    public function apply(Request $request, $id)
    {
        $user = Auth::user();
        $jobSeeker = jobSeeker::where('user_id', $user->id)->first();

        if (!$jobSeeker) {
            return redirect()->route('jobSeeker.create')->with('error', 'Please complete your profile before applying for jobs.');
        }

        $request->validate([
            'cover_letter' => 'nullable|string',
            'cv' => 'nullable|mimetypes:image/jpeg,image/png,image/jpg,application/pdf,application/msword,application/vnd.openxmlformats-officedocument.wordprocessingml.document|max:2048',
        ]);

        $cvPath = null;
        if ($request->hasFile('cv')) {
            $cvPath = $request->file('cv')->store('cv', 'public');
        }

        JobAplication::create([
            'job_seeker_id' => $jobSeeker->id,
            'job_post_id' => $id,
            'cover_letter' => $request->input('cover_letter'),
            'cv' => $cvPath,
        ]);

        return redirect()->route('jobseeker.job.list', $id)->with('success', 'Application submitted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(jobSeeker $jobSeeker)
    {
        //
    }
}
