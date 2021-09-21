<?php
include 'DbClass.php';

class MainClass extends DbClass
{
    function __construct()
    {
        parent::__construct();
    }

    protected function datatable($db, $table, $columns, $data)
    {
        $where = NULL;
        $params = [];
        $draw = $data['draw'];
        $searchcolumn = join(',', $columns);
        $columnIndex = $data['order'][0]['column']; // Column index
        $columnName = $data['columns'][$columnIndex]['data']; // Column name
        $columnSortOrder = $data['order'][0]['dir']; // asc or desc
        $row = $data['start'];
        $rowperpage = $data['length']; // Rows display per page
        $where = '';
        if (!empty($data['search']['value'])) {
            $where = [];

            foreach ($columns as $column) {
                $where[] = " {$column} LIKE :{$column} ";
                $params[$column] = "%{$data['search']['value']}%";
            }

            $where =  join(" OR ", $where);
            $where .= " ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :offset, :perpage";
        } else {
            $where .= "1 ORDER BY " . $columnName . " " . $columnSortOrder . " LIMIT :offset, :perpage";
        }
        $params = array_merge($params, ['offset' => intval($row), 'perpage' => intval($rowperpage)]);

        $projects = $this->getRows($db, $table, $searchcolumn, $where, $params);
        // pr($data);
        $totalRecords = count($this->getRows($db, $table));
        $totalRecordwithFilter = count($projects);

        return array(
            "draw" => intval($draw),
            "iTotalRecords" => $totalRecordwithFilter,
            "iTotalDisplayRecords" => $totalRecords,
            "aaData" => $projects
        );
    }

    public function createDB($db)
    {
        $this->DB($db);
    }
}
