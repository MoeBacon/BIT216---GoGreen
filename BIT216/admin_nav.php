<?php
    // Get the current page name
    $currentPage = basename($_SERVER['PHP_SELF']);
?>



<div class="sidebar">
    <div class="logo">
        <img src="image/GOGREEN1.png" alt="Logo">
    </div>
    <nav class="navbar">
        <a href="admin_dashboard.php" class="nav-btn <?php echo ($currentPage == 'admin_dashboard.php') ? 'active' : ''; ?>">Dashboard</a>
        <a href="admin_overview.php" class="nav-btn <?php echo ($currentPage == 'admin_overview.php') ? 'active' : ''; ?>">Reports</a>
        <a href="admin_announcement.php" class="nav-btn <?php echo ($currentPage == 'admin_announcement.php') ? 'active' : ''; ?>">Announcement</a>
        <a href="admin_schedule.php" class="nav-btn <?php echo ($currentPage == 'admin_schedule.php') ? 'active' : ''; ?>">Waste Schedule</a>
        <a href="php/functions.php?op=signOut" class="nav-btn logout">Logout</a>
    </nav>
</div>






