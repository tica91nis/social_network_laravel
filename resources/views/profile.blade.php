@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$user->name}}</div>

                <div class="card-body">
                   @foreach($posts as $objava)
                        <h5>{{$objava->user->name}} ({{ $objava->user->email}})</h5>
                        @if(file_exists ( 'images/' . $objava->user->id . '.jpeg'))
                        <img src="../images/{{ $objava->user->id }}.jpeg" width="25px" height="25px">
                        @else
                        <img src="../images/default.jpeg" width="25px" height="25px">
                        @endif
                        <p>{{$objava->content}}</p>
                        <small>{{$objava->created_at->format("d.m.Y h:i:s")}}</small>
                        <small>{{$objava->created_at->diffForHumans()}}</small>
                        <hr>
                   @endforeach

                   @foreach($events as $event)
                        <h5><a href="event/{id}">{{$event->name}}</a></h5>
                        <hr>
                   @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
