<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;
use Illuminate\Http\Request;

use MarketHelper;

class MarketController extends Controller
{

    public function index(Request $request) {
        if ($request->isMethod('POST')) {
            return view('market',[
                'name' => $request->get('name'),
                'price' => $request->get('price')
            ]);
        } else if ($request->isMethod('GET')) {
            return view('market');
        }
    }

}