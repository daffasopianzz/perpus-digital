@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
        <h2 class="mt-2">
                <a href="{{route('home')}}">Dashboard</a>/
                Daftar Buku
            </h2>
            
                @foreach($buku as $item)
                    <div class="col-4 mt-3">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-6">
                                    {{$item->judul}}

                                        @php

                                            // Ambil semua komentar untuk buku tertentu
                                            $komentars = App\Models\Komentar::where('id_buku', $item->id)->get();

                                            $totalRating = 0;
                                            $jumlahKomentar = $komentars->count();

                                            // Jumlahkan semua rating
                                            foreach ($komentars as $komentar) {
                                                $totalRating += $komentar->rating;
                                            }

                                            // Hitung rating keseluruhan
                                            $ratingBulat = ($jumlahKomentar > 0) ? round($totalRating / $jumlahKomentar) : 0;
                                        @endphp
                                        <br>
                                        <br>
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $ratingBulat)
                                                <span style="color: gold;">★</span>
                                            @else
                                                <span>★</span>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                            </div>

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
            </div>
    </div>

    <script>
        $(document).on('click', '#klik', function() {
            Swal.fire("SweetAlert2 is working!");
        })
    </script>
@endsection
