@extends('layouts.app')

@section('content')
<h1 class="text-center">Message from {{$message->name}} {{$message->lastname}}</h1>

<div class="container">
   <p class="mt-2"><strong>Email address:</strong> {{$message->email}} </p>
   <p class="m-auto mt-4 w-75 border p-3">
    {{$message->message_content}}
   </p>
   <a href="{{ route('messages.index', ['apartment' => $apartment->slug]) }}"
      class="btn btn-warning mt-3">Return to messages
  </a>
  <form class="d-inline"
  action="{{ route('messages.destroy', ['message' => $message->id]) }}"
  method="POST">
  @csrf
  @method('DELETE')
  <button type="submit" class="btn btn-danger mt-3">Delete</button>
</form>
</div>


@endsection
