<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Pesan Umum Aplikasi
    |--------------------------------------------------------------------------
    |
    | Baris bahasa berikut digunakan untuk menampilkan pesan umum ke pengguna
    | dalam berbagai aksi seperti CRUD, autentikasi, dan lainnya.
    |
    */

    // CRUD
    'created' => ':Item berhasil ditambahkan.',
    'updated' => ':Item berhasil diperbarui.',
    'deleted' => ':Item berhasil dihapus.',
    'retrieved' => 'Data :item berhasil ditampilkan.',
    'processed' => ':Item berhasil diproses.',

    // Error umum
    'not_found' => ':Item tidak ditemukan.',
    'unauthorized' => 'Akses tidak diizinkan.',
    'forbidden' => 'Anda tidak memiliki izin.',
    'self_forbidden' => 'Aksi ini tidak dapat dilakukan pada akun Anda sendiri.',
    'validation_failed' => 'Validasi gagal.',
    'operation_failed' => 'Operasi gagal dilakukan.',
    'process_failed' => 'Terjadi kesalahan saat memproses permintaan.',
    'invalid' => ':Attribute tidak valid.',
    'something_went_wrong' => 'Terjadi kesalahan.',

    // Autentikasi
    'registered' => 'Pendaftaran berhasil.',
    'registration_failed' => 'Pendaftaran gagal. Periksa data yang anda masukkan.',
    'logged_in' => 'Berhasil masuk.',
    'logged_out' => 'Berhasil keluar.',
    'login_failed' => 'Gagal masuk. Periksa email dan kata sandi Anda.',
];
