<?php

namespace App\Http\Controllers;

use App\Models\jobAplication;
use Illuminate\Http\Request;
use App\Models\jobSeeker;
use App\Models\JobPost;
use App\Models\Favorite;
use App\Models\Employer;
use Illuminate\Support\Facades\Auth;

class JobAplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    public function apply(Request $request, $id)
    {
        $user = Auth::user();
        $jobSeeker = jobSeeker::where('user_id', $user->id)->first();

        if (!$jobSeeker) {
            return redirect()->route('jobSeeker.create')->with('error', 'Please complete your profile before applying for jobs.');
        }

        $existingApplication = JobAplication::where('job_seeker_id', $jobSeeker->id)->where('job_post_id', $id)->first();
        if ($existingApplication) {
            return redirect()->route('jobseeker.job.list')->with('error', 'You have already applied for this job.');
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
            'status' => 'pending',
        ]);

        return redirect()->route('jobseeker.job.list', $id)->with('success', 'Application submitted successfully.');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(jobAplication $jobAplication)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(jobAplication $jobAplication)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, jobAplication $jobAplication)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(jobAplication $jobAplication)
    {
        //
    }

    public function listJobs(Request $request)
    {
        $query = JobPost::query();

        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        if ($request->filled('salary')) {
            [$minSalary, $maxSalary] = explode('-', $request->salary);
            $query->whereBetween('salary', [$minSalary, $maxSalary ?? PHP_INT_MAX]);
        }

        $jobs = $query->where('status', 'active')->paginate(10);
        $locations = JobPost::select('location')->distinct()->pluck('location');
        $jobTypes = JobPost::select('job_type')->distinct()->pluck('job_type');

        $appliedJobs = collect([]);  // Initialize as empty collection
        
        $user = Auth::user();
        if ($user) {
            $jobSeeker = jobSeeker::where('user_id', $user->id)->first();
            if ($jobSeeker) {
                $appliedJobs = JobAplication::where('job_seeker_id', $jobSeeker->id)
                    ->pluck('job_post_id');
            }
        }

        
        return view('dashboard.jobseeker.jobs', compact('jobs', 'locations', 'jobTypes', 'appliedJobs'));
    }
    
    public function jobDetails($id)
    {
        $job = JobPost::findOrFail($id);
        
        $cekFavorit = Favorite::where('job_seeker_id', Auth::id())->where('job_post_id', $job->id)->exists();

        return view('dashboard.jobseeker.job-details', compact('job', 'cekFavorit'));
    }

    public function listApplicants($id)
    {
        $jobPost = JobPost::with('jobAplications.jobSeeker')->find($id);
        // if (!$jobPost) {
        //     return redirect()->route('employer.jobs')->with('error', 'Job post not found.');
        // }
        return view('dashboard.employer.aplication-user', compact('jobPost'));
    }

    public function showJobSeekerProfile($id)
    {
        $jobSeeker = jobSeeker::find($id);

        if (!$jobSeeker) {
            return redirect()->route('employer.jobs')->with('error', 'Job Seeker profile not found.');
        }

        return view('dashboard.employer.profile', compact('jobSeeker'));
    }

    public function acceptApplicant($id)
    {
        $application = JobAplication::find($id);
        if ($application->status == 'pending') {
            $application->status = 'accepted';
            $application->save();
        }

        return redirect()->back()->with('success', 'Applicant accepted successfully.');
    }

    public function rejectApplicant($id)
    {
        $application = JobAplication::find($id);
        if ($application->status == 'pending') {
            $application->status = 'rejected';
            $application->save();
        }

        return redirect()->back()->with('success', 'Applicant rejected successfully.');
    }

    public function listApplications()
    {
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login to view your applications.');
        }

        $user = Auth::user();
        $jobSeeker = jobSeeker::where('user_id', $user->id)->first();
        
        if (!$jobSeeker) {
            return redirect()->route('jobSeeker.create')
                ->with('error', 'Please complete your profile first.');
        }

        $applications = JobAplication::where('job_seeker_id', $jobSeeker->id)->get();
        return view('dashboard.jobseeker.jobAplications', compact('applications'));
    }

    public function listAcceptedRejectedApplicants()
    {
        $user = Auth::user();
        $employer = Employer::where('user_id', $user->id)->first();
        
        if (!$employer) {
            return redirect()->route('employer.create')->with('error', 'Please complete your profile first.');
        }

        $jobPosts = JobPost::where('employer_id', $employer->id)->with(['jobAplications' => function ($query) {
            $query->whereIn('status', ['accepted', 'rejected']);
        }])->get();

        return view('dashboard.employer.accepted-rejected-applicants', compact('jobPosts', 'employer'));
    }
}
