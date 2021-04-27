<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\Time;
use App\User;
use App\Booking;
use App\Mail\AppointmentMail;
class FrontendController extends Controller
{
     public function index()
    {
    	date_default_timezone_set('Asia/Tokyo');

        if(request('date')){
            /*dd($this->findDoctorsBasedOnDate(request('date')));*/
            $doctors = $this->findDoctorsBasedOnDate(request('date'));
            return view('welcome',compact('doctors'));
        }
        /*$doctors = Appointment::where('date',date('Y-m-d'))->get();*/
        $doctors = Appointment::where('date',date('Y-m-d'))->get();
    	return view('welcome',compact('doctors'));
    }

    public function show($doctorId,$date)
    {
        $appointment = Appointment::where('user_id',$doctorId)->where('date',$date)->first();
        $times = Time::where('appointment_id',$appointment->id)->where('status',0)->get();
        $user = User::where('id',$doctorId)->first();
        $doctor_id = $doctorId;

        return view('appointment',compact('times','date','user','doctor_id'));
    }

    public function findDoctorsBasedOnDate($date)
    {
        $doctors = Appointment::where('date',$date)->get();
        return $doctors;

    }
    public function store(Request $rq){
         $rq->validate(['time'=>'required']);
         $check = $this->checkBookingTimeInterval(); // goi ham check exists hay chua
         if($check){
            return redirect()->back()->with('errmessage','You aldready made an appointment. Please wait to make next appointment');
         }
          Booking::create([
            'user_id'=> auth()->user()->id,
            'doctor_id'=> $rq->doctorId,
            'time'=> $rq->time,
            'date'=> $rq->date,
            'status'=>0
        ]);
         Time::where('appointment_id',$rq->appointmentId)
            ->where('time',$rq->time)
            ->update(['status'=>1]);
            $doctorName = User::where('id',$rq->doctorId)->first();
            $mailData= [
                'name' => auth()->user()->name,
                'time' => $rq->time,
                'date' => $rq->date,
                'doctorName' => $doctorName->name
            ];
          try{
           \Mail::to(auth()->user()->email)->send(new AppointmentMail($mailData));

        }catch(\Exception $e){

        }

        return redirect()->back()->with('message','Your appointment was booked');
    }
    public function checkBookingTimeInterval(){
        return Booking::orderby('id','desc')->where('user_id',auth()->user()->id)
        ->whereDate('created_at',date('Y-m-d'))
        ->exists(); //Kiem tra booking da ton tai hay chua vi moi ng chi duoc dat 1 lan trong ngay
    }

     public function myBookings()
    {
        $appointments = Booking::latest()->where('user_id',auth()->user()->id)->get();
        return view('booking.index',compact('appointments'));
    }

}
