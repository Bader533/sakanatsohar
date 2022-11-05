<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Room;
use App\Models\Waiting;
use Illuminate\Http\Request;

class WaitingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $waiting = Waiting::with('user', 'room')->get();
        if (request()->ajax()) {
            return datatables()->of($waiting)
                ->addColumn('action', function ($data) {
                    $button = '<form action="' . route('waiting.destroy', $data->id) . '" method="post">' . csrf_field() . ' ' . method_field('DELETE') . '<a href="' . route('waiting.edit', $data->id) . '" class="btn btn-primary"> <i class="fa fa-pen"></i></a>' . '&nbsp;' . '<button type="submit" class="btn btn-danger">' . trans('<i class="fa fa-trash"></i>') . '</button></form>';
                    return $button;
                })
                ->addColumn('name', function ($data) {
                    return $data->user->name;
                })
                ->addColumn('email', function ($data) {
                    return $data->user->email;
                })
                ->addColumn('living', function ($data) {
                    return $data->room->living->name_en;
                })
                ->addColumn('room', function ($data) {
                    return $data->room->kind;
                })
                ->rawColumns(['action', 'name', 'email', 'living', 'room'])
                ->make(true);
        }
        return view('dashboard.admin.waiting.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Waiting  $waiting
     * @return \Illuminate\Http\Response
     */
    public function show(Waiting $waiting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Waiting  $waiting
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $waiting = Waiting::where('id', $id)->with('user', 'room')->first();
        return view('dashboard.admin.waiting.edit', ['waiting' => $waiting]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Waiting  $waiting
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Waiting $waiting)
    {
        $order = new Order();
        $order->room_id = $waiting->room_id;
        $order->user_id = $waiting->user_id;
        $isSaved = $order->save();
        $room = Room::where('id', $waiting->room_id)->first();
        if ($room->currentrooms != 0 && $room->orderrooms != $room->totalrooms) {
            $room->currentrooms = $room->currentrooms - 1;
            $room->orderrooms = $room->orderrooms + 1;
        } else {
            return redirect()->route('waiting.index')->with('error', 'No Rooms Available');
        }
        $room->save();

        $isDeleted = $waiting->delete();
        if ($isSaved) {
            return redirect()->route('waiting.index')->with('message', 'Order Created Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Waiting  $waiting
     * @return \Illuminate\Http\Response
     */
    public function destroy(Waiting $waiting)
    {
        $isDeleted = $waiting->delete();
        return redirect()->route('waiting.index')->with('message', 'Order Canceled Successfully');
    }
}
