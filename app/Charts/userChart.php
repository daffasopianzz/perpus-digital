<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\user;


class userChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\DonutChart
    {
        $admin = user::where('role','1')->count();
        $petugas = user::where('role','2')->count();
        $member = user::where('role','3')->count();
        $non_member = user::where('role','4')->count();

        return $this->chart->donutChart()
            ->setTitle('Data Pengguna.')
            ->setSubtitle('Season 2021.')
            ->addData([$admin, $petugas, $member, $non_member])
            ->setLabels(['Admin', 'Petugas', 'Member','Non Member']);
    }
}
