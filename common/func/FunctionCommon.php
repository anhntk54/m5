<?php

namespace common\func;

use common\models\Config;

class FunctionCommon
{

    public static function getIP()
    {
        if (getenv("HTTP_CLIENT_IP")) {
            $ip = getenv("HTTP_CLIENT_IP");
        } elseif (getenv("HTTP_X_FORWARDED_FOR")) {
            $ip = getenv("HTTP_X_FORWARDED_FOR");
            if (strstr($ip, ',')) {
                $tmp = explode(',', $ip);
                $ip = trim($tmp[0]);
            }
        } else {
            $ip = getenv("REMOTE_ADDR");
        }
        return $ip;
    }

    public static function str_limit($str, $len = 100, $end = '...')
    {
        if (strlen($str) < $len) {
            return $str;
        }

        $str = preg_replace("/\s+/", ' ', str_replace(array("\r\n", "\r", "\n"), ' ', $str));

        if (strlen($str) <= $len) {
            return $str;
        }

        $out = '';
        foreach (explode(' ', trim($str)) as $val) {
            $out .= $val . ' ';

            if (strlen($out) >= $len) {
                $out = trim($out);
                return (strlen($out) == strlen($str)) ? $out : $out . $end;
            }
        }
    }

    public static function getExtension($str)
    {
        $i = strrpos($str, ".");
        if (!$i) {
            return "";
        }
        $l = strlen($str) - $i;
        $ext = substr($str, $i + 1, $l);
        return $ext;
    }

    public static function getReziveFixed($filename, $uploadedfile, $newwidth, $newheight, $path)
    {
        $extension = self::getExtension($filename);
        $extension = strtolower($extension);

        if ($extension == "jpg" || $extension == "jpeg") {
            $src = imagecreatefromjpeg($uploadedfile);
        } else if ($extension == "png") {
            $src = imagecreatefrompng($uploadedfile);
        } else {
            $src = imagecreatefromgif($uploadedfile);
        }
//        die(var_dump($uploadedfile));
        list($width, $height) = getimagesize($uploadedfile);
        $tmp = imagecreatetruecolor($newwidth, $newheight);


        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $newwidth, $newheight, $width, $height);


        imagejpeg($tmp, $path, 100);

        imagedestroy($src);
        imagedestroy($tmp);
    }

    public static function getWeek($date)
    {
        $date_stamp = strtotime(date('Y-m-d', strtotime($date)));

        //check date is sunday or monday
        $stamp = date('l', $date_stamp);
        $timestamp = strtotime($date);
        //start week
        if (date('D', $timestamp) == 'Mon') {
            $week_start = $date;
        } else {
            $week_start = date('Y-m-d', strtotime('Last Monday', $date_stamp));
        }
        //end week
        if ($stamp == 'Sunday') {
            $week_end = $date;
        } else {
            $week_end = date('Y-m-d', strtotime('Next Sunday', $date_stamp));
        }
        return array($week_start, $week_end);
    }

    public static function formatMoney($number)
    {
        return number_format($number, 0, ',', '.') . 'đ';
    }

    public static function formatPersen($number)
    {
        $number *= 10000;
        if ($number % 10 == 0) {
            $number = $number / 10;
            if ($number % 10 == 0) {
                return number_format($number / 10, 0, ',', '.') . '%';
            }
            return number_format($number / 10, 1, ',', '.') . '%';
        }
        return number_format($number / 100, 2, ',', '.') . '%';
    }

