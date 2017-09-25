@extends('layouts.app')

@section('content')
<thread-view :initial-reply-count="{{ $thread->replies_count }}" inline-template>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <div class="level">
                            <div class="flex">
                                <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a> posted:{{ $thread->title }}
                            </div>
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
                <replies :data="{{ $replies }}" @removed="replyCount--"></replies>
                {{-- @foreach ($replies as $reply)
                    @include ('threads.reply')
                @endforeach
                {{ $replies->links() }} --}}
                @auth
                <form action="{{ $thread->path() }}/replies" method="POST" class="form">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="body">Leave a reply</label>
                        <textarea name="body" id="body" cols="30" rows="5" class="form-control" placeholder="Add your thought"></textarea>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-default">Post</button>
                    </div>
                </form>
                @else
                <p class="text-center">Please <a href="{{ route('login') }}">Log in</a> to participate in the forum</p>
                @endauth
            </div>
            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        This thread was published {{ $thread->created_at->diffForHumans() }} by
                        <a href="#">{{ $thread->creator->name }}</a>, and currently
                        has <span v-text="repliesCount"></span>.
                    </div>
                </div>
            </div>
        </div>
    </div>
</thread-view>
@endsection
