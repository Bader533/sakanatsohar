<?php

namespace App\Http\Controllers;

use App\Models\Room;
use App\Models\Living;
use App\Models\Order;
use App\Models\RoomImage;
use App\Models\Waiting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class RoomController extends Controller
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
    public function create()
    {
        $living = Living::all();
        return view('dashboard.admin.room.create', ['living' => $living]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rooms = Room::where('living_id', '=', $request->input('living_id'))->get();
        // $roomKind = Room::where('living_id', '=', $request->input('living_id'))->where('kind_en', '=', 'single room')->first();
        // $v = $rooms->where('kind_en', '=', 'single room')->first();
        // dd($v);
        $rule = $this->rule();
        $validator = Validator($request->all(), $rule);
        if (!$validator->fails()) {

            if ($rooms->count() == 3) {
                return redirect()->back()->with('error', 'all rooms is created');
            } else {

                if ($rooms->where('kind_en', '=', $request->input('single_room'))->first() == null) {
                    $this->addRoom($room = new Room(), $request, $request->input('single_room'), 'غرفة مفردة', $request->input('single_totalrooms'), $request->input('single_price'), $request->file('single_image'));
                }
                if ($rooms->where('kind_en', '=', $request->input('double_room'))->first() == null) {
                    $this->addRoom($room = new Room(), $request, $request->input('double_room'), 'غرفة مزدوجة', $request->input('double_totalrooms'),  $request->input('double_price'), $request->file('double_image'));
                }
                if ($rooms->where('kind_en', '=', $request->input('triple_room'))->first() == null) {
                    $this->addRoom($room = new Room(), $request, $request->input('triple_room'), 'غرفة ثلاثية', $request->input('triple_totalrooms'),  $request->input('triple_price'), $request->file('triple_image'));
                }
            }

            return redirect()->route('getlivingroom', $request->input('living_id'))->with('message', 'Room Created Successfully');
        } else {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function show(Room $room)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $living = Living::all();
        $getRoomKind = [];
        $room = Room::where('living_id',  $id)->get();
        foreach ($room as $rooms) {
            $getRoomKind[] = $rooms->kind_en;
        }
        $roomdes = Room::where('living_id',  $id)->first();
        $roomKind = ["single room", "double room", "triple room"];
        $result = array_diff($roomKind, $getRoomKind);

        return view(
            'dashboard.admin.room.edit',
            [
                'room' => $room,
                'living' => $living,
                'roomKind' => $roomKind,
                'result' => $result,
                'roomdes' => $roomdes
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Room $room)
    {
        $rule = $this->rule();
        $validator = Validator($request->all(), $rule);
        if (!$validator->fails()) {
            if ($room->currentrooms == $room->totalrooms && $room->orderrooms == 0) {

                $this->addRoom(
                    Room::where('kind_en', '=', 'single room')->where('living_id', $room->living_id)->first() ?? $room = new Room(),
                    $request,
                    $request->input('single_room'),
                    'غرفة مفردة',
                    $request->input('single_totalrooms'),
                    $request->input('single_price'),
                    $request->file('single_image'),
                );

                $this->addRoom(
                    Room::where('kind_en', '=', 'double room')->where('living_id', $room->living_id)->first() ?? $room = new Room(),
                    $request,
                    $request->input('double_room'),
                    'غرفة مزدوجة',
                    $request->input('double_totalrooms'),
                    $request->input('double_price'),
                    $request->file('double_image'),
                );

                $this->addRoom(
                    Room::where('kind_en', '=', 'triple room')->where('living_id', $room->living_id)->first() ?? $room = new Room(),
                    $request,
                    $request->input('triple_room'),
                    'غرفة ثلاثية',
                    $request->input('triple_totalrooms'),
                    $request->input('triple_price'),
                    $request->file('triple_image'),
                );
            } else {
                return redirect()->back()->with('error', 'Update The Room Not Avalible');
            }

            return redirect()->route('getlivingroom', $request->input('living_id'))->with('message', 'Room updated Successfully');
        } else {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Room  $room
     * @return \Illuminate\Http\Response
     */
    public function destroy(Room $room)
    {

        $orders = Order::where('room_id', '=', $room->id)->get();
        $living = Living::where('id', $room->living_id)->first();
        if ($orders->isEmpty()) {
            $isDeleted = $room->delete();
            return redirect()->route('getlivingroom', $living->id)->with('message', 'room deleted Successfully');
        } else {
            return redirect()->route('getlivingroom', $living->id)->with('error', 'room deleted failde!');
        }
    }
    protected function rule()
    {
        return  $rule = [
            'living_id' => 'required',
            'description_en' => 'required|string | min:2 |max:500',
            'description_ar' => 'required|string | min:2 |max:500',
        ];
    }
    protected function addRoom($room, $request, $kind, $kindAr, $totalrooms, $price, $images)
    {
        $room->living_id = $request->input('living_id');
        $room->description_en = $request->input('description_en');
        $room->description_ar = $request->input('description_ar');
        $room->kind_en = $kind;
        $room->kind_ar = $kindAr;
        $room->totalrooms = $totalrooms;
        $room->price = $price;
        $room->currentrooms = $totalrooms;
        $room->orderrooms = 0;
        if ($images != null) {
            $file_name = str::random(10)  . time() . str::random(10) . '.' . $images->getClientOriginalExtension();
            $path = 'multi/rooms';
            $images->move($path, $file_name);
            $room->image_url = $file_name;
        }
        $room->save();
    }
}
