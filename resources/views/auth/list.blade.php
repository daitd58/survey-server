@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                <tr align="left">
                    <th>Username</th>
                    <th>Type</th>
                    <th>Delete</th>
                    <th>Edit</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $users as $user )
                    <tr class="odd gradeX" align="left">
                        <td>{{ $user['name'] }}</td>
                        <td>{{ ($user['user_type'] == 1) ? 'Admin' : (($user['user_type'] == 2) ? 'Staff' : 'Student') }}</td>
                        <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a href="#" onclick="confirm('Do you want to delete this user?')"> Delete</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i> <a href="#">Edit</a></td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection