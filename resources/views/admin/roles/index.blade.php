@extends('layouts.admin')

@section('content')

<div class="container-fluid pt-4 px-4">
    <div class="bg-light text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Roles</h6>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        {{-- <th scope="col"><input class="form-check-input" type="checkbox"></th> --}}
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($roles as $role)
                        <tr>
                            {{-- <td><input class="form-check-input" type="checkbox"></td> --}}
                            <td>{{ $role->id }}</td>
                            <td>{{ $role->name }}</td>
                            <td>
                                <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-primary btn-sm">Edit</a>
                                {{-- <a class="btn btn-sm btn-primary" href="{{ route('admin.role.show', $role->id) }}">Detail</a> --}}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4">No Role Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