//    public static function formatMoney($money) {
////        setlocale(LC_MONETARY, 'it_IT');
////        return money_format($money, 0);
//        return $money;
//    }
    public static function minusDate($date1, $date2)
    {
        $date1 = date('d-m-Y', strtotime($date1));
        $date2 = date('d-m-Y', strtotime($date2));
        $days = (strtotime($date2) - strtotime($date1)) / (60 * 60 * 24);
        return $days;
    }

    public static function random_code($length = 10)
    {

        $string = '';
        // You can define your own characters here.
        $characters = "23456789ABCDEFHJKLMNPRTVWXYZabcdefghijklmnopqrstuvwxyz";

        for ($p = 0; $p < $length; $p++) {
            $string .= $characters[mt_rand(0, strlen($characters) - 1)];
        }

        return $string;
    }

    public static function createFolder($path)
    {
        $pathYear = $path . '/' . date('Y');
        if (!file_exists($pathYear)) {
            mkdir($pathYear, 0777, TRUE);
        }
        $pathYear .= '/' . date('m');
        if (!file_exists($pathYear)) {
            mkdir($pathYear, 0777, TRUE);
        }
        return $pathYear . '/';
    }

    public static function formatSizeUnits($bytes)
    {
        if ($bytes >= 1073741824) {
            $bytes = number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            $bytes = number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            $bytes = number_format($bytes / 1024, 2) . ' KB';
        } elseif ($bytes > 1) {
            $bytes = $bytes . ' bytes';
        } elseif ($bytes == 1) {
            $bytes = $bytes . ' byte';
        } else {
            $bytes = '0 bytes';
        }

        return $bytes;
    }

    public static function getURLImage($title)
    {
        $config = Config::findOne(["name" => "baseUrl"]);
        $title = date('Y') . '/' . date("m") . '/' . $title;
        return $config->value . '/uploads/images/' . $title;
    }

    public static function getStatusUser()
    {
        return [
            0 => "Chưa xác minh",
            1 => "Đã xác minh",
        ];
    }

    public static function getRoleUser()
    {
        return [
            0 => "Người dùng bình người",
            1 => "Người dùng quản trị",
        ];
    }

    public static function stripVietnamese($str)
    {
        $unicode = array(
            'a' => 'á|à|ả|ã|ạ|ă|ắ|ặ|ằ|ẳ|ẵ|â|ấ|ầ|ẩ|ẫ|ậ',
            'd' => 'đ',
            'e' => 'é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ',
            'i' => 'í|ì|ỉ|ĩ|ị',
            'o' => 'ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ',
            'u' => 'ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự',
            'y' => 'ý|ỳ|ỷ|ỹ|ỵ',
            'A' => 'Á|À|Ả|Ã|Ạ|Ă|Ắ|Ặ|Ằ|Ẳ|Ẵ|Â|Ấ|Ầ|Ẩ|Ẫ|Ậ',
            'D' => 'Đ',
            'E' => 'É|È|Ẻ|Ẽ|Ẹ|Ê|Ế|Ề|Ể|Ễ|Ệ',
            'I' => 'Í|Ì|Ỉ|Ĩ|Ị',
            'O' => 'Ó|Ò|Ỏ|Õ|Ọ|Ô|Ố|Ồ|Ổ|Ỗ|Ộ|Ơ|Ớ|Ờ|Ở|Ỡ|Ợ',
            'U' => 'Ú|Ù|Ủ|Ũ|Ụ|Ư|Ứ|Ừ|Ứ|Ữ|Ự',
            'Y' => 'Ý|Ỳ|Ỷ|Ỹ|Ỵ',
        );

        foreach ($unicode as $nonUnicode => $uni) {
            $str = preg_replace("/($uni)/i", $nonUnicode, $str);
        }
        return $str;
    }

    public static function toSlug($string, $force_lowercase = true, $anal = false)
    {
        $strip = array("~", "`", "!", "@", "#", "$", "%", "^", "&", "*", "(", ")", "_", "=", "+", "[", "{", "]",
            "}", "\\", "|", ";", ":", "\"", "'", "&#8216;", "&#8217;", "&#8220;", "&#8221;", "&#8211;", "&#8212;",
            "â€”", "â€“", ",", "<", ".", ">", "/", "?");
        $clean = trim(str_replace($strip, "", strip_tags($string)));
        $clean = preg_replace('/\s+/', "-", $clean);
        $clean = ($anal) ? preg_replace("/[^a-zA-Z0-9]/", "", $clean) : $clean;
        return ($force_lowercase) ?
            (function_exists('mb_strtolower')) ?
                mb_strtolower($clean, 'UTF-8') :
                strtolower($clean) :
            $clean;
    }

    function time_hours($times)
    {
        $time = getdate(strtotime($times));
        if ($time["hours"] < 10) {
            $hour = "0" . $time["hours"];
        } else {
            $hour = $time["hours"];
        }
        return $hour;
    }

    function time_minutes($times)
    {
        $time = getdate(strtotime($times));
        if ($time["minutes"] < 10)
            $minute = "0" . $time["minutes"];
        else
            $minute = $time["minutes"];
        return $minute;
    }

    function time_seconds($times)
    {
        $time = getdate(strtotime($times));
        if ($time["seconds"] < 10)
            $seconds = "0" . $time["seconds"];
        else
            $seconds = $time["seconds"];
        return $seconds;
    }

    function time_hms($time)
    {
        return time_hours($time) . ":" . time_minutes($time) . ":" . time_seconds($time);
    }

    function time_date($times)
    {
        $time = getdate(strtotime($times));
        if ($time["mday"] < 10)
            $date = "0" . $time["mday"];
        else
            $date = $time["mday"];
        return $date;
    }

    function time_month($times)
    {
        $time = getdate(strtotime($times));
        if ($time["mon"] < 10)
            $month = "0" . $time["mon"];
        else
            $month = $time["mon"];
        return $month;
    }

    function time_year($times)
    {
        $time = getdate(strtotime($times));
        if ($time["year"] < 10)
            $year = "0" . $time["year"];
        else
            $year = $time["year"];
        return $year;
    }

    function time_dmy($time)
    {
        return time_date($time) . " tháng " . time_month($time) . " năm " . time_year($time);
    }

}
