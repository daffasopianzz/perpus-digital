@extends('layouts.app')

@section('content')
    <div class="container">
        @include('sweetalert::alert')
        <div class="row justify-content-center">
            <h2 class="mt-2">
                <a href="{{route('home')}}">Dashboard</a>/
                <a href="{{route('user')}}">Manajemen User</a>/
                Edit User
            </h2>
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Edit User
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{route('updateuser')}}" method="post">
                        @csrf
                            <div class="row">
                                <div class="col-12 mt-3">
                                    Nama:
                                    <input type="text" name="name" id="name" class="form-control" required value="{{$data->name}}">
                                </div>
                                <div class="col-12 mt-3">
                                    Email:
                                    <input type="text" name="email" id="email" class="form-control" required value="{{$data->email}}">
                                    <input type="hidden" name="id" value="{{$data->id}}">
                                </div>
                                <div class="col-12 mt-2">
                                    <button class="btn btn-primary float-end" type="submit">
                                        Kirim
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        
        $(document).on('click', '#klik', function() {
            Swal.fire("SweetAlert2 is working!");
        })
    </script>
@endsection
