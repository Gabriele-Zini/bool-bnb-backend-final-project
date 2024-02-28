@extends('layouts.app')
@section('content')
<h1>All messages</h1>
<ul>
        @foreach ($allMessages as $message)
            <li>{{$message['apartment']}}</li>
            <li>{{$message['name']}}</li>
            <li>{{$message['lastname']}}</li>
            <li>{{$message['email']}}</li>
            <li>{{$message['message_content']}}</li>
        @endforeach
</ul>
    @endsection