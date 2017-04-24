@extends('layouts.master')

@section('title')
    Post List
@endsection

@section('content')
    <style>.row.content {height: 550px}.sidenav {background-color: #f1f1f1;height: 100%;}@media screen and (max-width: 767px) {.row.content {height: auto;}}</style>
    <div class="row content">
        @include('admin.includes.sidebar')
        <div class="col-sm-9">
            <h3>All Posts</h3>
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>UPID</th>
                        <th>User</th>
                        <th>Post Content</th>
                        <th># Likes</th>
                        <th># Comments</th>
                        <th>Reports</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($posts as $post)
                        <tr>
                            <td><a href="{{route('admin.post', $post->id)}}">{{$post->id}}</a></td>
                            <td>{{$post->user->username}}</td>
                            <td>{{$post->body}}</td>
                            <td>{{count($post->likes)}}</td>
                            <td>{{count($post->comments)}}</td>
                            <td>Coming Soon</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <center>
                <nav aria-label="Page navigation">
                    <ul class="pagination">
                        {!! $posts->links() !!}
                    </ul>
                </nav>
            </center>
        </div>
    </div>
@endsection
