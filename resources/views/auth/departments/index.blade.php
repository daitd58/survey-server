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
            <div class="col-lg-12">
                <div class="block page_header clearfix">
                    <div class="item">
                        <h1>All Departments</h1>
                    </div>
                    <div class="btn-group item">
                        <a class="btn btn-primary" href="{{ url('department/create') }}">Create Department</a>
                    </div>
                </div>
                @if( !empty($departments) )
                    <table class="table table-bordered table-hover">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Department Name</th>
                            <th>Department Parent</th>
                            <th>Edit</th>
                            <th>Delete</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach( $departments as $department )
                            <tr>
                                <td>{{ $loop->index + 1 }}</td>
                                <td>{{ $department['department_name'] }}</td>
                                <td>{{ get_department_parent($department['parent_id']) }}</td>
                                <td class="center"><i class="fa fa-pencil fa-fw"></i> <a
                                            href="{{ url('department/edit', $department['id']) }}">Edit</a></td>
                                <td class="center"><i class="fa fa-trash-o  fa-fw"></i><a
                                            href="{{ url('/delete', $department['id']) }}" onclick="return confirm('Do you want to delete this department?')"> Delete</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <h3>Chưa có dữ liệu</h3>
                @endif
            </div>
        </div>
    </div>
@endsection