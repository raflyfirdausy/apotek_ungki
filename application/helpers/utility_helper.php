<?php
if (!defined('BASEPATH')) exit('No direct script access allowed');

if (!function_exists('get_external_ip')) {
    function get_external_ip()
    {
        // Batasi waktu mencoba
        $options = stream_context_create(array(
            'http' =>
            array(
                'timeout' => 2 //2 seconds
            )
        ));
        $externalContent = file_get_contents('http://checkip.dyndns.com/', false, $options);
        preg_match('/\b(?:\d{1,3}\.){3}\d{1,3}\b/', $externalContent, $m);
        $externalIp = $m[0];
        return $externalIp;
    }
}

if (!function_exists('d')) {
    function d($x)
    {
        return die(json_encode($x));
    }
}

//FUNCTION INI BELUM BERJALAN DENGAN BAIK
if (!function_exists('e')) {
    function e($data)
    {
        return isset($data) ? $data : "";
    }
}

if (!function_exists('generator')) {
    function generator($length = 7)
    {
        return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }
}

if (!function_exists('replace_lower')) {
    function replace_lower($string = "")
    {
        preg_replace("/[^A-Za-z0-9]/", "_", strtolower($string));
    }
}

if (!function_exists('ce')) {
    function ce($string = "")
    {
        return ucwords(strtolower($string));
    }
}

if (!function_exists('sc')) {
    function sc($string = "")
    {
        return ucfirst(strtolower($string));
    }
}

if (!function_exists("set")) {
    function set(&$string)
    {
        return isset($string) ? $string : FALSE;
    }
}

if (!function_exists('tanggal_tampil')) {
    function tanggal_tampil($tanggal = "")
    {
        $originalDate = $tanggal;
        $newDate = date("m/d/Y", strtotime($originalDate));
        return $newDate;
    }
}

if (!function_exists('insert_tanggal')) {
    function insert_tanggal($tanggal = "")
    {
        $newDate = date("Y-m-d", strtotime($tanggal));
        return $newDate;
    }
}

if (!function_exists('alphanumspace')) {
    function alphanumspace($string = "")
    {
        return preg_replace("/[^a-zA-Z0-9 ]+/", "", remove_duplicate_space($string));
    }
}

if (!function_exists('alphanum')) {
    function alphanum($string = "")
    {
        return preg_replace("/[^a-zA-Z0-9_]+/", "", remove_duplicate_space($string));
    }
}

if (!function_exists("remove_duplicate_space")) {
    function remove_duplicate_space($string = "")
    {
        return preg_replace('/\s+/', ' ', $string);
    }
}

if (!function_exists("dash")) {
    function dash($string = "")
    {
        return str_replace(" ", "-", $string);
    }
}

if (!function_exists("slug")) {
    function slug($string = "")
    {
        return strtolower(dash(remove_duplicate_space(alphanumspace($string))));
    }
}

if (!function_exists("remove_line_break")) {
    function remove_line_break($string = "")
    {
        return preg_replace("/\r|\n/", "", $string);
    }
}

if (!function_exists("validasi_input_artikel")) {
    function validasi_input_artikel($string = "")
    {
        return str_replace("'", "", remove_line_break($string));
    }
}

if (!function_exists('send_wa')) {
    function send_wa($payload = [])
    {
        $token          = "2c5a8d814a2bc664b8aafb0f57646d68";
        $number         = isset($payload["number"])         ? $payload["number"]        : "";
        $jenis          = "JEKNYONG_APP";                                                           //! GANTI JENISNYA SESUAI JENIS PENGIRIMIAN, TERSERAH APAPUN, HURUF BESAR SEMUA TANPA SPASI
        $message        = isset($payload["message"])        ? $payload["message"]       : "";       //! GANTI MESSAGE NYA
        $lampiran       = isset($payload["lampiran"])       ? $payload["lampiran"]      : "";       //! CONTOH SEPERTI INI
        $nama_lampiran  = isset($payload["nama_lampiran"])  ? $payload["nama_lampiran"] : "";       //! CONTOH SEPERTI INI

        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_URL             =>  "http://10.10.16.195:9969/kirim?" .
                "token=" .          urlencode($token) .
                "&number=" .        urlencode($number) .
                "&message=" .       urlencode($message) .
                "&jenis=" .         urlencode($jenis) .
                "&lampiran=" .      (!empty($lampiran) ? urlencode($lampiran) : "") .
                "&nama_lampiran=" . (!empty($nama_lampiran) ? urlencode($nama_lampiran) : ""),
            CURLOPT_RETURNTRANSFER  => true,
            CURLOPT_ENCODING        => '',
            CURLOPT_MAXREDIRS       => 10,
            CURLOPT_TIMEOUT         => 5,
            CURLOPT_FOLLOWLOCATION  => true,
            CURLOPT_HTTP_VERSION    => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST   => 'GET',
            CURLOPT_CONNECTTIMEOUT  => 2,

        ));

        curl_exec($curl);
        curl_close($curl);
    }
}

if (!function_exists('sendPushNotification')) {
    function sendPushNotification($payloads)
    {

        if (!isset($payloads["data"]["jenis_suara"])) {
            $payloads["data"]["jenis_suara"] = "JEKNYONG";
        }

        $url = 'https://fcm.googleapis.com/fcm/send';
        $headers = array(
            'Authorization: key=' . KEY_FCM,
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payloads));

        $result = curl_exec($ch);
        if ($result === FALSE) {
            die('Curl failed: ' . curl_error($ch));
        }

        //TODO : INSERT INTO DATABASE
        $CI = &get_instance();
        $CI->load->model("Tr_notifikasi_model", "notifikasi");
        $dataInsertNotif = [
            "id_user"               => isset($payloads["data"]["id_user"])        ? $payloads["data"]["id_user"]        : null,
            "id_driver"             => isset($payloads["data"]["id_driver"])      ? $payloads["data"]["id_driver"]      : null,
            "id_admin"              => isset($payloads["data"]["id_admin"])       ? $payloads["data"]["id_admin"]       : null,
            "notifikasi_title"      => isset($payloads["data"]["title"])          ? $payloads["data"]["title"]          : null,
            "notifikasi_message"    => isset($payloads["data"]["message"])        ? $payloads["data"]["message"]        : null,
            "notifikasi_to"         => $payloads["to"],
            "jenis_notif"           => isset($payloads["data"]["jenis_notif"])    ? $payloads["data"]["jenis_notif"]    : null,
        ];
        $CI->notifikasi->insert($dataInsertNotif);

        curl_close($ch);
        return $result;
    }
}
