@extends('layouts.app')

@section('content')
    <div class="container">
        @include('sweetalert::alert')
        <div class="row justify-content-center">
            <h2 class="mt-2">
                <a href="{{route('home')}}">Dashboard</a>/
                <a href="{{route('buku')}}">Manajemen Buku</a>/
                Tambah Buku
            </h2>
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">
                                Tambah Buku
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <form action="{{route('storebuku')}}" method="post" id="form" enctype="multipart/form-data">
                        @csrf
                            <div class="row">
                                <div class="col-12 mt-3">
                                    judul:
                                    <input type="text" name="judul" id="judul" class="form-control" required>
                                </div>
                                <div class="col-12 mt-3">
                                    Penulis:
                                    <input type="text" name="penulis" id="penulis" class="form-control" required>
                                </div>
                                <div class="col-12 mt-3">
                                    Kategori:
                                    <select name="kategori" id="kategori" class="form-control">
                                        @foreach($kategori as $item)
                                            <option value="{{$item->id}}">{{$item->nama_kategori}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-6 mt-3">
                                    buku:
                                    <input type="file" name="buku" id="buku" class="form-control" accept="application/pdf" required>
                                </div>
                                <div class="col-6 mt-3">
                                    cover:
                                    <input type="file" name="cover" id="cover" class="form-control" accept="image/*" required>
                                </div>
                                <div class="col-12 mt-3">
                                Deskripsi :
                                    <div class="editor" id="editor">
                                        
                                        <textarea name="deskripsi" id="deskripsi" cols="30" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="col-12 mt-2">
                                    <button class="btn btn-primary float-end" type="submit" id="kirim">
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

        $(document).ready(function() {
            ClassicEditor
                .create(document.querySelector('#editor'))
                .then(editor => {
                    $('#kirim').click(function(e) {
                        e.preventDefault();

                        // Get the CKEditor instance
                        var editorData = editor.getData();

                        // Set the content of CKEditor as the value of the textarea
                        $('#deskripsi').val(editorData);

                        // Submit the form
                        $('#form').submit();
                    });
                })
                .catch(error => {
                    console.error(error);
                });
        });

        
        $(document).on('click', '#klik', function() {
            Swal.fire("SweetAlert2 is working!");
        })
    </script>
@endsection
