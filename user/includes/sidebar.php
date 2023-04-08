        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">РУЧЕЕК</div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item">
            <?php if ($_SESSION['loginType']=="regularUser") { ?>
                <a class="nav-link" href="../logout.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Выход</span></a>
            <?php } else { ?>
                <a class="nav-link" href="../cashier/registered-users.php">
                    <i class="fas fa-fw fa-user"></i>
                    <span>Список участков</span></a>
            <?php } ?>

            </li>

            <!-- Divider -->
            <hr class="sidebar-divider">

            <!-- Heading -->
            <div class="sidebar-heading">
                Interface
            </div>

                    
            <!-- Nav Item - Charts -->
            <li class="nav-item">
              <form class="user" id="elUid"
                action="index.php" method="post"
              >
                <input type="hidden" name="uid" placeholder=""
                  value="<?php echo $uid?>"
                >
                <a class="nav-link" onclick="submit('elUid')" style="cursor:pointer">
                  <i class="fas fa-fw fa-user"></i>
                  <span>Электричество</span>
                </a>
              </form>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
              <form class="user" id="watUid"
                action="water.php" method="post"
              >
                <input type="hidden" name="uid" placeholder=""
                  value="<?php echo $uid?>"
                >
                <a class="nav-link" onclick="submit('watUid')" style="cursor:pointer">
                  <i class="fas fa-fw fa-user"></i>
                  <span>Вода</span>
                </a>
              </form>
            </li>

            <!-- Nav Item - Charts -->
            <li class="nav-item">
              <form class="user" id="feeUid"
                action="fee.php" method="post"
              >
                <input type="hidden" name="uid" placeholder=""
                  value="<?php echo $uid?>"
                >
                <a class="nav-link" onclick="submit('feeUid')" style="cursor:pointer">
                  <i class="fas fa-fw fa-user"></i>
                  <span>Членские</span>
                </a>
              </form>
            </li>

            <hr class="sidebar-divider d-none d-md-block">

            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
        <!-- End of Sidebar -->
