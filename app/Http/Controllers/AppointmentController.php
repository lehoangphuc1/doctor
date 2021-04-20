<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Time;
use App\Appointment;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $myappointments = Appointment::where('user_id',auth()->user()->id)->get();
        return view('admin.appointment.index',compact('myappointments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.appointment.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'date'=>'required|unique:appointments,date,NULL,id,user_id,'.\Auth::id(), //user_id lay gia tri cua id dang nhap hien tai
            'time'=>'required'
        ]);
        $appointment = Appointment::create([
            'user_id'=> auth()->user()->id,
            'date' => $request->date
        ]);
        foreach($request->time as $time){
            Time::create([
                'appointment_id'=> $appointment->id,
                'time'=> $time,
                //'stauts'=>0
            ]);
        }
        return redirect()->back()->with('message','Appointment created for '. $request->date);
       
    }
   public function check(Request $request){

        $date = $request->date;
        $appointment= Appointment::where('date',$date)->where('user_id',auth()->user()->id)->first();
        if(!$appointment){
            return redirect()->to('/appointment')->with('errmessage','Appointment time not available for this date');
        }
        $appointmentId = $appointment->id;
        $times = Time::where('appointment_id',$appointmentId)->get();

       
        return view('admin.appointment.index',compact('times','appointmentId','date'));
    }
   public function updateTime(Request $rq){
        $appointmentId = $rq->appoinmentId;
        $appointment = Time::where('appointment_id',$appointmentId)->delete(); //xóa hết appointment với id hiện tại
        foreach($rq->time as $time){  // cập nhật appointment mới
            Time::create([
                'appointment_id'=>$appointmentId,
                'time'=>$time,
                'status'=>0
            ]);
        }
        return redirect()->route('appointment.index')->with('message','Appointment time updated!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
