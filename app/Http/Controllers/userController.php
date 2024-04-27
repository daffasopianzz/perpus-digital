<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Models\kategori;
use App\Models\role;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Charts\userChart;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportSiswa;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;



class userController extends Controller
{
    public function index(userChart $userChart)
    {
        
        $role = auth()->user();
        if ($role->role == '1') {
            $user = user::with('rolee')->get();
        }
        else{
            $user = user::with('rolee')->where('role','!=', '1')->where('role','!=', '2')->get();
        }
        return view("user.index", compact('user'),['userChart' => $userChart->build()]);
    }

    public function add()
    {
        return view("user.add");
    }

    public function add2()
    {
        return view("user.add2");
    }

    public function profile()
    {
        $user = auth()->user();

        return view("user.edit-profile", compact('user'));
    }

    public function editProfile(request $request)
    {
   
        $validasi = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
        ]);
        if ($validasi->fails() == true) {

            Alert::warning('Nama Tak Boleh Kosong');
            return redirect()->back();
        } else {
            try {

                $data = user::where('id', $request->id )->first();
                    // dd($data);
                $data->name = $request->name;
                
                
                if($request->no_hp) {
                    $data->no_hp = $request->no_hp; 
                }

                if($request->alamat) {
                    $data->alamat = $request->alamat; 
                }


                $data->save();
                db::commit();

                Alert::success('Berhasil Edit');                    
                return redirect()->back();
            } catch (\Throwable $th) {
                dd ($th);
            }
        }
    }

    public function member()
    {
        return view("user.member");
    }

    public function pdf()
    {
        $data = user::with('rolee')->get();
        $pdf = app()->make('dompdf.wrapper');
        $pdf->loadView('user.pdf', compact('data'));
    
        return $pdf->download('user.pdf');
    }


    public function storeMember(request $request)
    {
        db::beginTransaction();
        try {
            $user =  Auth::id();        
            $data = user::where('id',$user)->first();

            $data->no_hp = $request->no_hp;
            $data->alamat = $request->alamat;
            $data->role = 3;

            $data->update();
            db::commit();

            Alert::success('Anda Berhasil Menjadi Member');
            return redirect()->route('home');

        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function store(request $request)
    {
        // dd($request->all());
        $validasi = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if ($validasi->fails() == true) {
            Alert::warning('Email Sudah Ada Atau Password Kurang Dari 8 Char');
            return redirect()->back();
        } else {
            try {
                $data = new user;
                $data->email = $request->email;
                $data->name = $request->name;
                $data->password = hash::make($request->password);
                $data->role = 2;


                $data->save();
                db::commit();

                Alert::success('Berhasil Tambah Petugas');                    
                return redirect()->back();
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    public function store2(request $request)
    {
        // dd($request->all());
        $validasi = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
        if ($validasi->fails() == true) {
            Alert::warning('Email Sudah Ada Atau Password Kurang Dari 8 Char');
            return redirect()->back();
        } else {
            try {
                $data = new user;
                $data->email = $request->email;
                $data->name = $request->name;
                $data->password = hash::make($request->password);
                $data->role = 3;


                $data->save();
                db::commit();

                Alert::success('Berhasil Tambah Petugas');                    
                return redirect()->back();
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    public function hapus($id)
    {
        db::beginTransaction();
        try {
            $data = user::where('id',$id)->first();
            $data->delete();
            db::commit();

            Alert::success('Berhasil Hapus Data');
            return redirect()->back();
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    public function edit($id)
    {
        $data = user::where('id',$id)->first();
        return view("user.edit",compact('data'));
    }

    public function update(request $request)
    {
        // dd($request->all());
        $validasi = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        ]);
        if ($validasi->fails() == true) {
            Alert::warning('Email Sudah Ada');
            return redirect()->back();
        } else {
            try {
                $data = user::where('id',$request->id)->first();
                $data->email = $request->email;
                $data->name = $request->name;


                $data->save();
                db::commit();

                Alert::success('Berhasil Update Data');                    
                return redirect()->back();
            } catch (\Throwable $th) {
                throw $th;
            }
        }
    }

    public function excel(Request $request)
    {
        $data = user::with('rolee')->where('role', '!=' , 1)->get();
    
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        // Judul
        $sheet->setCellValue('A1', 'Data User');
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
        $sheet->setCellValue('B5', 'Nama');
        $sheet->setCellValue('C5', 'Email');
        $sheet->setCellValue('D5', 'Role');


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
            $sheet->setCellValue('B'.$column, $value->name);
            $sheet->setCellValue('C'.$column, $value->email);
            $sheet->setCellValue('D'.$column, $value->rolee->nama);



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
        header('Content-Disposition: attachment;filename=Data_User.xlsx');
        header('Cache-Control: max-age=0');
    
        // Mengeluarkan file
        $writer->save('php://output');
        exit();
    }

    function import(Request $request){
        $file = $request->file('file');
        // dd($file);
    
        $datas = Excel::toArray(null, $file);
        foreach ($datas as $data) {
            $jumlah = 0;
            foreach ($data as $row) {
                if ($jumlah >= 1) {
                    $email = $row[0];
                    $name = $row[1];
                    $password = $row[2];
                    $no_hp = $row[3];
                    $alamat = $row[4];


                    $check = user::where("email", $email)->first();
                    if(!$check){
                        $newData = new user();
                        $newData->email= $email;
                        $newData->name = $name;  
                        $newData->password = hash::make($password); 
                        $newData->role = 4;
                        $newData->no_hp = $no_hp;
                        $newData->alamat = $alamat;
                        $newData->save();
                    }
                }
                $jumlah++;
            }
        }
        
        Alert::success('Anda Berhasil Import');
        return redirect()->back();
    }
    

}
