<?php

namespace App\Http\Controllers;

use App\Models\Living;
use App\Models\Order;
use App\Models\Room;
use App\Models\User;
use App\Models\Waiting;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getRoom(Request $request)
    {
        $living = Living::where('id', $request->id)->first('name_en');
        $room = Room::where('living_id', $request->id)->with('living')->get();
        if (request()->ajax()) {
            return datatables()->of($room)
                ->addColumn('action', function ($data) {
                    $button = '<form action="' . route('room.destroy', $data->id) . '" method="post">' . csrf_field() . ' ' . method_field('DELETE') . '<a href="' . route('room.edit', $data->living->id) . '" class="btn btn-primary"> <i class="fa fa-pen"></i></a>' . '&nbsp;' . '<button type="submit" class="btn btn-danger">' . trans('<i class="fa fa-trash"></i>') . '</button></form>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.admin.room.index', ['id' => $request->id, 'name' => $living->name_en]);
    }

    public function countWaitingOrders()
    {
        $waiting = Waiting::count();
        return view('dashboard.admin.home', ['waiting' => $waiting]);
    }

    public function total()
    {
        $living = Living::count();
        $rooms = Room::count();
        $users = User::count();
        $orders = Order::count();
        $waiting = Waiting::count();
        return view('dashboard.admin.home', ['living' => $living, 'room' => $rooms, 'user' => $users, 'order' => $orders, 'waiting' => $waiting]);
    }
}
