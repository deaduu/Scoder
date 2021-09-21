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
            if (strpos($sql, '?') !== false) {
                $ques = true;
            } else {
                $ques = false;
            }
            if ($ques) {
                $statement->execute($params);
            } else {
                // Bind values
                if ($params) {
                    foreach ($params as $key => $value) {
                        if (gettype($value) == 'string') {
                            $statement->bindValue(':' . $key, $value, PDO::PARAM_STR);
                        } elseif (gettype($value) == 'integer') {
                            $statement->bindValue(':' . $key, (int)$value, PDO::PARAM_INT);
                        }
                    }
                }

                $statement->execute();
            }
            $results = $statement->fetchAll(PDO::FETCH_ASSOC);

            return $results;
        } catch (PDOException $e) {
            return "Connection failed: " . $e->getMessage();
        }
    }

    protected function row($sql, $params = NULL)
    {
        try {
            $conn = new PDO("mysql:host=$this->servername;dbname=" . $this->db, $this->username, $this->password);
            // set the PDO error mode to exception
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $statement = $conn->prepare($sql);
            if (strpos($sql, '?') !== false) {
                $ques = true;
            } else {
                $ques = false;
            }
            // Bind values
            if ($ques) {
                $statement->execute($params);
            } else {
                // Bind values
                if ($params) {
                    foreach ($params as $key => $value) {
                        if (gettype($value) == 'string') {
                            $statement->bindValue(':' . $key, $value, PDO::PARAM_STR);
                        } elseif (gettype($value) == 'integer') {
                            $statement->bindValue(':' . $key, (int)$value, PDO::PARAM_INT);
                        }
                    }
                }

                $statement->execute();
            }
            $results = $statement->fetch(PDO::FETCH_ASSOC);

            return $results;
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

    public function getRows($db, $table, $select = NULL, $where = NULL, $params = NULL)
    {
        $params = !empty($params) ? $params : NULL;
        $select = !empty($select) ? $select : '*';
        $sql = "SELECT {$select} FROM `{$db}`.`{$table}`";

        if ($where != NULL) {
            if (is_array($where)) {
                $condition = array_keys($where)[0];
                foreach ($where[$condition] as $key => $value) {
                    $columnSets[] = $key . ' = :' . $key;
                    $params[$key] = $value;
                }

                $sql .= " WHERE " . join(" " . $condition . " ", $columnSets);
                return $this->rows($sql, $params);
            } else {
                $sql .= " WHERE 1 AND " . $where;
                return $this->rows($sql, $params);
            }
        } else {
            return $this->rows($sql);
        }
    }

    public function getRow($db, $table, $select = NULL, $where = NULL, $params = NULL)
    {
        $params = !empty($params) ? $params : NULL;
        $select = !empty($select) ? $select : '*';
        $sql = "SELECT {$select} FROM `{$db}`.`{$table}`";

        if ($where != NULL) {
            if (is_array($where)) {
                $condition = array_keys($where)[0];
                foreach ($where[$condition] as $key => $value) {
                    $columnSets[] = $key . ' = :' . $key;
                    $params[$key] = $value;
                }

                $sql .= " WHERE " . join(" " . $condition . " ", $columnSets);
                return $this->row($sql, $params);
            } else {
                $sql .= " WHERE 1 AND " . $where;
                return $this->row($sql, $params);
            }
        } else {
            return $this->row($sql);
        }
    }

    protected function getdbname($db)
    {
        return $this->rows("SELECT table_name 
        FROM INFORMATION_SCHEMA.TABLES
        WHERE TABLE_TYPE = 'BASE TABLE' AND TABLE_SCHEMA='{$db}'");
    }

    protected function getColumns($data)
    {
        return $this->rows("
        SELECT
        `column_name` AS id,
        CONCAT(UPPER(SUBSTRING(REPLACE(`column_name`,'_',' '),1,1)),LOWER(SUBSTRING(REPLACE(`column_name`,'_',' '),2))) as name,
    (CASE
        WHEN `data_type` = 'int' THEN 'integer'
        WHEN `data_type` = 'varchar' THEN 'string'
     END) as type
        FROM `INFORMATION_SCHEMA`.`COLUMNS` 
        WHERE `TABLE_SCHEMA`='{$data['db']}' 
            AND `TABLE_NAME`='{$data['table']}'");
    }
}
