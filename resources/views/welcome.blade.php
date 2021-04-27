<!--xoa welcome mac dinh cua laravel, custom lai-->
@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row ">
        <div class="col-md-6">
            <img src="/doctor/logo.PNG" alt="" class="img img-responsive">
           
        </div>
        <div class="col-md-6">
            <h2>Create an account & Book your appointment</h2>
            <p> Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
            tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
            quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
            consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
            cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
            proident, sunt in culpa qui officia deserunt mollit anim id est laborum. </p>
            <div class="mt-5">
               <a href="{{url('/register')}}"> <button class="btn btn-success">Register as Patient</button></a>
                <a href="{{url('/login')}}"><button class="btn btn-secondary">Login</button></a>
            </div>
        </div>
    </div>
    <hr>
    <!--search doctors-->
    <div class="card">
      <form action="{{url('/')}}" method="GET">
        @csrf
        <div class="card-body">
            <div class="card-header">Find Doctors</div>
            <div class="card-body">
               <div class="row">
                   <div class="col-md-8">
                        <input type="text" name="date" id="datepicker" autocomplete="off" class="form-control">
                   </div>
                   <div class="col-md-4">
                       <button class="btn btn-primary" type="submit">Find Doctors</button>
                   </div>
               </div>
            </div>
        </div>
        </form>
    </div>

    <!--display doctors-->
<hr>
     <div class="card">
        <div class="card-body">
            <div class="card-header">List Doctors</div>
            <div class="card-body">
               <table class="table table-striped">
                   <thead>
                       <tr>
                           <th>#</th>
                           <th>Photo</th>
                           <th>Name</th>
                           <th>Expertise</th>
                           <th>Book</th>
                       </tr>
                   </thead>
                   <tbody>
                    @foreach($doctors as $doctor)
                       <tr>
                           <th scope="row"></th>
                           <td>
                               <img src="{{asset('images')}}/{{$doctor->doctor->image}}" width="100px" style="border-radius:50%">
                           </td>
                           <td>{{$doctor->doctor->name}}</td>
                           <td>{{$doctor->doctor->department}}</td>
                           <td><a href="{{route('create.appointment',[$doctor->user_id,$doctor->date])}}" class="btn btn-success">Book Appointment</a></td>
                       </tr>
                    @endforeach
                   </tbody>
               </table>
            </div>
        </div>
    </div>
</div>

@endsection
