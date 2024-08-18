<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h5 class="text-primary"><i class="fa fa-industry me-1"></i>IQBAL KNITTING</h5>
        </a>
        <div class="navbar-nav w-100">
            <a href="{{ url('admin/dashboard') }}"
                class="nav-item nav-link my-1 {{ Request::is('admin/dashboard') ? 'active' : '' }}">
                <i class="fa fa-tachometer-alt me-1"></i>Dashboard
            </a>
            <div
                class="nav-item dropdown my-1">
                <a href="#" class="nav-link dropdown-toggle {{ Request::is('admin/user', 'admin/role', 'admin/permissions') ? 'show active' : '' }}" data-bs-toggle="dropdown">
                    <i class="far fa-user-circle me-1"></i>User</a>
                <div class="dropdown-menu bg-transparent border-0 {{ Request::is('admin/user', 'admin/role', 'admin/permissions') ? 'show active' : '' }}">
                    <a href="{{ route('admin.role.index') }}"
                        class="dropdown-item ms-2 {{ Request::is('admin/role') ? 'active' : '' }}">
                        <i class="fa fa-circle me-3 ms-1 font-12"></i>Role</a>
                    <a href="{{ route('admin.permissions.index') }}"
                        class="dropdown-item ms-2 {{ Request::is('admin/permissions') ? 'active' : '' }}">
                        <i class="fa fa-circle me-3 ms-1 font-12"></i>Permission</a>
                    <a href="{{ route('admin.users.index') }}"
                        class="dropdown-item ms-2 {{ Request::is('admin/users') ? 'active' : '' }}">
                        <i class="fa fa-circle me-3 ms-1 font-12"></i>User</a>
                </div>
            </div>
            <div
                class="nav-item dropdown my-1">
                <a href="#" class="nav-link dropdown-toggle {{ (Request::is('admin/order') || Request::is('admin/order_out')) ? 'show active' : '' }}" data-bs-toggle="dropdown">
                    <i class="fa fa-th me-1"></i>Billing</a>
                <div class="dropdown-menu bg-transparent border-0 {{ (Request::is('admin/order') || Request::is('admin/order_out')) ? 'show active' : '' }}">
                    <a href="{{ route('admin.order.index') }}"
                        class="dropdown-item ms-2 {{ Request::is('admin/order') ? 'active' : '' }}">
                        <i class="fas fa-wallet me-3 ms-1 font-12"></i>Order In</a>
                    <a href="{{ route('admin.order_out.index') }}"
                        class="dropdown-item ms-2 {{ Request::is('admin/order_out') ? 'active' : '' }}">
                        <i class="fas fa-wallet me-3 ms-1 font-12"></i>Order Out</a>
                </div>
            </div>
            <a href="{{ route('admin.thread.index') }}"
                class="nav-item nav-link my-1 {{ Request::is('admin/thread*') ? 'active' : '' }}">
                <i class="fa fa-keyboard me-1"></i>Thread
            </a>
            <a href="{{ route('admin.quality.index') }}"
                class="nav-item nav-link my-1 {{ Request::is('admin/quality*') ? 'active' : '' }}">
                <i class="fa fa-keyboard me-1"></i>Quality
            </a>
            <a href="{{ route('admin.party.index') }}"
                class="nav-item nav-link my-1 {{ Request::is('admin/party*') ? 'active' : '' }}">
                <i class="fa fa-th me-1"></i>Party
            </a>
        </div>
    </nav>
</div>

@push('script')
    <script>
        $(document).ready(function() {
            // Add 'active' class to the clicked tab and its dropdown
            $('.nav-link dropdown-toggle').on('click', function() {
                $(this).toggleClass('active');
            });

            // Add 'active' class to the clicked dropdown item
            $('.dropdown-item').on('click', function() {
                // Remove 'active' class from all dropdown items
                $('.dropdown-item').removeClass('active');

                // Add 'active' class to the clicked dropdown item
                $(this).addClass('active');

                // Keep the 'active' class on the dropdown toggle link
                var dropdownToggle = $(this).closest('.dropdown').find('.nav-link dropdown-toggle');
                dropdownToggle.addClass('active');
            });

            // Remove 'active' class from the dropdown toggle link when the dropdown is hidden
            $('.nav-link dropdown-toggle').on('hidden.bs.dropdown', function() {
                $(this).removeClass('active');
            });
        });
    </script>
@endpush
