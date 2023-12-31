@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Edit Role</h6>
                <button href="{{ route('admin.role.index') }}" class="btn btn-primary">Back</button>
            </div>
            <div class="table-responsive">
                <form method="POST" action="{{ route('admin.role.update', $roles->id) }}">
                    @csrf
                    @method('PUT')

                    <div class="text-start">
                        <strong>Name</strong>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $roles->name }}"
                            required>
                    </div>
                    <div class="">
                        <div class="d-flex justify-content-between">
                            <strong>Permission:</strong> <span><input type="checkbox" id="selectAll" />Select all</span>
                        </div>
                        <select id="permission" name="permission[]" class="form-control" multiple="">
                            @foreach ($permission as $value)
                                <option value="{{ $value->id }}"
                                    {{ in_array($value->id, $rolePermission) ? 'selected' : '' }}> {{ $value->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <!-- Add other fields for role editing as needed -->

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary float-end">Update Role</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $('document').ready(function() {
            $('#permission').select2();
        });

        $(document).on('change','#selectAll',function(){
        if($("#selectAll").is(':checked') ){
            $('#permission').select2('destroy').find('option').prop('selected', 'selected').end().select2()
        }else{
            $('#permission').select2('destroy').find('option').prop('selected', false).end().select2()
        }
    });
    </script>
@endpush
