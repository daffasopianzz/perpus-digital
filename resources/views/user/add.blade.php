@extends('layouts.app')

@section('content')
    <div class="container">
        @include('sweetalert::alert')
        <div class="row justify-content-center">
            <h2 class="mt-2">
                <a href="{{route('home')}}">Dashboard</a>/
                <a href="{{route('user')}}">Manajemen User</a>/
                Tambah Petugas
            </h2>
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Tambah Petugas
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{route('storeuser')}}" method="post">
                        @csrf
                            <div class="row">
                                <div class="col-12 mt-3">
                                    Nama:
                                    <input type="text" name="name" id="name" class="form-control" required>
                                </div>
                                <div class="col-12 mt-3">
                                    Email:
                                    <input type="text" name="email" id="email" class="form-control" required>
                                </div>
                                <div class="col-12 mt-3">
                                    Password:
                                    <br>
                                    <small class="text-muted">
                                        Pastikan Password Lebih Dari 7 char
                                    </small>
                                    <input type="password" name="password" id="password" class="form-control" required>
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
