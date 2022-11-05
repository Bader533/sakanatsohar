<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\Living;
use App\Models\Room;
use Illuminate\Support\Str;
use Illuminate\Http\Request;


class LivingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $living = Living::with('rooms')->get();

        if (request()->ajax()) {
            return datatables()->of($living)
                ->addColumn('action', function ($data) {
                    $button = '<form action="' . route('living.destroy', $data->id) . '" method="post">' . csrf_field() . ' ' . method_field('DELETE') . '<a href="' . route('living.edit', $data->id) . '" class="btn btn-primary"> <i class="fa fa-pen"></i></a>' . '&nbsp;' . '<a href="' . route('getlivingroom', $data->id) . '" class="btn btn-primary"> <i class="fa fa-eye"></i></a>' . '&nbsp;' . '<button type="submit" class="btn btn-danger">' . trans('<i class="fa fa-trash"></i>') . '</button></form>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.admin.living.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admin.living.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rule = $this->rule();
        $validator = Validator($request->all(), $rule);
        if (!$validator->fails()) {
            $living = new Living();
            $living->name_en = $request->input('name_en');
            $living->name_ar = $request->input('name_ar');
            $living->description_en = $request->input('description_en');
            $living->description_ar = $request->input('description_ar');
            $living->address_en = $request->input('address_en');
            $living->address_ar = $request->input('address_ar');
            $living->ownername_en = $request->input('ownername_en');
            $living->ownername_ar = $request->input('ownername_ar');
            $living->phone = $request->input('phone');
            $isSaved = $living->save();
            $image = [];
            foreach ($request->file('image') as $key => $multi_image) {
                $file_name = str::random(10) . $key . time() . str::random(10) . '.' . $multi_image->getClientOriginalExtension();

                $path = 'multi/living';
                $multi_image->move($path, $file_name);
                $image[] = $file_name;
            }
            foreach ($image as $image) {
                $images = new Image();
                $images->image_url = $image;
                $images->living_id = $living->id;
                $isSaved = $images->save();
            }

            return redirect()->route('living.index')->with('message', 'living Created Successfully');
        } else {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Living  $living
     * @return \Illuminate\Http\Response
     */
    public function show(Living $living)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Living  $living
     * @return \Illuminate\Http\Response
     */
    public function edit(Living $living)
    {
        $images = Image::where('living_id', $living->id)->get();
        return view('dashboard.admin.living.edit', ['living' => $living, 'images' => $images]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Living  $living
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Living $living)
    {

        $rule = $this->rule();
        $validator = Validator($request->all(), $rule);
        if (!$validator->fails()) {
            $living->name_en = $request->input('name_en');
            $living->name_ar = $request->input('name_ar');
            $living->description_en = $request->input('description_en');
            $living->description_ar = $request->input('description_ar');
            $living->address_en = $request->input('address_en');
            $living->address_ar = $request->input('address_ar');
            $living->ownername_en = $request->input('ownername_en');
            $living->ownername_ar = $request->input('ownername_ar');
            $living->phone = $request->input('phone');
            if (!is_null($request->image)) {
                $image = [];

                foreach ($request->file('image') as $key =>  $multi_image) {

                    $file_name = str::random(10) . $key . time() . str::random(10) . '.' . $multi_image->getClientOriginalExtension();
                    $path = 'multi/living';

                    $multi_image->move($path, $file_name);
                    $image[] = $file_name;
                }

                $isDeleted = Image::where('living_id', $living->id)->delete();
                if ($isDeleted) {
                    foreach ($image as $image) {
                        $newImage = new Image();
                        $newImage->image_url = $image;
                        $newImage->living_id = $living->id;
                        $newImage->save();
                    }
                }
            }
            $isSaved = $living->save();

            return redirect()->route('living.index')->with('message', 'living Updated Successfully');
        } else {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Living  $living
     * @return \Illuminate\Http\Response
     */
    public function destroy(Living $living)
    {
        $room = Room::where('living_id', $living->id)->get();

        if ($room->isEmpty()) {
            // dd('deleted');
            $living->images()->delete();
            $isDeleted = $living->delete();
            return redirect()->route('living.index')->with('message', 'living deleted Successfully');
        } else {
            // dd('Not deleted');
            return redirect()->route('living.index')->with('error', 'living deleted failed!');
        }
    }

    protected function rule()
    {
        return  $rule = [
            'name_en' => 'required | max:50',
            'name_ar' => 'required | max:50',
            'description_en' => 'required|string | min:2 |max:500',
            'description_ar' => 'required|string | min:2 |max:500',
            'address_en' => 'required|string | max:100',
            'address_ar' => 'required|string | max:100',
            'ownername_en' => 'required|string | max:50',
            'ownername_ar' => 'required|string | max:50',
            'phone' => 'required |numeric',
            // 'image' => 'required',

        ];
    }
}
