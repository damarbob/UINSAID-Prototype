<?php

return [
    // Core Messages
    'noRuleSets'      => 'Tidak ada set aturan yang ditentukan dalam konfigurasi Validasi.',
    'ruleNotFound'    => '"{0}" bukan aturan yang valid.',
    'groupNotFound'   => '"{0}" bukan grup aturan validasi.',
    'groupNotArray'   => 'Grup aturan "{0}" harus berupa array.',
    'invalidTemplate' => '"{0}" bukan template Validasi yang valid.',

    // Rule Messages
    'alpha'                 => 'Kolom {field} hanya boleh berisi karakter alfabet.',
    'alpha_dash'            => 'Kolom {field} hanya boleh berisi karakter alfanumerik, garis bawah, dan tanda hubung.',
    'alpha_numeric'         => 'Kolom {field} hanya boleh berisi karakter alfanumerik.',
    'alpha_numeric_punct'   => 'Kolom {field} hanya boleh berisi karakter alfanumerik, spasi, dan karakter ~ ! # $ % & * - _ + = | : .',
    'alpha_numeric_space'   => 'Kolom {field} hanya boleh berisi karakter alfanumerik dan spasi.',
    'alpha_space'           => 'Kolom {field} hanya boleh berisi karakter alfabet dan spasi.',
    'decimal'               => 'Kolom {field} harus berisi angka desimal.',
    'differs'               => 'Kolom {field} harus berbeda dari kolom {param}.',
    'equals'                => 'Kolom {field} harus tepat: {param}.',
    'exact_length'          => 'Kolom {field} harus tepat {param} karakter.',
    'greater_than'          => 'Kolom {field} harus berisi angka yang lebih besar dari {param}.',
    'greater_than_equal_to' => 'Kolom {field} harus berisi angka yang lebih besar atau sama dengan {param}.',
    'hex'                   => 'Kolom {field} hanya boleh berisi karakter heksadesimal.',
    'in_list'               => 'Kolom {field} harus salah satu dari: {param}.',
    'integer'               => 'Kolom {field} harus berisi angka bulat.',
    'is_natural'            => 'Kolom {field} hanya boleh berisi digit.',
    'is_natural_no_zero'    => 'Kolom {field} hanya boleh berisi digit dan harus lebih besar dari nol.',
    'is_not_unique'         => 'Kolom {field} harus berisi nilai yang sudah ada di database.',
    'is_unique'             => 'Kolom {field} harus berisi nilai yang unik.',
    'less_than'             => 'Kolom {field} harus berisi angka yang lebih kecil dari {param}.',
    'less_than_equal_to'    => 'Kolom {field} harus berisi angka yang lebih kecil atau sama dengan {param}.',
    'matches'               => 'Kolom {field} tidak cocok dengan kolom {param}.',
    'max_length'            => 'Kolom {field} tidak boleh melebihi {param} karakter.',
    'min_length'            => 'Kolom {field} harus minimal {param} karakter.',
    'not_equals'            => 'Kolom {field} tidak boleh: {param}.',
    'not_in_list'           => 'Kolom {field} tidak boleh salah satu dari: {param}.',
    'numeric'               => 'Kolom {field} harus berisi angka saja.',
    'regex_match'           => 'Kolom {field} tidak dalam format yang benar.',
    'required'              => 'Kolom {field} diperlukan.',
    'required_with'         => 'Kolom {field} diperlukan ketika {param} ada.',
    'required_without'      => 'Kolom {field} diperlukan ketika {param} tidak ada.',
    'string'                => 'Kolom {field} harus berupa string yang valid.',
    'timezone'              => 'Kolom {field} harus berisi zona waktu yang valid.',
    'valid_base64'          => 'Kolom {field} harus berisi string base64 yang valid.',
    'valid_email'           => 'Kolom {field} harus berisi alamat email yang valid.',
    'valid_emails'          => 'Kolom {field} harus berisi semua alamat email yang valid.',
    'valid_ip'              => 'Kolom {field} harus berisi IP yang valid.',
    'valid_url'             => 'Kolom {field} harus berisi URL yang valid.',
    'valid_url_strict'      => 'Kolom {field} harus berisi URL yang valid.',
    'valid_date'            => 'Kolom {field} harus berisi tanggal yang valid.',
    'valid_json'            => 'Kolom {field} harus berisi json yang valid.',

    // Credit Cards
    'valid_cc_num' => 'Kolom {field} tampaknya bukan nomor kartu kredit yang valid.',

    // Files
    'uploaded' => 'Kolom {field} bukan file yang diunggah dengan valid.',
    'max_size' => 'Kolom {field} terlalu besar.',
    'is_image' => 'Kolom {field} bukan file gambar yang valid.',
    'mime_in'  => 'Kolom {field} tidak memiliki tipe mime yang valid.',
    'ext_in'   => 'Kolom {field} tidak memiliki ekstensi file yang valid.',
    'max_dims' => 'Kolom {field} bukan gambar, atau terlalu lebar atau tinggi.',
];
