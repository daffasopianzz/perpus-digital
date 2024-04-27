@extends('layouts.app')

@section('content')
    <div class="container">
        @include('sweetalert::alert')
        <div class="row justify-content-center">
            <h2 class="mt-2">
                <a href="{{route('home')}}">Dashboard</a>/
                <a href="{{route('kategori')}}">Tambah Kategori</a>/
                Tambah Kategori
            </h2>
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Tambah Kategori
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{route('storekategori')}}" method="post">
                        @csrf
                            <div class="row">
                                <div class="col-12">
                                    nama:
                                    <input type="text" name="nama_kategori" id="nama_kategori" class="form-control">
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
