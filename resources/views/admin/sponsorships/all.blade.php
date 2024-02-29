@extends('layouts.app')

@section('content')
    <h1>All the sponsorships by apartment</h1>

    {{-- @dd($groupedResult) --}}

    @foreach ($groupedResult as $key => $result)
        <ul>
            <li>
                <h4>{{ $key }}</h4>
            </li>
            @foreach ($result as $item)
                <li>{{ $item->name }}</li>
                <li>{{ $item->start_date }}</li>
                <li>{{ $item->expiration_date }}</li>
            @endforeach
        </ul>
    @endforeach
    {{-- @foreach ($a as $sponsorizations)
        @if ($sponsorizations->count() > 0)
            @dump($sponsorizations->title)
            @foreach ($sponsorizations as $sponsorization)
                @foreach ($sponsorships as $sponsorship)
                    @if ($sponsorship->id === $sponsorization->sponsorship_id)
                        @dump($sponsorship->name)
                        @endif
                        @endforeach
                        @dump($sponsorization)
            @endforeach
        @endif
    @endforeach --}}
@endsection
