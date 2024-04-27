@extends('layouts.app')

@section('content')
    <div class="container">
        @include('sweetalert::alert')
        <div class="row justify-content-center">
            <h2 class="mt-2">
                <a href="{{route('home')}}">Dashboard</a>/
                Member
            </h2>
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Daftar Member
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{route('storeMember')}}" method="post">
                        @csrf
                            <div class="row">
                                <div class="col-12 mt-3">
                                    No Hp
                                    <input type="number" name="no_hp" id="no_hp" class="form-control" required placeholder="contoh : 08">
                                </div>
                                <div class="col-12 mt-3">
                                    Alamat
                                    <input type="text" name="alamat" id="alamat" class="form-control" required>
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
