<!DOCTYPE html>
<html>
<head>
    <title>Signin</title>
    <!--Import Google Icon Font-->
    <link href="http://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url('assets/materialize/css/materialize.min.css'); ?>" media="screen,projection" />
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>
 
<body class="grey lighten-4">
    <div class="container">
        <div class="row">
            <div class="col s12 m5 offset-m3">
                <h4 class="center">Please sign in...</h4>
                <a href="<?php echo site_url('auth/log_with_google') ?>"><img src="<?php echo base_url('assets/images/btn-login-with-google.png') ?>" width="100%"></a>
                <p class="center">Or<br>Sign with existing account</p>
 
                <div class="card-panel">
                Ops akun tidak ditemukan
                </div>
 
                <div class="card">
                    <div class="card-content">
                        <div class="row">
                            <form class="col s12">
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="email" type="email" class="validate">
                                        <label for="email" data-error="wrong" data-success="right">Email</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="input-field col s12">
                                        <input id="password" type="password" class="validate">
                                        <label for="password">Password</label>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col s12">
                                        <button class="btn waves-effect waves-light btn-large" type="submit">Login</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--Import jQuery before materialize.js-->
    <script type="text/javascript" src="https://code.jquery.com/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/materialize/js/materialize.min.js') ?>"></script>
</body>
</html>