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

    function demoninator($price)
    {
        $price = abs($price);
        $number = array(
            "",
            "Satu",
            "Dua",
            "Tiga",
            "Empat",
            "Lima",
            "Enam",
            "Tujuh",
            "Delapan",
            "Sembilan",
            "Sepuluh",
            "Sebelas"
        );
        $temp = "";

        if ($price < 12) {
            $temp = "" . $number[$price];
        } elseif ($price < 20) {
            $temp = $this->demoninator($price - 10) . " Belas ";
        } elseif ($price < 100) {
            $temp = $this->demoninator($price / 10) . " Puluh " . $this->demoninator($price % 10);
        } elseif ($price < 200) {
            $temp = " Seratus " . $this->demoninator($price - 100);
        } elseif ($price < 1000) {
            $temp = $this->demoninator($price / 100) . " Ratus " . $this->demoninator($price % 100);
        } elseif ($price < 2000) {
            $temp = " Seribu " . $this->demoninator($price - 1000);
        } elseif ($price < 1000000) {
            $temp = $this->demoninator($price / 1000) . " Ribu " . $this->demoninator($price % 1000);
        } elseif ($price < 1000000000) {
            $temp = $this->demoninator($price / 1000000) . " Juta " . $this->demoninator($price % 1000000);
        } elseif ($price < 1000000000000) {
            $temp = $this->demoninator($price / 1000000000) . " Milyar " . $this->demoninator(fmod($price, 1000000000));
        } elseif ($price < 1000000000000000) {
            $temp = $this->demoninator($price / 1000000000000) . " Trilyun " . $this->demoninator(fmod($price, 1000000000000));
        }

        return $temp;
    }

    function spill($price)
    {

        $price = $price == -0 ? 0 : $price;

        if ($price < 0) {
            $result = " Minus " . trim($this->demoninator($price));
        } else if ($price == 0) {
            $result = " Nol Rupiah ";
        } else {
            $result = trim($this->demoninator($price)) . " Rupiah ";
        }
        return $result;
    }
}
