@extends('layouts.admin')

@section('content')
    <div class="container-fluid pt-4 px-4">
        <div class="bg-light text-center rounded p-4">
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h6 class="mb-0">Add Party</h6>
                <a href="{{ route('admin.party.index') }}" class="btn btn-primary">Back</a>
            </div>

            <form method="POST" action="{{ route('admin.party.store') }}">
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" name="name">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="number" class="form-control" name="phone">
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" name="address" >
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="checkbox" class="form-label">Wastage</label>
                        <input type="checkbox" class="form-check-input" name="wastage_status"
                        id="checkbox" onchange="toggleDropdown()">
                    </div>

                    <div class="col-md-4 mb-2">
                        <label for="dropdown" class="form-label">Wastage Percentage</label>
                        <select class="form-select" name="wastage_percentage" id="dropdown" disabled>
                            <option value="0.5">0.5</option>
                            <option value="1.0">1.0</option>
                            <option value="1.5">1.5</option>
                            <option value="2.0">2.0</option>
                        </select>
                    </div>
                </div>
                <div class="mb-3">
                    <button type="submit" class="btn btn-primary float-end">Submit</button>
                </div>
            </form>

        </div>
    </div>
@endsection

<script>
    function toggleDropdown() {
        var checkbox = document.getElementById("checkbox");
        var dropdown = document.getElementById("dropdown");

        dropdown.disabled = !checkbox.checked;
    }
</script>
