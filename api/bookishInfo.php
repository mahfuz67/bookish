<?php
declare(strict_types=1);
require '../scrappers/bookinfoscrapers.php';
require '../vendor/autoload.php';
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

if (isset($_GET['bookinfolink']) && isset($_GET['getbookpdf'])){
    if($_GET['getbookpdf'] == 'true' ){

        $link = $_GET['bookinfolink'];
        $link = trim($link);
        $curl = curl_init($link);
        curl_setopt($curl, CURLOPT_URL, $link);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response1 = (string) curl_exec($curl);
        curl_close($curl);
        //echo $response1;
        libxml_use_internal_errors(true);
        $xmlDoc = new DOMDocument();
        $xmlDoc->loadHTML($response1);
        $xpathE = new DOMXPath($xmlDoc);
        $bookLinkD = $xpathE->evaluate("//div[@class='ebook-buttons']/span[@id='download-button']/a/@href"); 
        $bookLinkD = $bookLinkD[0]->textContent.PHP_EOL;
        $bookLinkD = trim($bookLinkD);
        $bookLinkDFull = "https://www.pdfdrive.com$bookLinkD"; 
        $serverUrl = 'http://localhost:9515';
        $driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());
        $driver->get($bookLinkDFull);
        $element = $driver->wait(30, 500)->until(
                function () use ($driver) {
                    $element = $driver->findElement(WebDriverBy::XPath("//a[normalize-space()='Download ( PDF )'] | //a[normalize-space()='Go to PDF']"));
                    $element = $element->getAttribute('href');
                    return $element;
                }
            );
        $bookLinkFull = ($element[0] == '/') ? "https://www.pdfdrive.com$element" : $element ;
        echo json_encode($bookLinkFull);
       
        //function getPdf()
   // {
   // $client = new \GuzzleHttp\Client();
   // header('Content-type: application/pdf');
   // $response = $client->get('https://www.pdfdrive.com/download.pdf?id=58864799&h=c55ee8a467a370dd11fcf9dcec21f426&u=cache&ext=pdf'); 
    //$result = (string) $response->getBody(); 
   // echo $result;
   // exit();


    }else if($_GET['getbookpdf'] == 'false') {

        function  domListParser(iterable $nodeList): array {
            $extractedItems = [];
            foreach ($nodeList as $node) {
                $extractedItems[] = $node->textContent.PHP_EOL;
                };
                return $extractedItems;
        }
    
        $link = $_GET['bookinfolink'];
        $link = trim($link);
        $client = new \GuzzleHttp\Client();
        $response = $client->get($link);  
        $resString = (string) $response->getBody();
        libxml_use_internal_errors(true);
        $xmlDoc = new DOMDocument();
        $xmlDoc->loadHTML($resString);
        $xpath = new DOMXPath($xmlDoc);
        $bookObectGetterInfo = new BookObjectGetterInfo();
        $bookIds = domListParser($xpath->evaluate('//div[@class="file-right"]//div[@class="file-info"]/@data-id'));  
        $resultsData =[];
        //loop to create result data
        for ($i=0; $i < count($bookIds) ; $i++) { 
            $resultsData[$i] = array(
                "id"=> $bookIds[$i],
                "image"=>$bookObectGetterInfo->getBookImageSuggested($bookIds[$i], $xpath),
                "title"=>$bookObectGetterInfo->getBookTitleSuggested($bookIds[$i], $xpath),
                "pages"=>$bookObectGetterInfo->getBookNumberOfPagesSuggested($bookIds[$i], $xpath),
                "year"=>$bookObectGetterInfo->getBookYearOfPublishSuggested($bookIds[$i], $xpath),
                "size"=> $bookObectGetterInfo->getBookSIzeSuggested($bookIds[$i], $xpath),
                "ifNew"=>$bookObectGetterInfo->checkIfNewSuggested($bookIds[$i], $xpath),
                "downloads"=>$bookObectGetterInfo->getBookNumberOfDownloadsSuggested($bookIds[$i], $xpath),
                "bookLink"=>$bookObectGetterInfo->getBookInfoLinkSuggested($bookIds[$i], $xpath),
            );
        };
      
        $result = array(
            "bookAuthorMain" => $bookObectGetterInfo->getBookAuthor($xpath),
            "suggestedBooks" => $resultsData,
        ); 
        echo json_encode($result);
    }
}


