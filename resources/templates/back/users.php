<?php update_user_role_in_admin(); ?>
<!-- ?php delete_user_in_home(); ?> -->
<div class="col-lg-12">


    <h1 class="page-header">
        Users
    </h1>
      <p class="bg-success">
        <?php echo display_message(); ?>
    </p>

    <!-- <a href="index.php?add_user" class="btn btn-primary">Add User</a> -->


    <div class="col-md-12">

        <table class="table table-hover">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Admin</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
              <?php get_users_in_admin(); ?>
            </tbody>
        </table> <!--End of Table-->
    </div>

</div>
