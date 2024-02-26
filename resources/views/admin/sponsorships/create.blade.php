@extends('layouts.app')

@section('content')

    <h2 class="text-center">Activate a new sponsorization for {{$apartment->title}}</h2>
<div class="container w-50">
    <form action="{{route('sponsorships.store')}}" method="POST">
        @csrf
        {{-- Sponsorization type --}}
        <div class="text-center mt-2">
            <label for="sponsorship">Type:</label>
            <select class="form-control w-50 text-center mx-auto " name="sponsorship_id" id="sponsorship" required>
                <option value="">Select a sponsorization type</option>
                @foreach ($sponsorship as $sponsor)
                <option value="{{$sponsor->id}}" required>{{@ucwords($sponsor->name)}} - € {{$sponsor->price}}</option>
                @endforeach
            </select>
        </div>
        
        <div class="text-center mt-2">
           <label for="startDate">Start date:</label>
            <input type="date" class="form-control w-50 mx-auto mt-2" name="start_date" id="startDate" min="{{date('Y-m-d')}}" required> 
        </div>
        <div class="text-center mt-2">
            <label for="startTime">Start time:</label>
             <input type="time" class="form-control w-25 mx-auto mt-2" name="start_time" id="startTime" required> 
         </div>

         <div class="d-none">
             <input type="number" name="apartment_id" value="{{$apartment->id}}"> 
         </div>
        <div class="text-center mt-2">
            <button type="submit" class="btn btn-success">Buy</button>
         </div>
        

    </form>
</div>
    

    
@endsection