<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Job;
use DataTables;
use App\Http\Requests\JobRequest;

class JobsController extends Controller
{

    public function __construct()
    {
        $this->authorizeResource(Job::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $jobs = Job::query();

            return Datatables::of($jobs)->setTotalRecords(Job::count())
                ->addColumn('action', function ($row) {
                    return  view('jobs.actions', compact('row'));
                })->rawColumns(['action']) ->make(true);
        }
        return view('jobs.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('jobs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(JobRequest $request)
    {
        Job::create($request->all());
        return redirect()->route('jobs.index')->with('success', 'Job has been added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Job $job)
    {
        if (!$job->no_action) {
            return view('jobs.edit', compact('job'));
        }
        return redirect()->route('jobs.index')->with('error', 'This Job can not updated');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(JobRequest $request, Job $job)
    {
        $job->update($request->all());
        return redirect()->route('jobs.index')->with('success', 'Job has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Job $job)
    {
        if (!$job->no_action) {
              $job->delete();
              return redirect()->route('jobs.index')->with('success', 'Job has been deleted');
        }
        return redirect()->route('jobs.index')->with('error', 'This Job can not deleted');
    }
}
