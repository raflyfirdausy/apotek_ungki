<?php

class Transaksi_obat_model extends Custom_model
{
    public $table                   = 'tr_transaksi_obat';
    public $primary_key             = 'id';
    public $soft_deletes            = TRUE;
    public $timestamps              = TRUE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();

        $this->has_one['admin'] = array(
            'foreign_model'     => 'Admin_model',
            'foreign_table'     => 'm_admin',
            'foreign_key'       => 'id',
            'local_key'         => 'id_admin'
        );

        $this->has_one['obat'] = array(
            'foreign_model'     => 'Obat_model',
            'foreign_table'     => 'm_obat',
            'foreign_key'       => 'id',
            'local_key'         => 'id_obat'
        );
    }
}
