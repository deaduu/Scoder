<?php 
$sql = "%sql%";
$params = [%params%];
$obj = new MainClass;
$results = $obj->getRows('%db%','%table%','%select%',$sql,$params);
?>
<style>
table, th, td {
  border:1px solid black;
}
</style>
<table style="width:100%">
    <thead>
        <tr>
            %columns%
        </tr>
    </thead>
    <tbody>
        <?php foreach($results as $row){ ?>
        <tr>
            %rowdata%
        </tr>
        <?php } ?>
    </tbody>
</table>