@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <h2 class="mt-2">
                    <a href="{{route('home')}}">Dashboard</a>/
                    <a href="{{route('daftarBuku')}}">Daftar Buku</a>/
                    Detail Buku
            </h2>
            
             <div class="card">
                <div class="card-header">
                    Detail Buku
                </div>
                <div class="card-body">
                    <div class="pdf-viewer text-center" id="pdf-viewer">
                        <script>
                            // Mendapatkan URL file PDF
                            var pdfUrl = "{{ asset('assets/buku/'. $buku->buku) }}";
                            // Mengambil referensi container
                            var pdfViewer = document.getElementById('pdf-viewer');

                            // Memuat PDF menggunakan PDF.js
                            pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
                                // Menentukan jumlah halaman
                                var numPages = pdf.numPages;

                                // Mengatur skala halaman
                                var scale = 1.1;

                                // Membuat fungsi untuk merender halaman
                                function renderPage(pageNum) {
                                    pdf.getPage(pageNum).then(function(page) {
                                        var viewport = page.getViewport({ scale: scale });
                                        var canvas = document.createElement('canvas');
                                        var context = canvas.getContext('2d');
                                        canvas.height = viewport.height;
                                        canvas.width = viewport.width;

                                        var renderContext = {
                                            canvasContext: context,
                                            viewport: viewport
                                        };

                                        // Memuat dan merender halaman
                                        page.render(renderContext).promise.then(function() {
                                            // Menambahkan canvas ke dalam container
                                            pdfViewer.appendChild(canvas);

                                            // Memeriksa apakah masih ada halaman yang perlu dirender
                                            if (pageNum < numPages) {
                                                renderPage(pageNum + 1); // Render halaman berikutnya
                                            }
                                        });
                                    });
                                }

                                // Memulai proses rendering dengan halaman pertama
                                renderPage(1);
                            });
                        </script>
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
