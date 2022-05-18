<?php

class TRApar_model extends Custom_model
{
    public $table                   = 'tr_apar';
    public $primary_key             = 'id';
    public $soft_deletes            = TRUE;
    public $timestamps              = TRUE;
    public $return_as               = "array";

    public function __construct()
    {
        parent::__construct();
        $this->has_one['region'] = array(
            'foreign_model'     => 'Region_model',
            'foreign_table'     => 'm_region',
            'foreign_key'       => 'id',         
            'local_key'         => 'id_region'          
        );

        $this->has_one['perusahaan'] = array(
            'foreign_model'     => 'Perusahaan_model',
            'foreign_table'     => 'm_perusahaan',
            'foreign_key'       => 'id',         
            'local_key'         => 'id_perusahaan'          
        );

        $this->has_one['unit'] = array(
            'foreign_model'     => 'Unit_model',
            'foreign_table'     => 'm_unit',
            'foreign_key'       => 'id',         
            'local_key'         => 'id_unit'          
        );

        $this->has_one['jenis'] = array(
            'foreign_model'     => 'JenisApar_model',
            'foreign_table'     => 'm_jenis_apar',
            'foreign_key'       => 'id',         
            'local_key'         => 'id_jenis_apar'          
        );
    }
}
