<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/bootstrap/bootstrap.min.css" />
    <link href="css/theme.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="css/style2.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Jua&display=swap">
    <style>
        section{
            padding: 6.5rem 0;
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <section style="background-color:rgb(162, 223, 156);" class="hero-banner position-relative custom-pt-1 custom-pb-2 bg-dark"
            data-bg-img="assets/images/bg/02.png">
            <div class="container">
                <div class="row text-white text-center z-index-1">
                    <div class="col">
                        <h1 class="text-white">Log In</h1>
                    </div>
                </div>
            </div>
            <div class="shape-1 bottom">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 300">
                    <path fill="#fff" fill-opacity="1"
                        d="M0,288L48,288C96,288,192,288,288,266.7C384,245,480,203,576,208C672,213,768,267,864,245.3C960,224,1056,128,1152,96C1248,64,1344,96,1392,112L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                    </path>
                </svg>
            </div>
        </section>
        <div class="page-content">
            <section class="register">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 col-md-10 ms-auto me-auto">
                            <div class="register-form text-center">
                              <form id="contact-form" method="post" action="php/functions.php?op=login">
                                <div class="messages"></div>
                                <div class="form-group">
                                  <input id="form_name" type="email" value="<?php if(isset($_COOKIE['email'])){
                                    echo $_COOKIE['email'];
                                  }; ?>" name="name" class="form-control" placeholder="Email" required="required" data-error="Username is required.">
                                  <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group">
                                  <input id="form_password" type="password" value="<?php if(isset($_COOKIE['pass'])){
                                    echo $_COOKIE['pass'];
                                  }; ?>" name="password" class="form-control" placeholder="Password" required="required" data-error="password is required.">
                                  <div class="help-block with-errors"></div>
                                </div>
                                <div class="form-group mt-4 mb-5">
                                  <div class="remember-checkbox d-flex align-items-center justify-content-between">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" <?php if(isset($_COOKIE['email'])){
                                    echo 'checked';
                                  }; ?> name="remember" id="check1">
                                      <label class="form-check-label" for="check1">Remember me</label>
                                    </div> <a href="forget_password.php">Forgot Password?</a>
                                  </div>
                                </div> <button type="submit" class="btn btn-primary">Login Now</button>
                              </form>
                              <div class="d-flex align-items-center text-center justify-content-center mt-4"> <span class="text-muted me-1">Don't have an account?</span>
                                <a href="signup.php">Sign Up</a>
                              </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <script src="js/bootstrap/bootstrap.min.js"></script>
</body>

</html>