<?php

namespace App\Http\Controllers;

use App\Job;
use App\JobProposal;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class JobController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $q = Job::query()->latest();
        if (Auth::user() -> role_id == 3)
        {
            $jobs = $q->where('user_id', Auth::id())->get();

        }else
        {
            $jobs = $q ->get();
        }
        return  view('jobs.index', compact('jobs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return  view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'delivery_date' => 'required|date',
            'budget' => 'numeric|required',
            'file' => 'nullable|file',
        ]);
        // dd($data );
        if ($request->budget > Auth::user()->balance){
            return redirect()->back()->with('message','Top Up your Wallet before Posting this Job')->withInput();
        }

        DB::beginTransaction();
        try {
        //    $job=new Job;
        //     $job->title=$request->title;
        //     $job->description=$request->description;
        //     $job->budget=$request->budget;
        //     $job->delivery_date= Carbon::create($request->delivery_date) ;
            $data['delivery_date'] = Carbon::create($request->delivery_date) ;

            if ($request->hasFile('file'))
            {
                $url=$request->file('file')->store('files');

                $data['file'] = $url;
            }


            $User = Auth::user(); //transfareble
            $User->jobs()->create(
                [
                    'title'=> $data['title'],
                    'description'=> $data['description'],
                    'delivery_date'=> $data['delivery_date'],
                    'budget'=> $data['budget'],
                    'file'=> $data['file'],

                ]
             );
            //  dd($User->jobs);
            $request->session()->flash('status','The Job has been created successfully');

            /*transfer Budget To Admin*/

            $admin = User::where('role_id', 1)->first();
            if ( empty($admin)  || $admin == null) {
                # code...
                $request->session('status',"no admin found");
                return redirect()->back();
            }
            // $wallet = $admin->getWallet(0);
            // dd($wallet);
            //withdraw budget from user
            // deposit to admin
            $User->transfer($admin, floatval($request->budget) );
            DB::commit();
            return redirect()->route('job.index');
        }catch (\Exception $exception)
        {
            DB::rollBack();
            return redirect()->back()->with('message',$exception->getMessage());
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function show(Job $job)
    {
        return  view('jobs.show', compact('job'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        return  view('jobs.edit', compact('job'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Job  $job
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Job $job)
    {
        $data = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'delivery_date' => 'required|date',
            'budget' => 'numeric|required',
            'file' => 'nullable|file',
        ]);

        DB::beginTransaction();
        try {
            $job=new Job;
            $job->title=$request->title;
            $job->description=$request->description;
            $job->budget=$request->budget;
            $job->delivery_date= Carbon::create($request->delivery_date) ;

            if ($request->hasFile('file'))
            {
                $url=$request->file('file')->store('files');
                $job -> file = $url;
            }


            $User = Auth::user();
            $User->jobs()->save($job);
            $request->session()->flash('status','The Job has been Updated successfully');

            DB::commit();
            return redirect()->route('job.index');
        }catch (\Exception $exception)
        {
            DB::rollBack();
            return redirect()->back()->with('message',$exception->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Job  $job
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Job $job)
    {

        try {
            $job->delete();
            return  redirect()->back()->with('message','Deleted');
        } catch (\Exception $e) {
            return  redirect()->back()->with('error','Could Not delete');
        }

    }

    public function apply(Job $job)
    {
        return view('jobs.apply', compact('job'));
    }
    public function applyStore(Request $request, Job $job)
    {
        /*create Proposal*/
        $proposal = JobProposal::firstOrCreate([
            'proposal_text'=> $request->proposal_text,
            'bid'=> $request->bid,
            'delivery_date'=> Carbon::create($request->delivery_date) ,
            'job_id'=> $job ->id ,
        ]);

        Auth::user()->proposals()->save($proposal);

        return redirect()->route('jobs.applied');
    }
    public function applied()
    {
         return view('jobs.applied');
    }
}
