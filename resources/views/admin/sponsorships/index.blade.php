@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card my-5 px-3 pb-5 ms_bg-card shadow">
            <h4 class="text-center my-5 fs-3">Sponsorships for {{ $apartment->title }}</h4>
            @if (session('message'))
                <div class="alert text-center alert-success col-12 col-md-5 col-lg-4 m-auto my-3">
                    {{ session('message') }}
                </div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger text-center col-12 col-md-5 col-lg-4 m-auto my-3">
                    {{ session('error') }}
                </div>
            @endif
            <div class="container">
                @foreach ($sponsorships as $sponsor)
                    <div class="card mb-3 ms_bg-small-card shadow">
                        <div class="card-body">
                            <h5 class="card-title">Type:
                                @switch($sponsor->sponsorship_id)
                                    @case($typeSponsorship[0]->id)
                                        {{ ucwords($typeSponsorship[0]->name) }}
                                    @break

                                    @case($typeSponsorship[1]->id)
                                        {{ ucwords($typeSponsorship[1]->name) }}
                                    @break

                                    @case($typeSponsorship[2]->id)
                                        {{ ucwords($typeSponsorship[2]->name) }}
                                    @break

                                    @default
                                        Not sponsored yet
                                @endswitch
                            </h5>
                            <p class="card-text">From: {{ $sponsor->start_date }}</p>
                            <p class="card-text">To: {{ $sponsor->expiration_date }}</p>
                            <span
                                class="badge
                        @if (round(strtotime($sponsor->expiration_date) - time()) < 0) bg-danger">Expired
                        @elseif (round(strtotime($sponsor->expiration_date) - time()) > 0)
                            @if (round(strtotime($sponsor->start_date) - time()) > 0)
                                bg-success">Not yet started
                            @else
                                bg-warning">Started @endif
                        @endif
                    </span>
                    <form class="d-inline"
                                action="{{ route('sponsorships.destroy', ['sponsorship' => $sponsor->id]) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                        </div>
                    </div>
                @endforeach
                <div class="d-flex gap-3">
                    <a href="{{ route('sponsorships.create', ['apartment' => $apartment->slug]) }}"
                        class="btn btn-warning">Activate a new sponsorship for this apartment</a>
                </div>
            </div>
        </div>
    </div>
@endsection
