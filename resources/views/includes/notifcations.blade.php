<ul class="dropdown-menu">
    @if(count(\App\Notification::where('to', Auth::user()->id)->whereNull('read_at')->get()))
        @foreach(\App\Notification::where('to', Auth::user()->id)->whereNull('read_at')->get() as $notif)
            @if($notif->type == "like")
                <li>
                    <a href="{{route('read.notification', $notif->id)}}">
                        {{\App\User::where('id', $notif->user_id)->first()->first_name}} {{\App\User::where('id', $notif->user_id)->first()->last_name}} Liked your post.
                    </a>
                </li>
            @elseif($notif->type == "fRequest")
                <li>
                    <a href="{{route('read.notification', $notif->id)}}">
                        {{\App\User::where('id', $notif->user_id)->first()->first_name}} {{\App\User::where('id', $notif->user_id)->first()->last_name}} Sent you a friend request.
                    </a>
                </li>
            @elseif($notif->type == "fRequestAccept")
                <li>
                    <a href="{{route('read.notification', $notif->id)}}">
                        {{\App\User::where('id', $notif->user_id)->first()->first_name}} {{\App\User::where('id', $notif->user_id)->first()->last_name}} Accepted your friend request.
                    </a>
                </li>
            @elseif($notif->type == "comment")
                <li>
                    <a href="{{route('read.notification', $notif->id)}}">
                        {{\App\User::where('id', $notif->user_id)->first()->first_name}} {{\App\User::where('id', $notif->user_id)->first()->last_name}} Commented your post.
                    </a>
                </li>
            @elseif($notif->type == "comment.deleted")
                <li>
                    <a href="{{route('read.notification', $notif->id)}}">
                        {{\App\User::where('id', $notif->user_id)->first()->first_name}} {{\App\User::where('id', $notif->user_id)->first()->last_name}} Deleted your comment.
                    </a>
                </li>
            @elseif($notif->type == "reporter.post.deleted")
                <li>
                    <a href="{{route('read.notification', $notif->id)}}">
                        {{\App\User::where('id', $notif->user_id)->first()->first_name}} {{\App\User::where('id', $notif->user_id)->first()->last_name}} Deleted the post reported.
                    </a>
                </li>
            @elseif($notif->type == "reported.post.deleted")
                <li>
                    <a href="{{route('read.notification', $notif->id)}}">
                        {{\App\User::where('id', $notif->user_id)->first()->first_name}} {{\App\User::where('id', $notif->user_id)->first()->last_name}} Deleted your post as it was reported.
                    </a>
                </li>
            @elseif($notif->type == "post.reported")
                <li>
                    <a href="{{route('read.notification', $notif->id)}}">
                        {{\App\User::where('id', $notif->user_id)->first()->first_name}} {{\App\User::where('id', $notif->user_id)->first()->last_name}} Reported your post.
                    </a>
                </li>
            @elseif($notif->type == "admin.bio.updated")
                <li>
                    <a href="{{route('read.notification', $notif->id)}}">
                        {{\App\User::where('id', $notif->user_id)->first()->first_name}} {{\App\User::where('id', $notif->user_id)->first()->last_name}} Updated your bio as it was going against our guidelines.
                    </a>
                </li>
            @endif
        @endforeach
    @else
        <li>You have no notifications</li>
    @endif
</ul>