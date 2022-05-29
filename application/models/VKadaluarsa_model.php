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
    }
}
