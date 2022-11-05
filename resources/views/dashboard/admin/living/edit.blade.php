@extends('dashboard.starter')
@section('title', 'update living')
@section('pageName', 'Update Living')
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

    #multimg {
        display: flex;
        gap: 10px;
        padding: 10px 0;
        height: 200px;
    }
</style>
@endsection
@section('content')

<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add New Living</h3>
        </div>
        <form action="{{ route('living.update', $living->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{-- name --}}
                        <div class="row">

                            <div class="col-lg-6 fv-row">
                                <label>Name En</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" name="name_en" id="name_en" value="{{ $living->name_en }}" class="form-control
                                                        datetimepicker-input" data-target="#reservationdate"
                                        required />
                                </div>
                            </div>

                            <div class="col-lg-6 fv-row">
                                <label>Name Ar</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" name="name_ar" value="{{ $living->name_ar }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdate"
                                        required />
                                </div>
                            </div>

                        </div>
                        {{-- end name --}}

                        {{-- description --}}
                        <div class="row">

                            <div class="col-lg-6 fv-row">
                                <label>Description En</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <textarea class="form-control" name="description_en"
                                        id="exampleFormControlTextarea1" rows="3"
                                        required>{{ $living->description_en }}</textarea>
                                </div>
                            </div>

                            <div class="col-lg-6 fv-row">
                                <label>Description Ar</label>
                                <div class="input-group date" id="reservationdatetime" data-target-input="nearest">
                                    <textarea class="form-control" name="description_ar"
                                        id="exampleFormControlTextarea1" rows="3"
                                        required>{{ $living->description_ar }}</textarea>
                                </div>
                            </div>

                        </div>
                        {{-- end description --}}

                        {{-- address --}}
                        <div class="row">

                            <div class="col-lg-6 fv-row">
                                <label>Address En</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" name="address_en" value="{{ $living->address_en }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdate"
                                        required />
                                </div>
                            </div>

                            <div class="col-lg-6 fv-row">
                                <label>Address Ar</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" name="address_ar" value="{{ $living->address_ar }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdate"
                                        required />
                                </div>
                            </div>

                        </div>
                        {{-- end address --}}

                        {{-- owner name --}}
                        <div class="row">

                            <div class="col-lg-4 fv-row">
                                <label>Owner Name En</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" name="ownername_en" value="{{ $living->ownername_en }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdate"
                                        required />
                                </div>
                            </div>

                            <div class="col-lg-4 fv-row">
                                <label>Owner Name Ar</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" name="ownername_ar" value="{{ $living->ownername_ar }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdate"
                                        required />
                                </div>
                            </div>
                            <div class="col-lg-4 fv-row">

                                <label>phone</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="text" name="phone" value="{{ $living->phone }}"
                                        class="form-control datetimepicker-input" data-target="#reservationdate"
                                        required />
                                </div>

                            </div>



                        </div>
                        {{-- end owner name --}}

                        {{-- image --}}
                        <div class="row">
                            <div class="col-lg-6 fv-row">
                                <label>Image</label>
                                <div class="input-group date" id="reservationdate" data-target-input="nearest">
                                    <input type="file" name="image[]" id="files" multiple class="form-control-file"
                                        data-target="#reservationdate" />
                                    @error('image')
                                    <small class="form-text text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        {{-- end image --}}

                        <div id="multimg">

                            @foreach ($images as $image)
                            <img src="{{ asset('multi/living/' . $image->image_url) }}" height="200px;" alt="">
                            @endforeach

                        </div>

                        <div class="row mb-3">
                            <label for="example-text-input" class="col-sm-2 col-form-label"> </label>
                            <div class="col-sm-10">
                                <output id="result">
                            </div>
                            <button type="submit" class="btn btn-primary">Update</button>

                        </div>

                    </div>
                </div>

        </form>
    </div>

</div><br>

@endsection

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script type="text/javascript">
    document.querySelector("#files").addEventListener("change", (e) => {
            if (window.File && window.FileReader && window.FileList && window.Blob) {
                document.getElementById("multimg").style.display = "none";
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
