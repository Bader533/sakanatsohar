@extends('dashboard.starter')
@section('title', 'update room')
@section('pageName', 'Update Room')
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
            <h3 class="card-title">Update Room</h3>
        </div>
        <form action="{{ route('room.update', $roomdes->id) }}" method="POST" id="formedit"
            enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{-- living --}}
                        <div class="row">

                            <div class="col-lg-12 fv-row">
                                <label>Living</label>
                                <select name="living_id" class="form-control" id="" required>
                                    @foreach ($living as $living)
                                    <option value="{{ $living->id }}" @if ($living->id == $roomdes->living_id) selected
                                        @endif
                                        value="{{ $living->id }}">{{ $living->name_en }}</option>
                                    @endforeach
                                </select>
                            </div>

                        </div>
                        {{-- end living --}}

                        {{-- description --}}
                        <div class="row">

                            <div class="col-lg-6 fv-row">
                                <label>Description En</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <textarea class="form-control" name="description_en" required
                                        id="exampleFormControlTextarea1"
                                        rows="3">{{ $roomdes->description_en }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6 fv-row">
                                <label>Description Ar</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <textarea class="form-control" name="description_ar" required
                                        id="exampleFormControlTextarea1"
                                        rows="3">{{ $roomdes->description_ar }}</textarea>
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
                                    @foreach ($room as $key => $rooms)
                                    <tr>
                                        <td>
                                            <select
                                                name="{{ $rooms->kind_en === 'single room' ? 'single_room' : ($rooms->kind_en === 'double room' ? 'double_room' : 'triple_room') }}"
                                                class="form-control" id="">
                                                <option value="{{ $rooms->kind_en }}">{{ $rooms->kind_en }}
                                                </option>
                                            </select>
                                        </td>

                                        <td><input type="text"
                                                name="{{ $rooms->kind_en === 'single room' ? 'single_totalrooms' : ($rooms->kind_en === 'double room' ? 'double_totalrooms' : 'triple_totalrooms') }}"
                                                value="{{ $rooms->totalrooms }}" class="form-control" />
                                        </td>
                                        <td><input type="text"
                                                name="{{ $rooms->kind_en === 'single room' ? 'single_price' : ($rooms->kind_en === 'double room' ? 'double_price' : 'triple_price') }}"
                                                value="{{ $rooms->price }}" class="form-control" />
                                        </td>
                                        <td>
                                            <input type="file" id="upload"
                                                onchange="loadFile(event,'{{ $rooms->kind_en }}')"
                                                name="{{ $rooms->kind_en === 'single room' ? 'single_image' : ($rooms->kind_en === 'double room' ? 'double_image' : 'triple_image') }}"
                                                value="" class="input-group date" /><br>
                                            <img id="image{{ $key }}"
                                                src="{{ asset('multi/rooms/' . $rooms->image_url) }}" width="100" />
                                            <img id="output{{ $key }}" width="100" />
                                        </td>
                                    </tr>
                                    @endforeach

                                    @if (count($result) != 0)
                                    @foreach ($result as $key => $results)
                                    <tr>
                                        <td>
                                            <select
                                                name="{{ $results === 'single room' ? 'single_room' : ($results === 'double room' ? 'double_room' : 'triple_room') }}"
                                                class="form-control" id="">
                                                <option value="{{ $results }}">{{ $results }}
                                                </option>
                                            </select>
                                        </td>

                                        <td><input type="text"
                                                name="{{ $results === 'single room' ? 'single_totalrooms' : ($results === 'double room' ? 'double_totalrooms' : 'triple_totalrooms') }}"
                                                value="0" class="form-control" />
                                        </td>
                                        <td><input type="text"
                                                name="{{ $results === 'single room' ? 'single_price' : ($results === 'double room' ? 'double_price' : 'triple_price') }}"
                                                value="0" class="form-control" />
                                        </td>
                                        <td>
                                            <input type="file" id="{{ $results }}"
                                                onchange="loadFile2(event,'{{ $results }}','{{$key}}')"
                                                name="{{ $results === 'single room' ? 'single_image' : ($results === 'double room' ? 'double_image' : 'triple_image') }}"
                                                value="" class="input-group date" /><br>

                                            <img id="output{{$key}}" width="100" />

                                        </td>
                                    </tr>
                                    @endforeach
                                    @endif

                                </table>
                            </div>

                        </div>
                        {{-- end kind & roomcount & price --}}


                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Update</button>

            </div>
        </form>
    </div>


</div><br>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript">
    var loadFile = function(event, name) {
            if (name == 'single room') {
                document.getElementById("image0").style.display = "none";
                var image = document.getElementById('output0');
                image.src = URL.createObjectURL(event.target.files[0]);
            } else if (name == 'double room') {
                document.getElementById("image1").style.display = "none";
                var image = document.getElementById('output1');
                image.src = URL.createObjectURL(event.target.files[0]);
            } else {
                document.getElementById("image2").style.display = "none";
                var image = document.getElementById('output2');
                image.src = URL.createObjectURL(event.target.files[0]);
            }

        };

        var loadFile2 = function(event, name,key) {
            var image = document.getElementById('output'+key);
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
