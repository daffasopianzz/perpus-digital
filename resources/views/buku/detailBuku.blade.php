@extends('layouts.app')

@section('content')

<style>
.star-rating {
  display: flex;
  flex-direction: row-reverse; /* Mengatur urutan dari kanan ke kiri */
}

.radio-input {
  position: fixed;
  opacity: 0;
  pointer-events: none;
}

.radio-label {
  cursor: pointer;
  font-size: 0;
  color: rgba(0, 0, 0, 0.2);
  transition: color 0.1s ease-in-out;
}

.radio-label:before {
  content: "★";
  display: inline-block;
  font-size: 32px;
}

.radio-input:checked~.radio-label {
  color: #ffc700;
  color: gold;
}

.radio-label:hover,
.radio-label:hover~.radio-label {
  color: goldenrod;
}

.radio-input:checked+.radio-label:hover,
.radio-input:checked+.radio-label:hover~.radio-label,
.radio-input:checked~.radio-label:hover,
.radio-input:checked~.radio-label:hover~.radio-label,
.radio-label:hover~.radio-input:checked~.radio-label {
  color: darkgoldenrod;
}

.average-rating {
  position: relative;
  appearance: none;
  color: transparent;
  width: auto;
  display: inline-block;
  vertical-align: baseline;
  font-size: 25px;
}

.average-rating::before {
  --percent: calc(4.3 / 5 * 100%);
  content: '★★★★★';
  position: absolute;
  top: 0;
  left: 0;
  color: rgba(0, 0, 0, 0.2);
  background: linear-gradient(90deg, gold var(--percent), rgba(0, 0, 0, 0.2) var(--percent));
  -webkit-background-clip: text;
  -webkit-text-fill-color: transparent;
}

body {
  margin: 50px;
}

form {
  margin: 0 0 50px;
}

