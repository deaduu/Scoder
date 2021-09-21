<?php
include 'DbClass.php';

class MainClass extends DbClass
{
    function __construct()
    {
        parent::__construct();
    }

    public function getProjects()
    {
        $where = array(
            'AND' => array(
                'project_id' => '1'
            )
        );
        $this->getRows('scoder', 'projects', $where);
    }
}
