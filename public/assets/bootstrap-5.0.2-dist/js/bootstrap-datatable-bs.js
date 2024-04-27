// use App\Http\Controllers\Controller;
// use App\Models\User;
// use App\Models\Buku;
// use App\Models\kategori;
// use App\Models\komentar;
// use App\Models\buku_favorite;
// use Illuminate\Foundation\Auth\RegistersUsers;
// use Illuminate\Support\Facades\Hash;
// use Illuminate\Support\Facades\Validator;
// use RealRashid\SweetAlert\Facades\Alert;
// use Illuminate\Support\Facades\File;
// use Illuminate\Support\Facades\Auth;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
// use Dompdf\Dompdf;
// use Illuminate\Support\Facades\Redirect;
// use PhpParser\Node\Stmt\Return_;

//hapus

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
                    var editUrl = "{{ route('hapusKategori', '') }}" + "/" + btnId;
                    window.location.href = editUrl;
                }
            });
        })


//ck


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

//i
    public function store(Request $request )
    {   
        // dd($request->all());
        $validator = validator::make( $request->all(), [
            // 'daffa' => 'required'
        ]);

        if($validator->fails()){
            Alert::Warning('pastikan isi data dengan benar');
            return redirect()->back();
        }
        else
        {
            db::BeginTransaction();

            try {
                $data = new buku;
                $data->nama = $request->judul;
                $data->deskripsi = $request->deskripsi;
                $data->kategori = $request->kategori;
                $data->penulis = $request->penulis;

                if ($request->hasfile('buku')) {
                    $bukuFileName = time() . '.' . $request->file('buku')->extension();
                    $request->file('buku')->move( public_path( 'assets/img'), $bukuFileName);
                    $data->buku = $bukuFileName;
                }

                if ($request->hasfile('cover')) {
                    $covername = time() . '.' . $request->file('cover')->extension();
                    $request->file('cover')->move( public_path( 'assets/cover'), $covername);
                    $data->cover = $covername;
                }

                $data->save();
                db::commit();
                Alert::success('Sukses Menambahkan Data Buku');
                return redirect()->back();
            } catch (\Exception $th) {
                dd($th);
                DB::rollback();
                Alert::error('Oops', 'Terjadi Kesalahan');
                return redirect()->back()->withInput();
            }
        }
        // return view('buku.addbuku');
    }


//u
    public function update(Request $request,$id)
    {
        db::BeginTransaction();
        try {
            $data = buku::where('id',$id)->first();
            
            if ($request->cover) {
                # code...
                $coverPath = public_path('assets/cover/' . $data->cover);
                if (File::exists($coverPath)) {
                    File::delete($coverPath);
                }
            }

            if ($request->buku) {
                $bukuPath = public_path('assets/img/' . $data->buku);
                if (File::exists($bukuPath)) {
                    File::delete($bukuPath);
                }
            }

            $data->nama = $request->judul;
                $data->deskripsi = $request->deskripsi;
                $data->kategori = $request->kategori;
                $data->penulis = $request->penulis;

                if ($request->hasfile('buku')) {
                    $bukuFileName = time() . '.' . $request->file('buku')->extension();
                    $request->file('buku')->move( public_path( 'assets/img'), $bukuFileName);
                    $data->buku = $bukuFileName;
                }

                if ($request->hasfile('cover')) {
                    $covername = time() . '.' . $request->file('cover')->extension();
                    $request->file('cover')->move( public_path( 'assets/cover'), $covername);
                    $data->cover = $covername;
                }

                $data->save();
                db::commit();

            Alert::success('Buku Berhasil Di diupdate');
            return redirect()->back();

        } catch (\Throwable $th) {
            dd($th);
            
        }
    }


//dbuk
<div class="card-body">
<div id="pdf-viewer"></div>

<script>
    // Mendapatkan URL file PDF
    var pdfUrl = "{{ asset('assets/img/' . $buku->buku) }}";
    // Mengambil referensi container
    var pdfViewer = document.getElementById('pdf-viewer');

    // Memuat PDF menggunakan PDF.js
    pdfjsLib.getDocument(pdfUrl).promise.then(function(pdf) {
        // Mendapatkan halaman pertama untuk menentukan ukuran halaman
        pdf.getPage(1).then(function(firstPage) {
            var viewport = firstPage.getViewport({
                scale: 1
            });
            var pageWidth = viewport.width;
            var pageHeight = viewport.height;

            // Mengatur skala halaman
            var scale = 1.5;

            // Menggunakan loop untuk merender setiap halaman (mulai dari halaman terakhir)
            for (var pageNum = Math.ceil(pdf.numPages / 3); pageNum >= 1; pageNum--) {
                pdf.getPage(pageNum).then(function(page) {
                    var viewport = page.getViewport({
                        scale: scale
                    });
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
                        // Menambahkan canvas ke dalam container (urutan dari terakhir ke pertama)
                        pdfViewer.insertBefore(canvas, pdfViewer.firstChild);
                    });
                });
            }
        });
    });
</script>
</div>

