<?php

namespace App\Http\Controllers;

use App\Models\present;
use App\Models\staff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PresentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = staff::all();
        // dd($data);
        return view('present', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('add.uploadPresent');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $upload=$request->file('upload-file');

        $handle = fopen($upload, "r"); //read line one by one

        if ($handle) {
            while (($line = fgets($handle)) !== false) {
                list($pin,$date,$in,$out,$code,$status)=explode("\t",$line);
                // var_dump($pin);
                $save= new present;
                $save->staff_id=$pin;
                $save->date=$date;
                $save->in=$in;
                $save->out=$out;
                $save->code=$code;
                $save->status=$status;
                $save->save();
            }
        
            fclose($handle);
        }
        return to_route('indexPresent');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\present  $present
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        $pin = $request->input('pin');
        $pinStaff = DB::table('staff')->where('pin', $pin)->first();
        $pinPresent = DB::table('presents')->where('staff_id', $pin)->get();

        $id_time = DB::table('staff')->where('pin', $pin)->value('id_times');
        $time = DB::table('times')->where('id', $id_time)->get();

        $month = $request->month;
        $year = $request->year;
        // dd($time);

        return view('printPresent', compact('pinStaff', 'pinPresent', 'month', 'year', 'time'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\present  $present
     * @return \Illuminate\Http\Response
     */
    public function edit(present $present)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\present  $present
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, present $present)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\present  $present
     * @return \Illuminate\Http\Response
     */
    public function destroy(present $present)
    {
        //
    }
    public function indexManual()
    {
        $data = staff::all();
        // dd($data);
        return view('manualPresent', compact('data'));
    }

    public function showManual(Request $request)
    {
        $pin = $request->input('pin');
        $pinStaff = DB::table('staff')->where('pin', $pin)->first();
        $pinPresent = DB::table('presents')->where('staff_id', $pin)->get();

        $id_time = DB::table('staff')->where('pin', $pin)->value('id_times');
        $time = DB::table('times')->where('id', $id_time)->get();

        $month = $request->month;
        $year = $request->year;
        // dd($pinPresent);

        return view('show.showManualPresent', compact('pinStaff', 'pinPresent', 'month', 'year', 'time'));
    }
    public function showDate($id,$date)
    {
        $fromDate = date_create("$date 00:00:00");
        $toDate = date_create("$date 23:59:59");
        $dataPresent = DB::table('presents')
            ->where('staff_id', '=', $id)
            ->where('date', '>', $fromDate)
            ->where('date', '<', $toDate)->get();
        
        $dataStaff = DB::table('staff')->where('pin', $id)->first();

        $inDate = NULL;
        $outDate = NULL;
        $keterangan = NULL;
        $inClock = NULL;
        $outClock = NULL;
        
        for($i = 0; $i<count($dataPresent); $i++)
        {
            if(($dataPresent[$i]->in == 1) && ($dataPresent[$i]->out == 0))
            {
                $inDate = $dataPresent[$i]->id;
                $timestamp = (strtotime($dataPresent[$i]->date));
                $inClock = date('H:i:s', $timestamp);
                $keterangan = $dataPresent[$i]->keterangan;
            }
            if(($dataPresent[$i]->in == 1) && ($dataPresent[$i]->out == 1))
            {
                $outDate = $dataPresent[$i]->id;
                $timestamp = (strtotime($dataPresent[$i]->date));
                $outClock = date('H:i:s', $timestamp);
                $keterangan = $dataPresent[$i]->keterangan;
            }
        }
        // dd($inClock);

        return view('show.showPresentPerDate', compact('dataStaff', 'keterangan','inClock', 'outClock', 'date', 'inDate', 'outDate'));
    }
    public function storeManual(Request $request, $pin)
    {
        // dd($request);
        $inDate = date_create("$request->date $request->in");
        $outDate = date_create("$request->date $request->out");

        // dd($inDate);
        if ($request->idIn != NULL)
        {
            $data = present::find($request->idIn);
            $dataPresentIn = DB::table('presents')->where('id', $request->idIn)->get();
            $data->update([
                'staff_id' => $dataPresentIn[0]->staff_id,
                'date' => $inDate,
                'in' => $dataPresentIn[0]->in,
                'out' => $dataPresentIn[0]->out,
                'code'=> $dataPresentIn[0]->code,
                'status' => $dataPresentIn[0]->status,
                'keterangan' => $request->keterangan
            ]);
        }
        else
        {
            present::create([
                'staff_id' => $pin,
                'date' => $inDate,
                'in' => 1,
                'out' => 0,
                'code'=> 1,
                'status' => 0,
                'keterangan' => $request->keterangan
            ]);
        }
        if($request->idOut != NULL)
        {
            $data = present::find($request->idOut);
            $dataPresentOut = DB::table('presents')->where('id', $request->idOut)->get();
            $data->update([
                'staff_id' => $dataPresentOut[0]->staff_id,
                'date' => $outDate,
                'in' => $dataPresentOut[0]->in,
                'out' => $dataPresentOut[0]->out,
                'code'=> $dataPresentOut[0]->code,
                'status' => $dataPresentOut[0]->status,
                'keterangan' => $request->keterangan
            ]);
        }
        else
        {
            present::create([
                'staff_id' => $pin,
                'date' => $outDate,
                'in' => 1,
                'out' => 1,
                'code'=> 1,
                'status' => 0,
                'keterangan' => $request->keterangan
            ]);
        }

        return redirect()->route('indexManualPresent');
    }
}
