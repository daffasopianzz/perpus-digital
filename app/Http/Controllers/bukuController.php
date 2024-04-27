<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\kategori;
use App\Models\buku;
use App\Models\role;
use App\Models\User;
use App\Models\favorit;
use App\Models\komentar;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use App\Charts\bukuTerfavorite;
use App\Models\log_buku;
use App\Models\log_kategori;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;


use Illuminate\Support\Facades\Hash;

class bukuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(bukuTerfavorite $chart)
    {
        $buku = buku::with('kategorii')->get();
        return view("buku.index", compact('buku'),['chart' => $chart->build()]);
    }

    public function daftarBuku()
    {
        $buku = buku::all();
        return view("buku.daftarBuku", compact('buku'));
    }

    public function log()
    {
        $data1 = log_buku::all();
        $data2 = log_kategori::all();
        return view("log.index", compact('data1','data2'));
    }

    public function AksiLog($id)
    {
        db::beginTransaction();
        try {
            $data = log_kategori::where('id', $id)->first();
            
            $insert = new kategori;

            $insert->id = $data->id_kategori;
            $insert->nama_kategori = $data->nama_kategori;

            $insert->save();
            $data->delete();
            db::commit();

            Alert::success('Berhasil Memulihkan Data');
            return redirect()->back();
            
        } catch (\Throwable $th) {
            dd($th);
        }
    }


    public function pdf()
    {
        $data = buku::with('kategorii')->get();
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('buku.pdf', compact('data'));
    
        return $pdf->download('buku.pdf');
    }

    public function bacaBuku($id)
    {
        $buku = buku::where('id',$id)->first();
        return view("buku.bacaBuku", compact('buku'));
    }

    public function bacaBukuMember($id)
    {
        $buku = buku::where('id',$id)->first();
        return view("buku.bacaBukuMember", compact('buku'));
    }

    public function komentar(request $request)
    {
        // dd($request->all());
        db::BeginTransaction();
        try {
            $data = new komentar;
            $data->id_user = Auth::id();
            $data->id_buku = $request->id_buku;
            $data->komentar = $request->komentar;
            $data->rating = $request->star_input;
            $data->save();
            db::commit();

            Alert::success('Berhasil Mengirimkan Komentar');
            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th);    
        }
    }

    public function excel(Request $request)
    {
        $data = buku::with('kategorii')->get();
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Judul
        $sheet->setCellValue('A1', 'Laporan Buku');
        $sheet->mergeCells('A1:G3'); // Rentang kolom sampai G
        $sheet->getStyle('A1')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK); // Mengubah warna teks judul menjadi hitam
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');
        $sheet->getStyle('A1')->getFont()->setBold(true)->setName('Poppins')->setSize(12);
        $spreadsheet->getActiveSheet()->getStyle('A1')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('f9d392'); // Mengubah warna latar belakang menjadi abu-abu muda
    
        // Menambahkan gambar
        $drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
        $drawing->setPath('assets/img/pre.png');
        $drawing->setHeight(60);
        $drawing->setCoordinates('A1');
        $drawing->setWorksheet($sheet);
    
        // Header
        $sheet->setCellValue('A5', 'No');
        $sheet->setCellValue('B5', 'Judul');
        $sheet->setCellValue('C5', 'Penulis');
        $sheet->setCellValue('D5', 'Kategori');


        // $sheet->mergeCells('B5:B5'); // Rentang kolom sampai G
        $sheet->getStyle('A5:D5')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK); // Mengubah warna teks header menjadi hitam
        $sheet->getStyle('A5:D5')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A5:D5')->getFont()->setBold(true)->setName('Poppins')->setSize(9);
        $sheet->getStyle('A5:D5')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A5:D5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('f9d392'); // Mengubah warna latar belakang header menjadi abu-abu muda
    
        // Data
        $column = 6;
        $no = 1;
        foreach ($data as $key => $value) {
            $sheet->setCellValue('A'.$column, $no);
            $sheet->setCellValue('B'.$column, $value->judul);
            $sheet->setCellValue('C'.$column, $value->penulis);
            $sheet->setCellValue('D'.$column, $value->kategorii->nama_kategori);




            $sheet->getStyle('A'.$column.':D'.$column)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN); // Rentang kolom sampai G
            $sheet->getStyle('A'.$column.':D'.$column)->getFont()->setBold(false)->setName('Poppins')->setSize(9); // Rentang kolom sampai G
            $column++;
            $no++;
        }
    
        // Auto size kolom
        $sheet->getColumnDimension('A')->setAutoSize(true);
        $sheet->getColumnDimension('B')->setAutoSize(true);
        $sheet->getColumnDimension('C')->setAutoSize(true);
        $sheet->getColumnDimension('D')->setAutoSize(true);
        $sheet->getColumnDimension('E')->setAutoSize(true);
        $sheet->getColumnDimension('F')->setAutoSize(true);
        $sheet->getColumnDimension('G')->setAutoSize(true);
    
        // Mengatur format output dan nama file
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename=Data_buku.xlsx');
        header('Cache-Control: max-age=0');
    
        // Mengeluarkan file
        $writer->save('php://output');
        exit();
    }

    public function updatekomentar(request $request)
    {
        // dd($request->all());
        db::BeginTransaction();
        try {
            $user =  Auth::id();  
            $data = komentar::where('id_user',$user)->first();
            $data->id_user = Auth::id();
            $data->id_buku = $request->id_buku;
            $data->komentar = $request->komentar;
            $data->rating = $request->star_input;
            $data->update();
            db::commit();

            Alert::success('Berhasil Mengirimkan Komentar');
            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th);    
        }
    }

    public function edit($id)
    {
        $data = buku::where('id',$id)->first();
        $kategori = kategori::all();    
        return view("buku.edit", compact('data','kategori'));
    }

    public function detail($id)
    {
        $data = buku::where('id',$id)->first();

        return view("buku.detailBuku", compact('data'));
    }

    public function indexFavorit()
    {

        $id_user =  Auth::id();        
        $data = Favorit::where('id_user', $id_user)->pluck('id_buku');
        $cek = 1;
        
        $buku = Buku::whereIn('id', $data)->get();
       
        if ($buku->isEmpty()) {
            $cek = 0;
            $buku = "<h1 class='text-center'>Anda Belum Memiliki Buku Favorite</h1>";
        }
    
        return view("buku.favoritBuku", compact('data','buku','cek'));
    }
    

    public function TambahFavorit(request $request)
    {
        db::beginTransaction();
        try {
            $data = new favorit;
            $data->id_user = Auth::id();
            $data->id_buku = $request->id_buku; 

            $data->save();
            db::commit();

            Alert::success('Anda Berhasil Menambahkan Ke Favorit');
            return redirect()->back();
        } catch (\Throwable $th) {
            dd($th);
        }
    }

    public function HapusFavorit(request $request)
    {

        db::beginTransaction();
        try {
            $data = favorit::where('id_buku',$request->id_buku)->first();
            // dd($data);
            $data->delete();
            db::commit();

            Alert::success('Anda Berhasil Menghapus Data');
            return redirect()->back();
        } catch (\Throwable $th) {
            dd( $th);
        }
    }

    public function add()
    {
        $kategori = kategori::all();
        return view("buku.add", compact('kategori'));
    }

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
                $data->judul = $request->judul;
                $data->penulis = $request->penulis;
                $data->kategori = $request->kategori;
                $data->deskripsi = $request->deskripsi;

                if ($request->hasfile('buku')) {
                    $bukuFileName = time() . '.' . $request->file('buku')->extension();
                    $request->file('buku')->move( public_path( 'assets/buku'), $bukuFileName);
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


    public function hapus($id)
    {
        db::BeginTransaction();
        try {
            $data = buku::where('id',$id)->first();

            $coverPath = public_path('assets/cover/' . $data->cover);
            if (File::exists($coverPath)) {
                File::delete($coverPath);
            }

            $bukuPath = public_path('assets/buku/' . $data->buku);
            if (File::exists($bukuPath)) {
                File::delete($bukuPath);
            }

            $data->delete();
            db::commit();

            Alert::success('Berhasil Hapus Data');
            return redirect()->back();  

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(Request $request)
    {
        // dd($request->all());
        db::BeginTransaction();
        try {
            $data = buku::where('id',$request->id)->first();
            
            if ($request->cover) {
                # code...
                $coverPath = public_path('assets/cover/' . $data->cover);
                if (File::exists($coverPath)) {
                    File::delete($coverPath);
                }
            }

            if ($request->buku) {
                $bukuPath = public_path('assets/buku/' . $data->buku);
                if (File::exists($bukuPath)) {
                    File::delete($bukuPath);
                }
            }

                $data->judul = $request->judul;
                $data->deskripsi = $request->deskripsi;
                $data->penulis = $request->penulis;

                if ($request->kategori) {
                    $data->kategori = $request->kategori;
                }

                if ($request->hasfile('buku')) {
                    $bukuFileName = time() . '.' . $request->file('buku')->extension();
                    $request->file('buku')->move( public_path( 'assets/buku'), $bukuFileName);
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

}
