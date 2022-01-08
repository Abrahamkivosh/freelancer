<?php

namespace App\Http\Controllers;

use App\Comment;
use App\JobProposal;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class JobProposalController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\JobProposal  $jobProposal
     * @return \Illuminate\Http\Response
     */
    public function show(JobProposal $jobProposal)
    {
        return view('jobs.single-proposa', compact('jobProposal'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\JobProposal  $jobProposal
     * @return \Illuminate\Http\Response
     */
    public function edit(JobProposal $jobProposal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\JobProposal  $jobProposal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, JobProposal $jobProposal)
    {
        $request->validate([
            'remarks' => 'required',
            'file' => 'file',
        ]);
        if ($request->hasFile('file'))
        {
            $url=$request->file('file')->store('files');
            $jobProposal -> delivery_file = $url;
        }
        $jobProposal -> delivery_date = now();
        $jobProposal -> delivery_comments = $request-> remarks;
        $jobProposal -> status = 'delivered';
        $jobProposal -> save();
        return redirect()->back()->with('message','Sent');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\JobProposal  $jobProposal
     * @return \Illuminate\Http\Response
     */
    public function destroy(JobProposal $jobProposal)
    {
        //
    }

    public function acceptProposal(JobProposal $jobProposal)
    {
        $jobProposal ->update(['accepted' => true]);
        return redirect()->back()->with('message','Accepted');
    }

    public function acceptResult(JobProposal $jobProposal)
    {
        $job = $jobProposal -> job ;
        $freelancer = $jobProposal -> user;
        $admin = User::where('role_id', 1)->first();

        $job ->update(['status' => 'closed']);
        $jobProposal ->update(['status' =>'delivered']);
        $bal =  $admin->balance;
        $admin ->transfer($freelancer, $jobProposal -> bid);

        return redirect()->back()->with('message','JOb Delivered and Closed');
    }
}
