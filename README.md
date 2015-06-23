# mojepanstwo-api-php
service API from https://mojepanstwo.pl/api

Install
=====================
~~~ go
„require”: {

   "dawid-daweb/mojepanstwo-api-php": "dev-master"
}
~~~
Require
=====================
PHP >= 5.4

Example
=====================
~~~ go
$mojePanstwoProvider = new MojePanstwoProvider;

$KRSPodmioty = $mojePanstwoProvider->search(MojePanstwoProvider::KRS_PODMIOTY);

$KRSResult = $KRSPodmioty->page(10)
        ->conditons([
            'adres_miejscowosc' => 'Bechcice-kolonia',
            'liczba_wspolnikow' => 1
        ])
        ->limit(5) 
        ->getResult();

if ($KRSResult) {

   if($KRSPodmioty->countResult()) { // check count result
      $KRSPodmioty->toJson(); // return json
      $KRSPodmioty->toArray(); // return array
      $KRSPodmioty->toObject(); // return object
   }
   
} else {
    $KRSPodmioty->responseCode; // what happened?, use this for service error
}

~~~
