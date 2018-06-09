<!DOCTYPE html>
<!--
Template Name: Metronic - Responsive Admin Dashboard Template build with Twitter Bootstrap 3.3.6
Version: 4.6
Author: KeenThemes
Website: http://www.keenthemes.com/
Contact: support@keenthemes.com
Follow: www.twitter.com/keenthemes
Dribbble: www.dribbble.com/keenthemes
Like: www.facebook.com/keenthemes
Purchase: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
Renew Support: http://themeforest.net/item/metronic-responsive-admin-dashboard-template/4021469?ref=keenthemes
License: You must have a valid license purchased only from themeforest(the above link) in order to legally use the theme for your project.
-->
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
    <!--<![endif]-->
    <!-- BEGIN HEAD -->

    <head>
      <meta charset="utf-8" />
      <title>Health Care System | Maintenance</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta content="width=device-width, initial-scale=1" name="viewport" />
      <meta content="" name="description" />
      <meta content="" name="author" />
      <!-- BEGIN GLOBAL MANDATORY STYLES -->
      <link href="https://fonts.googleapis.com/css?family=Montserrat+Alternates:700|Pacifico" rel="stylesheet">
      <!-- <link href="{{ asset('metronic/') }}/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" /> -->
      <!-- <link href="{{ asset('metronic/') }}/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" /> -->
      <link href="{{ asset('metronic/') }}/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
      <!-- <link href="{{ asset('metronic/') }}/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" /> -->
      <!-- END GLOBAL MANDATORY STYLES -->
      <!-- BEGIN THEME GLOBAL STYLES -->
      <!-- <link href="{{ asset('metronic/') }}/global/css/components-md.min.css" rel="stylesheet" id="style_components" type="text/css" /> -->
      <!-- <link href="{{ asset('metronic/') }}/global/css/plugins-md.min.css" rel="stylesheet" type="text/css" /> -->
      <!-- END THEME GLOBAL STYLES -->
      <!-- BEGIN PAGE LEVEL STYLES -->
      <!-- <link href="{{ asset('metronic/') }}/pages/css/error.min.css" rel="stylesheet" type="text/css" /> -->
      <link href="{{ asset('custom/') }}/error-custom.css" rel="stylesheet" type="text/css" />
      <!-- END PAGE LEVEL STYLES -->
      <!-- BEGIN THEME LAYOUT STYLES -->
      <!-- END THEME LAYOUT STYLES -->
      <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->
    <body class="page-404-full-page">
        <div class="page-404 error">
            <div class="details">
              <img src="{{ asset('custom/error.png') }}" alt="404">
              <br/>
              <br/>
              <br/>
              <br/>
              <br/>
              <h3>Mohon maaf.</h3>
              <p> Sistem sedang dalam proses perbaikan.
                <br/>
                Silahkan ikuti tautan <a href="{{ url('/home') }}"> berikut </a> untuk kembali.
              </p>
              <p>
                Kode kesalahan yang muncul:<br/>
                <textarea style="resize:none" name="name" rows="4" cols="30" readonly="readonly">
                  {{-- {{ $exception->getMessage() }} --}}
                </textarea>
              </p>

            </div>
        </div>
    </body>
</html>
