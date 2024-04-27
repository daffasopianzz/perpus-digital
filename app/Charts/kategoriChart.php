<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\kategori;
use App\Models\buku;

class kategoriChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $idBukuTerbanyak = buku::select('kategori')
            ->groupBy('kategori')
            ->orderByRaw('COUNT(*) DESC')
            ->value('kategori');
    
        $count = buku::where('kategori', $idBukuTerbanyak)->count();
    
        $bukuTerbanyak = kategori::where('id', $idBukuTerbanyak)->first();
    
        $idBukuTerbesar1 = buku::select('kategori')
            ->groupBy('kategori')
            ->orderByRaw('COUNT(*) DESC')
            ->skip(1)
            ->take(1)
            ->value('kategori');
    
        $bukuTerbanyak1 = $bukuTerbanyak1Count = 'tidak ada';
        $count1 = 0;
        if ($idBukuTerbesar1) {
            $count1 = buku::where('kategori', $idBukuTerbesar1)->count();
            $bukuTerbanyak1 = kategori::where('id', $idBukuTerbesar1)->value('nama_kategori');
        }
    
        $idBukuTerbesar2 = buku::select('kategori')
            ->groupBy('kategori')
            ->orderByRaw('COUNT(*) DESC')
            ->skip(2)
            ->take(1)
            ->value('kategori');
    
        $bukuTerbanyak2 = $bukuTerbanyak2Count = 'tidak ada';
        $count2 = 0;
        if ($idBukuTerbesar2) {
            $count2 = buku::where('kategori', $idBukuTerbesar2)->count();
            $bukuTerbanyak2 = kategori::where('id', $idBukuTerbesar2)->value('nama_kategori');
        }
    
        return $this->chart->pieChart()
            ->setTitle('Top 3 Kategori Terbanyak')
            ->setSubtitle('Berdasarkan jumlah favorit')
            ->addData([$count, $count1, $count2])
            ->setLabels([
                $bukuTerbanyak ? $bukuTerbanyak->nama_kategori : 'tidak ada',
                $bukuTerbanyak1,
                $bukuTerbanyak2
            ]);
    }
    
}
