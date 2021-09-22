<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

use MarketHelper;

class AuthMarketApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */


    public function handle($request, Closure $next)
    {
        $token = MarketHelper::getApiToken($request->type);
        $MarketSales = MarketHelper::getApiResponse($request->type, 'list', null, array('Authorization' => $token));

        /* 에러 처리 */ 
        if (!$token || !in_array($request->names, $MarketSales)) {
            return response('400 error', 400);
        }

        $result = MarketHelper::getApiResponse(
            $request->type,
            'list',
            array('name' => $request->names),
            array('Authorization' => $token),
        );
        
        $request->merge([
            'name' => $result['name'],
            'price' => $result['price'],
        ]);

        return $next($request);
    }

}