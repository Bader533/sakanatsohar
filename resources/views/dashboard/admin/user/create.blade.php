@extends('dashboard.starter')
@section('title','create user')
@section('pageName','Add user')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
@section('content')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Add New User</h3>
        </div>
        <form action="{{route('user.store')}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card-body">

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{-- name --}}
                        <div class="row">

                            <div class="col-lg-12 fv-row">
                                <label>Name</label>
                                <input type="text" name="name" class="form-control datetimepicker-input"
                                    data-target="#reservationdate" required />


                            </div>

                        </div>
                        {{-- name --}}

                        {{-- email --}}
                        <div class="row">

                            <div class="col-lg-12 fv-row">
                                <label>email</label>
                                <input type="email" name="email" class="form-control datetimepicker-input"
                                    data-target="#reservationdate" required />
                            </div>

                        </div>
                        {{-- email --}}

                        {{-- password --}}
                        <div class="row">

                            <div class="col-lg-12 fv-row">
                                <label>password</label>
                                <input type="password" name="password" class="form-control datetimepicker-input"
                                    data-target="#reservationdate" required />
                            </div>

                        </div>
                        {{-- password --}}

                        {{-- imagge --}}
                        <div class="row">
                            <div class="col-lg-12 fv-row">
                                <label>Image</label>
                                <input type="file" name="image" class="form-control datetimepicker-input"
                                    data-target="#reservationdate" required />
                            </div>
                        </div><br>
                        {{-- imagge --}}

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
<script>
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
