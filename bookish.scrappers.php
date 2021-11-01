<?php
declare(strict_types=1);

//global function that parses domnodelist and returns an array
function  domListParser(iterable $nodeList): array {
    $extractedItems = [];
    foreach ($nodeList as $node) {
        $extractedItems[] = $node->textContent.PHP_EOL;
        };
        return $extractedItems;
}


class BookishScrapper {
    //static function to check if book is new
    static function checkIfNew($bookId, $xpath): string{
        $bookIfNew = iterator_to_array($xpath->evaluate("//div[@class='file-right']//div[@data-id=$bookId]/span[@class='new']")); 
        if (empty($bookIfNew)) {
            return "";
        } else {
            return "New!";
        }
        
    }

    //function that executes search query and returns result
    function  bookishSearchScrapper(string $query ): array{
    $client = new \GuzzleHttp\Client();
    $response = $client->get('https://www.pdfdrive.com/search?q='.$query.'&pagecount=&pubyear=&searchin=&em=');  
    $resString = (string) $response->getBody();
    libxml_use_internal_errors(true);
    $xmlDoc = new DOMDocument();
    $xmlDoc->loadHTML($resString);
    $xpath = new DOMXPath($xmlDoc);
    //arrays of scrapped nodes
    $numOfResult =  $xpath->evaluate("//div[@class='files-new']/ul/li"); 
    $bookIds = domListParser($xpath->evaluate('//div[@class="file-right"]//div[@class="file-info"]/@data-id'));
    $bookImages = domListParser($xpath->evaluate('//div[@class="file-left"]//a/img/@src'));
    $booktitles = domListParser($xpath->evaluate('//div[@class="file-right"]//h2'));
    $bookNumPages =domListParser($xpath->evaluate('//div[@class="file-right"]//div[@class="file-info"]/span[@class="fi-pagecount "]'));   
    $bookYearOfPublish =domListParser($xpath->evaluate("//div[@class='file-right']//div[@class='file-info']/span[@class='fi-year ']"));    
    $bookFileSize =domListParser($xpath->evaluate("//div[@class='file-right']//div[@class='file-info']/span[@class='fi-size hidemobile']"));   
    $bookNumOfDownload =domListParser($xpath->evaluate("//div[@class='file-right']//div[@class='file-info']/span[@class='fi-hit']"));     
    //data exposed by the endpoint
    $resultsData =[];
    //loop to create result data
    for ($i=0; $i < count($bookIds) ; $i++) { 
        $resultsData[$i] = array(
            "id"=> $bookIds[$i],
            "images"=>$bookImages[$i],
            "titles"=> $booktitles[$i],
            "pages"=> $bookNumPages[$i],
            "year"=>$bookYearOfPublish[$i],
            "size"=> $bookFileSize[$i],
            "ifNew"=>self::checkIfNew($bookIds[$i], $xpath),
            "downloads"=>$bookNumOfDownload[$i],
        );
    };

    return $resultsData;
}

}