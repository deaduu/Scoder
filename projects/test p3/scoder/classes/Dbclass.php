<?php
class DbClass
{
    private $servername = "localhost"; // your host name  
    private $username = "root"; // your user name  
    private $password = ""; // your password  
    protected $db = "scoder"; // your database name  

    function __construct()
    {
        $config = parse_ini_file('config.ini', false, INI_SCANNER_NORMAL);
        $this->servername = $config['servername']; // your host name  
        $this->username = $config['username']; // your user name   
        $this->password = $config['password']; // your password   
        $this->db = $config['db']; // your database name 
    }


    private function query($sql)
    {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=" . $this->db, $this->username, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // use exec() because no results are returned
            $conn->exec($sql);
        } catch (PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }

    private function prepInsertQuery($sql, $params)
    {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=" . $this->db, $this->username, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $conn->prepare($sql);

            $statement->execute($params);
            return $conn->lastInsertId();
        } catch (PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }

    protected function rows($sql, $params = NULL)
    {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=" . $this->db, $this->username, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $conn->prepare($sql);

            $statement->execute($params);
            $result = $statement->setFetchMode(PDO::FETCH_ASSOC);

            return $result;
        } catch (PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }

    protected function DB($name)
    {
        $this->query("CREATE DATABASE {$name}");
    }


    protected function table($db, $name, $fields, $constraints = NULL)
    {
        $string = '';
        foreach ($fields as $key => $field) {
            $string .= " `{$key}` {$field},";
        }
        $query = "CREATE TABLE `{$db}`.`{$name}` 
        ( 
            `id` INT NOT NULL AUTO_INCREMENT ,
            {$string}
            {$constraints}
            PRIMARY KEY (`id`)) ENGINE = InnoDB;";

        $this->query($query);
    }

    protected function insert($db, $table, $data)
    {
        $columnSets = array();
        $params = array();
        $bindSets = array();
        foreach ($data as $key => $value) {
            $columnSets[] = $key;
            $params[] = $value;
            $bindSets[] = '?';
        }

        $column = join(',', $columnSets);
        $bind = join(',', $bindSets);

        $sql = "INSERT INTO `{$db}`.`{$table}` 
        ({$column})
        VALUES ({$bind})";

        $this->prepInsertQuery($sql, $params);
    }

    public function getRows($db, $table, $where = NULL, $select = '*')
    {
        $sql = "SELECT {$select} FROM `{$db}`.`{$table}`";
        $sqlwhere = " WHERE ";
        if ($where != NULL) {
            if (is_array($where)) {
                $condition = array_keys($where)[0];
                foreach ($where[$condition] as $key => $value) {
                    $columnSets[] = $key . ' = ?';
                    $params[] = $value;
                }

                $sql .= $sqlwhere . join(" " . $condition . " ", $columnSets);
                $this->rows($sql, $params);
            } else {
                $sql .= $sqlwhere . $where;
            }
        }
    }
}
