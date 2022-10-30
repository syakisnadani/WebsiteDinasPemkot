<?php

namespace App\Http\Controllers;

use App\Models\staff;
use App\Models\Time;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = staff::all();
        $time = Time::all();
        // dd($data);
        return view('staff', compact('data', 'time'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $time = Time::all();
        return view('add.addStaff', compact('time'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        staff::create($request->all());
        // dd($request->all());
        return redirect()->route('indexStaff');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = staff::find($id);
        $time = Time::all();
        // dd($data);
        
        return view('show.showStaff', compact('data', 'time'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function edit(staff $staff)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = staff::find($id);
        $data->update($request->all());

        return redirect()->route('indexStaff');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\staff  $staff
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = staff::find($id);
        $data->delete();

        return redirect()->route('indexStaff');
    }
}
