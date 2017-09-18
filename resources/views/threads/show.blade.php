@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <a href="#">{{ $thread->creator->name }}</a> posted:{{ $thread->title }}
                </div>
                <div class="panel-body">
                    {{ $thread->body }}
                </div>
            </div>
        </div>
    </div>
    @foreach ($thread->replies as $reply)
        @include ('threads.reply')
    @endforeach
    @auth
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <form action="{{ $thread->path() }}/replies" method="POST" class="form">
                {{ csrf_field() }}
                <div class="form-group">
                    <textarea name="body" id="body" cols="30" rows="5" class="form-control" placeholder="Add your thought"></textarea>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-default">Post</button>
                </div>
            </form>
        </div>
    </div>
    @endauth
    @guest
        <p class="text-center">Please <a href="{{ route('login') }}">Log in</a> to participate in the forum</p>
    @endguest
</div>
@endsection
