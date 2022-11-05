<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Waiting;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class WaitingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

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
                $waiting = new Waiting();
                $waiting->room_id = $request->room_id;
                $waiting->user_id = $request->user_id;
                $waiting->status = 'waiting';
                $isSaved = $waiting->save();
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

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
