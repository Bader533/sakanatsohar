@extends('dashboard.starter')
@section('title', 'update user')
@section('pageName', 'Update User')
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
            <h3 class="card-title">Update User</h3>
        </div>
        <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{-- name --}}
                        <div class="row">

                            <div class="col-lg-12 fv-row">
                                <label>Name</label>
                                <input type="text" name="name" value="{{ $user->name }}"
                                    class="form-control datetimepicker-input" data-target="#reservationdate" required />


                            </div>

                        </div>
                        {{-- name --}}

                        {{-- email --}}
                        <div class="row">

                            <div class="col-lg-12 fv-row">
                                <label>email</label>
                                <input type="email" name="email" value="{{ $user->email }}"
                                    class="form-control datetimepicker-input" data-target="#reservationdate" required />
                            </div>

                        </div>
                        {{-- email --}}

                        {{-- password --}}
                        <div class="row">

                            <div class="col-lg-12 fv-row">
                                <label>password</label>
                                <input type="password" name="password" class="form-control datetimepicker-input"
                                    data-target="#reservationdate" />
                            </div>

                        </div>
                        {{-- password --}}

                        {{-- imagge --}}
                        <div class="row">
                            <div class="col-lg-12 fv-row">
                                <label>Image</label>
                                <input type="file" name="image" class="input-group date" id="files"
                                    data-target="#reservationdate" />
                            </div>
                        </div><br>
                        {{-- imagge --}}
                        <img id="multimg" src="{{ asset('multi/' . $user->image_url) }}" height="200px;" alt="">
                        <div>


                            <div class="row mb-3">
                                <div class="col-sm-10">
                                    <output id="result" width="200">
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">update</button>

            </div>
        </form>
    </div>


</div><br>
@endsection
@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
<script>
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
