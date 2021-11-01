<?php
require 'vendor/autoload.php';
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
$client = new \GuzzleHttp\Client();
$response = $client->get('https://www.pdfdrive.com/search?q='.$query.'&pagecount=&pubyear=&searchin=&em=');  //$client->request('GET', 'https://www.pdfdrive.com/search?q='.$query.'&searchin=eng');
$resString = (string) $response->getBody();
libxml_use_internal_errors(true);
$xmlDoc = new DOMDocument();
$xmlDoc->loadHTML($resString);
$xpath = new DOMXPath($xmlDoc);
$images = $xpath->evaluate('//div[@class="file-left"]//a/img/@src');
$extractedTitles = [];
foreach ($images as $image) {
$extractedTitles[] = $image->textContent.PHP_EOL;
echo '<p>'.$title->textContent.PHP_EOL.'</p>' ;
}


}


?> 


</body>
</html>
