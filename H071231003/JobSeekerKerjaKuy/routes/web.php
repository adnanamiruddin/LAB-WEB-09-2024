<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobAplicationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\JobPostController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobSeekerController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\FavoriteController;

Route::get('/', function () {
    $jobs = \App\Models\JobPost::latest()->take(6)->get();
    return view('welcome', compact('jobs'));
});
// Ensure this line is correct
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::get('/dashboard', [HomeController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/employers', [AdminController::class, 'listEmployers'])->name('admin.listEmployers');
    Route::resource('admin', AdminController::class)
        ->names([
            'index' => 'admin.index',
            'create' => 'admin.create',
            'store' => 'admin.store',
            'show' => 'admin.show',
            'edit' => 'admin.edit',
            'update' => 'admin.update',
            'destroy' => 'admin.destroy',
        ]);
    Route::get('/admin/job/{id}/applicants', [AdminController::class, 'listApplicants'])->name('admin.job.applicants');
    Route::get('/admin/jobs/{id}', [AdminController::class, 'listJobsAdmin'])->name('admin.listJobsAdmin');
    Route::get('/admin/employer/{id}/jobs', [AdminController::class, 'listJobsByEmployer'])->name('admin.employer.jobs');
    Route::get('/employer/{id}/jobs', [EmployerController::class, 'listJobs'])->name('employer.jobs');
});

Route::middleware(['auth', 'employer'])->group(function () {
    Route::resource('employer', EmployerController::class)
    ->except(['show'])
    ->names([
        'index' => 'employer.index',
        'create' => 'employer.create',
        'store' => 'employer.store',
        'edit' => 'employer.edit',
        'update' => 'employer.update', 
        'destroy' => 'employer.destroy',
    ]);
    Route::resource('jobPost', JobPostController::class)
    ->names([
        'index' => 'jobPost',
        'create' => 'jobPost.create',
        'store' => 'jobPost.store',
        'edit' => 'jobPost.edit',
        'update' => 'jobPost.update',
        'destroy' => 'jobPost.destroy',
        'show' => 'jobPost.show',
        'listApplicants' => 'employer.aplication',
    ]);
    Route::get('/employer/applications', [JobAplicationController::class, 'listAcceptedRejectedApplicants'])->name('employer.applications');
    Route::get('/employer/job/{id}/applicants', [JobAplicationController::class, 'listApplicants'])->name('employer.aplication');
    Route::get('/employer/jobPost/{id}/applicants', [JobPostController::class, 'listApplicants'])->name('employer.aplication');
    Route::get('/employer/profile/{id}', [JobAplicationController::class, 'showJobSeekerProfile'])->name('employer.profile');
    Route::post('/employer/accept-applicant/{id}', [JobAplicationController::class, 'acceptApplicant'])->name('employer.acceptApplicant');
    Route::post('/employer/reject-applicant/{id}', [JobAplicationController::class, 'rejectApplicant'])->name('employer.rejectApplicant');
});


Route::middleware(['auth', 'job_seeker'])->group(function () {
    Route::resource('jobSeeker', JobSeekerController::class)
        ->names([
            'create' => 'jobSeeker.create',
            'store' => 'jobSeeker.store',
            'edit' => 'jobSeeker.edit',
            'update' => 'jobSeeker.update',
            'destroy' => 'jobSeeker.destroy',
            'jobDetails' => 'jobSeeker.job.details',
        ]);
        Route::get('/jobs', [JobAplicationController::class, 'listJobs'])->name('jobseeker.job.list');
        Route::get('/job/{id}', [JobAplicationController::class, 'jobDetails'])->name('jobseeker.job.details');
        Route::post('/jobseeker/apply/{id}', [JobSeekerController::class, 'apply'])->name('jobseeker.apply');
        Route::get('/job-seeker/applications', [JobAplicationController::class, 'listApplications'])->name('jobSeeker.applications');
        Route::post('/favorite/{job}', [FavoriteController::class, 'store'])->name('jobseeker.favorite');
        Route::delete('/favorite/{job}', [FavoriteController::class, 'destroy'])->name('jobseeker.favorite.remove');
        Route::get('/favorites', [FavoriteController::class, 'index'])->name('jobseeker.favorites');
});





Route::get('/welcome', function () {
    $jobs = \App\Models\JobPost::latest()->take(6)->get();
    return view('welcome', compact('jobs'));
})->name('welcome');

require __DIR__.'/auth.php';