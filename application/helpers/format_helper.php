<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Format Rupiah
 * @param int|float|null $angka
 * @param bool $pakai_rp
 * @return string
 */
function rupiah($angka, $pakai_rp = true)
{
    if ($angka === null || $angka == 0) {
        return '0';
    }

    $hasil = number_format((float)$angka, 0, ',', '.');

    return $pakai_rp ? 'Rp. ' . $hasil : $hasil;
}

/**
 * Nama bulan Indonesia
 * @param int $bulan
 * @return string
 */
function bulan_id($bulan)
{
    $bulan = (int)$bulan;
    $list = [
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
    ];

    return $list[$bulan] ?? '';
}
