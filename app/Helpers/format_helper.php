<?php

namespace App\Helpers;

use IntlDateFormatter;

if (!function_exists('format_tanggal')) {
    function format_tanggal($data)
    {
        $isNotArray = false; // For use in return statement

        // Ensure $data is always an array
        if (!is_array($data) || isset($data['created_at'])) {
            $isNotArray = true;
            $data = array($data);
        }

        foreach ($data as &$item) {
            $timestamp_created_at = strtotime($item['created_at']); // Convert to timestamp
            $timestamp_updated_at = strtotime($item['updated_at']); // Convert to timestamp

            $bulan_indonesia = array(
                1 => 'Januari',
                2 => 'Februari',
                3 => 'Maret',
                4 => 'April',
                5 => 'Mei',
                6 => 'Juni',
                7 => 'Juli',
                8 => 'Agustus',
                9 => 'September',
                10 => 'Oktober',
                11 => 'November',
                12 => 'Desember'
            );

            $item['created_at_terformat'] = date('d', $timestamp_created_at) . ' ' . $bulan_indonesia[date('n', $timestamp_created_at)] . ' ' . date('Y', $timestamp_created_at);
            $item['created_at_timestamp'] = $timestamp_created_at;

            $item['updated_at_terformat'] = date('d', $timestamp_updated_at) . ' ' . $bulan_indonesia[date('n', $timestamp_updated_at)] . ' ' . date('Y', $timestamp_updated_at);
            $item['updated_at_timestamp'] = $timestamp_updated_at;
        }

        return $isNotArray ? $data[0] : $data; // Return first data directly if it's not array (single data), otherwise return array
    }
}

if (!function_exists('format_tanggal_dari_timestamp')) {
    function format_tanggal_dari_timestamp($timestamp)
    {
        $bulan_indonesia = array(
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        );
        return date('d', $timestamp) . ' ' . $bulan_indonesia[date('n', $timestamp)] . ' ' . date('Y', $timestamp);
    }
}

if (!function_exists('capitalize_first_letter')) {
    function capitalize_first_letter($string)
    {
        // Ubah huruf pertama menjadi huruf besar
        $firstLetter = strtoupper(substr($string, 0, 1));
        // Ambil sisa string setelah huruf pertama
        $restOfString = substr($string, 1);
        // Gabungkan huruf pertama besar dengan sisa string
        $capitalizedString = $firstLetter . $restOfString;
        return $capitalizedString;
    }
}

if (!function_exists('create_slug')) {
    function create_slug($string)
    {
        // Convert the string to lowercase
        $slug = strtolower($string);

        // Remove special characters
        $slug = preg_replace('/[^a-z0-9-]/', ' ', $slug);

        // Replace spaces with hyphens
        $slug = preg_replace('/\s+/', '-', $slug);

        // Trim hyphens from the beginning and end of the string
        $slug = trim($slug, '-');

        return $slug;
    }
}

if (!function_exists('format_date_to_array')) {
    function format_date_to_array($date)
    {
        // Array to map Indonesian month names to their English equivalents
        $indonesian_months = [
            'Januari' => 'January',
            'Februari' => 'February',
            'Maret' => 'March',
            'April' => 'April',
            'Mei' => 'May',
            'Juni' => 'June',
            'Juli' => 'July',
            'Agustus' => 'August',
            'September' => 'September',
            'Oktober' => 'October',
            'November' => 'November',
            'Desember' => 'December'
        ];

        // Replace Indonesian month name with English equivalent
        foreach ($indonesian_months as $indonesian => $english) {
            $date = str_replace($indonesian, $english, $date);
        }

        // Convert the date string to a timestamp
        $timestamp = strtotime($date);

        // Extract the day and the abbreviated month name
        $day = date('d', $timestamp);
        $month = date('M', $timestamp);

        // Return them as an array
        return [$day, $month];
    }
}

if (!function_exists('format_tanggal_suatu_kolom')) {
    /**
     * --------------------------------------------------------------------------
     * Format Tanggal Suatu Kolom
     * --------------------------------------------------------------------------
     * 
     * Format datetime of selected column from database with Locale id_ID
     * 
     * Added 'formatted_datetime' key on returned array
     * 
     * @return $data with added 'formatted_datetime'
     */
    function format_tanggal_suatu_kolom($data, $kolom = 'created_at', $showWaktu = false)
    {
        $isNotArray = false; // For use in return statement

        // Set the locale to Indonesian
        $locale = 'id_ID';
        $dateType = IntlDateFormatter::RELATIVE_FULL;
        $timeType = $showWaktu ? IntlDateFormatter::LONG : IntlDateFormatter::NONE;
        $pattern = 'EEEE, d MMMM yyyy HH:mm z';
        $formatter = new IntlDateFormatter($locale, $dateType, $timeType);

        // Ensure $data is always an array
        if (!is_array($data) || isset($data[$kolom])) {
            $isNotArray = true;
            $data = array($data);
        }

        foreach ($data as &$item) {
            $date = date_create($item[$kolom]);
            // $item['formatted_datetime'] = date_format($date, 'j M Y');
            $item['formatted_datetime'] = $formatter->format($date);
        }

        return $isNotArray ? $data[0] : $data; // Return first data directly if it's not array (single data), otherwise return array
    }
}
