<div class="col-sm-3 sidenav hidden-xs">
  <h2>Administration Dashboard</h2>
  <ul class="nav nav-pills nav-stacked">
    <li @if(\Request::route()->getName() === "admin.dashboard") class="active" @endif><a href="{{route('admin.dashboard')}}">Dashboard</a></li>
    <li @if(\Request::route()->getName() === "admin.users" || \Request::route()->getName() === "admin.user") class="active" @endif><a href="{{route('admin.users')}}" >Users</a></li>
    <li @if(\Request::route()->getName() === "admin.reports" || \Request::route()->getName() === "admin.report") class="active" @endif><a href="{{route('admin.reports')}}">Reports</a></li>
    <li @if(\Request::route()->getName() === "admin.posts"  || \Request::route()->getName() === "admin.post") class="active" @endif><a href="{{route('admin.posts')}}">Posts</a></li>
    <li @if(\Request::route()->getName() === "admin.comments" || \Request::route()->getName() === "admin.comment") class="active" @endif><a href="{{route('admin.comments')}}">Comments</a></li>
  </ul>
</div>
