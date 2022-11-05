<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Room;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::with('user', 'room')->get();
        if (request()->ajax()) {
            return datatables()->of($orders)
                ->addColumn('name', function ($data) {
                    return $data->user->name;
                })
                ->addColumn('email', function ($data) {
                    return $data->user->email;
                })
                ->addColumn('living', function ($data) {
                    return $data->room->living->name_en;
                })
                ->addColumn('status', function ($data) {
                    return $data->status_en;
                })
                ->addColumn('kind', function ($data) {
                    return $data->room->kind_en;
                })
                ->addColumn('price', function ($data) {
                    return $data->room->price;
                })
                ->addColumn('create at', function ($data) {
                    return $data->room->created_at;
                })->addColumn('action', function ($data) {
                    $button = '<a href="' . route('order.edit', $data->id) . '" class="btn btn-primary"> <i class="fa fa-pen"></i></a>';
                    return $button;
                })
                ->rawColumns(['name', 'email', 'living', 'status', 'room', 'kind', 'price', 'create at', 'action'])
                ->make(true);
        }
        return view('dashboard.admin.order.index');
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
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        return view('dashboard.admin.order.edit', ['order' => $order]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        if ($order->status_en == 'approval') {
            return redirect()->route('order.index')->with('info', 'Room is booked up');
        } else {
            $order->room_id = $order->room_id;
            $order->user_id = $order->user_id;
            $order->status_en  = 'approval';
            $order->status_ar = 'موافقة';
            $isSaved = $order->save();
            $room = Room::where('id', $order->room_id)->first();
            if ($room->currentrooms != 0 && $room->orderrooms != $room->totalrooms) {
                $room->currentrooms = $room->currentrooms - 1;
                $room->orderrooms = $room->orderrooms + 1;
            } else {
                return redirect()->route('order.index')->with('error', 'No Rooms Available');
            }
            $room->save();
            return redirect()->route('order.index')->with('message', 'Order Created Successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        if ($order->status_en == 'canceled') {
            return redirect()->route('order.index')->with('info', 'Order is Canceled!');
        } else if ($order->status_en == 'approval') {
            $order->status_en = 'canceled';
            $order->status_ar = 'تم ألغاء';
            $order->save();
            $room = Room::where('id', '=', $order->room_id)->first();
            if ($room->currentrooms != $room->totalrooms && $room->orderrooms != 0) {
                $room->currentrooms = $room->currentrooms + 1;
                $room->orderrooms = $room->orderrooms - 1;
                $room->save();
                return redirect()->route('order.index')->with('message', 'Order Canceled Successfully');
            } else {
                return redirect()->route('order.index')->with('error', 'Canceled failed!');
            }
        } else {
            $order->status_en = 'canceled';
            $order->save();
            return redirect()->route('order.index')->with('message', 'Order Canceled Successfully');
        }
    }
}
