<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="background: #0F75BD;">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Radiant Ins</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Services
    </div>

    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="index.php">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>


    <?php if (isset($_SESSION['employeeid'])): ?>
        <li class="nav-item">
            <a class="nav-link" href="clients.php">
                <i class="fas fa-fw fa-address-book"></i>
                <span>Clients</span>
            </a>
        </li>

        <li class="nav-item">
            <a class="nav-link" href="insurances.php">
                <i class="fas fa-fw fa-layer-group"></i>
                <span>Insurances</span>
            </a>
        </li>

    <?php endif; ?>

    <?php if (isset($_SESSION['clientid'])): ?>

        <li class="nav-item">
            <a class="nav-link" href="client_insurance.php">
            <i class="fas fa-fw fa-building"></i>
                <span>My Insurances</span>
            </a>
        </li>

    <?php endif; ?>

    <li class="nav-item">
        <a class="nav-link" href="renewals.php">
            <i class="fas fa-fw fa-chess"></i>
            <span>Renewals</span>
        </a>
    </li>


    <?php if (isset($_SESSION['employeeid'])): ?>

        <li class="nav-item">
            <a class="nav-link" href="reports.php">
                <i class="fas fa-fw fa-file-alt"></i>
                <span>Reports</span>
            </a>
        </li>

    <?php endif; ?>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->