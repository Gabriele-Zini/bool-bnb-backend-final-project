@extends('layouts.app')
@section('content')
    <h1>All messages</h1>
    <ul class="list-unstyled">
        {{-- @dd($a) --}}
        @foreach ($a as $apartment)
            {{-- @dd($apartment->items) --}}
            <li class="m-2">
                <h4>{{ $apartment->title }}</h4>
            </li>
            @foreach ($apartment as $apartment_info)
                <li>
                    {{ $apartment_info->name }} {{ $apartment_info->lastname }}
                </li>
                <li>
                    {{ $apartment_info->email }}
                </li>
                <li>
                    {{ $apartment_info->message_content }}
                </li>
            @endforeach

        @endforeach
    </ul>
@endsection
