@extends('layouts.app')

@section('content')
    {{-- @dd($groupedResult) --}}
    <div class="container w-100 mt-5">
        @foreach ($groupedResult as $key => $result)
            <div class="">
                <div class="alert ms_bg-color-sponsorships" role="alert">
                    <h4 class="text-center my-4 text-white"><strong>{{ $key }}</strong></h4>
                </div>
                <table class="table col-12 col-md-10 col-lg-8 mb-5">
                    <thead>
                        <tr>
                            <th scope="col">Sponsorship</th>
                            <th scope="col">Status</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Expiration Date</th>
                            <th scope="col"><a class="btn btn-warning"
                                    href="{{ route('sponsorships.index', ['apartment' => $result[0]->slug]) }}">purchase</a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($result as $item)
                            <tr>
                                <td>{{ ucfirst($item->name) }}</td>
                                <td>

                                    @if (round((strtotime($item->expiration_date) - time())) < 0)
                                        <span class="badge bg-danger">Expired</span>
                                    @elseif (round((strtotime($item->expiration_date) - time())) > 0)
                                        @if (round((strtotime($item->start_date) - time())) > 0)
                                            <span class="badge bg-success">Not yet started </span>
                                        @else
                                            <span class="badge bg-warning">Started</span>
                                        @endif
                                    @endif
                                </td>
                                <td>{{ date('d/m/Y', strtotime($item->start_date)) }}</td>
                                <td>{{ date('d/m/Y', strtotime($item->expiration_date)) }}</td>
                                <td></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>
@endsection
