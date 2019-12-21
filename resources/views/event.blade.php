@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{$event->name}}</div>
                        <h5><a href="event/{id}">{{$event->name}}</a></h5>
                        <hr>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection