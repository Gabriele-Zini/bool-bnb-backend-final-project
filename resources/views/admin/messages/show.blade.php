@extends('layouts.app')

@section('content')
    <div class="container border rounded p-5 mt-5 ms_bg-card">
        <h4 class="text-center fs-2 mb-3">Message from {{ $message->name }} {{ $message->lastname }}</h4>
        <p class="mt-2 text-center"><strong>Email address:</strong> {{ $message->email }} </p>
        <p class="m-auto mt-4 w-75 border rounded p-5 overflow-auto ms_bg-small-card" style="height: 100px;">
            {{ $message->message_content }}
        </p>
        <div class="d-flex gap-2 justify-content-center pt-2">
            <a href="{{ url()->previous() }}" class="my-btn-blue ">Return to messages
            </a>
            <form class="d-inline" action="{{ route('messages.destroy', ['message' => $message->id]) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="my-btn-delete" data-title="{{ $message->email }}"><i
                        class="fas fa-trash-can"></i>
                    Delete</button>
            </form>
        </div>
    </div>
@endsection
