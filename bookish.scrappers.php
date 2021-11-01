<?php
declare(strict_types=1);

class BookishScrapper {

public function  bookishSearchScrapper(string $query ): array{
    $client = new \GuzzleHttp\Client();
    $response = $client->get('https://www.pdfdrive.com/search?q='.$query.'&pagecount=&pubyear=&searchin=&em=');  //$client->request('GET', 'https://www.pdfdrive.com/search?q='.$query.'&searchin=eng');
    $resString = (string) $response->getBody();
    libxml_use_internal_errors(true);
    $xmlDoc = new DOMDocument();
    $xmlDoc->loadHTML($resString);
    $xpath = new DOMXPath($xmlDoc);
    $images = $xpath->evaluate('//div[@class="file-left"]//a/img/@src');
    var_dump($images);
    return $images;
}

}