<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('query_distance')) {
    function query_distance($lat, $lng, $limitKm = 5)
    {
        return "SELECT DISTINCT ( bantuan.id_trayek ), MIN ( bantuan.jarak ) AS jarak FROM ( SELECT tr_detail_trayek.ID AS id_detail_trayek, calculate_distance ( $lat, $lng, latitude :: FLOAT, longitude :: FLOAT, 'K' ) AS jarak, id_trayek, m_trayek.nama, latitude, longitude, nama_tempat, alamat FROM tr_detail_trayek INNER JOIN m_trayek ON tr_detail_trayek.id_trayek :: INT = m_trayek.ID :: INT AND m_trayek.deleted_at IS NULL ORDER BY jarak ASC ) bantuan WHERE jarak <= $limitKm GROUP BY bantuan.id_trayek ORDER BY jarak ASC";
    }
}

if (!function_exists('query_terdekat')) {
    function query_terdekat($id_trayek, $lat, $lng)
    {
        return " SELECT tr_detail_trayek.ID AS id_detail_trayek, calculate_distance ( $lat, $lng, latitude :: FLOAT, longitude :: FLOAT, 'K' ) AS jarak, id_trayek, no_urut, latitude, longitude, nama_tempat, alamat FROM tr_detail_trayek WHERE id_trayek = '$id_trayek' ORDER BY jarak ASC LIMIT 1";
    }
}
