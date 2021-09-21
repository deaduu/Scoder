<?php
include 'DbClass.php';

class CreateProjectClass extends DbClass
{
    function __construct($name, $projectname)
    {
        $this->DB($name);
        $fields = array(
            'name' => 'VARCHAR(255) NOT NULL',
            'password' => 'VARCHAR(255) NOT NULL',
            'email' => 'VARCHAR(255) NOT NULL',
        );
        $this->table($name, 'users', $fields, 'UNIQUE (email),');

        $this->insert($this->db, 'projects', ['name' => $projectname, 'db' => $name]);
    }

    public function writeConfig($filename, $name)
    {
        $serverconfig = parse_ini_file('config.ini', false, INI_SCANNER_NORMAL);

        $config = array(
            'servername' => $serverconfig['servername'], // your host name  
            'username' => $serverconfig['username'], // your user name  
            'password' => $serverconfig['password'], // your password  
            'db' => $name, // your database name  
        );

        $fh = fopen($filename, "w");
        if (!is_resource($fh)) {
            return false;
        }
        foreach ($config as $key => $value) {
            fwrite($fh, sprintf("%s = %s\n", $key, $value));
        }
        fclose($fh);

        return true;
    }
}
