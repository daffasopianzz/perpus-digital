@extends('layouts.app')

@section('content')
    <div class="container">
        @include('sweetalert::alert')
        <div class="row justify-content-center">
            <h2 class="mt-2">
                <a href="{{route('home')}}">Dashboard</a>/
                Log Aktivitas
            </h2>
            <div class="col-6 mt-5">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            Log Aktivitas Buku
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
                                                Id Buku
                                            </th>
                                            <th>
                                                Nama Buku
                                            </th>
                                            <th>
                                                Waktu
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data1 as $key => $item)
                                            <tr class="text-center">
                                                <td>
                                                {{ $key + 1 }}
                                                </td>
                                                <td>
                                                    {{ $item->id_buku }}
                                                </td>
                                                <td>
                                                    {{ $item->nama_buku }}
                                                </td>
                                                <td>
                                                    {{ $item->created_at }}
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

 
               
            </div> 

            <div class="col-6 mt-5">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            Log Aktivitas kategori
                        </div>
                    </div>
                        <div class="col-12">
                            <div class="card-body">
                                <table class="table" id="table2">
                                    <thead>
                                        <tr class="text-center">
                                            <th>
                                                No
                                            </th>
                                            <th>
                                                Id Kategori
                                            </th>
                                            <th>
                                                Nama Kategori
                                            </th>
                                            <th>
                                                Waktu
                                            </th>
                                            <th>
                                                Aksi
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data2 as $key => $item)
                                            <tr class="text-center">
                                                <td>
                                                {{ $key + 1 }}
                                                </td>
                                                <td>
                                                    {{ $item->id_kategori }}
                                                </td>
                                                <td>
                                                    {{ $item->nama_kategori }}
                                                </td>
                                                <td>
                                                    {{ $item->created_at }}
                                                </td>
                                                <td>
                                                <button class="btn btn-primary btn-edit" id="btn-edit" data-id="{{$item->id}}">
                                                        Pulihkan
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
    </div>

    <script>
        new DataTable('#table');
        new DataTable('#table2');

        
        $(document).on('click','#btn-edit',function(){
            Swal.fire({
                title: "Are you sure?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes, Pulihkan!"
            }).then((result) => {
                if (result.isConfirmed) {
                    var btnId = $(this).data('id');
                    var editUrl = "{{ route('aksiLog', '') }}" + "/" + btnId;
                    window.location.href = editUrl;
                }
            });
        })

        
    </script>
@endsection
