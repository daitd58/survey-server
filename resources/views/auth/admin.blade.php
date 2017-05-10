@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                @if( Session::has('flash_message') )
                    <div class="alert alert-{!! Session::get('flash_level') !!}">
                        {!! Session::get('flash_message') !!}
                    </div>
                @endif
            </div>
            <div class="col-md-4">
                <form action="{{ url('/create') }}" method="post" role="form" class="center-block">
                    {{ csrf_field() }}
                    <legend>Create User</legend>

                    <div class="form-group">
                        <label for="">UserName</label>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username...">
                    </div>
                    <div class="form-group">
                        <label for="">User Type</label>
                        <select name="user_type" class="form-control" id="user_type">
                            <option value="1">Admin</option>
                            <option value="2">Staff</option>
                            <option value="3">Student</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="">Email</label>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Username...">
                    </div>
                    <div class="form-group">
                        <label for="">Password</label>
                        <input type="password" class="form-control" name="password" id="password" placeholder="Username...">
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection