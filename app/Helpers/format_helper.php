<?php

namespace App\Helpers;

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
                1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
                7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
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
            1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April', 5 => 'Mei', 6 => 'Juni',
            7 => 'Juli', 8 => 'Agustus', 9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
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
