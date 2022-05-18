<?php

if (!function_exists('base_wa')) {
    function base_wa($path = ""){
        return base_url("whatsapp/$path");
    }
}