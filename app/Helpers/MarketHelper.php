<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

class MarketHelper
{
    // 상점 내 외부 API URL
    private static function getApiUrl(){
        return array(
            'fruit' => array(
                'url' => 'http://fruit.api.postype.net',
                'token' => 'http://fruit.api.postype.net/token',
                'list' => 'http://fruit.api.postype.net/product',
            ),
            'vegetable' => array(
                'url' => 'http://vegetable.api.postype.net',
                'token' => 'http://vegetable.api.postype.net/token',
                'list' => 'http://vegetable.api.postype.net/item',
            )
        );
    }


    public static function getApiToken($type){
        /* json으로 반환되는 type */
        $byResponse = array(
            'fruit',
        );

        /* header로 반환되는 type */
        $byHeader = array(
            'vegetable',
        );

        $apiUrl = self::getApiUrl();
        $url = "{$apiUrl[$type]['token']}";

        if(in_array($type, $byResponse)){
            $response = json_decode(Http::get($url), TRUE);
        } else if(in_array($type, $byHeader)) {
            $response = self::response_header_proc(Http::get($url)->headers());
        }

        return $response['accessToken'];
    }


    public static function getApiResponse($type, $urlPath, $params = array(), $headers = array()){
        $apiUrl = self::getApiUrl();

        $requestUrl = "{$apiUrl[$type][$urlPath]}";

        $response = Http::withHeaders(
            $headers
        )->get($requestUrl, 
            $params
        )->json();

        return $response;
    }


    /* 헤더 속 쿠키 처리 */ 
    public static function response_header_proc($content){
        $result = array();

        foreach($content as $key => $val) {
            if($key == 'Set-Cookie'){
                $cookieOpt = preg_replace('/\s+/', '', $val[0]);
                
                preg_match('/^Authorization=[^;]*/', $cookieOpt, $match);

                list($k, $v) = explode('=', $match[0]);

                $result['accessToken'] = $v;
            }
        }

        return $result;
    }
}