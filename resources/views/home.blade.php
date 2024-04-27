@extends('layouts.app')

@section('content')
    <div class="container">
    @include('sweetalert::alert')
        <div class="row justify-content-center">
            @php
                $role = auth()->user();
            @endphp

            @if ($role->role == 1 || $role->role == 2)
            
            <div class="col-4 mt-3">
                <div class="card">
                    <div class="card-header">Manajemen Kategori</div>

                    <div class="card-body">
                        <a href="{{route('kategori')}}" class="btn btn-primary float-end">
                            go
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-4 mt-3">
                <div class="card">
                    <div class="card-header">Manajemen User</div>

                    <div class="card-body">
                        <a href="{{route('user')}}" class="btn btn-primary float-end">
                            go
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-4 mt-3">
                <div class="card">
                    <div class="card-header">Manajemen Buku</div>

                    <div class="card-body">
                        <a href="{{route('buku')}}" class="btn btn-primary float-end">
                            go
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-4 mt-3">
                <div class="card">
                    <div class="card-header">Aktivitas Log</div>

                    <div class="card-body">
                        <a href="{{route('log')}}" class="btn btn-primary float-end">
                            go
                        </a>
                    </div>
                </div>
            </div>

            @endif

            <div class="col-4 mt-3">
                <div class="card">
                    <div class="card-header">Daftar Buku</div>

                    <div class="card-body">
                        <a href="{{route('daftarBuku')}}" class="btn btn-primary float-end">
                            go
                        </a>
                    </div>
                </div>
            </div>

            <div class="col-4 mt-3">
                <div class="card">
                    <div class="card-header">Favorit Buku Anda</div>

                    <div class="card-body">
                        <a href="{{route('favorit')}}" class="btn btn-primary float-end">
                            go
                        </a>
                    </div>
                </div>
            </div>

            @if ($role->role == 4)
                <div class="col-4 mt-3">
                    <div class="card">
                        <div class="card-header">Daftar Member</div>

                        <div class="card-body">
                            <a href="{{route('member')}}" class="btn btn-primary float-end">
                                go
                            </a>
                        </div>
                    </div>
                </div>
            @endif

        </div>
    </div>

    <script>
        $(document).on('click', '#klik', function() {
            Swal.fire("SweetAlert2 is working!");
        })
    </script>
@endsection
