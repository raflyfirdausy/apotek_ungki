<?php

class Satuan_obat_model extends Custom_model
{
    public $table                   = 'm_obat_satuan';
    public $primary_key             = 'id';
    public $soft_deletes            = TRUE;
    public $timestamps              = TRUE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();
    }
}
