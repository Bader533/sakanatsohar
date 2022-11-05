<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::get();

        if (request()->ajax()) {
            return datatables()->of($users)
                ->addColumn('action', function ($data) {
                    $button = '<form action="' . route('user.destroy', $data->id) . '" method="post">' . csrf_field() . ' ' . method_field('DELETE') . '<a href="' . route('user.edit', $data->id) . '" class="btn btn-primary"> <i class="fa fa-pen"></i></a>' . '&nbsp;' . '<button type="submit" class="btn btn-danger">' . trans('<i class="fa fa-trash"></i>') . '</button></form>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('dashboard.admin.user.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.admin.user.create');
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
            $user = new User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $file_name = rand(1, 100) . time() . rand(1, 100000) . '.' . $request->file('image')->extension();
            $path = 'multi';
            $request->file('image')->move($path, $file_name);
            $user->image_url = $file_name;
            $isSaved = $user->save();

            return redirect()->route('user.index')->with('message', 'User Added Successfully');
        } else {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
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
    public function edit(User $user)
    {
        return view('dashboard.admin.user.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {

        $rule = $this->rule();
        $validator = Validator($request->all(), [
            'name' => 'required | max:30',
            'email' => 'required | email',

        ]);
        if (!$validator->fails()) {
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            if ($request->image != null) {
                $file_name = rand(1, 100) . time() . rand(1, 100000) . '.' . $request->file('image')->extension();
                $path = 'multi';
                $request->file('image')->move($path, $file_name);
                $user->image_url = $file_name;
            }

            $isSaved = $user->save();

            return redirect()->route('user.index')->with('message', 'User Added Successfully');
        } else {
            return redirect()->back()->with('error', $validator->getMessageBag()->first());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $isDeleted = $user->delete();
        return redirect()->route('living.index')->with('message', 'User deleted Successfully');
    }
    protected function rule()
    {
        return  $rule = [
            'name' => 'required | max:30',
            'email' => 'required | email',
            'password' => 'required',
            'image' => 'required',

        ];
    }
}
