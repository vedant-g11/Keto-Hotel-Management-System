<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        if (auth::id()) {
            $usertype = Auth::user()->usertype;
            if ($usertype == 'user') {
                $room = Room::all();

                return view('home.index', compact('room'));
            } elseif ($usertype == 'admin') {
                return view('admin.index');
            } else {
                return redirect()->back()->with('error', 'Unauthorized access');
            }
        }
    }

    public function home()
    {
        $room = Room::all();

        return view('home.index', compact('room'));
    }

    public function create_room()
    {
        return view('admin.create_room');
    }

    public function add_room(Request $request)
    {

        $data = new Room;

        $data->room_title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->wifi = $request->wifi;
        $data->room_type = $request->type;

        $image = $request->image;
        if ($image) {
            $imagename = time().'.'.$image->getClientOriginalExtension();
            $request->image->move('room', $imagename);
            $data->image = $imagename;
        } else {
            return redirect()->back()->with('error', 'Image is required');
        }

        $data->save();

        return redirect()->back()->with('message', 'Room added successfully');
    }

    public function view_room()
    {

        $data = Room::all();

        return view('admin.view_room', compact('data'));
    }

    public function room_delete($id)
    {

        $data = Room::find($id);
        if ($data) {
            $data->delete();

            return redirect()->back()->with('message', 'Room deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Room not found');
        }

    }

    public function room_update($id)
    {

        $data = Room::find($id);

        return view('admin.update_room', compact('data'));
    }

    public function edit_room(Request $request, $id)
    {
        $data = Room::find($id);

        if (! $data) {
            return redirect()->back()->with('error', 'Room not found');
        }

        $data->room_title = $request->title;
        $data->description = $request->description;
        $data->price = $request->price;
        $data->wifi = $request->wifi;
        $data->room_type = $request->type;

        if ($request->hasFile('image')) {

            $image = $request->image;
            if ($image) {
                $imagename = time().'.'.$image->getClientOriginalExtension();
                $request->image->move('room', $imagename);
                $data->image = $imagename;
            }
        }

        $data->save();

        return redirect()->back()->with('message', 'Room updated successfully');
    }

    public function bookings()
    {
        $data = Booking::all();

        return view('admin.booking', compact('data'));
    }

    public function delete_booking($id)
    {
        $data = Booking::find($id);
        $data->delete();

        return redirect()->back();
    }

    public function approve_book($id)
    {
        $booking = Booking::find($id);
        $booking->status = 'Approve';
        $booking->save();

        return redirect()->back();
    }
}
