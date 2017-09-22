@component('profiles.activities.activity')
    @slot('heading')
    <a href="#">
        {{ $profileUser->name }} favorited a reply.
    </a>
    @endslot
    @slot('body')
        {{ $activity->subject->favorited->body }}
    @endslot
@endcomponent
