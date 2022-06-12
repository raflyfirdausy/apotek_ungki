<?php

class VKadaluarsa_model extends Custom_model
{
    public $table                   = 'v_kadaluarsa';
    public $primary_key             = 'id';
    public $soft_deletes            = FALSE;
    public $timestamps              = FALSE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();

        $this->has_one['obat'] = array(
            'foreign_model'     => 'Obat_model',
            'foreign_table'     => 'm_obat',
            'foreign_key'       => 'id',
            'local_key'         => 'id_obat'
        );
    }
}
