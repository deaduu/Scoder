<?php require_once dirname(__FILE__) . '/autoload.php'; ?>
<html>
	<body>
<?php 
$sql = "name = ?";
$params = ['sdf'];
$obj = new MainClass;
$results = $obj->getRows('test_p1','users','id,name,email',$sql,$params);
?>
<style>
table, th, td {
  border:1px solid black;
}
</style>
<table style="width:100%">
    <thead>
        <tr>
            <th>id</th><th>name</th><th>email</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($results as $row){ ?>
        <tr>
            <td><?php echo $row["id"]; ?></td>
			<td><?php echo $row["name"]; ?></td>
			<td><?php echo $row["email"]; ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>
	</body>
</html>