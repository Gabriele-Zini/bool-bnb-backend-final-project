@extends('layouts.app')

@section('content')
    @if (session('message'))
        <div class="alert alert-success col-12 col-md-5 col-lg-4 mx-auto my-3">
            {{ session('message') }}
        </div>
    @endif
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-10 col-lg-9">
                @foreach ($a as $apartment)
                    @if ($apartment->count() > 0)
                        <div class="alert alert-info" role="alert">
                            <h4 class="text-center my-4">Messages for: <strong>{{ $apartment->title }}</strong></h4>
                        </div>

                        @foreach ($apartment as $message)
                            <div class="card mb-4">
                                <div class="card-body">
                                    <h5 class="card-title">From: {{ $message->name }} {{ $message->lastname }}</h5>
                                    <p class="card-text">Message: {{ $message->message_content }}</p>
                                    <span class="badge {{ $message->readed ? 'bg-secondary' : 'bg-primary' }}">
                                        <i class="fas fa-envelope{{ $message->readed ? '-open' : '' }}"></i>
                                    </span>
                                    <div class="mt-2">
                                        <a href="{{ route('messages.show', ['message' => $message->id]) }}" class="btn btn-primary"><i class="fas fa-file-lines"></i> View</a>
                                        <form class="d-inline" action="{{ route('messages.destroy', ['message' => $message->id]) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" data-title="{{ $message->email }}"><i class="fas fa-trash-can"></i> Delete</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
