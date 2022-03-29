<?php

use Carbon\Carbon;
use Illuminate\Support\Str;

class ShopHelper
{
    public static function formatTime($time)
    {
        if(is_null($time)) {
            $timeFormat = null;
        }else{
            if (is_string($time)) {
                $time = strtotime($time);
                $timeFormat = date('d/m/Y', $time);
            } else {
                $timeFormat = $time->format('d/m/Y');
            }
        }
        return $timeFormat;
    }

    public static function formatTimeShow($time)
    {
        if (is_null($time)) {
            $timeFormat = null;
        } else {
            if (is_string($time)) {
                $time = strtotime($time);
                $timeFormat = date('H:i d/m/Y', $time);
            } else {
                $timeFormat = $time->format('H:i d/m/Y');
            }
        }

        return $timeFormat;
    }

    public static function formatString($entityType, $field)
    {
        if (strlen($entityType->$field) > 100) {
            $string = Str::limit($entityType->$field, 100, $end = '...');
        } else {
            $string = $entityType->$field;
        }
        return $string;
    }

    public static function formatDate($date) {
        return Carbon::createFromFormat('d/m/Y', $date)->format('Y-m-d');
    }

    public static function formatDateTime($date) {
        return Carbon::createFromFormat('d/m/Y H:i', $date)->format('Y-m-d H:i');
    }

    public static function covertDateTime($date) {
        if(str_contains($date, '/')){
            return $date;
        }else{
            return Carbon::createFromFormat('Y-m-d H:i', $date)->format('d/m/Y H:i');
        }
    }

    public static function slug($str)
    {
        $slug = Str::slug($str, "-");
        if (is_null($slug) || $slug == '') {
            $slug = sha1($str);
        }
        return $slug;
    }

    public static function random6($id)
    {
        return sprintf("%06s", $id);
    }

    public static function genPath($str, $id = null)
    {
        if (!is_null($id)) {
            return self::slug($str) . '-' . self::random6($id);
        } else {
            return self::slug($str);
        }
    }

    public static function numberFormat($value)
    {
        return number_format(round($value), 0, ',', '.');
    }

}
