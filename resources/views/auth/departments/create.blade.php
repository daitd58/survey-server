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
                <form action="{{ url('department/create') }}" method="post" role="form">
                    <legend>Create Department</legend>

                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="">Department name</label>
                        <input type="text" class="form-control" name="department_name" id="department_name"
                               placeholder="Department name...">
                    </div>

                    <div class="form-group">
                        <label for="">Department parent</label>
                        <select name="parent_id" class="form-control">
                            <option value="0">Không có</option>
                            {{ get_departments($departments) }}
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="">Staff</label>
                        <select name="staff" class="form-control" multiple>
                            @foreach($user_staff as $item)
                                <option value="{{ $item['person_id'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
@endsection