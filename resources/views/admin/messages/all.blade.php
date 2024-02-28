@extends('layouts.app')
@section('content')
<h1>All messages</h1>
<ul>
        @foreach ($allMessages as $message)
            {{$message}}
        @endforeach
</ul>
    @endsection