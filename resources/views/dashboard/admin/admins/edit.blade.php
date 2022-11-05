@extends('dashboard.starter')
@section('title', 'update admin')
@section('pageName', 'update admin')
@section('css')
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@endsection
@section('content')
<div class="col-md-12">
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">update admin</h3>
        </div>
        <form action="{{ route('admin.update',$admins->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUt')
            <div class="card-body">

                <div class="row mb-6">
                    <div class="col-lg-12">
                        {{-- name --}}
                        <div class="row">

                            <div class="col-lg-12 fv-row">
                                <label>Name</label>
                                <input type="text" name="name" value="{{$admins->name}}"
                                    class="form-control datetimepicker-input" data-target="#reservationdate" required />


                            </div>

                        </div>
                        {{-- name --}}

                        {{-- email --}}
                        <div class="row">

                            <div class="col-lg-12 fv-row">
                                <label>email</label>
                                <input type="email" name="email" value="{{$admins->email}}"
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

                        </div><br>
                        {{-- password --}}
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
