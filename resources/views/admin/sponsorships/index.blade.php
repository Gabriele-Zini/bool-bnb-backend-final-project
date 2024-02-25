@extends('layouts.app')

@section('content')
    <h1 class="text-center">Sponsorships for {{ $apartment->title }}</h1>
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
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Type</th>
                    <th scope="col">From</th>
                    <th scope="col">To</th>
                    <th scope="col">Status</th>
                    <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sponsorships as $sponsor)
                    <tr>
                        <td>
                            @switch($sponsor->sponsorship_id)
                                @case($typeSponsorship[0]->id)
                                    {{ @ucwords($typeSponsorship[0]->name) }}
                                @break

                                @case($typeSponsorship[1]->id)
                                    {{ @ucwords($typeSponsorship[1]->name) }}
                                @break

                                @case($typeSponsorship[2]->id)
                                    {{ @ucwords($typeSponsorship[2]->name) }}
                                @break

                                @default
                                    Not sponsorizated yet
                            @endswitch
                            @if ($sponsor->sponsorship_id == $typeSponsorship[0]->id)
                                {{ $typeSponsorship[0]->id }}
                            @endif
                        </td>
                        <td>
                            {{ $sponsor->start_date }}
                        </td>
                        <td>
                            {{ $sponsor->expiration_date }}
                        </td>
                        <td>

                            @if (round((strtotime($sponsor->expiration_date) - time()) / 3600) < 0)
                                <span class="badge bg-danger">Expired</span>
                            @elseif (round((strtotime($sponsor->expiration_date) - time()) / 3600) > 0)
                                @if (round((strtotime($sponsor->start_date) - time()) / 3600) > 0)
                                    <span class="badge bg-success">Not yet started </span>
                                @else
                                    <span class="badge bg-warning">Started</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            <form class="d-inline"
                            action="{{ route('sponsorships.destroy', ['sponsorship' => $sponsor->id]) }}"
                            method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        </td>

                    </tr>
                @endforeach
            </tbody>
        </table>

        <a href="{{ route('sponsorships.create', ['apartment' => $apartment->slug]) }}" class="btn btn-warning">Activate a
            new sponsorship for this apartment </a>


    </div>
@endsection
