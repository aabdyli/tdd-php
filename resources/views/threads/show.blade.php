@extends('layouts.app')

@section('content')
<thread-view :initial-reply-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <img src="{{ $thread->creator->avatar() }}" alt="" class="mr-1" width="23" height="25">
                            <span class="flex">
                                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:{{ $thread->title }}
                            </span>

                            @can ('update', $thread)
                            <form method="POST" action="{{ $thread->path() }}">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-link">Delete</button>
                            </form>
                            @endcan
                        </div>
                    </div>
                    <div class="panel-body">
                        {{ $thread->body }}
                    </div>
                </div>
                <replies
                    @removed="repliesCount--"
                    @added="repliesCount++"></replies>
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="#">{{ $thread->creator->name }}</a>, and currently
                        has <span v-text="repliesCount"></span>.
                        <subscribe-button :active="@json($thread->isSubscribedTo)"></subscribe-button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection

@section('styles')
<link rel="stylesheet" href="/css/vendor/jquery.atwho.css">
@endsection