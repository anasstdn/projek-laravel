<!doctype html>
<html lang="en" class="no-focus">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

        <title>Laravel Forecast</title>

        <meta name="description" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
        <meta name="author" content="pixelcave">
        <meta name="robots" content="noindex, nofollow">

        <!-- Open Graph Meta -->
        <meta property="og:title" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework">
        <meta property="og:site_name" content="Codebase">
        <meta property="og:description" content="Codebase - Bootstrap 4 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
        <meta property="og:type" content="website">
        <meta property="og:url" content="">
        <meta property="og:image" content="">

        <!-- Icons -->
        <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
        <link rel="shortcut icon" href="{{asset('codebase/')}}/src/assets/media/favicons/favicon.png">
        <link rel="icon" type="image/png" sizes="192x192" href="{{asset('codebase/')}}/src/assets/media/favicons/favicon-192x192.png">
        <link rel="apple-touch-icon" sizes="180x180" href="{{asset('codebase/')}}/src/assets/media/favicons/apple-touch-icon-180x180.png">
        <!-- END Icons -->

        <!-- Stylesheets -->

        <!-- Fonts and Codebase framework -->
        <link rel="stylesheet" href="{{asset('codebase/')}}/src/assets/js/plugins/datatables/dataTables.bootstrap4.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Nunito+Sans:300,400,400i,600,700&display=swap">
        <link rel="stylesheet" id="css-main" href="{{asset('codebase/')}}/src/assets/css/codebase.min.css">

        <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
        <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/flat.min.css"> -->
        <link rel="stylesheet" id="css-theme" href="{{asset('codebase/')}}/src/assets/css/themes/corporate.min.css">
        <link href="{{asset('codebase/')}}/build/toastr.css" rel="stylesheet" type="text/css" />
        <link rel="stylesheet" href="{{asset('codebase/')}}/src/assets/js/plugins/select2/css/select2.min.css">
        <link rel="stylesheet" href="{{asset('codebase/')}}/src/assets/js/plugins/flatpickr/flatpickr.min.css">
        <link rel="stylesheet" href="{{ asset('neon/') }}/bootstrap-datepicker/bootstrap-datepicker.css">
        <!-- END Stylesheets -->
    </head>
    <body>

        <!-- Page Container -->
        <!--
            Available classes for #page-container:

        GENERIC

            'enable-cookies'                            Remembers active color theme between pages (when set through color theme helper Template._uiHandleTheme())

        SIDEBAR & SIDE OVERLAY

            'sidebar-r'                                 Right Sidebar and left Side Overlay (default is left Sidebar and right Side Overlay)
            'sidebar-mini'                              Mini hoverable Sidebar (screen width > 991px)
            'sidebar-o'                                 Visible Sidebar by default (screen width > 991px)
            'sidebar-o-xs'                              Visible Sidebar by default (screen width < 992px)
            'sidebar-inverse'                           Dark themed sidebar

            'side-overlay-hover'                        Hoverable Side Overlay (screen width > 991px)
            'side-overlay-o'                            Visible Side Overlay by default

            'enable-page-overlay'                       Enables a visible clickable Page Overlay (closes Side Overlay on click) when Side Overlay opens

            'side-scroll'                               Enables custom scrolling on Sidebar and Side Overlay instead of native scrolling (screen width > 991px)

        HEADER

            ''                                          Static Header if no class is added
            'page-header-fixed'                         Fixed Header

        HEADER STYLE

            ''                                          Classic Header style if no class is added
            'page-header-modern'                        Modern Header style
            'page-header-inverse'                       Dark themed Header (works only with classic Header style)
            'page-header-glass'                         Light themed Header with transparency by default
                                                        (absolute position, perfect for light images underneath - solid light background on scroll if the Header is also set as fixed)
            'page-header-glass page-header-inverse'     Dark themed Header with transparency by default
                                                        (absolute position, perfect for dark images underneath - solid dark background on scroll if the Header is also set as fixed)

        MAIN CONTENT LAYOUT

            ''                                          Full width Main Content if no class is added
            'main-content-boxed'                        Full width Main Content with a specific maximum width (screen width > 1200px)
            'main-content-narrow'                       Full width Main Content with a percentage width (screen width > 1200px)
        -->
        <div id="page-container" class="sidebar-inverse side-scroll page-header-fixed page-header-glass page-header-inverse main-content-boxed">


         @include('layouts.header')

            <!-- Main Container -->
            <main id="main-container">
            <meta name="csrf-token" content="{{ csrf_token() }}">
            @yield('content')

                <!-- Header -->
             

            </main>
            <!-- END Main Container -->

            <!-- Footer -->
            <footer id="page-footer" class="bg-white opacity-0">
                <div class="content py-20 font-size-sm clearfix">
                    <div class="float-right">
                        by Anas Setyadin</a>
                    </div>
                    <div class="float-left">
                        <a class="font-w600" href="https://1.envato.market/95j" target="_blank">Laravel Forecast v.2.0.0</a> &copy; <span class="">2020</span>
                    </div>
                </div>
            </footer>
            <!-- END Footer -->
        </div>
        <!-- END Page Container -->

        <!--
            Codebase JS Core

            Vital libraries and plugins used in all pages. You can choose to not include this file if you would like
            to handle those dependencies through webpack. Please check out assets/_es6/main/bootstrap.js for more info.

            If you like, you could also include them separately directly from the assets/js/core folder in the following
            order. That can come in handy if you would like to include a few of them (eg jQuery) from a CDN.

            assets/js/core/jquery.min.js
            assets/js/core/bootstrap.bundle.min.js
            assets/js/core/simplebar.min.js
            assets/js/core/jquery-scrollLock.min.js
            assets/js/core/jquery.appear.min.js
            assets/js/core/jquery.countTo.min.js
            assets/js/core/js.cookie.min.js
        -->
        <script src="{{asset('codebase/')}}/src/assets/js/codebase.core.min.js"></script>

        <!--
            Codebase JS

            Custom functionality including Blocks/Layout API as well as other vital and optional helpers
            webpack is putting everything together at assets/_es6/main/app.js
        -->
        <script src="{{asset('codebase/')}}/src/assets/js/codebase.app.min.js"></script>

        <!-- Page JS Plugins -->
        <script src="{{asset('codebase/')}}/src/assets/js/plugins/chartjs/Chart.bundle.min.js"></script>
        <script src="{{asset('codebase/')}}/src/assets/js/plugins/select2/js/select2.full.min.js"></script>
        <script src="{{asset('neon/')}}/html/neon/assets/js/toastr.js"></script>

        <!-- Page JS Code -->
        <script src="{{asset('codebase/')}}/src/assets/js/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="{{asset('codebase/')}}/src/assets/js/sweetalert.min.js"></script>
        <script src="{{asset('codebase/')}}/src/assets/js/plugins/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page JS Code -->
        <script src="{{asset('codebase/')}}/src/assets/js/pages/be_tables_datatables.min.js"></script>
         <script src="{{asset('codebase/')}}/src/assets/js/plugins/jquery-validation/jquery.validate.min.js"></script>
        <script src="{{asset('codebase/')}}/src/assets/js/pages/db_corporate.min.js"></script>
        <script src="{{asset('codebase/')}}/src/assets/js/plugins/flatpickr/flatpickr.min.js"></script>
        <script src="{{ asset('neon/') }}/bootstrap-datepicker/bootstrap-datepicker.js"></script>

        <script src="{{asset('codebase/')}}/src/assets/apexcharts/apexcharts.js"></script>
        <script src="{{asset('codebase/')}}/src/assets/apexcharts/apex-custom-script.js"></script>
        

        <script src="{{asset('js/')}}/moment.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment-timezone/0.5.13/moment-timezone-with-data.min.js"></script>
        <script src="{{asset('js/')}}/echo.js"></script>
        <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/crypto-js/4.0.0/crypto-js.min.js"></script>
        <script src="{{asset('js/')}}/Encryption.js"></script>

        <script type="text/javascript">
          var notificationsWrapper   = $('.notifications');
          var notificationsToggle    = notificationsWrapper.find('a[data-toggle]');
          var notificationsCountElem = notificationsToggle.find('i[data-count]');
          var notificationsCount     = parseInt(notificationsCountElem.data('count'));
          var notifications          = notificationsWrapper.find('ul.dropdown-menu-list');


    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('985705c222cb4b13a227', {
      cluster: 'ap3',
      forceTLS: true
    });

    // Subscribe to the channel we specified in our Laravel Event
    var channel = pusher.subscribe('{{Auth::user()->id}}');

    // Bind a function to a Event (the full Laravel class)
    channel.bind('send-message', function(data) {
      console.log(data);
      var existingNotifications = notifications.html();
      var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
      var newNotificationHtml = `
      <li class="notification-info">
      <a href="#">
      <i class="pull-right"><img src="https://api.adorable.io/avatars/71/`+avatar+`.png" class="img-circle" alt="25x25" style="width: 25px; height: 25px;"></i>

      <span class="line">
      `+data.title+`
      </span>

      <span class="line small">
      `+data.content+`
      </span>
      <span class="line small" id="time_`+notificationsCount+`">
      `+dateToHowManyAgo(data.timestamp,notificationsCount)+`
      </span>
      </a>
      </li>
      `;
      notifications.html(newNotificationHtml + existingNotifications);

      notificationsCount += 1;
      notificationsCountElem.attr('data-count', notificationsCount);
      notificationsWrapper.find('.info').text(notificationsCount);
      notificationsWrapper.find('.data-count').text(notificationsCount);
      notificationsWrapper.show();
    });

    function get_notification()
    {
      $.ajax({
        url   : '{{url('home/get-notif')}}',
        type  : 'GET',
        async : true,
        dataType : 'json',
        success : function(data){
          for(let i=0;i<data.data.length;i++)
          {
            var existingNotifications = notifications.html();
            var avatar = Math.floor(Math.random() * (71 - 20 + 1)) + 20;
            var newNotificationHtml = `
            <li class="notification-info">
            <a href="#">
            <i class="pull-right"><img src="https://api.adorable.io/avatars/71/`+avatar+`.png" class="img-circle" alt="25x25" style="width: 25px; height: 25px;"></i>

            <span class="line">
            `+data.data[i].title+`
            </span>

            <span class="line small">
            `+data.data[i].content+`
            </span>
            <span class="line small" id="time_`+(i)+`">
            `+
            dateToHowManyAgo(data.data[i].created_at,(i))+`
            </span>
            </a>
            </li>
            `;
            notifications.html(newNotificationHtml + existingNotifications);
            notificationsCount += 1;
            notificationsCountElem.attr('data-count', notificationsCount);
            notificationsWrapper.find('.info').text(notificationsCount);
            notificationsWrapper.find('.data-count').text(notificationsCount);
            notificationsWrapper.show();
          }
        },
        error:function (xhr, status, error){
          alert(xhr.responseText);
        },
      });
    }

    function dateToHowManyAgo(stringDate,id){
      var dateTime = new Date(stringDate);
      var timestamp = moment(dateTime, 'ddd MMM DD YYYY HH:mm:ss GMT Z').fromNow();
      return timestamp;
    }

    $(document).ready(function(){
    // setTimeout(function(){
     get_notification();
    // }, 500);

  })



