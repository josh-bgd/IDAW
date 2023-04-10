<?php
require_once('header.php');
require_once('cookie_session.php');
?>

<body>

    <header role="banner">
      <?php
      require_once('banner.php');
      renderMenuToHTML('signup.php');
      ?>
    </header>
    <!-- END header -->

    <div class="slider-wrap no-slanted">
      <div class="slider-item" style="background-image: url('img/hero_1.jpg');">

        <div class="container">
          <div class="row slider-text align-items-center justify-content-center">
            <div class="col-md-8 text-center col-sm-12 ">
              <h1 data-aos="fade-up">Create your acount</h1>
            </div>
          </div>
        </div>

      </div>
      <!-- END slider -->
    </div>

    <section class="section  pt-5 top-slant-white2 relative-higher bottom-slant-gray">

      <div class="container">
        <div class="row">
          <div class="col-lg-10">

            <form id="signup-form" method="post">

              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="prenom">Name*</label>
                  <input type="text" id="prenom" class="form-control " required>
                </div>
                <div class="col-md-6 form-group">
                  <label for="nom">Last name*</label>
                  <input type="text" id="nom" class="form-control " required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="login">Username*</label>
                  <input type="text" id="login" class="form-control " required>
                </div>
                <div class="col-md-6 form-group">
                  <label for="id_sexe">Sexe*</label>
                  <select id="id_sexe" class="form-control" required>
                    <option value="">Select your gender</option>
                    <option value="1">Male</option>
                    <option value="2">Female</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="date_de_naissance">Birth date*</label>
                  <input type="date" id="date_de_naissance" class="form-control " required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="taille">Height*</label>
                  <input type="number" id="taille" class="form-control " placeholder="Enter your height in centimeters" required>
                </div>
                <div class="col-md-6 form-group">
                  <label for="poids">Weight*</label>
                  <input type="number" id="poids" class="form-control " placeholder="Enter your weight in kilograms" required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-6 form-group">
                  <label for="id_tranche_age">Age range*</label>
                  <select id="id_tranche_age" class="form-control" required>
                    <option value="">Select your age range (13+)</option>
                    <option value="1">13-25</option>
                    <option value="2">26-35</option>
                    <option value="3">36-45</option>
                    <option value="4">46-55</option>
                    <option value="5">56-65</option>
                    <option value="6">66-75</option>
                    <option value="7">76+</option>
                  </select>
                </div>
                <div class="col-md-6 form-group">
                  <label for="id_niveau">Level of sport practice*</label>
                  <select id="id_niveau" class="form-control" required>
                    <option value="">Select your level</option>
                    <option value="1">beginner</option>
                    <option value="2">Intermediate</option>
                    <option value="3">Expert</option>
                  </select>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="email">Email*</label>
                  <input type="email" id="email" class="form-control " required>
                </div>
              </div>

              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="motdepasse">Password*</label>
                  <input type="password" id="motdepasse" class="form-control " placeholder="Choose a strong password" required>
                </div>
              </div>
              <div class="row">
                <div class="col-md-12 form-group">
                  <label for="confirme-motdepasse"></label>
                  <input type="password" id="confirme-motdepasse" class="form-control " placeholder="Confirm your password" required>
                </div>
              </div>


              <div class="row">
                <div class="col-md-6 form-group">
                  <input type="submit" value="Create my account" class="btn btn-primary">
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>

    </section>

    <!-- .section -->

    <section class="section bg-light pt-0 relative-higher">

      <div class="clearfix mb-5 pb-5 ">
        <div class="container-fluid">
          <div class="row" data-aos="fade">
            <div class="col-md-12 text-center heading-wrap">
              <h2>Testimonial</h2>
            </div>
          </div>
        </div>
      </div>

      <div class="container">

        <div class="row justify-content-center">
          <div class="col-lg-7">
            <div class="owl-carousel centernonloop2">
              <div class="slide" data-aos="fade-left" data-aos-delay="100">
                <blockquote class="testimonial">
                  <p>&ldquo; Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. &rdquo;</p>
                  <div class="d-flex author">
                    <img src="img/person_1.jpg" alt="" class="mr-4">
                    <div class="author-info">
                      <h4>Mellisa Howard</h4>
                      <p>CEO, XYZ Company</p>
                    </div>
                  </div>
                </blockquote>
              </div>
              <div class="slide" data-aos="fade-left" data-aos-delay="200">
                <blockquote class="testimonial">
                  <p>&ldquo; Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. &rdquo;</p>
                  <div class="d-flex author">
                    <img src="img/person_2.jpg" alt="" class="mr-4">
                    <div class="author-info">
                      <h4>Mike Richardson</h4>
                      <p>CEO, XYZ Company</p>
                    </div>
                  </div>
                </blockquote>
              </div>
              <div class="slide" data-aos="fade-left" data-aos-delay="300">
                <blockquote class="testimonial">
                  <p>&ldquo; Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts. Separated they live in Bookmarksgrove right at the coast of the Semantics, a large language ocean. &rdquo;</p>
                  <div class="d-flex author">
                    <img src="img/person_3.jpg" alt="" class="mr-4">
                    <div class="author-info">
                      <h4>Charles White</h4>
                      <p>CEO, XYZ Company</p>
                    </div>
                  </div>
                </blockquote>
              </div>
            </div>
          </div>
        </div>




      </div>
    </section> 
    <!-- .section -->


    <footer class="site-footer" role="contentinfo">
      <div class="container mb-5">
        <div class="row justify-content-center">
          <div class="col-lg-6 text-center">
            <div class="row">
              <div class="col-md-12 mb-3">
                <h3>Subsribe Newsletter</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Dolore ex temporibus magni ipsam inventore dolorum sunt, amet vel.</p>
              </div>

              <form action="" class="col-12 mb-5">
                <div class="row align-items-center">
                  <div class="col-md-8 mb-3 mb-md-0">
                    <input type="text" class="form-control" placeholder="Enter Email Address">
                  </div>
                  <div class="col-md-4">
                    <input type="submit" class="btn btn-primary btn-block" value="Subscribe">
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>

    <?php
    require_once('footer.php');
    require_once('loader.php');
    ?>
    <script src="js/signup.js"></script>

</body>

</html>