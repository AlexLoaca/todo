    <!-- Modal Register -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">

    <div class="modal-content">

          <!--Modal Header -->
          <div class="modal-header">
            <div>
            <h5 class="modal-title" id="exampleModalLabel">Register</h5>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>

          <!--Modal Body -->
          <div class="modal-body">
            <form action="classes/authentication.class.php" method="post">
                <div class="form-group">
                    <input class="form-control" type="text" name="username" placeholder="Username" required="">
                </div>
                <div class="form-group">
                    <input class="form-control" type="email" name="email" placeholder="Email" required="">
                </div>
                <div class="form-group">
                    <input class="form-control" type="password" name="password" placeholder="Password" required="">
                </div>
                <input class="form-control" type="password" name="password" placeholder="Repeat Password" required="">
                <!--Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" name="register">Send</button>
                </div>
            </form>
          </div>

          
    </div>
  
  </div>
</div>