</script>
<script type="text/javascript">

  @if ($errors->any())
  @foreach ($errors->all() as $error)
  toastr_notif("{!! $error !!}","gagal");
  @endforeach
  @endif
  @if(Session::get('messageType'))
  toastr_notif("{!! Session::get('message') !!}","{!! Session::get('messageType') !!}");
  <?php
  Session::forget('messageType');
  Session::forget('message');
  ?>
  @endif

function show_modal(url) { // clear error string
  $.ajax({
    url:url,
    dataType: 'text',
    success: function(data) {
      $("#formModal").html(data);
      $("#formModal").modal('show');
        // todo:  add the html to the dom...
      }
    });
};

function delete_data(url) { // clear error string
  $.ajax({
    url:url,
    dataType: 'text',
    success: function(data) {
      $("#formModal1").html(data);
      $("#formModal1").modal('show');
        // todo:  add the html to the dom...
      }
    });
};

// function notification( message,type ) {
//   if( type == 'success' ) {
//         toastr.success(message,'<i>Success</i>');
//     } else if( type == 'error' ) {
//         toastr.error(message,'error');
//     } else if( type == 'warning' ) {
//         toastr.warning(message,'Warning');
//     } else {
//         toastr.info(message,'Information');
//     }
// };

function toastr_notif(message,type)
{
  if(type=='sukses')
  {
    var opts = {
      "closeButton": true,
      "debug": false,
      "positionClass": "toast-top-right",
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };

    toastr.success(message, "Berhasil", opts);
  }
  else
  {
    var opts = {
      "closeButton": true,
      "debug": false,
      "positionClass": "toast-top-right",
      "onclick": null,
      "showDuration": "300",
      "hideDuration": "1000",
      "timeOut": "5000",
      "extendedTimeOut": "1000",
      "showEasing": "swing",
      "hideEasing": "linear",
      "showMethod": "fadeIn",
      "hideMethod": "fadeOut"
    };

    toastr.warning(message, 'Peringatan', opts);
  }
}

