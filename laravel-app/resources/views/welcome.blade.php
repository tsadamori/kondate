@extends('layouts.app')

@section('content')
<div class="center">
    <div class="text-center mt-5">
        <h1 class="h2 mb-3">This is the 献立アプリ</h1>
        <p>〜自分の献立を登録して、日々の料理を楽しく〜</p>
        {!! link_to_route('signup.get', 'Sign up now!', [], ['class' => 'btn btn-sm btn-dark']) !!}
        {!! link_to_route('login.get', 'Log in', [], ['class' => 'btn btn-sm btn-dark']) !!}
    </div>
</div>
@endsection