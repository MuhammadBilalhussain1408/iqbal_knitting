@extends('layouts.admin')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Permissions</h6>
            <a href="{{route('admin.permissions.create')}}" class="btn btn-primary">Add Permission</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($permissions as $permission)
                        <tr>
                            
                            <td>{{ $permission->id }}</td>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No Permission Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
