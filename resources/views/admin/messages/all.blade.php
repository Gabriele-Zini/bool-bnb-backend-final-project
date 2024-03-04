@extends('layouts.app')

@section('content')

    <div class="container-fluid">
        @if (session('message'))
            <div class="alert alert-success col-12 col-md-5 col-lg-4 m-auto my-3">
                {{ session('message') }}
            </div>
        @endif

        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-10">
                @foreach ($a as $apartment)
                    @if ($apartment->count() > 0)
                        <div class="card mt-4 px-4 pb-5 ms_bg-card shadow">
                            <h4 class="text-center my-4">Messages for: <strong>{{ $apartment->title }}</strong></h4>

                            @foreach ($apartment as $message)
                                <div class="card ms_bg-small-card  mb-4">
                                    <div class="card-body">
                                        <h4>From: {{ $message->name }} {{ $message->lastname }}</h4>
                                        <p class="card-text mb-0"><span class="fw-bold">Message:</span> {{ $message->message_content }}</p>
                                        <p class="card-text mt-0"><span class="fw-bold">Send at:</span> {{ $message->created_at }}</p>
                                        <span class="badge {{ $message->readed ? 'bg-secondary' : 'bg-primary' }}">
                                            <i class="fas fa-envelope{{ $message->readed ? '-open' : '' }}"></i>
                                        </span>
                                        <div class="mt-2">
                                            <a href="{{ route('messages.show', ['message' => $message->id]) }}"
                                                class="my-btn-blue"><i class="fas fa-file-lines"></i> View</a>
                                            <form class="d-inline"
                                                action="{{ route('messages.destroy', ['message' => $message->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="my-btn-delete"
                                                    data-title="{{ $message->email }}"><i class="fas fa-trash-can"></i>
                                                    Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
