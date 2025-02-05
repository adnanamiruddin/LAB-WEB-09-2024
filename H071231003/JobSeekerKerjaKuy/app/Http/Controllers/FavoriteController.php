<?php

namespace App\Http\Controllers;

use App\Models\Favorite;
use App\Models\Job;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $favorites = Favorite::where('job_seeker_id', Auth::id())->with('job')->get();
        return view('dashboard.jobSeeker.favorite', compact('favorites'));
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
    public function store(Request $request, $jobId)
    {
        $cekFavorit   = Favorite::where('job_seeker_id', Auth::id())->where('job_post_id', $jobId)->first();
        if ($cekFavorit){
            $cekFavorit->delete();
        } else {
            $favorite = new Favorite();
            $favorite->job_seeker_id = Auth::id();
            $favorite->job_post_id = $jobId;
            $favorite->save();
        }  

        return redirect()->back()->with('success', 'Job status updated');
    }

    /**
     * Display the specified resource.
     */
    public function show(Favorite $favorite)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Favorite $favorite)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Favorite $favorite)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $favorite = Favorite::where('job_seeker_id', Auth::id())->where('job_post_id', $id)->first();
        if ($favorite) {
            $favorite->delete();
            return redirect()->back()->with('success', 'Job removed from favorites');
        }
        return redirect()->back()->with('error', 'Job not found in favorites');
    }
}
