@extends('dashboard.starter')
@section('title', 'create room')
@section('pageName', 'Create Room')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
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
                                        <th>Image</th>
                                    </tr>
                                    {{-- single --}}
                                    <tr>
                                        <td>
                                            <select name="single_room" class="form-control" id="">
                                                <option value="single room">Single Room</option>
                                            </select>
                                        </td>

                                        <td><input type="text" name="single_totalrooms" value="0"
                                                class="form-control" />
                                        </td>
                                        <td><input type="text" name="single_price" value="0" class="form-control" />
                                        </td>
                                        <td><input type="file" id="file" onchange="loadFile(event)" name="single_image"
                                                value="0" class="input-group date" /><br>
                                            <img id="output" width="100" />
                                        </td>
                                    </tr>
                                    {{-- ... --}}
                                    {{-- double --}}
                                    <tr>
                                        <td>
                                            <select name="double_room" class="form-control" id="">
                                                <option value="double room">Double Room</option>
                                            </select>
                                        </td>

                                        <td><input type="text" name="double_totalrooms" value="0"
                                                class="form-control" />
                                        </td>
                                        <td><input type="text" name="double_price" value="0" class="form-control" />
                                        </td>
                                        <td><input type="file" id="file2" onchange="loadsecond(event)"
                                                name="double_image" value="0" class="input-group date" /><br>
                                            <img id="output2" width="100" />
                                        </td>
                                    </tr>
                                    {{-- ... --}}
                                    {{-- double --}}
                                    <tr>
                                        <td>
                                            <select name="triple_room" class="form-control" id="">
                                                <option value="triple room">Triple Room</option>
                                            </select>
                                        </td>

                                        <td><input type="text" name="triple_totalrooms" value="0"
                                                class="form-control" />
                                        </td>
                                        <td><input type="text" name="triple_price" value="0" class="form-control" />
                                        </td>
                                        <td><input type="file" id="files" onchange="loadthrid(event)"
                                                name="triple_image" value="0" class="input-group date" /><br>
                                            <img id="output3" width="100" />
                                        </td>
                                    </tr>
                                    {{-- ... --}}
                                </table>
                            </div>

                        </div>
                        {{-- end kind & roomcount & price --}}


                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Add</button>

            </div>
        </form>
    </div>


</div><br>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript">
    var loadFile = function(event) {
            var image = document.getElementById('output');
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        var loadsecond = function(event) {
            var image = document.getElementById('output2');
            image.src = URL.createObjectURL(event.target.files[0]);
        };

        var loadthrid = function(event) {
            var image = document.getElementById('output3');
            image.src = URL.createObjectURL(event.target.files[0]);
        };


        @if (Session::has('message'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.success("{{ session('message') }}");
        @endif

        @if (Session::has('error'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.error("{{ session('error') }}");
        @endif

        @if (Session::has('info'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.info("{{ session('info') }}");
        @endif

        @if (Session::has('warning'))
            toastr.options = {
                "closeButton": true,
                "progressBar": true
            }
            toastr.warning("{{ session('warning') }}");
        @endif
</script>
@endsection
