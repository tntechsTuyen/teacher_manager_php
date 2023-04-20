
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login System</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="views/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="views/assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="views/assets/css/style.css">
    <link rel="shortcut icon" href="views/assets/images/favicon.png" />
  </head>
  <body>
    <div class="container-scroller">
      <div class="container-fluid page-body-wrapper full-page-wrapper">
        <div class="row w-100">
          <div class="content-wrapper full-page-wrapper auth login-2 login-bg">
            <div class="card col-lg-4">
              <div class="card-body px-5 py-5">
                <h3 class="card-title text-start mb-3">ĐĂNG NHẬP</h3>
                <form id="login-form" action="?m=submitLogin" method="POST">
                  
                  <div class="form-group">
                    <label>Quyền hạn</label>
                    <select name="role" class="form-control">
                      <option value="1">Quản trị viên</option>
                      <option value="2">Giảng viên</option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label>Tên đăng nhập *</label>
                    <input name="username" type="text" class="form-control p_input">
                  </div>

                  <div class="form-group" id="ip-password">
                    <label>Mật khẩu *</label>
                    <input name="password" type="password" class="form-control p_input">
                  </div>

                  <div class="text-center">
                    <button type="type" class="btn btn-primary btn-block btn-login">Đăng nhập</button>
                  </div>
                </form>
              </div>
            </div>
          </div>
          <!-- content-wrapper ends -->
        </div>
        <!-- row ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <script src="views/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="views/assets/js/off-canvas.js"></script>
    <script src="views/assets/js/hoverable-collapse.js"></script>
    <script src="views/assets/js/misc.js"></script>
    <script src="views/assets/js/settings.js"></script>
    <script src="views/assets/js/todolist.js"></script>
    <!-- endinject -->
    
    <script>
      $(`[name="role"]`).change(function(){
        const val = $(this).val() * 1
        console.log(val)
        if(val == 1){
          $(`#ip-password`).removeClass("d-none")
        }else{
          $(`#ip-password`).addClass("d-none")
        }
      })
    </script>
    <?php if (isset($_SESSION['mess'])): ?>
      <script>
        alert('<?php echo $_SESSION['mess']; ?>')
        <?php unset($_SESSION['mess']); ?>
      </script>
    <?php endif ?>
  </body>
</html>