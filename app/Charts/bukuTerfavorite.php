<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\favorit;
use App\Models\buku;

class bukuTerfavorite
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $idBukuTerbanyak = Favorit::select('id_buku')
            ->groupBy('id_buku')
            ->orderByRaw('COUNT(*) DESC')
            ->value('id_buku');
    
        // Periksa apakah ada buku favorit
        if (!$idBukuTerbanyak) {
            // Inisialisasi variabel jika tidak ada buku favorit
            $count = 0;
            $bukuTerbanyak = null;
        } else {
            $count = Favorit::where('id_buku', $idBukuTerbanyak)->count();
            $bukuTerbanyak = Buku::where('id', $idBukuTerbanyak)->first();
        }
    
        $idBukuTerbesar1 = Favorit::select('id_buku')
            ->groupBy('id_buku')
            ->orderByRaw('COUNT(*) DESC')
            ->skip(1) // Mengabaikan data terbesar (urutan pertama)
            ->take(1) // Mengambil data terbesar kedua
            ->value('id_buku');
    
        // Periksa apakah ada buku favorit kedua
        if (!$idBukuTerbesar1) {
            // Inisialisasi variabel jika tidak ada buku favorit kedua
            $count1 = 0;
            $bukuTerbanyak1 = null;
        } else {
            $count1 = Favorit::where('id_buku', $idBukuTerbesar1)->count();
            $bukuTerbanyak1 = Buku::where('id', $idBukuTerbesar1)->first();
        }
    
        $idBukuTerbesar2 = Favorit::select('id_buku')
            ->groupBy('id_buku')
            ->orderByRaw('COUNT(*) DESC')
            ->skip(2) // Mengabaikan data terbesar (urutan pertama)
            ->take(1) // Mengambil data terbesar kedua
            ->value('id_buku');
    
        // Periksa apakah ada buku favorit ketiga
        if (!$idBukuTerbesar2) {
            // Inisialisasi variabel jika tidak ada buku favorit ketiga
            $count2 = 0;
            $bukuTerbanyak2 = null;
        } else {
            $count2 = Favorit::where('id_buku', $idBukuTerbesar2)->count();
            $bukuTerbanyak2 = Buku::where('id', $idBukuTerbesar2)->first();
        }
    
        return $this->chart->pieChart()
            ->setTitle('Top 3 Favorite Books')
            ->setSubtitle('Based on number of favorites')
            ->addData([$count, $count1, $count2])
            ->setLabels([
                $bukuTerbanyak ? $bukuTerbanyak->judul : 'No Favorite Book',
                $bukuTerbanyak1 ? $bukuTerbanyak1->judul : 'No Favorite Book',
                $bukuTerbanyak2 ? $bukuTerbanyak2->judul : 'No Favorite Book'
            ]);
    }
}
