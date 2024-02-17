@extends('layouts.app')

@section('content')
    <h1>Lista appartamenti</h1>
    
    
    @foreach ($apartments as $apartment)
    <ul>
        <li>
            {{$apartment->title}}
        </li>
        <li>
            {{$apartment->city}}
        </li>
        <li>
            {{$apartment->street_name}}, {{ $apartment->street_number }}
        </li>
    </ul>
    @endforeach 
   
@endsection