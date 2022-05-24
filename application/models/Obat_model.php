<?php

class Obat_model extends Custom_model
{
    public $table                   = 'm_obat';
    public $primary_key             = 'id';
    public $soft_deletes            = TRUE;
    public $timestamps              = TRUE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();

        $this->has_one['golongan'] = array(
            'foreign_model'     => 'Golongan_obat_model',
            'foreign_table'     => 'm_obat_golongan',
            'foreign_key'       => 'id',
            'local_key'         => 'id_golongan'
        );

        $this->has_one['kategori'] = array(
            'foreign_model'     => 'Kategori_obat_model',
            'foreign_table'     => 'm_obat_kategori',
            'foreign_key'       => 'id',
            'local_key'         => 'id_kategori'
        );

        $this->has_one['satuan'] = array(
            'foreign_model'     => 'Satuan_obat_model',
            'foreign_table'     => 'm_obat_satuan',
            'foreign_key'       => 'id',
            'local_key'         => 'id_satuan'
        );
    }
}
