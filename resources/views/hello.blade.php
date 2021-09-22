@extends('layout')

@section('title')
    MARKET
@endsection

@section('contents')
    @foreach($data as $d)
        <li> {{ $d }} </li>
    @endforeach
@endsection