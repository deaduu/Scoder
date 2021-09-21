<?php
include 'DbClass.php';

class PageClass extends DbClass
{
    function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        //
    }

    public function projects()
    {
        //
    }

    public function editor()
    {
        $data['codes'] = $this->getRows('scoder', 'scoder');
        return $data;
    }
}
