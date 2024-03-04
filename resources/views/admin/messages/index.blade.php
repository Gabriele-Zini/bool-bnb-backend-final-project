@extends('layouts.app')

@section('content')
    <h4 class="text-center my-4">Messages for {{ $apartment->title }}</h4>

    @if (session('message'))
        <div class="alert alert-success col-12 col-md-5 col-lg-4 m-auto my-3">
            {{ session('message') }}
        </div>
    @endif

    <div class="container">
        @if ($messages->isEmpty())
            <div class="card py-4 ms_bg-card">
                <p class="text-center fw-bold mt-4">There are no messages for this apartment</p>
            </div>
        @else
            <div class="card p-5 ms_bg-card">
                @foreach ($messages as $message)
                    <div class="card ms_bg-small-card p-3 d-flex justify-content-center gap-3 align-items-center">
                        <div>
                            <span class="fw-bold">{{ $message->name }} {{ $message->lastname }}:</span>
                            <span>{{ Str::limit($message->message_content, 100) }}</span>
                        </div>
                        <div>
                            <span class="fw-bold">Send at:</span>
                            <span>{{ $message->created_at }}</span>
                        </div>
                        <div class="d-flex gap-5 align-items-center">
                            @if ($message->readed)
                                <span class="badge bg-warning">Readed</span>
                            @else
                                <span class="badge bg-success">To read</span>
                            @endif
                            <a href="{{ route('messages.show', ['message' => $message->id]) }}" class="my-btn-blue">Read</a>
                            <form class="d-inline" action="{{ route('messages.destroy', ['message' => $message->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="my-btn-delete"
                                    data-title="{{ $message->email }}">Delete</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

@endsection
