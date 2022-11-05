<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Living;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LivingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $living = Living::with('images', 'rooms')->get();

        $data = Living::with(['rooms' => function ($query) {
            $query->min('price');
        }])->get();

        // $users = Living::select(
        //     "livings.id",
        //     "livings.name_en",
        //     "livings.description_en",
        //     "rooms.price as room_price"
        // )->join("rooms", "rooms.living_id", "=", "livings.id")->get()->toArray();
        return response()->json([
            'status' => true,
            'message' => 'Success',
            'data' => $data
        ]);
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $living = Living::with('rooms', 'images')->where('id', $id)->get();
        $oneRoom = Room::where('living_id', $id)->first(['description_en', 'description_ar']);

        return response()->json([
            'status' => true,
            'message' => 'Success',
            'description' => $oneRoom,
            'data' => $living
        ]);
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
