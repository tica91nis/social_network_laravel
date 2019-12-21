@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">

                    @if(session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success') }}
                        </div>
                        @elseif(session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error') }}
                        </div>
                    @endif

                    <form action="/home" method="post">
                    @csrf
                        <textarea name="content" rows="5" cols="30" class="form-control" 
                        placeholder="What's on your mind..">
                        </textarea>
                        <br>
                        <input type="submit" class="btn btn-primary" value="Post">
                    </form>
                </div>
                <hr>
                <div class="card-body">
                   @foreach($objave as $objava)
                        @if(file_exists ( 'images/' . $objava->user->id . '.jpeg'))
                        <img src="images/{{ $objava->user->id }}.jpeg" width="25px" height="25px">
                        @else
                        <img src="images/default.jpeg" width="25px" height="25px">
                        @endif
                        <h5><a href="user/{{$objava->user->id}}">{{$objava->user->name}} ({{ $objava->user->email}})</a></h5>
                        @if($objava->user->id == Auth::user()->id)
                        <p style='color: green'>{{$objava->content}}</p>
                        @else
                        <p style='color: blue'>{{$objava->content}}</p>
                        @endif
                        <small>{{$objava->created_at->format("d.m.Y h:i:s")}}</small>
                        <small>{{$objava->created_at->diffForHumans()}}</small>
                        <input type="submit" class="btn btn-primary" value="Delete" onclick="">
                        <hr>

                   @endforeach
                   @foreach($events as $event)
                        <h5><a href="event/{{$event->id}}">{{$event->name}}</a></h5>
                        <hr>
                   @endforeach
                </div>
            </div>
        </div>
        <div class="col-md-4">
        @if(count($others))
            <div class="card">
                <div class="card-header">
                    Suggestions
                </div>
                <div class="card-body">
                    @foreach ($others as $follow)
                    <h5><a href="user/{{$follow->id}}">{{$follow->name}}</a></h5>
                    <button class="btn btn-primary">Follow</button>
                    @endforeach
                </div>
            </div>
        @endif
            <br>
        @if(count($mutuals))
            <div class="card">
                <div class="card-header">
                    Mutual friends
                </div>
                <div class="card-body">
                    @foreach ($mutuals as $follow)
                    <h5><a href="user/{{$follow->id}}">{{$follow->name}}</a></h5>
                    <button class="btn btn-primary">Unfollow</button>
                    @endforeach
                </div>
            </div>
        @endif
            <br>
        @if(count($following))
            <div class="card">
                <div class="card-header">
                    Users I am following
                </div>
                <div class="card-body">
                    @foreach ($following as $follow)
                    <h5><a href="user/{{$follow->id}}">{{$follow->name}}</a></h5>
                    <button class="btn btn-primary">Unfollow</button>
                    @endforeach
                </div>
            </div>
            @endif
            <br>
            @if(count($followers))
            <div class="card">
                <div class="card-header">
                    My followers
                </div>
                <div class="card-body">
                    @foreach ($followers as $follow)
                    <h5><a href="user/{{$follow->id}}">{{$follow->name}}</a></h5>
                    <button class="btn btn-primary">Follow</button>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
