@forelse ($threads as $thread)
<div class="panel panel-default">
    <div class="panel-heading">
        <div class="level">
            <div class="flex">
                <h4 class="flex">
                    <a href="{{ $thread->path() }}">
                        @if (auth()->check() && $thread->hasUpdatesFor(auth()->user()))
                            <strong>
                            {{ $thread->title }}                                    
                            </strong>
                        @else
                            {{ $thread->title }}
                        @endif
                    </a>
                </h4>
                <h5>Posted By: <a href="{{ route('profile', $thread->creator) }}">{{ $thread->creator->name }}</a></h5>
            </div>
            <a href="{{ $thread->path() }}"><strong>{{ $thread->replies_count }} {{ str_plural('comment', $thread->replies_count) }}</strong></a>
        </div>
    </div>
    <div class="panel-body">
        <article>
            <div class="body">
                {{ $thread->body }}
            </div>
        </article>
    </div>
</div>
@empty
<p class="text-center">This channel is Empty. Please write the first thread.</p>
@endforelse