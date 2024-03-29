<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\VisitorRequest;
use DataTables;
use App\Country;
use App\City;
use App\User;
use App\Visitor;
use Illuminate\Support\Str;
use App\Traits\ManageFiles;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class VisitorsController extends Controller
{
    use SendsPasswordResetEmails,ManageFiles;

    public function __construct()
    {
        $this->authorizeResource(Visitor::class);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
      
        if ($request->ajax()) {
            $visitor=Visitor::with(['image']);

            return Datatables::of($visitor)
               ->addColumn('action', function ($row) {
                return  view('visitors.actions', compact('row'));
               })
               ->addColumn('status', function ($row) {
                return  view('visitors.status', compact('row'));
               })->rawColumns(['action','status']) ->make(true);
        }
         return view('visitors.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $countries = Country::pluck('name', 'id');
        return view('visitors.create', compact('countries'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VisitorRequest $request)
    {
        $user=User::create(
            array_merge($request->all(), ['password'=> Str::random(8)])
        );
        $visitor=$user->visitor()->create($request->all());

        if ($request->file('image')) {
            $visitor->image()->create(['image'=>$this->Upload($request, 'visitors')]);
        } else {
            $visitor->image()->create(['image'=>$this->DefaultImage()]);
        }

  
        $this->sendResetLinkEmail($request);
        return redirect()->route('visitors.index')->with('success', 'User has been Added');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Visitor $visitor)
    {
        $countries = Country::pluck('name', 'id');
        $cities = City::where("country_id", $visitor->country_id)->pluck("city_name", "id");

        return view('visitors.edit', compact('visitor', 'countries', 'cities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(VisitorRequest $request, Visitor $visitor)
    {
        $visitor->update($request->all());
        $visitor->user->update($request->all());

        if ($image=$request->file('image')) {
            $visitor->image()->update(['image'=>$this->Upload($request, 'visitors')]);
        } else {
            $visitor->image()->update(['image'=>$this->DefaultImage()]);
        }

        return redirect()->route('visitors.index')->with('success', 'visitor has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return redirect()->route('visitors.index')->with('success', 'visitor deleted');
    }
}
