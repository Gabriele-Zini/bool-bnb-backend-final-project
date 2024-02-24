@extends('layouts.app')

@section('content')
    <div class="container my-5">


        @foreach ($images as $image)
            @if ($image->cover_image)
                <h3 class="text-center title-link">Cover Image</h3>
                <div class="d-flex justify-content-center mt-3 mb-5">
                    <img src="{{ asset('storage/image_path/' . $image->image_path) }}" alt=""
                        class="rounded col-12 col-md-6 col-lg-5">
                </div>
            @endif
        @endforeach

        <h4 class="text-center title-link">Your Images</h4>
        <div class="d-flex justify-content-center flex-wrap gap-2">
            @foreach ($images as $image)
                @if (!$image->cover_image)
                    <div class="image-controller-container">
                        <img src="{{ asset('storage/image_path/' . $image->image_path) }}" alt=""
                            class="rounded ms_img-index">


                        <div class="popover">
                            <i class="fas fa-ellipsis-h popover-icon"></i>
                            <div class="popover-content d-none">

                                <form action="{{ route('images.update', ['image' => $image->id]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')
                                    <button type="submit">Set as cover image</button>
                                </form>
                                <form action="{{ route('images.destroy', ['image' => $image->id]) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit">Delete</button>
                                </form>
                            </div>
                        </div>


                    </div>
                @endif
            @endforeach

        </div>
    </div>
@endsection