</style>

    @include('sweetalert::alert')
    <div class="container">
        <div class="row justify-content-center">
        <h2 class="mt-2">
                <a href="{{route('home')}}">Dashboard</a>/
                <a href="{{route('daftarBuku')}}">Daftar Buku</a>/
                Detail Buku
        </h2>
            <div class="col-12 mt-3">
                     <div class="card mt-3">
                       <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Detail Buku
                            </div>
                            <div class="col-6">
                                @php
                                    use App\Models\Favorit;
                                    $user = auth()->id();

                                    $favorites = Favorit::where('id_user', $user)->where('id_buku' , $data->id)->first();
                                @endphp
                                @if ($favorites == null)
                                    <form action="{{route('TambahFavorit')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="id_buku" id="id_buku" value="{{$data->id}}">

                                        <button class="btn btn-success float-end">
                                            Tambah Favorit
                                        </button>
                                    </form>
                                @else
                                    <form action="{{route('HapusFavorit')}}" method="post">
                                            @csrf
                                            <input type="hidden" name="id_buku" id="id_buku" value="{{$data->id}}">

                                            <button class="btn btn-danger float-end">
                                                Batal Favorit
                                            </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <img src="{{ asset('assets/cover/' . $data->cover) }}" alt="cover" height="250" width="250">
                                    @php
                                    use App\Models\Komentar;

                                    // Ambil semua komentar untuk buku tertentu
                                    $komentars = Komentar::where('id_buku', $data->id)->get();

                                    $totalRating = 0;
                                    $jumlahKomentar = $komentars->count();

                                    // Jumlahkan semua rating
                                    foreach ($komentars as $komentar) {
                                        $totalRating += $komentar->rating;
                                    }

                                    // Hitung rating keseluruhan
                                    $ratingKeseluruhan = ($jumlahKomentar > 0) ? round($totalRating / $jumlahKomentar) : 0;
                                    $ratingBulat = ($jumlahKomentar > 0) ? round($totalRating / $jumlahKomentar) : 0;
                                @endphp
                                <br>
                                <br>
                                {{ $ratingKeseluruhan }}
                                <br>
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $ratingBulat)
                                        <span style="color: gold;">★</span>
                                    @else
                                        <span>★</span>
                                    @endif
                                @endfor
                                </div>


                                <div class="col-6">
                                    <table id="table" class="table">
                                        <tr>
                                            <td>
                                                judul:
                                                <br>
                                              {{ $data->judul }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                penulis:
                                                <br>
                                                {{ $data->penulis }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Kategori:
                                                <br>
                                                {{ $data->kategori }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                Deskripsi:
                                                <br>
                                                {{ strip_tags($data->deskripsi)}}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                @php
                                                    $role = auth()->user();
                                                @endphp
                                                @if ($role->role == 4)
                                                    <a href="{{route('bacaBuku', $data->id)}}" class="btn btn-primary float-end">baca</a>
                                                @else
                                                <a href="{{route('bacaBukuMember', $data->id)}}" class="btn btn-primary float-end">baca</a>
                                                    
                                                @endif
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                     </div>

                     <div class="card mt-3">
                            <div class="card-header">
                                Komentar
                            </div>
                        <div class="card-body">
                            
                            <div class="card mt-3">
                                <div class="card-header">
                                    Tambah Komentar
                                </div>
                                <div class="card-body">
                                @php
                                    

                                    $cek = Komentar::where('id_user', $user)->where('id_buku',$data->id)->first();
                                @endphp
                                @if ($cek == true)
                                <form action="{{route('updatekomentar')}}" method="post" id="form">
                                        @csrf
                                        <div class="row">
                                            <div class="col star-rating">
                                                <input class="radio-input" type="radio" id="star5"
                                                @if( $cek->rating == 5)
                                                    checked
                                                @endif
                                                name="star_input" value="5" />
                                                <label class="radio-label" for="star5" title="5 stars">5 stars</label>

                                                <input class="radio-input" type="radio" id="star4"
                                                @if( $cek->rating == 4)
                                                    checked
                                                @endif
                                                 name="star_input" value="4" />

                                                <label class="radio-label" for="star4" title="4 stars">4 stars</label>

                                                <input class="radio-input" type="radio" id="star3"
                                                @if( $cek->rating == 3)
                                                    checked
                                                @endif
                                                name="star_input" value="3" />
                                                <label class="radio-label" for="star3" title="3 stars">3 stars</label>

                                                <input class="radio-input" type="radio" id="star2"
                                                @if( $cek->rating == 2)
                                                    checked
                                                @endif
                                                name="star_input" value="2" />
                                                <label class="radio-label" for="star2" title="2 stars">2 stars</label>

                                                <input class="radio-input" type="radio" id="star1"
                                                @if( $cek->rating == 1)
                                                    checked
                                                @endif
                                                 name="star_input" value="1" />
                                                <label class="radio-label" for="star1" title="1 star"  >1 star</label>
                                            </div>

                                        </div>
                                        <br>
                                        
                                        <div class="editor" id="editor">
                                            <textarea name="komentar" id="komentar" cols="30" rows="10"> {{ strip_tags($cek->komentar) }}</textarea>
                                            <input type="hidden" name="id_buku" id="id_buku" value="{{ $data->id }}">
                                        </div>
                                        <button class="btn btn-primary float-end mt-3" id="kirim" type="submit">
                                            kirim
                                        </button>
                                </form>
                                @else
                                <form action="{{route('komentar')}}" method="post" id="form">
                                        @csrf
                                        <div class="row">
                                            <div class="col star-rating">
                                                <input class="radio-input" type="radio" id="star5" name="star_input" value="5" />
                                                <label class="radio-label" for="star5" title="5 stars">5 stars</label>

                                                <input class="radio-input" type="radio" id="star4" name="star_input" value="4" />
                                                <label class="radio-label" for="star4" title="4 stars">4 stars</label>

                                                <input class="radio-input" type="radio" id="star3" name="star_input" value="3" />
                                                <label class="radio-label" for="star3" title="3 stars">3 stars</label>

                                                <input class="radio-input" type="radio" id="star2" name="star_input" value="2" />
                                                <label class="radio-label" for="star2" title="2 stars">2 stars</label>

                                                <input class="radio-input" type="radio" id="star1" name="star_input" value="1" />
                                                <label class="radio-label" for="star1" title="1 star " >1 star</label>
                                            </div>

                                        </div>
                                        <br>
                                        
                                        <div class="editor" id="editor">
                                            <textarea name="komentar" id="komentar" cols="30" rows="10"></textarea>
                                            <input type="hidden" name="id_buku" id="id_buku" value="{{ $data->id }}">
                                        </div>
                                        <button class="btn btn-primary float-end mt-3" id="kirim" type="submit">
                                            kirim
                                        </button>
                                </form>
                                @endif

                                </div>
                            </div>
                            @php

                                $komentar = Komentar::with('id_user_a')->where('id_buku', $data->id)
                                    ->orderBy('created_at', 'desc')
                                    ->paginate(2);
                            @endphp
                            @foreach ($komentar as $komen)
                                    <div class="card mt-3">
                                       <div class="card-header">
                                            <div class="row">
                                                <div class="col-6">
                                                    {{$komen->id_user_a->name}}
                                                </div>
                                                <div class="col-3"></div>
                                                <div class="col-3 float-end">
                                                    <?php if ($komen->rating == 1): ?>
                                                        <span style="color: gold;">★</span>
                                                    <?php elseif ($komen->rating == 2): ?>
                                                        <span style="color: gold;">★★</span>
                                                    <?php elseif ($komen->rating == 3): ?>
                                                        <span style="color: gold;">★★★</span>
                                                    <?php elseif ($komen->rating == 4): ?>
                                                        <span style="color: gold;">★★★★</span>
                                                    <?php elseif ($komen->rating == 5): ?>
                                                        <span style="color: gold;">★★★★★</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                       </div>
                                       <div class="card-body">
                                       {{ strip_tags($komen->komentar)}}
                                       </div> 
                                    </div>
                                @endforeach

                                <div class="float-end mt-3">
                                    {{ $komentar->links('pagination::bootstrap-4') }}
                                </div>
                        </div>

                     </div>
                     
            </div>
        </div>   
    </div>

    <script>
        $(document).on('click', '#klik', function() {
            Swal.fire("SweetAlert2 is working!");
        })

        $(document).ready(function() {
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then(editor => {
                    $('#kirim').click(function(e) {
                        e.preventDefault();

                        // Get the CKEditor instance
                        var editorData = editor.getData();

                        // Set the content of CKEditor as the value of the textarea
                        $('#komentar').val(editorData);

                        // Submit the form
                        $('#form').submit();
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
    <script>
        const starRatingForm = document.querySelector(".star-rating");

        const handleFormChange = (e) => {
        const selectedRating = e.target.value;
        const allLabels = starRatingForm.querySelectorAll(".radio-label");
        const labelsArray = Array.from(allLabels);
        
        // Balik urutan label
        labelsArray.reverse().forEach((label, index) => {
            label.style.order = index + 1;
        });
        
        console.log(selectedRating);
        
        // Tambahkan fungsi reset di sini
        setTimeout(resetRating, 1000); // Reset setelah 1 detik
        };

        // Fungsi untuk mereset tampilan rating ke posisi awal
        const resetRating = () => {
        const allLabels = starRatingForm.querySelectorAll(".radio-label");
        const labelsArray = Array.from(allLabels);
        
        // Kembalikan urutan label ke posisi awal
        labelsArray.forEach((label, index) => {
            label.style.order = "";
        });
        };

        starRatingForm.addEventListener("change", handleFormChange);


    </script>
@endsection
