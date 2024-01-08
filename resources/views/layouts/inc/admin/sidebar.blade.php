<div class="sidebar pe-4 pb-3">
    <nav class="navbar bg-light navbar-light">
        <a href="index.html" class="navbar-brand mx-4 mb-3">
            <h5 class="text-primary"><i class="fa fa-industry me-1"></i>IQBAL KNITTING</h5>
        </a>
        <div class="navbar-nav w-100">
            <a href="{{ url('admin/dashboard') }}" class="nav-item nav-link active my-1"><i
                    class="fa fa-tachometer-alt me-1"></i>Dashboard</a>
            <div class="nav-item dropdown my-1">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="far fa-user-circle me-1"></i>User</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('admin.role.index') }}" class="dropdown-item ms-4">
                        <i class="fa fa-circle me-3 ms-1 font-12"></i>Role</a>
                    <a href="{{ route('admin.permissions.index') }}" class="dropdown-item ms-4">
                        <i class="fa fa-circle me-3 ms-1 font-12"></i>Permission</a>
                    <a href="{{ route('admin.users.index') }}" class="dropdown-item ms-4">
                        <i class="fa fa-circle me-3 ms-1 font-12"></i>User</a>
                </div>
            </div>
            <div class="nav-item dropdown my-1">
                <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                    <i class="fa fa-th me-1"></i>Billing</a>
                <div class="dropdown-menu bg-transparent border-0">
                    <a href="{{ route('admin.order.index') }}" class="dropdown-item ms-4">
                        <i class="fas fa-wallet me-3 ms-1 font-12"></i>Order In</a>
                    <a href="{{ route('admin.delivery.index') }}" class="dropdown-item ms-4">
                        <i class="fas fa-wallet me-3 ms-1 font-12"></i>Order Out</a>
                </div>
            </div>
            <a href="{{ route('admin.thread.index') }}" class="nav-item nav-link my-1"><i
                    class="fa fa-keyboard me-1"></i>Thread</a>
            <a href="{{ route('admin.party.index') }}" class="nav-item nav-link my-1"><i
                    class="fa fa-th me-1"></i>Party</a>

        </div>
    </nav>
</div>
