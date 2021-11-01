<?php
require 'vendor/autoload.php';
require 'bookish.scrapper.php';
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
$images = $searchScrapper->bookishSearchScrapper($query);
foreach ($images as $image) {
echo "<img src=".$image->textContent.PHP_EOL." >" ;
}


}
?> 


</body>
</html>
