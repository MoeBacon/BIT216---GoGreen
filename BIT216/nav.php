<?php
    // Get the current page name
    $currentPage = basename($_SERVER['PHP_SELF']);
?>

<style>
    .logout {
        margin-top: 70px;
    }
</style>

<nav class="menu">
    <ul>
        <li><a href="dashboard.php" class="<?php echo ($currentPage == 'dashboard.php') ? 'active' : ''; ?>"><i class="fa-solid fa-table-columns"></i><span>My dashboard</span></a></li>
        <li><a href="account.php" class="<?php echo ($currentPage == 'account.php') ? 'active' : ''; ?>"><i class="fa-solid fa-user"></i><span>Accounts</span></a></li>
        <li><a href="reportIssue.php" class="<?php echo ($currentPage == 'reportIssue.php') ? 'active' : ''; ?>"><i class="fa-solid fa-comment-dots"></i><span>Report</span></a></li>
        <li><a href="schedule.php" class="<?php echo ($currentPage == 'schedule.php') ? 'active' : ''; ?>"><i class="fa-solid fa-calendar-days"></i><span>Schedule PickUp</span></a></li>
        <li><a href="history.php" class="<?php echo ($currentPage == 'history.php') ? 'active' : ''; ?>"><i class="fa-solid fa-clock-rotate-left"></i><span>History</span></a></li>
        <li><a href="overview.php" class="<?php echo ($currentPage == 'overview.php') ? 'active' : ''; ?>"><i class="fa-solid fa-chart-simple"></i><span>Overview</span></a></li>
        <li class="logout"><a href="php/functions.php?op=signOut"><i class="fa-solid fa-arrow-right-from-bracket"></i><span>Logout</span></a></li>
    </ul>
</nav>
