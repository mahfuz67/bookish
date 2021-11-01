<?php
require 'vendor/autoload.php';
require 'bookish.scrappers.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<?php

if(isset($_GET['q'])){
$query = $_GET['q'];
$searchScrapper = new BookishScrapper();
$result = $searchScrapper->bookishSearchScrapper($query);

echo json_encode($result);
}
?> 


</body>
</html>
