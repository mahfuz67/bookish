<?php

require '../vendor/autoload.php';
use Facebook\WebDriver\Remote\DesiredCapabilities;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\WebDriverBy;
use Facebook\WebDriver\WebDriverExpectedCondition;

class BookObjectGetterInfo {

    //similar books

    function getBookImageSuggested($bookId, $xpath){
        $image = $xpath->evaluate("//div[@class='file-left']//a[@data-id=$bookId]/img/@src"); 
        $image = $image[0]->textContent.PHP_EOL;
        return  $image;
        
    }
     function getBookTitleSuggested($bookId, $xpath){
        $bookTitle = $xpath->evaluate("//div[@class='file-right']//div[@data-id=$bookId]/preceding-sibling::a/h2"); 
        $bookTitle = $bookTitle[0]->textContent.PHP_EOL;
        return  $bookTitle;
        
    }
     function getBookNumberOfPagesSuggested($bookId, $xpath){
        $pages = iterator_to_array($xpath->evaluate("//div[@class='file-right']//div[@data-id=$bookId]/span[@class='fi-pagecount ']")); 
        if (empty($pages)) {
           return '';
        } else {
            $pages = $pages[0]->textContent.PHP_EOL;
            return  $pages;
        }
             
    }
     function getBookYearOfPublishSuggested($bookId, $xpath){
        $yearOfPublish =iterator_to_array($xpath->evaluate("//div[@class='file-right']//div[@data-id=$bookId]/span[@class='fi-year ']")); 
        if (empty($yearOfPublish)) {
            return '';
         } else {
            $yearOfPublish = $yearOfPublish[0]->textContent.PHP_EOL;
            return $yearOfPublish;
         }
       
        
    }
     function getBookSIzeSuggested($bookId, $xpath){
        $bookSIze = iterator_to_array($xpath->evaluate("//div[@class='file-right']//div[@data-id=$bookId]/span[@class='fi-size hidemobile']")); 
        if (empty($bookSIze)) {
            return '';
         } else {
            $bookSIze = $bookSIze[0]->textContent.PHP_EOL;
        return  $bookSIze;
         }
       
        
    }
     function getBookNumberOfDownloadsSuggested($bookId, $xpath){
        $numberOfDownloads =iterator_to_array($xpath->evaluate("//div[@class='file-right']//div[@data-id=$bookId]/span[@class='fi-hit']")); 
        if (empty($numberOfDownloads)) {
            return '';
         } else {
            $numberOfDownloads = $numberOfDownloads[0]->textContent.PHP_EOL;
            return   $numberOfDownloads;
         }
        
    }
    function checkIfNewSuggested($bookId, $xpath): string{
        $bookIfNew = iterator_to_array($xpath->evaluate("//div[@class='file-right']//div[@data-id=$bookId]/span[@class='new']")); 
        if (empty($bookIfNew)) {
            return "";
        } else {
            return "New!";
        }
        
    }

    function getBookInfoLinkSuggested($bookId, $xpath)
    {
        $bookLinkE = $xpath->evaluate("//div[@class='file-left']//a[@data-id=$bookId]/@href[normalize-space()]"); 
        $bookLinkE = (string) $bookLinkE[0]->textContent.PHP_EOL;
        $bookLinkE = trim($bookLinkE);
        $bookLinkEFull = "https://www.pdfdrive.com$bookLinkE"; 
        return $bookLinkEFull;
    }

      //end similar books

    function getBookAuthor($xpath){
            $bookAuthor = iterator_to_array($xpath->evaluate("//div[@class='ebook-right']//div[@class='ebook-author']//span")); 
            if (empty($bookAuthor)) {
                return '';
             } else {
                $bookAuthor =  $bookAuthor[0]->textContent.PHP_EOL;
            return  $bookAuthor;
             }

            
        }


}