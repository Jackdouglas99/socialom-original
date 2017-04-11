@extends('layouts.master')

@section('title')
    Report List
@endsection

@section('content')
    <style>
        /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
        .row.content {height: 550px}

        /* Set gray background color and 100% height */
        .sidenav {
            background-color: #f1f1f1;
            height: 100%;
        }

        /* On small screens, set height to 'auto' for the grid */
        @media screen and (max-width: 767px) {
            .row.content {height: auto;}
        }
    </style>
    <div class="row content">
        @include('admin.includes.sidebar')
        <div class="col-sm-9">
            <h3>All Users</h3>
            <table class="table table-hover">
                <thead>
                <tr>
                    <th>URID</th>
                    <th>Reporter</th>
                    <th>Reported</th>
                    <th>Reason</th>
                    <th>UPID</th>
                    <th>Status</th>
                </tr>
                </thead>
                <tbody>
                @foreach($reports as $report)
                    <tr>
                        @if($report->status == 1)
                            <td>{{$report->id}}</td>
                        @else
                            <td><a href="{{route('admin.report', $report->id)}}">{{$report->id}}</a></td>
                        @endif
                        <td><a href="{{route('admin.user', $report->reporter)}}">{{\App\User::where('id', $report->reporter)->first()->first_name}} {{\App\User::where('id', $report->reporter)->first()->last_name}}</a></td>
                        <td><a href="{{route('admin.user', $report->reported)}}">{{\App\User::where('id', $report->reported)->first()->first_name}} {{\App\User::where('id', $report->reported)->first()->last_name}}</a></td>
                        @if($report->reason == 0)
                            <td><span class="label label-primary">Annoying</span></td>
                        @elseif($report->reason == 1)
                            <td><span class="label label-primary">Not Needed</span></td>
                        @elseif($report->reason == 2)
                            <td><span class="label label-primary">Spam</span></td>
                        @endif
                        <td>{{$report->post_id}}</td>
                        @if($report->status == 0)
                            <td><span class="label label-primary">New</span></td>
                        @elseif($report->status == 1)
                            <td><span class="label label-success">Resolved</span></td>
                        @elseif($report->status == 2)
                            <td><span class="label label-danger">Spam</span></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
