<?php
// Calculate base paths based on current directory
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$is_in_scripts = ($current_dir == 'scripts');
$is_in_screens = ($current_dir == 'screens');

// Define prefixes for links
// If in root, screens are in screens/, scripts are in scripts/
// If in screens/, other screens are ./, scripts are ../scripts/
// If in scripts/, screens are ../screens/, scripts are ./
$screens_prefix = '';
$scripts_prefix = '';

if ($is_in_scripts) {
    $screens_prefix = '../screens/';
    $scripts_prefix = './';
} elseif ($is_in_screens) {
    $screens_prefix = './';
    $scripts_prefix = '../scripts/';
} else {
    // Root level
    $screens_prefix = 'screens/';
    $scripts_prefix = 'scripts/';
}
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
    <a class="navbar-brand" href="<?php echo $screens_prefix; ?>home.php">
      <h6 class="m-0"><b style="color: white;">WELCOME TO LIBRARY <span style="color: rgb(236, 134, 17)">ZONE</span></b></h6>
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ml-auto align-items-center">
        <li class="nav-item"><a class="nav-link text-white font-weight-bold px-3" href="<?php echo $screens_prefix; ?>home.php">Home</a></li>
        <li class="nav-item"><a class="nav-link text-white font-weight-bold px-3" href="<?php echo $screens_prefix; ?>student.php">Student</a></li>
        <li class="nav-item"><a class="nav-link text-white font-weight-bold px-3" href="<?php echo $screens_prefix; ?>faculty.php">Faculty</a></li>
        <li class="nav-item"><a class="nav-link text-white font-weight-bold px-3" href="<?php echo $screens_prefix; ?>sample.php">Librarian</a></li>
        <li class="nav-item"><a class="nav-link text-white font-weight-bold px-3" href="<?php echo $screens_prefix; ?>admin.php">Admin</a></li>
        
        <?php 
          $current_page = basename($_SERVER['PHP_SELF']);
          $is_dashboard = in_array($current_page, ['staff.php', 'librarian.php', 'admin_dashboard.php', 'filldata.php', 'update.php', 'update_staff_book.php', 'change_password.php']);
          if(isset($_SESSION['username']) && $is_dashboard): 
        ?>
        <li class="nav-item dropdown ml-lg-3 mt-2 mt-lg-0">
          <a class="nav-link dropdown-toggle text-white font-weight-bold d-flex align-items-center" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="background: #007bff; border-radius: 10px; padding: 8px 20px; transition: all 0.3s ease;">
            <div class="bg-white rounded-circle d-flex align-items-center justify-content-center mr-2" style="width: 32px; height: 32px;">
                <i class="fas fa-user text-primary" style="font-size: 16px;"></i>
            </div>
            <span class="mr-1">Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></span>
          </a>
          <div class="dropdown-menu dropdown-menu-right shadow-lg border-0 mt-2" style="border-radius: 10px;" aria-labelledby="profileDropdown">
            <a class="dropdown-item py-2" href="<?php echo $screens_prefix; ?>change_password.php"><i class="fas fa-key text-muted mr-2"></i> Change Password</a>
            <div class="dropdown-divider"></div>
            <a class="dropdown-item py-2 text-danger" href="<?php echo $scripts_prefix; ?>logout.php"><i class="fas fa-sign-out-alt mr-2"></i> Logout</a>
          </div>
        </li>
        <?php endif; ?>
      </ul>
    </div>
</nav>
