<?php
function fetch_record($table, $order, $offset)
{
	include("config/include_database.php");
	$stmt = $pdo->prepare("select * from ".$table." order by ".$order." asc limit ".$offset.", 20");
	$stmt->execute();
	$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
	return $rows;
}

function fetch_count($table)
{
	include("config/include_database.php");
	$stmt = $pdo->prepare("select count(*) as number from ".$table);
	$stmt->execute();
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	return $rows;
}

function fetch_company_name($company_id)
{
	include("config/include_database.php");
	$stmt = $pdo->prepare("select company_name from company where company_id = ?");
	$stmt->execute(array($company_id));
	$rows = $stmt->fetch(PDO::FETCH_ASSOC);
	return $rows['company_name'];
}
?>
