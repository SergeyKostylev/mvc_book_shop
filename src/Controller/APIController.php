<?php

namespace Controller;

use Framework\BaseController;
use Framework\Request;
use GuzzleHttp\Client;

class APIController extends BaseController
{
    public function indexAction(Request $request)
    {
        header('Content-type: application/json');
        return json_encode(['a' => 1]);
    }

    public function guzzleAction(Request $request)
    {
        $client = new Client();
        $res=$client
            ->request('GET', 'https://bank.gov.ua/NBUStatService/v1/statdirectory/exchange?json')
            ->getBody()
        ;
        $rates= json_decode($res,true);

        return $this->render('guzzle.html.twig',
            ['rates' => $rates]
        );
    }
}