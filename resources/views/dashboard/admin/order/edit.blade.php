@extends('dashboard.starter')
@section('title','update user')
@section('pageName','Update User')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3">

                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            <img class="profile-user-img img-fluid img-circle"
                                src="{{asset('multi'). '/' . $order->user->image_url}}">
                        </div>

                        <h3 class="profile-username text-center">{{$order->user->name}}</h3>

                        <ul class="list-group list-group-unbordered mb-3">
                            <li class="list-group-item">
                                <b>ID</b> <a class="float-right">{{$order->user->id}}</a>
                            </li>
                            <li class="list-group-item">
                                <b>Email</b> <a class="float-right">{{$order->user->email}}</a>
                            </li>
                        </ul>
                    </div>
                </div>


            </div>
            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <ul class="nav nav-pills">
                            <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Room</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        <div class="tab-content">

                            <div class="active tab-pane" id="settings">
                                <div class="form-group row">
                                    <label for="inputName" class="col-sm-2 col-form-label">Living</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control"
                                            value="{{$order->room->living->name_en}}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-2 col-form-label">Price</label>
                                    <div class="col-sm-10">
                                        <input type="email" class="form-control" value="{{$order->room->price}}"
                                            placeholder="Email">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Kind</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{$order->room->kind_en}}"
                                            placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputName2" class="col-sm-2 col-form-label">Status</label>
                                    <div class="col-sm-10">
                                        <input type="text" class="form-control" value="{{dd($order->status_en)}}"
                                            placeholder="Name">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="inputExperience" class="col-sm-2 col-form-label">Description</label>
                                    <div class="col-sm-10">
                                        <textarea class="form-control" id="inputExperience"
                                            placeholder="Experience">{{$order->room->description_en}}</textarea>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <div class="btn-group" role="group" aria-label="Basic example">
                                        <form action="{{route('order.destroy',$order->id)}}" method="POST"
                                            class="form-horizontal">@csrf @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Cancel</button>

                                        </form>&nbsp;
                                        <form action="{{route('order.update',$order->id)}}" method="POST"
                                            class="form-horizontal">@csrf @method('PUT')
                                            <button type="submit" class="btn btn-primary">Ordered</button>

                                        </form>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>

    </div>
</section>
@endsection
