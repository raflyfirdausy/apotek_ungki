<?php

class VStok_obat_model extends Custom_model
{
    public $table                   = 'v_stok_obat';
    public $primary_key             = 'id';
    public $soft_deletes            = FALSE;
    public $timestamps              = FALSE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();

        $this->has_one['lokasi'] = array(
            'foreign_model'     => 'Lokasi_model',
            'foreign_table'     => 'm_lokasi',
            'foreign_key'       => 'id',
            'local_key'         => 'id_lokasi'
        );
    }
}
