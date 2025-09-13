<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Booking;

class HomeController extends Controller
{
    public function room_details($id){
        $room = Room::find($id);
        if ($room) {
            return view('home.room_details', compact('room'));
        } else {
            return redirect()->back()->with('error', 'Room not found');
        }
    }

    public function add_booking(Request $request, $id){

        $request->validate([
            'startdate' => 'required|date',
            'enddate' => 'date|after:startdate'
        ]);

        $data = new Booking;
        $data->room_id = $id;
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $startdate = $request->startdate;
        $enddate = $request->enddate;
        $isBooked = Booking::where('room_id','$id')
        ->where('start_date','<=',$enddate)
        ->where('end_date','>=',$startdate)->exists();
        if($isBooked){
            return redirect()->back()->with('message', 'Room is already Booked');
        }
        else {
            $data->start_date = $request->startdate;
            $data->end_date = $request->enddate;
            $data->save();

            return redirect()->back()->with('message', 'Booking added successfully');
        }
    }
}
