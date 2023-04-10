<?php
require_once('header.php');
require_once('cookie_session.php');
?>

<body>

  <header role="banner">
    <?php
    require_once('banner.php');
    renderMenuToHTML('objectives.php');
    ?>
  </header>
  <!-- END header -->

  <div class="slider-wrap no-slanted">
    <div class="slider-item" style="background-image: url('img/hero_1.jpg');">

      <div class="container">
        <div class="row slider-text align-items-center justify-content-center">
          <div class="col-md-8 text-center col-sm-12 ">
            <h1 data-aos="fade-up">Let's fix your objectives</h1>
          </div>
        </div>
      </div>

    </div>
    <!-- END slider -->
  </div>

  <section class="section pt-5 top-slant-white2 relative-higher bottom-slant-gray">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-12">

          <form id="objectives-form">
          <input type="hidden" id="login" value="<?php echo $login; ?>">

            <div id="indicator-forms">
              <!-- Indicator forms will be dynamically added here -->
              <div class="indicator-form row">
                <div class="col-md-6 form-group">
                  <select id="id_indicateur" class="form-control">
                  </select>
                </div>
                <div class="col-md-6">
                  <div class="row">
                    
                    <!-- quantity -->
                    <div class="col-md-8 form-group">
                      <input type="number" id="quantite" class="form-control" placeholder="quantity" required>
                    </div>
                    <!-- quantity -->
                    
                  </div>
                </div>
              </div>

              <!-- .add indicator button -->
              <div class="row">
                <div class="col-md-12 form-group text-center">
                  <button type="button" class="btn btn-primary" id="add-indicator">Add an indicator</button>
                </div>
              </div>
              <!-- .add indicator button -->

              <!-- .enter button -->
              <div class="row">
                <div class="col-md-12 form-group text-center">
                  <input type="submit" value="Enter" class="btn btn-primary">
                </div>
              </div>
              <!-- .enter button -->
            </div>
          </form>

        </div>
      </div>
    </div>
  </section>
  <!-- .section -->


  <footer class="site-footer" role="contentinfo">


  <?php
  require_once('footer.php');
  require_once('loader.php');
  ?>

<script src="js/objectives.js"></script>
</body>

</html>