function uploadProgressHandler(event) {
    // $("#loaded_n_total").html("Uploaded " + event.loaded + " bytes of " + event.total);
    var percent = (event.loaded / event.total) * 100;
    var progress = Math.round(percent);
    $("#percent").html(progress + "%");
    $(".progress-bar").css("width", progress + "%");
    $("#status").html(progress + "% uploaded... please wait");
  }

  function loadHandler(event) {
    $("#status").html('Load Completed');
    setTimeout(function(){
      $('.ajax-loader').fadeOut()
      $("#percent").html("0%");
      $(".progress-bar").css("width", "100%");
    }, 500);
  }

  function errorHandler(event) {
    $("#status").html("Send Data Failed");
  }

  function abortHandler(event) {
    $("#status").html("Send Data Aborted");
  }



var tday=["Sun","Mon","Tue","Wed","Thru","Fri","Sat"];
var tmonth=["January","February","March","April","May","June","July","August","September","October","November","December"];

  function GetClock(){
    var d=new Date();
    // console.log(moment().tz(''));
    var nday=d.getDay(),nmonth=d.getMonth(),ndate=d.getDate(),nyear=d.getFullYear();
    var nhour=d.getHours(),nmin=d.getMinutes(),nsec=d.getSeconds();
    if(nmin<=9) nmin="0"+nmin;
    if(nsec<=9) nsec="0"+nsec;

    var clocktext=""+tday[nday]+", "+ndate+" "+tmonth[nmonth]+" "+nyear+" "+nhour+":"+nmin+":"+nsec+"";
    document.getElementById('clockbox').innerHTML=clocktext;
  }

  GetClock();
  setInterval(GetClock,1000);

  function hapus(url) { // clear error string
    var token = $("meta[name='csrf-token']").attr("content");
    swal({
      title: "Are you sure?",
      text: "Once deleted, you will not be able to recover this file!",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
          // swal("Poof! Your imaginary file has been deleted!", {
          //   icon: "success",
          // });
          $.ajax({
            url : url,
            type: 'DELETE',
            headers: {
              'X-CSRF-TOKEN': token
            },
            success:function(){
              swal('Data Berhasil Dihapus', ' ', 'success');

              setTimeout(function() {
  //your code to be executed after 1 second
  location.reload();
}, 1000);
            },
          });
        } else {
          swal("Delete is canceled");
        }
      });
  }
  function reset_password(url) { // clear error string
    var token = $("meta[name='csrf-token']").attr("content");
    swal({
      title: "Password Reset?",
      text: "Are you sure to reset the password?",
      icon: "warning",
      buttons: true,
      dangerMode: true,
    })
    .then((willDelete) => {
      if (willDelete) {
          // swal("Poof! Your imaginary file has been deleted!", {
          //   icon: "success",
          // });
          $.ajax({
            url : url,
            type: 'GET',
            headers: {
              'X-CSRF-TOKEN': token
            },
            success:function(){
              swal('Password Berhasil Direset', ' ', 'success');

              setTimeout(function() {
  //your code to be executed after 1 second
  location.reload();
}, 1000);
            },
          });
        } else {
          swal("Reset is canceled");
        }
      });
  }
</script>

@yield('js')  
@stack('js')
    </body>
</html>