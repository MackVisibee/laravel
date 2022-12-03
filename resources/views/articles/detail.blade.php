@extends("layouts.app");
@section("content")
<div class="container">
    @if (session('info'))
        <div class="alert alert-info">
            {{session('info')}}
        </div>
    @endif
    <div class="card mb-2">
        <div class="card-body">
            <h5 class="card-title">{{ $article->title}}</h5>
            {{ $article->created_at->diffForHumans()}}
            Category: {{ $article->category->name }}
            <p class="card-text">
                {{$article->body}}
            </p>
            @auth
                @can('article-delete', $article)
                    <a href="{{ url("/articles/edit/$article->id")}}" class="btn btn-secondary card-link">Edit</a>
                    <a href="{{ url("/articles/delete/$article->id")}}" class="btn btn-warning card-link">Delete...</a>
                @endcan
                
            @endauth
            
        </div>
    </div>
    
    <h4 class="ms-1 h5 mt-4">Comments ({{ count($article->comments)}})</h4>
    <ul class="list-group">
        @foreach ($article->comments as $comment )
            <li class="list-group-item">
                @can('comment-delete', $comment) 
                    <a href="{{ url("/comments/delete/$comment->id")}}" class="btn-close float-end">
                    
                    </a>
                @endcan
                
                <div>
                    <small>
                        <b class="text-success">{{ $comment->user->name}}</b>
                        {{ $comment->created_at->diffForHumans() }}
                    </small>
                </div>
                {{ $comment->content}}</li>
        @endforeach
    </ul>
    @auth
        <form action="{{ url("/comments/add")}}" method="post">
            @csrf
            <input type="hidden" name="article_id" value="{{ $article->id }}">
            <textarea name="content"  class="form-control my-2"></textarea>
            <button class="btn btn-secondary">Add Comment</button>
        </form>
    @endauth
    
</div>
@endsection