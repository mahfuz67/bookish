<?php

require '../vendor/autoload.php';
 

use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class BookObjectGetterSearch {

     function getBookImage($bookId, $xpath){
        $image = $xpath->evaluate("//div[@class='file-left']//a[@data-id=$bookId]/img/@src"); 
        $image = $image[0]->textContent.PHP_EOL;
        return  $image;
        
    }
     function getBookTitle($bookId, $xpath){
        $bookTitle = $xpath->evaluate("//div[@class='file-right']//div[@data-id=$bookId]/preceding-sibling::a/h2"); 
        $bookTitle = $bookTitle[0]->textContent.PHP_EOL;
        return  $bookTitle;
        
    }
     function getBookNumberOfPages($bookId, $xpath){
        $pages = iterator_to_array($xpath->evaluate("//div[@class='file-right']//div[@data-id=$bookId]/span[@class='fi-pagecount ']")); 
        if (empty($pages)) {
           return '';
        } else {
            $pages = $pages[0]->textContent.PHP_EOL;
            return  $pages;
        }
        
        
    }
     function getBookYearOfPublish($bookId, $xpath){
        $yearOfPublish =iterator_to_array($xpath->evaluate("//div[@class='file-right']//div[@data-id=$bookId]/span[@class='fi-year ']")); 
        if (empty($yearOfPublish)) {
            return '';
         } else {
            $yearOfPublish = $yearOfPublish[0]->textContent.PHP_EOL;
            return $yearOfPublish;
         }
       
        
    }
     function getBookSIze($bookId, $xpath){
        $bookSIze = iterator_to_array($xpath->evaluate("//div[@class='file-right']//div[@data-id=$bookId]/span[@class='fi-size hidemobile']")); 
        if (empty($bookSIze)) {
            return '';
         } else {
            $bookSIze = $bookSIze[0]->textContent.PHP_EOL;
        return  $bookSIze;
         }
       
        
    }
     function getBookNumberOfDownloads($bookId, $xpath){
        $numberOfDownloads =iterator_to_array($xpath->evaluate("//div[@class='file-right']//div[@data-id=$bookId]/span[@class='fi-hit']")); 
        if (empty($numberOfDownloads)) {
            return '';
         } else {
            $numberOfDownloads = $numberOfDownloads[0]->textContent.PHP_EOL;
            return   $numberOfDownloads;
         }
        
    }
    
    function checkIfNew($bookId, $xpath): string{
        $bookIfNew = iterator_to_array($xpath->evaluate("//div[@class='file-right']//div[@data-id=$bookId]/span[@class='new']")); 
        if (empty($bookIfNew)) {
            return "";
        } else {
            return "New!";
        }
        
    }

    function getBookInfoLink($bookId, $xpath)
    {
        $bookLinkE = $xpath->evaluate("//div[@class='file-left']//a[@data-id=$bookId]/@href[normalize-space()]"); 
        $bookLinkE = (string) $bookLinkE[0]->textContent.PHP_EOL;
        $bookLinkE = trim($bookLinkE);
        $bookLinkEFull = "https://www.pdfdrive.com$bookLinkE"; 
        return $bookLinkEFull;
    }
//     function getBookLink($bookId, $xpath){

//         $client = new \GuzzleHttp\Client();
//         $xmlDoc = new DOMDocument();
//         $bookLinkE = $xpath->evaluate("//div[@class='file-left']//a[@data-id=$bookId]/@href[normalize-space()]"); 
//         $bookLinkE = (string) $bookLinkE[0]->textContent.PHP_EOL;
//         $bookLinkE = trim($bookLinkE);
//         $bookLinkEFull = "https://www.pdfdrive.com$bookLinkE"; 
//         $curl = curl_init($bookLinkEFull);
//         curl_setopt($curl, CURLOPT_URL, $bookLinkEFull);
//         curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
//         $response1 = (string) curl_exec($curl);
//         curl_close($curl);
//         //echo $response1;
//         libxml_use_internal_errors(true);
//         $xmlDoc->loadHTML($response1);
//         $xpathE = new DOMXPath($xmlDoc);
//         $bookLinkD = $xpathE->evaluate("//div[@class='ebook-buttons']/span[@id='download-button']/a/@href"); 
//         $bookLinkD = $bookLinkD[0]->textContent.PHP_EOL;
//         $bookLinkD = trim($bookLinkD);
//         $bookLinkDFull = "https://www.pdfdrive.com$bookLinkD"; 
//         $serverUrl = 'http://localhost:9515';
//         $driver = RemoteWebDriver::create($serverUrl, DesiredCapabilities::chrome());
//         $driver->get($bookLinkDFull);
//         $element = $driver->wait(30, 500)->until(
//                 function () use ($driver) {
//                     $element = $driver->findElement(WebDriverBy::XPath("//a[normalize-space()='Download ( PDF )'] | //a[normalize-space()='Go to PDF']"));
//                     $element = $element->getAttribute('href');
//                     return $element;
//                 }
//             );
//         $bookLinkFull = ($element[0] == '/') ? "https://www.pdfdrive.com$element" : $element ;
//         return  $bookLinkFull;
       
//         //function getPdf()
//    // {
//    // $client = new \GuzzleHttp\Client();
//    // header('Content-type: application/pdf');
//    // $response = $client->get('https://www.pdfdrive.com/download.pdf?id=58864799&h=c55ee8a467a370dd11fcf9dcec21f426&u=cache&ext=pdf'); 
//     //$result = (string) $response->getBody(); 
//    // echo $result;
//    // exit();
        
//     }
}