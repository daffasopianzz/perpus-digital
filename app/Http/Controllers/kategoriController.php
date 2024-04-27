<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\kategori;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\View;
use App\Charts\kategoriChart;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;


class kategoriController extends Controller
{
    public function index(kategoriChart $kategoriChart)
    {
        $kategori = kategori::all();
        return view("kategori.index", compact('kategori'),['kategoriChart' => $kategoriChart->build()]);
    }

    public function add()
    {
        return view("kategori.add");
    }

    public function pdf()
    {
        $data = kategori::all();
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('kategori.pdf', compact('data'));
    
        return $pdf->download('kategori.pdf');
    }

    public function edit($id)
    {
        $kategori = kategori::where('id', $id)->first();
        return view("kategori.edit", compact("kategori"));
    }

    public function store(request $request)
    {
        // dd($request->all());
        db::beginTransaction();
        try {
            $data = new kategori;
            $data->nama_kategori = $request->nama_kategori;

            $data->save();
            db::commit();

            Alert::success("Data Berhasil Di Tambah");
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function hapus($id)
    {
        db::beginTransaction();
        try {
            $data = kategori::where('id', $id)->first();

            $data->delete();
            db::commit();

            Alert::success('Berhasil Hapus Data');
            return redirect()->back();

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function update(request $request)
    {
        db::beginTransaction();
        try {
            $data = kategori::where('id', $request->id)->first();

            $data->nama_kategori = $request->nama_kategori;
            $data->update();
            db::commit();

            Alert::success('Berhasil Update Data');
            return redirect()->back();

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function excel(Request $request)
    {
        $data = Kategori::all();
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Judul
        $sheet->setCellValue('A1', 'Laporan Kategori');
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
        $sheet->setCellValue('B5', 'Kategori');
        $sheet->mergeCells('B5:B5'); // Rentang kolom sampai G
        $sheet->getStyle('A5:B5')->getFont()->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK); // Mengubah warna teks header menjadi hitam
        $sheet->getStyle('A5:B5')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('A5:B5')->getFont()->setBold(true)->setName('Poppins')->setSize(9);
        $sheet->getStyle('A5:B5')->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A5:B5')->getFill()
            ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('f9d392'); // Mengubah warna latar belakang header menjadi abu-abu muda
    
        // Data
        $column = 6;
        $no = 1;
        foreach ($data as $key => $value) {
            $sheet->setCellValue('A'.$column, $no);
            $sheet->setCellValue('B'.$column, $value->nama_kategori);
            $sheet->getStyle('A'.$column.':B'.$column)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN); // Rentang kolom sampai G
            $sheet->getStyle('A'.$column.':B'.$column)->getFont()->setBold(false)->setName('Poppins')->setSize(9); // Rentang kolom sampai G
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
        header('Content-Disposition: attachment;filename=Laporan_Kategori.xlsx');
        header('Cache-Control: max-age=0');
    
        // Mengeluarkan file
        $writer->save('php://output');
        exit();
    }


}
