<?php
    include '../database-connection.php';
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Database Ish</title>
</head>
<body>

<?php
$statement = $mainDBConnection->query('show master status');

//var_dump($statement->fetch());
?>

<form action="">

</form>

</body>
</html>
