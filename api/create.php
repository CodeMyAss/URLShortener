<?php

namespace urlshortener\api;
use urlshortener\data as data;
use \urlshortener\etc\Router as Router;

$params = array();
if(!empty($_GET['url'])) {
    $url = data\Url::constructUrl($_GET['url']);
    if($url==null) {
        unset($_GET['url']);
        $params['result'] = "invalidurl";
    } else {
        if(!empty($_GET['code'])) {
            $params['code'] = data\ShortenedUrl::constructFromUrl($url,$_GET['code'])->getCode();
        } else {
            $params['code'] = data\ShortenedUrl::constructFromUrl($url)->getCode();
        }
        if(empty($params['code'])) {
            $params['result'] = "undefinederror";
        } else {
            $params['result'] = "success";
            $params['url'] = $url->getUrl();
        }
    }
} else {
    $params['result'] = "emptyurl";
}
if(Router::getInstance()->isApiCall()) {
    header('Content-Type: application/json');
    echo json_encode($params);
}
