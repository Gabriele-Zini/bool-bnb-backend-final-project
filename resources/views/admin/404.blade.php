@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-center align-items-center" style="min-height: 500px">
        


            <div class="card ms_bg-small-card w-75v d-flex justify-content-center align-items-center p-5 shadow"
                style="height:400px">

                <div class="logo-back text-center me-2 mb-2 d-flex">
                    <img style="width: 50px; height: 50px;" src="{{ URL::asset('/img/b.png') }}">


                </div>

            
                <div class="text-center">
                    <h3>Ooopsss! Something went wrong...</h3>

                 <h4 class="mt-2">
                    Error 404: page not found
                   </h4>

                </div>

            
            </div>
        
    </div>
</div>
@endsection