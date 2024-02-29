@extends('layouts.app')
@section('content')
    @if (session('message'))
        <div class="alert alert-success col-12 col-md-5 col-lg-4 m-auto my-3">
            {{ session('message') }}
        </div>
    @endif
    <div class="container-fluid">
        <div class="row justify-content-center mt-4">
            <div class="col-12 col-md-10 col-lg-9">
                @foreach ($a as $apartment)
                    {{-- @if ($apartment->count() === 0)
                        <div class="alert alert-light mb-5" role="alert">
                            <h4 class="text-center my-4">There are no messages for: <strong>{{ $apartment->title }}</strong></h4>
                        </div>
                    @endif --}}

                    @if ($apartment->count() > 0)
                        <div class="alert alert-info" role="alert">
                            <h4 class="text-center my-4">Messages for: <strong>{{ $apartment->title }}</strong></h4>
                        </div>

                        <table class="table mb-5">
                            <thead>
                                <tr>
                                    <th scope="col">From</th>
                                    <th scope="col">Message</th>
                                    <th scope="col">Status</th>
                                    <th scope="col">Options</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($apartment as $apartment_info)
                                    <tr>
                                        <th scope="row">{{ $apartment_info->name }} {{ $apartment_info->lastnamename }}
                                        </th>
                                        <td>{{ $apartment_info->message_content }}</td>
                                        <td>
                                            @if ($apartment_info->readed)
                                            <span class="badge text-bg-secondary"><i class="fa-solid fa-envelope-open"></i></span>
                                            @else
                                                <span class="badge text-bg-primary"><i class="fa-solid fa-envelope"></i></span>
                                            @endif
                                        </td>
                                        <td class="d-flex justify-content-center gap-2 border-0">
                                            <a href="{{ route('messages.show', ['message' => $apartment_info->id]) }}"
                                                class="btn btn-success"><i class="fa-regular fa-file-lines"></i></a>
                                            <form class="d-inline"
                                                action="{{ route('messages.destroy', ['message' => $apartment_info->id]) }}"
                                                method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger"
                                                    data-title={{ $apartment_info->email }}><i class="fa-solid fa-trash-can"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
