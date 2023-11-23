@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Add Role</h6>
                <a href="{{ route('admin.role.index') }}" class="btn btn-primary">Back</a>
            </div>
            <div class="table-responsive">
                <form method="POST" action="{{ route('admin.role.store') }}">
                    @csrf
                    <div class="text-start">
                        <strong>Name</strong>
                        <input type="text" class="form-control" id="name" name="name"
                            required>
                    </div>
                    <div class="">
                        <div class="d-flex justify-content-between">
                            <strong>Permission:</strong> <span><input type="checkbox" id="selectAll" />Select all</span>
                        </div>
                        <select id="permission" name="permission[]" class="form-control text-start" multiple="">
                            @foreach ($permission as $value)
                                <option value="{{ $value->id }}">{{ $value->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mt-3">
                        <button type="submit" class="btn btn-primary float-end">Create Role</button>
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
