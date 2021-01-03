@extends('layouts.app')

@section('content')

    <!-- Bootstrap Boilerplate... -->

    <div class="container">
    <div class="panel-body">
        <!-- Display Validation Errors -->
    @include('common.errors')

    <!-- User Comment Form -->
        <form action="/user-comment" method="POST" class="form-horizontal">
        {{ csrf_field() }}

            <!-- User Comment Name -->
            <div class="form-group">
                <label for="task" class="col-sm-3 control-label">Name</label>

                <div class="col-sm-6">
                    <input type="text" name="name" id="user-name" class="form-control">
                </div>
            </div>

            <!-- User Comment -->
            <div class="form-group">
                <label for="task" class="col-sm-3 control-label">Comment</label>

                <div class="col-sm-6">
                    <textarea name="comments" id="user-comment" class="form-control"></textarea>
                </div>
            </div>

            <!-- Add Comment Button -->
            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-6">
                    <input type="hidden" name="password" id="user-password" value="720DF6C2482218518FA20FDC52D4DED7ECC043AB">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add Comment
                    </button>
                </div>
            </div>
        </form>
    </div>
    </div>

    <div class="container">
    <!-- Current Tasks -->
    @if (count($usercomments) > 0)
        <div class="panel panel-default">
            <div class="panel-heading">
                Current Tasks
            </div>

            <div class="panel-body">
                <table class="table table-striped task-table">

                    <!-- Table Headings -->
                    <thead>
                    <th>User Comment</th>
                    <th colspan="2">&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                    @foreach ($usercomments as $usercomment)
                        <tr>
                            <!-- Task Name -->
                            <td class="table-text">
                                <div>{{ $usercomment->name }}</div>
                            </td>
                            <td>
                                <form action="/user-comment/{{$usercomment->id}}" method="GET">
                                    <button class="btn btn-light" >View</button>
                                </form>
                            </td>
                            <td>
                                <form action="/user-comment/{{ $usercomment->id }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    </div>
@endsection
