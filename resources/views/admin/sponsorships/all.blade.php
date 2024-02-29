@extends('layouts.app')

@section('content')
    <h3 class="text-center my-5">All the sponsorships by apartment</h3>

    {{--  @dd($groupedResult) --}}
    <div class="container w-100">
        @foreach ($groupedResult as $key => $result)
            <div class="">
                <div class="alert ms_bg-color-sponsorships" role="alert">
                    <h4 class="text-center my-4 text-white"><strong>{{ $key }}</strong></h4>
                </div>
                <table class="table col-12 col-md-10 col-lg-8 mb-5">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Sponsorship</th>
                            <th scope="col">Start Date</th>
                            <th scope="col">Expiration Date</th>
                            <th scope="col">Purchase</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php $count = 1 @endphp
                        @foreach ($result as $item)
                            <tr>
                                <th scope="row">{{ $count }}</th>
                                <td>{{ ucfirst($item->name) }}</td>
                                <td>{{ date('d/m/Y', strtotime($item->start_date)) }}</td>
                                <td>{{ date('d/m/Y', strtotime($item->expiration_date)) }}</td>
                                <td><a class="btn btn-warning" href="{{ route('sponsorships.index', ['apartment'=>$item->slug])}}">purchase</a></td>
                            </tr>
                            @php $count++ @endphp <!-- Incrementa il contatore -->
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endforeach
    </div>

@endsection
