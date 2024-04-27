@extends('layouts.app')

@section('content')
    <div class="container">
        @include('sweetalert::alert')
        <div class="row justify-content-center">
            <h2 class="mt-2">
                <a href="{{route('home')}}">Dashboard</a>/
                Manajemen Kategori
            </h2>
            <div class="col-8 mt-5">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Manajemen Kategori
                            </div>
                            <div class="col-6">                                 
                                <a href="{{route('addkategori')}}" class="btn btn-primary float-end">
                                    Tambah
                                </a>
                                <a href="{{route('pdfkategori')}}" class="btn btn-Pdf btn-danger me-1 float-end">print</a>
                                <a href="{{route('excelkategori')}}" class="btn btn-Pdf btn-success me-1 float-end">Excel</a>

                            </div>
                        </div>
                        <div class="col-12">
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
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($kategori as $key => $item)
                                            <tr class="text-center">
                                                <td>
                                                {{ $key + 1 }}
                                                </td>
                                                <td>
                                                    {{ $item->nama_kategori }}
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger btn-hapus" id="btn-hapus" data-id="{{$item->id}}">
                                                        Hapus 
                                                    </button>
                                                    <button class="btn btn-warning btn-edit" id="btn-edit" data-id="{{$item->id}}">
                                                        Edit 
                                                    </button>

                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

 
                </div>
            </div>
            <div class="col-4 mt-5">
                <div class="card">
                    <div class="card-header">
                        Informasi
                    </div>
                    <div class="card">
                        {!! $kategoriChart->container() !!}
                    </div>
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
                    var editUrl = "{{ route('hapuskategori', '') }}" + "/" + btnId;
                    window.location.href = editUrl;
                }
            });
        })

        $(document).on('click', '#btn-edit', function() {
            var btnId = $(this).data('id');
            var editUrl = "{{ route('editkategori', '') }}" + "/" + btnId;
            window.location.href = editUrl;
        })
        
    </script>
        <script src="{{ $kategoriChart->cdn() }}"></script>

        {{ $kategoriChart->script() }}
@endsection
