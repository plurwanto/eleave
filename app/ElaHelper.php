<?php

namespace App;

use App\Http\Model\Eleave\Menu;
use App\Mail\TestEmail;
use Mail;

class ElaHelper
{

    public static function myCurl($url, $data = array())
    {
        $fullUrl = env('API_URL') . $url; //var_dump($fullUrl);exit();

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (!empty($data)) {
            $jsonData = json_encode($data, JSON_PRETTY_PRINT);
            // echo $jsonData;exit;

            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData))
            );
        }

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

    public static function toCsv($param)
    {
        $fullpath = public_path('file/' . $param["filename"]);
        $handle = fopen($fullpath, 'w+');

        //setup header
        fputcsv($handle, $param["header"]);

        //insert content
        fputcsv($handle, $param["content"]);

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return response()->download($fullpath, $param["filename"], $headers);
    }

    public static function SendMail($param)
    {
        $send = Mail::to($param['to'])->send(new TestEmail($param));
        var_dump($send);exit();
        return $send;
    }

    public static function checkHrisSession()
    {
        if (session('id_hris') == 0) {
            return redirect('portal');
        }
    }

    public static function convert($number)
    {
        $number = str_replace('.', '', $number);
        if (!is_numeric($number)) {
            throw new Exception("Please input number.");
        }

        $base = array('nol', 'satu', 'dua', 'tiga', 'empat', 'lima', 'enam', 'tujuh', 'delapan', 'sembilan');
        $numeric = array('1000000000000000', '1000000000000', '1000000000000', 1000000000, 1000000, 1000, 100, 10, 1);
        $unit = array('kuadriliun', 'triliun', 'biliun', 'milyar', 'juta', 'ribu', 'ratus', 'puluh', '');
        $str = null;
        $i = 0;
        if ($number == 0) {
            $str = 'nol';
        } else {
            while ($number != 0) {
                $count = (int) ($number / $numeric[$i]);
                if ($count >= 10) {
                    $str .= static::convert($count) . ' ' . $unit[$i] . ' ';
                } elseif ($count > 0 && $count < 10) {
                    $str .= $base[$count] . ' ' . $unit[$i] . ' ';
                }
                $number -= $numeric[$i] * $count;
                $i++;
            }
            $str = preg_replace('/satu puluh (\w+)/i', '\1 belas', $str);
            $str = preg_replace('/satu (ribu|ratus|puluh|belas)/', 'se\1', $str);
            $str = preg_replace('/\s{2,}/', ' ', trim($str));
        }
        return $str;
    }

    public static function convert_e($number)
    {

        $hyphen = '-';
        $conjunction = ' and ';
        $separator = ', ';
        $negative = 'negative ';
        $decimal = ' point ';
        $dictionary = array(
            0 => 'zero',
            1 => 'one',
            2 => 'two',
            3 => 'three',
            4 => 'four',
            5 => 'five',
            6 => 'six',
            7 => 'seven',
            8 => 'eight',
            9 => 'nine',
            10 => 'ten',
            11 => 'eleven',
            12 => 'twelve',
            13 => 'thirteen',
            14 => 'fourteen',
            15 => 'fifteen',
            16 => 'sixteen',
            17 => 'seventeen',
            18 => 'eighteen',
            19 => 'nineteen',
            20 => 'twenty',
            30 => 'thirty',
            40 => 'fourty',
            50 => 'fifty',
            60 => 'sixty',
            70 => 'seventy',
            80 => 'eighty',
            90 => 'ninety',
            100 => 'hundred',
            1000 => 'thousand',
            1000000 => 'million',
            1000000000 => 'billion',
            1000000000000 => 'trillion',
            1000000000000000 => 'quadrillion',
            1000000000000000000 => 'quintillion',
        );

        if (!is_numeric($number)) {
            return false;
        }

        if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
            // overflow
            trigger_error(
                'convert_e only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
                E_USER_WARNING
            );
            return false;
        }

        if ($number < 0) {
            return $negative . Self::convert_e(abs($number));
        }

        $string = $fraction = null;

        if (strpos($number, '.') !== false) {
            list($number, $fraction) = explode('.', $number);
        }

        switch (true) {
            case $number < 21:
                $string = $dictionary[$number];
                break;
            case $number < 100:
                $tens = ((int) ($number / 10)) * 10;
                $units = $number % 10;
                $string = $dictionary[$tens];
                if ($units) {
                    $string .= $hyphen . $dictionary[$units];
                }
                break;
            case $number < 1000:
                $hundreds = $number / 100;
                $remainder = $number % 100;
                $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
                if ($remainder) {
                    $string .= $conjunction . Self::convert_e($remainder);
                }
                break;
            default:
                $baseUnit = pow(1000, floor(log($number, 1000)));
                $numBaseUnits = (int) ($number / $baseUnit);
                $remainder = $number % $baseUnit;
                $string = Self::convert_e($numBaseUnits) . ' ' . $dictionary[$baseUnit];
                if ($remainder) {
                    $string .= $remainder < 100 ? $conjunction : $separator;
                    $string .= Self::convert_e($remainder);
                }
                break;
        }

        if (null !== $fraction && is_numeric($fraction)) {
            $string .= $decimal;
            $words = array();
            foreach (str_split((string) $fraction) as $number) {
                $words[] = $dictionary[$number];
            }
            $string .= implode(' ', $words);
        }

        return $string;
    }

    public static function privilege_check($page_id, $do = null)
    {
        $result = Menu::privilege_check($page_id, $do);

        return $result;
    }

    public static function privilege_check_approver($page_id, $do = null)
    {
        $result = Menu::privilege_check_approver($page_id, $do);

        return $result;
    }

    public static function myCurlInventory($url, $data = array())
    {
        $fullUrl = env('API_INVENTORY_URL') . $url; //var_dump($fullUrl);exit();
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fullUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (!empty($data)) {
            $jsonData = json_encode($data, JSON_PRETTY_PRINT);
            // echo $jsonData;exit;

            curl_setopt($ch, CURLOPT_POSTFIELDS, $jsonData);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($jsonData))
            );
        }

        $result = curl_exec($ch);

        curl_close($ch);

        return $result;
    }

    public static function getMenuHRIS($menu_id, $id_hris)
    {
        $param = [
            "id_hris" => $id_hris,
            "menu_id" => $menu_id,
        ];
        return json_decode(Self::myCurl('hris/get-access-menu2', $param));
    }

    public static function month($search, $type)
    {
        $month = [
                    1   => 'January',
                    2   => 'February',
                    3   => 'March',
                    4   => 'April',
                    5   => 'May',
                    6   => 'June',
                    7   => 'July',
                    8   => 'August',
                    9   => 'September',
                    10  => 'October',
                    11  => 'November',
                    12  => 'Desember'
        ];

        if($type == 'name')
        {
            $return = $month[$search];
        }
        else
        {
            $return = array_search($search, $month);
        }

        return $return;
    }

}
