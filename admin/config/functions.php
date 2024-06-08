<?php

class Functions
{
    public function dayIndonesia($day)
    {
        $dayList = [
            'Sunday' => 'Minggu',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jumat',
            'Saturday' => 'Sabtu'
        ];

        return $dayList[$day];
    }

    public function monthIndonesia($month)
    {
        $monthList = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember'
        ];

        return $monthList[$month];
    }

    public function dateIndonesia($date)
    {
        $day = date('l', strtotime($date));
        $dayIndo = $this->dayIndonesia($day);
        $month = date('F', strtotime($date));
        $monthIndo = $this->monthIndonesia($month);
        $year = date('Y', strtotime($date));
        $dayNum = date('d', strtotime($date));

        return $dayIndo . ', ' . $dayNum . ' ' . $monthIndo . ' ' . $year;
    }

    public function currency($value)
    {
        return number_format($value, 0, ',', '.');
    }
}
