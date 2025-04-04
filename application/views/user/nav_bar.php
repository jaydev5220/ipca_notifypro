    <!--Navbar-->
    <nav class="navbar navbar-light light-blue lighten-4">
        <!-- Collapse button -->
        <button class="navbar-toggler toggler-example" type="button" data-toggle="collapse" data-target="#navbarSupportedContent1" aria-controls="navbarSupportedContent1" aria-expanded="false" aria-label="Toggle navigation"><span class="dark-blue-text"><i class="fas fa-bars fa-1x"></i></span></button>

        <!-- Collapsible content -->
        <div class="collapse navbar-collapse" id="navbarSupportedContent1">

            <!-- Links -->
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a href="<?php echo base_url('user/create_notification') ?>" class="btn btn-lg rounded-0  btn-color  full-width m-1">Create Notification</a>
                </li>
                <li class="nav-item">
                    <a href="<?php echo base_url('user/list') ?>" class="btn btn-lg rounded-0  btn-color  full-width m-1">Listing</a>
                </li>
                <li class="nav-item">
                    <?php if (isset($permission->category) && $permission->category == 'on') { ?>

                        <a href="<?php echo base_url('category') ?>" class="btn btn-lg rounded-0  btn-color full-width m-1">Category</a>

                    <?php } ?>
                </li>
                <li class="nav-item">
                    <?php if (isset($permission->companies) && $permission->companies == 'on') { ?>

                        <a href="<?php echo base_url('companies') ?>" class="btn btn-lg rounded-0  btn-color full-width m-1">Companies</a>

                    <?php } ?>
                <li class="nav-item">
                    <a href="<?php echo base_url('user/logout') ?>" class="btn btn-lg rounded-0  btn-color  full-width m-1">Logout</a>
                </li>
            </ul>
            <!-- Links -->

        </div>
        <!-- Collapsible content -->

    </nav>
    <!--/.Navbar-->