<!DOCTYPE html>
<html>

<head>
    <title>Add/remove multiple input fields dynamically with Jquery Laravel 5.8</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
</head>

<body>

    <div class="container">
        <h2 align="center">Add/remove multiple input fields dynamically with Jquery Laravel 5.8</h2>

        <form action="" method="POST">
            @csrf

            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            @if (Session::has('success'))
            <div class="alert alert-success text-center">
                <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                <p>{{ Session::get('success') }}</p>
            </div>
            @endif

            <table class="table table-bordered" id="dynamicTable">
                <tr>
                    <th>Name</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                <tr>
                    <td><input type="text" name="addmore[0][name]" placeholder="Enter your Name" class="form-control" />
                    </td>
                    <td><input type="text" name="addmore[0][qty]" placeholder="Enter your Qty" class="form-control" />
                    </td>
                    <td><input type="text" name="addmore[0][price]" placeholder="Enter your Price"
                            class="form-control" /></td>
                    <td><button type="button" name="add" id="add" class="btn btn-success">Add More</button></td>
                </tr>
            </table>

            <button type="submit" class="btn btn-success">Save</button>
        </form>
    </div>

    <script type="text/javascript">
        var i = 0;

    $("#add").click(function(){

        ++i;

        $("#dynamicTable").append('<tr><td><input type="text" name="addmore['+i+'][name]" placeholder="Enter your Name" class="form-control" /></td><td><input type="text" name="addmore['+i+'][qty]" placeholder="Enter your Qty" class="form-control" /></td><td><input type="text" name="addmore['+i+'][price]" placeholder="Enter your Price" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>');
    });

    $(document).on('click', '.remove-tr', function(){
         $(this).parents('tr').remove();
    });

    </script>

</body>

</html>


@extends('dashboard.starter')
@section('title', 'create room')
@section('pageName', 'Create Room')
@section('css')
<style>
    #result {
        display: flex;
        gap: 10px;
        padding: 10px 0;
    }

    .thumbnail {
        height: 200px;
    }
</style>
@endsection
@section('content')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add New Room</h3>
        </div>
        <form action="{{ route('room.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{-- room number --}}
                        <div class="row">

                            <div class="col-lg-12 fv-row">
                                <label>Living</label>
                                <select name="living_id" class="form-control" id="" required>

                                    @foreach ($living as $living)
                                    <option value="{{ $living->id }}">{{ $living->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        {{-- end room number / price --}}

                        {{-- description --}}
                        <div class="row">

                            <div class="col-lg-6 fv-row">
                                <label>Description En</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <textarea class="form-control" name="description_en" required
                                        id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>

                            <div class="col-lg-6 fv-row">
                                <label>Description Ar</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <textarea class="form-control" name="description_ar" required
                                        id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>
                            </div>

                        </div><br>
                        {{-- end description --}}

                        {{-- kind & roomcount & price --}}
                        <div class="row">

                            <div class="col-lg-12 fv-row">
                                <table class="table table-bordered" id="dynamicTable">
                                    <tr>
                                        <th>Kind</th>
                                        <th>Room Count</th>
                                        <th>Price</th>
                                        <th>Action</th>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="addmore[0][kind]" class="form-control" id="">
                                                <option>choose option</option>
                                                <option value="single room">Single Room</option>
                                                <option value="double room">Double Room</option>
                                                <option value="triple room">Triple Room</option>
                                            </select>
                                        </td>

                                        <td><input type="text" name="addmore[0][totalrooms]" class="form-control" />
                                        </td>
                                        <td><input type="text" name="addmore[0][price]" class="form-control" /></td>
                                        <td><button type="button" name="add" id="add" class="btn btn-success"><i
                                                    class="fa fa-plus"></i></button></td>
                                    </tr>
                                </table>
                            </div>

                        </div>
                        {{-- end kind & roomcount & price --}}


                    </div>
                </div>
                {{-- image --}}
                <div class="form-group">
                    <label>Image</label>
                    <div class="input-group date" id="reservationdate" data-target-input="nearest">
                        <input type="file" name="image[]" id="files" multiple data-target="#reservationdate" />
                    </div>
                </div>
                <div class="col-sm-10">
                    <output id="result" width="200">
                </div>
                {{-- end image --}}
                <button type="submit" class="btn btn-primary">Add</button>

            </div>
        </form>
    </div>


</div><br>

@endsection

@section('js')
<script type="text/javascript">
    var i = 0;

        $("#add").click(function() {

            ++i;

            $("#dynamicTable").append(
                '<tr><td><select name="addmore[' + i +
                '][kind]" class="form-control" id=""><option>choose option</option> <option value="single room">Single Room</option> <option value="double room">Double Room</option> <option value="triple room">Triple Room</option> </select></td><td><input type="text" name="addmore[' +
                i + '][totalrooms]" class="form-control" /></td><td><input type="text" name="addmore[' + i +
                '][price]" class="form-control" /></td><td><button type="button" class="btn btn-danger remove-tr">Remove</button></td></tr>'
            );
        });

        $(document).on('click', '.remove-tr', function() {
            $(this).parents('tr').remove();
        });


        document.querySelector("#files").addEventListener("change", (e) => {
            if (window.File && window.FileReader && window.FileList && window.Blob) {
                const files = e.target.files;
                const output = document.querySelector("#result");
                output.innerHTML = "";
                for (let i = 0; i <
                    files.length; i++) {
                    if (!files[i].type.match("image")) continue;
                    const picReader = new FileReader();
                    picReader.addEventListener("load", function(event) {
                        const picFile = event.target;
                        const
                            div = document.createElement("div");
                        div.innerHTML = `<img class="thumbnail" src="${picFile.result}"
                title="${picFile.name}" />`;
                        output.appendChild(div);
                    });
                    picReader.readAsDataURL(files[i]);
                }
            } else {
                alert("Your browser does not support File API");
            }
        });
</script>
@endsection
