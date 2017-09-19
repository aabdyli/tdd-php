@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Create a new Thread</div>

                <div class="panel-body">
                    <form method="POST" action="/threads">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="channel_id">Channel:</label>
                            <select class="form-control" type="text" name="channel_id" id="channel_id" required>
                                <option value="">Choose One</option>
                                @foreach ($channels as $channel)
                                    <option {{ old('channel_id') == $channel->id ? 'selected' : ''}} value="{{ $channel->id }}">{{ $channel->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="title">Title:</label>
                            <input class="form-control" type="text" name="title" id="title" value="{{ old('title') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="body">Body:</label>
                            <textarea class="form-control" name="body" id="body" cols="30" rows="5" required>{{ old('body') }}</textarea>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Publish</button>
                        </div>
                    </form>
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
