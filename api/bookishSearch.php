<?php
declare(strict_types=1);
require '../scrappers/booksearchscrappers.php';


if( isset($_GET['q']) || isset($_GET['pagecount']) || isset($_GET['c']) || isset($_GET['searchin']) || isset($_GET['em']) || isset($_GET['page']) ){
    $query = $_GET['q'];
    $pagecount = $_GET['pagecount']??'';
    $pubyear = $_GET['pagecount']??'';
    $searching = $_GET['searchin']??'';
    $em = $_GET['em']??'';
    $page =  $_GET['page']??'';

    function  domListParser(iterable $nodeList): array {
        $extractedItems = [];
        foreach ($nodeList as $node) {
            $extractedItems[] = $node->textContent.PHP_EOL;
            };
            return $extractedItems;
    }

    $client = new \GuzzleHttp\Client();
    $response = $client->get('https://www.pdfdrive.com/search?q='.$query.'&pagecount='.$pagecount.'&pubyear='.$pubyear.'&searchin='.$searching.'&em='.$em.'&page='.$page);  
    $resString = (string) $response->getBody();
    libxml_use_internal_errors(true);
    $xmlDoc = new DOMDocument();
    $xmlDoc->loadHTML($resString);
    $xpath = new DOMXPath($xmlDoc);
    $bookObectGetter = new BookObjectGetterSearch();
    $bookLinks= $xpath->evaluate('//div[@class="file-left"]//a/@href');
    //$numOfResult =  $xpath->evaluate("//div[@class='files-new']/ul/li"); 
    $bookIds = domListParser($xpath->evaluate('//div[@class="file-right"]//div[@class="file-info"]/@data-id'));
    $resultsData =[];
    //loop to create result data
    for ($i=0; $i < count($bookIds) ; $i++) { 
        $resultsData[$i] = array(
            "id"=> $bookIds[$i],
            "image"=>$bookObectGetter->getBookImage($bookIds[$i], $xpath),
            "title"=>$bookObectGetter->getBookTitle($bookIds[$i], $xpath),
            "pages"=>$bookObectGetter->getBookNumberOfPages($bookIds[$i], $xpath),
            "year"=>$bookObectGetter->getBookYearOfPublish($bookIds[$i], $xpath),
            "size"=> $bookObectGetter->getBookSIze($bookIds[$i], $xpath),
            "ifNew"=>$bookObectGetter->checkIfNew($bookIds[$i], $xpath),
            "downloads"=>$bookObectGetter->getBookNumberOfDownloads($bookIds[$i], $xpath),
            "linkToInfo"=> $bookObectGetter->getBookInfoLink($bookIds[$i], $xpath),
            //"bookLink"=> $bookObectGetter->getBookLink($bookIds[$i], $xpath),
        );
    };

    var_dump($resultsData);
}