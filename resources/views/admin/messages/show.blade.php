@extends('layouts.app')

@section('content')

<div class="container border rounded p-5 mt-5 bg-light">
   <h1 class="text-center">Message from {{$message->name}} {{$message->lastname}}</h1>
   <p class="mt-2 text-center"><strong>Email address:</strong> {{$message->email}} </p>
   <p class="m-auto mt-4 w-75 border rounded p-3">
    {{$message->message_content}}
   </p>
   <div class="d-flex gap-2 justify-content-center pt-2">
   <a href="{{ route('messages.index', ['apartment' => $apartment->slug]) }}"
      class="my-btn-blue ">Return to messages
  </a>
  <form class="d-flex"
  action="{{ route('messages.destroy', ['message' => $message->id]) }}"
  method="POST">
  @csrf
  @method('DELETE')
  <a type="submit" class="my-btn-delete">Delete</a>
</form>
</div>
</div>


@endsection
