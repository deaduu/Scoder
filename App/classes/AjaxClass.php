<?php
include 'MainClass.php';

class AjaxClass extends MainClass
{
    function __construct()
    {
        parent::__construct();
    }

    public $data;

    public function projects()
    {
        $response = $this->datatable('scoder', 'projects', ['id', 'name'], $this->data);
        return json_encode($response);
    }

    public function pagesave()
    {
        file_put_contents('../' . $this->data['file'], $this->data['content']);

        // $fh = fopen('../' . $this->data['file'], 'w');
        // fwrite($fh, $this->data['content']);
        // fclose($fh);
    }

    public function pagecall()
    {
        $response = file_get_contents('../' . $this->data['page']);
        return $response;
    }

    public function scoder()
    {
        return file_get_contents('../scoder/' . $this->data['val'] . '.php');
    }

    public function dbnames()
    {
        return json_encode($this->getRows('scoder', 'projects', "name,db"));
    }

    public function tablename()
    {
        return json_encode($this->getdbname($this->data['db']));
    }

    public function tableColumn()
    {
        return json_encode($this->getColumns($this->data));
    }

    public function codecall()
    {

        $columns = explode(',', $this->data['column']);

        $table_th = '';
        $table_row = '';
        foreach ($columns as $col) {
            $table_th .= "<th>{$col}</th>";
            $table_row .= '<td><?php echo $row["' . $col . '"]; ?></td>';
        }


        $response = file_get_contents('../scoder/' . $this->data['val'] . '.php');
        $response = str_replace('%db%', $this->data['db'], $response);
        $response = str_replace('%table%', $this->data['table'], $response);
        $response = str_replace('%sql%', $this->data['sql'], $response);
        $response = str_replace('%select%', $this->data['column'], $response);
        $response = str_replace('%columns%', $table_th, $response);
        $response = str_replace('%rowdata%', $table_row, $response);

        $params = [];

        foreach ($this->data['params'] as $param) {
            if (gettype($param) == 'string') {
                $params[] = "'" . $param . "'";
            } elseif (gettype($param) == 'integer') {
                $params[] = $param;
            }
        }

        $response = str_replace('%params%', join(',', $params), $response);
        return $response;
    }
}
