<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Living;
use App\Models\Order;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = auth('user-api')->user()->id;

        $order = Order::where('user_id', '=', auth('user-api')->id())->with('room')->get();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $order
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator(
            $request->all(),
            [
                'user_id' => 'required',
                'room_id' => 'required',
            ]
        );

        if (!$validator->fails()) {
            $room = Room::where('id', '=', $request->room_id)->first();
            if ($room->currentrooms != 0) {
                $order = new Order();
                $order->room_id = $request->room_id;
                $order->user_id = $request->user_id;
                $order->status_en = 'waiting';
                $order->status_ar = 'انتظار الموافقة';
                $isSaved = $order->save();
                return response()->json(
                    [
                        'status' => true,
                        'message' => $isSaved ? 'Order is Waiting' : 'Order failed !'
                    ]
                );
            } else {
                return response()->json(
                    [
                        'status' => false,
                        'message' => 'No rooms Avalible !'
                    ],
                );
            }
        } else {
            return response()->json(
                [
                    'status' => false,
                    'message' => $validator->getMessageBag()->first()
                ],
                Response::HTTP_BAD_REQUEST
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $order = Order::select(
            "orders.id",
            "orders.status_en",
            "orders.status_ar",
            "rooms.kind_en",
            "rooms.kind_ar",
            "rooms.price",
            "livings.*",
            "images.*",
        )->where('orders.id', '=', $id)->join("rooms", "orders.room_id", "=", "rooms.id")
            ->join("livings", "rooms.living_id", "=", "livings.id")
            ->join("images", "images.living_id", "=", "livings.id")->first();

        // $order = Order::with(['room.living.images'])->where('id','=',$id)->get();

        // $latestPosts = DB::table('rooms')
        //     ->select('living_id', DB::raw('MAX(price) as max_price'))
        //     ->groupBy('living_id');

        // $user = Living::joinSub($users, '*', function ($join) {
        //     $join->on('livings.id', '=', 'rooms.living_id');
        // })->get();

        // $order = Order::where('id', $id)->with('room', 'living.images')->first();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $order
        ]);
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
