@extends('layouts.app')

@section('content')
    <div class="container">
        @include('sweetalert::alert')
        <div class="row justify-content-center">
            <h2 class="mt-2">
                <a href="{{route('home')}}">Dashboard</a>/
                Manajemen User
            </h2>
            <div class="col-8 mt-5">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Manajemen User
                            </div>
                            <div class="col-6">
                                @php
                                    $role = auth()->user();
                                @endphp
                                @if ($role->role == 1)
                                    <a href="{{route('adduser')}}" class="btn btn-primary float-end">
                                        Tambah Petugas
                                    </a>
                                @else
                                    <a href="{{route('adduser2')}}" class="btn btn-primary float-end">
                                        Tambah Member
                                    </a>
                                @endif
                            
                                <a href="{{route('pdfuser')}}" class="btn btn-Pdf btn-danger me-1 float-end">print</a>
                                <button type="button" class="btn btn-success float-end me-1" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Import
                                </button>
                                <a href="{{route('exceluser')}}" class="btn btn-Pdf btn-success me-1 float-end">Export</a>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <table class="table" id="table">
                            <thead>
                                <tr class="text-center">
                                    <th>
                                        No
                                    </th>
                                    <th>
                                        Nama
                                    </th>
                                    <th>
                                        Email
                                    </th>
                                    <th>
                                        Role
                                    </th>
                                    <th>
                                        Aksi
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($user as $key => $item)
                                    <tr class="text-center">
                                        <td>
                                            {{ $key + 1 }}
                                        </td>
                                        <td>
                                            {{ $item->name }}
                                        </td>
                                        <td>
                                            {{ $item->email }}
                                        </td>
                                        <td>
                                            {{ $item->rolee->nama ?? '-' }}
                                        </td>
                                        <td>
                                            <button class="btn btn-danger btn-hapus" id="btn-hapus" data-id="{{$item->id}}">
                                                Hapus
                                            </button>
                                            <button class="btn btn-warning btn-edit" id="btn-edit" data-id="{{$item->id}}">
                                                edit
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-4 mt-5">
            <div class="card">
                <div class="card-header">
                    Jumlah User
                </div>
                <div class="card-body">
                    {!!  $userChart->container() !!}
                </div>
            </div>
        </div>
        </div>
    </div>



    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Masukan Data</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('importuser') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="col-6">
                            Masukkan File
                            <input type="file" name="file" id="file" class="form-control">
                        </div>

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Import</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script>
        new DataTable('#table');
        
        $(document).on('click','#btn-hapus',function(){
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, delete it!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var btnId = $(this).data('id');
                    var editUrl = "{{ route('hapususer', '') }}" + "/" + btnId;
                    window.location.href = editUrl;
                }
            });
        })

        $(document).on('click', '#btn-edit', function() {
            var btnId = $(this).data('id');
            var editUrl = "{{ route('edituser', '') }}" + "/" + btnId;
            window.location.href = editUrl;
        })
    </script>
     <script src="{{ $userChart->cdn() }}"></script>

{{ $userChart->script() }}
@endsection
