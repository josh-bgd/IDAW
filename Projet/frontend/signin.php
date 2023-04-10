<?php
require_once('header.php');
require_once('cookie_session.php');
?>

<body>

    <header role="banner">
      <?php
      require_once('banner.php');
      renderMenuToHTML('signin.php');
      ?>
    </header>
    <!-- END header -->

    <div class="slider-wrap no-slanted">
      <div class="slider-item" style="background-image: url('img/hero_1.jpg');">

        <div class="container">
          <div class="row slider-text align-items-center justify-content-center">
            <div class="col-md-8 text-center col-sm-12 ">
              <h1 data-aos="fade-up">Connect to your account</h1>
            </div>
          </div>
        </div>

      </div>
      <!-- END slider -->
    </div>

    <section class="section  pt-5 top-slant-white2 relative-higher bottom-slant-gray">

      <div class="container">
        <div class="row">
          <div class="col-lg-6">

            <form id="login-form">

              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="login">Username</label>
                  <input type="text" id="login" class="form-control ">
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="password">Password</label>
                  <input type="password" id="password" class="form-control ">
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="submit" value="Connect" class="btn btn-primary">
                  <span id="error-message">
                </div>
              </div>
          </div>

          </form>

        </div>
      </div>
      </div>

    </section> <!-- .section -->


    <footer class="site-footer" role="contentinfo">

    <?php
    require_once('footer.php');
    require_once('loader.php');
    ?>
     <script src="js/login.js"></script>

</body>

</html>