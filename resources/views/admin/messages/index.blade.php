@extends('layouts.app')

@section('content')
    <h1 class="text-center">Messages for {{ $apartment->title }}</h1>
    @if (session('message'))
    <div class="alert alert-success col-12 col-md-5 col-lg-4 m-auto my-3">
        {{ session('message') }}
    </div>
@endif
    <div class="container">
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">From</th>
                    <th scope="col">Message</th>
                    <th scope="col">Status</th>
                    <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
                @foreach ($messages as $message)
                    <tr>
                        <th scope="row">{{ $message->name }} {{ $message->lastname }}</th>
                        <td>{{ $message->message_content }}</td>
                        <td>
                            @if ($message->readed)
                                <span class="badge bg-warning">Readed</span>
                            @else
                                <span class="badge bg-success">To read</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('messages.show', ['message' => $message->id]) }}"
                                class="btn btn-success">Read</a>
                                <form class="d-inline"
                                    action="{{ route('messages.destroy', ['message' => $message->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger"
                                        data-title={{ $message->email }}>Delete</button>
                                </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection