@extends('layout.default')


@section('content')

 <form class="container mb-5" action="{{ url('editpost/' . $post->id) }}" method="POST">
    @csrf
    <div class="mb-3">
      <input type="text" class="form-control" id="title" name="title" placeholder="Title" value="{{$post->title}}" required>
    </div>
    <div class="mb-3">
      <textarea class="form-control" id="body" name="body" placeholder="Body" value="{{$post->body}}" required></textarea>
    </div>
    <button type="submit" class="btn btn-primary">Edit</button>
</form>

<div class="container">
  @include('components.session-handler')
  @include('components.error-handler')
</div>

@endsection