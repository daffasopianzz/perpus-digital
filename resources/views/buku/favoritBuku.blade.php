@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
        <h2 class="mt-2">
                <a href="{{route('home')}}">Dashboard</a>/
                Favorit
            </h2>
            
            @if ($cek == 1)
                @foreach($buku as $item)
                        <div class="col-4 mt-3">
                            <div class="card">
                                <div class="card-header">{{$item->judul}}</div>

                                <div class="card-body">
                                <div class="row">
                                    <div class="col text-center mt-2">
                                        <img src="{{ asset('assets/cover/' . $item->cover) }}" alt="cover" height="250" width="250">
                                    </div>
                                    <br class="mt-2">
                                    <hr>
                                    <div class="col mt-2">
                                        <a href="{{route('detailBuku',$item->id)}}" class="btn btn-primary float-end">baca</a>
                                    </div>
                                </div>
                                </div>
                            </div>
                        </div>
                @endforeach
            @else
                <h1 class="text-center">
                    Tidak Ada Buku Favorite
                </h1>
            @endif
            </div>
    </div>

    <script>
        $(document).on('click', '#klik', function() {
            Swal.fire("SweetAlert2 is working!");
        })
    </script>
@endsection
