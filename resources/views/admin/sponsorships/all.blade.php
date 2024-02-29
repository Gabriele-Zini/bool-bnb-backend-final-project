@extends('layouts.app')

@section('content')
    <h1>All the sponsorships by apartment</h1>

    @dd($a, $sponsorships)
    @foreach ($a as $sponsorizations)
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
    @endforeach
@endsection
