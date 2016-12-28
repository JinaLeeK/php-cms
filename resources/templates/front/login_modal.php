 <div class="modal fade" id="editModal">
  <div class="modal-dialog modal-sm" role="document">
    <div class="modal-content">
      <div class="modal-body" style="">
        <form role="form" action="" method="post" id="comment-login-form" autocomplete="off">
            <div class="text-center bg-warning" id="comment-msg"></div>

            <input type="hidden" id="comment_id" name="comment_id" value="">
            <input type="hidden" id="role" name="role" value="">

            <div class="form-group">
                <label for="username" class="sr-only">Name *</label>
                <input autofocus type="text" name="username" id="username" class="form-control" placeholder="Nickname *">
            </div>

             <div class="form-group">
                <label for="password" class="sr-only">Password *</label>
                <input type="password" name="password" id="key" class="form-control" placeholder="Password *">
            </div>
            <!-- <button type="button" class="btn btn-sm" data-dismiss="modal">Close</button> -->
            <button type="submit" name="comment_login" id="edit-submit" class="btn btn-xs btn-primary pull-right">Submit</button>
        </form><br>
        <!-- <span>Forgot password? Click <a href="index.php?password">hear.</a></span><br> -->
      </div>
    </div>
  </div>
</div>
