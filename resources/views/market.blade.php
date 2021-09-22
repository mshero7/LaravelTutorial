@extends('layout')

@section('title')
    MARKET
@endsection

<div>
<form method="POST" action="/market">
    @csrf
    <select name="type">
        <option value="fruit">과일</option>
        <option value="vegetable">채소</option>
    </select>
    <input type="text" name="names">
    <button type="submit" class="btn btn-block btn-primary"> 조회 </button>
</form>
</div>

{{ isset($price) ? "$price" : '' }}