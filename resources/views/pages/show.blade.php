@extends('layouts.app')

@section('content')
<div class="container margin_80_55">
    <div class="main_title_2">
        <span><em></em></span>
        <h2>{{ $page->title }}</h2>
    </div>
    {{ $page->content }}
</div>
@endsection