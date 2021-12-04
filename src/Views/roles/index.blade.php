@extends(fn_get_permission_layout())


@section('content')
<div class="container">
    <div class="row">
        <div class="col-lg-12 margin-tb">
            <div class="pull-left">
                <h2>Role Management</h2>
            </div>
            <div class="pull-right">
                @permission('role-create')
                <a class="btn btn-success" href="{{ route('roles.create') }}"> Create New Role</a>
                @endpermission
            </div>
        </div>
    </div>


    @if ($message = Session::get('success'))
    <div class="alert alert-success">
        <p>{{ $message }}</p>
    </div>
    @endif


    <table class="table table-bordered">
        <tr>
            <th>{{__('No')}}</th>
            <th>{{__('Name')}}</th>
            <th>{{__('Level')}}</th>
            <th width="280px">Action</th>
        </tr>
        @foreach ($roles as $key => $role)
        <tr>
            <td>{{ $loop->index + 1 }}</td>
            <td>{{ $role->name }}</td>
            <td>{{ $role->level }}</td>
            <td>
                @permission('update',$role)
                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Edit</a>
                @endpermission
                @permission('delete',$role)
                <a class="btn btn-primary" href="{{ route('roles.edit',$role->id) }}">Delete</a>
                @endpermission
            </td>
        </tr>
        @endforeach
    </table>
</div>
@endsection