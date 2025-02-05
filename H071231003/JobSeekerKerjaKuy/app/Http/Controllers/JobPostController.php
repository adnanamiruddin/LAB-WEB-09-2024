<?php

namespace App\Http\Controllers;

use App\Models\jobPost;
use App\Models\Employer; // Add this line
use Illuminate\Contracts\Queue\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log; // Add this line

class JobPostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        if ($user) {
            $employer = Employer::where('user_id', $user->id)->first();
            if ($employer) {
                $jobPosts = JobPost::where('employer_id', $employer->id)->paginate(10);
                return view('dashboard.employer.jobpost', compact('jobPosts'));
            } else {
                $jobPosts = jobPost::where('employer_id', $user->id);
                return view('dashboard.employer.jobpost', compact('jobPosts'));
            }
        }
        abort(401);
    }
        // $user = Auth::user();
        // $employer = Employer::where('user_id', $user->id)->first();
        // $jobPosts = jobPost::where('employer_id', $user->id)->paginate(10);
        // return view('dashboard.employer.jobpost', compact('jobPosts'));

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::check() && Auth::user()->role == 'employer') {
            $employer = Employer::where('user_id', Auth::id())->first();
            if (!$employer) {
                return redirect()->route('jobPost')->withErrors(['error' => 'Anda harus membuat profil perusahaan terlebih dahulu sebelum menambahkan pekerjaan.']);
            }
            return view('dashboard.employer.create-jobPost');
        }
        abort(401);
    }

    public function store(Request $request)
    {
        if (Auth::check() && Auth::user()->role == 'employer') {
            $employer = Employer::where('user_id', Auth::user()->id)->first();

            if (!$employer) {
                return redirect()->back()->withErrors(['error' => 'Employer ID tidak ditemukan']);
            }

            $request->validate([
                'title' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'job_type' => 'required|string|in:full-time,part-time,freelance',
                'description' => 'required|string',
                'requirements' => 'required|string',
                'salary' => 'nullable|numeric',
                'payday' => 'required|string|in:yearly,monthly,weekly,daily',
            ], [
                'title.required' => 'Nama Pekerjaan Harus di Isi',
                'location.required' => 'Lokasi Pekerjaan Harus di Isi',
                'job_type.required' => 'Tipe Pekerjaan Harus di Isi',
                'description.required' => 'Deskripsi Pekerjaan Harus di Isi',
                'requirements.required' => 'Persyaratan Pekerjaan Harus di Isi',
                'salary.required' => 'Gaji Pekerjaan Harus di Isi',
                'salary.numeric' => 'Gaji Harus Berupa Angka',
                'salary.min' => 'Gaji Tidak Boleh Kurang dari 0',
                'payday.required' => 'Pilih Periode Pembayaran Gaji',
            ]);


            JobPost::create([
                'employer_id' => $employer->id, // Updated to use the employer's ID
                'title' => $request->title,
                'location' => $request->location,
                'job_type' => $request->job_type,
                'description' => $request->description,
                'requirements' => $request->requirements,
                'salary' => $request->salary,
                'status' => 'active', 
                'payday' => $request->payday,
            ]);

            return redirect()->route('jobPost')->with('success', 'Pekerjaan Berhasil di Buat');
        }
        abort(401);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (Auth::check() && Auth::user()->role == 'employer') {
            $jobPost = JobPost::findOrFail($id);
            $employer = Employer::where('user_id', Auth::user()->id)->first();
            if ($employer && $employer->id == $jobPost->employer_id) {
                return view('dashboard.employer.show-jobPost', compact('jobPost'));
            }
            abort(401);
        }
        abort(401);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (Auth::check() && Auth::user()->role == 'employer') {
            $selectedEmployer = JobPost::findOrFail($id); // Updated to find the job post by ID
            $employer = Employer::where('user_id', Auth::user()->id)->first();
            if ($employer && $employer->id == $selectedEmployer->employer_id) {
                return view('dashboard.employer.edit-jobPost', compact('selectedEmployer'));
            }
            abort(401);
        }
        abort(401);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::check() && Auth::user()->role == 'employer') {
            $request->validate([
                'title' => 'required|string|max:255',
                'location' => 'required|string|max:255',
                'job_type' => 'required|string|in:full-time,part-time,freelance',
                'description' => 'required|string',
                'requirements' => 'required|string',
                'salary' => 'nullable|numeric',
                'status' => 'required|string|in:active,closed',
                'payday' => 'required|string|in:yearly,monthly,weekly,daily',
            ], [
                'title.required' => 'Nama Pekerjaan Harus di Isi',
                'location.required' => 'Lokasi Pekerjaan Harus di Isi',
                'job_type.required' => 'Tipe Pekerjaan Harus di Isi',
                'description.required' => 'Deskripsi Pekerjaan Harus di Isi',
                'requirements.required' => 'Persyaratan Pekerjaan Harus di Isi',
                'salary.required' => 'Gaji Pekerjaan Harus di Isi',
                'salary.numeric' => 'Gaji Harus Berupa Angka',
                'salary.min' => 'Gaji Tidak Boleh Kurang dari 0',
                'status.required' => 'Status Pekerjaan Harus di pilih',
                'payday.required' => 'Pilih Periode Pembayaran Gaji',
            ]);

            $data = [
                'title' => $request->title,
                'location' => $request->location,
                'job_type' => $request->job_type,
                'description' => $request->description,
                'requirements' => $request->requirements,
                'salary' => $request->salary,
                'status' => $request->status, // Add this line to update the status
                'payday' => $request->payday,
            ];

            $jobPost = JobPost::findOrFail($id);
            $employer = Employer::where('user_id', Auth::user()->id)->first();
            if ($employer && $employer->id == $jobPost->employer_id) {
                $jobPost->update($data);
                return redirect()->route('jobPost')->with('success', 'Pekerjaan Berhasil di Update');
            }
            abort(401);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (Auth::check() && Auth::user()->role == 'employer') {
            $jobPost = JobPost::findOrFail($id);
            $employer = Employer::where('user_id', Auth::user()->id)->first();
            if ($employer && $employer->id == $jobPost->employer_id) {
                $jobPost->delete();
                return redirect()->route('jobPost')->with('success', 'Pekerjaan Berhasil di Hapus');
            }
            abort(401);
        }
        abort(401);
    }

    public function listApplicants($id)
    {
        $jobPost = JobPost::with('jobAplications.jobSeeker')->find($id);
        if (!$jobPost) {
            return redirect()->route('jobPost')->with('error', 'Job post not found.');
        }
        return view('dashboard.employer.aplication-user', compact('jobPost'));
    }
}
