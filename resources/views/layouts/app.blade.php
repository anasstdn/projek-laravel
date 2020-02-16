<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="" />

    <link rel="icon" href="{{asset('neon/')}}/html/neon/assets/images/favicon.ico">

    <title>Laravel Forecast</title>

    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/css/font-icons/entypo/css/entypo.css">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/css/bootstrap.css">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/css/neon-core.css">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/css/neon-theme.css">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/css/neon-forms.css">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/css/custom.css">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/js/datatables/datatables.css">
    <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/css/skins/green.css">
    {{-- <link rel="stylesheet" href="{{asset('neon/')}}/html/neon/assets/js/daterangepicker/daterangepicker-bs3.css"> --}}

    <script src="{{asset('neon/')}}/html/neon/assets/js/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://skywalkapps.github.io/bootstrap-notifications/stylesheets/bootstrap-notifications.css">

    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
    <style>
[type="radio"]:checked,
[type="radio"]:not(:checked) {
    position: absolute;
    left: -9999px;
}
[type="radio"]:checked + label,
[type="radio"]:not(:checked) + label
{
    position: relative;
    padding-left: 28px;
    cursor: pointer;
    line-height: 20px;
    display: inline-block;
    color: #666;
}
[type="radio"]:checked + label:before,
[type="radio"]:not(:checked) + label:before {
    content: '';
    position: absolute;
    left: 0;
    top: 0;
    width: 18px;
    height: 18px;
    border: 1px solid #ddd;
    border-radius: 100%;
    background: #fff;
}
[type="radio"]:checked + label:after,
[type="radio"]:not(:checked) + label:after {
    content: '';
    width: 12px;
    height: 12px;
    background: #4CAF50;
    position: absolute;
    top: 4px;
    left: 4px;
    border-radius: 100%;
    -webkit-transition: all 0.2s ease;
    transition: all 0.2s ease;
}
[type="radio"]:not(:checked) + label:after {
    opacity: 0;
    -webkit-transform: scale(0);
    transform: scale(0);
}
[type="radio"]:checked + label:after {
    opacity: 1;
    -webkit-transform: scale(1);
    transform: scale(1);
}



</style>
<body class="page-body page-fade gray" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
    
    @include('layouts.sidebar')

    <div class="main-content">
        @include('layouts.header')
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @yield('content')
                {{-- <h2>Here starts everything...</h2> --}}
        
        <br />
        
        <!-- lets do some work here... -->
        <!-- Footer -->
        <footer class="main">
            
            <center>Laravel Forecast <strong>v.1.0.3</strong> by Anas Setyadin<br/><strong>Copyright &copy; 2020</strong></center>
        
        </footer>
    </div>

    
    
</div>


<!-- Bottom scripts (common) -->
<script src="{{asset('neon/')}}/html/neon/assets/js/gsap/TweenMax.min.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/datatables/datatables.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/bootstrap.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/joinable.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/resizeable.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/neon-api.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/jquery.validate.min.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/neon-login.js"></script>



<!-- Imported scripts on this page -->
    <script src="{{asset('neon/')}}/html/neon/assets/js/toastr.js"></script>
    <script src="{{asset('neon/')}}/html/neon/assets/js/fileinput.js"></script>
    <script src="{{asset('neon/')}}/html/neon/assets/js/dropzone/dropzone.js"></script>
    <script src="{{asset('neon/')}}/html/neon/assets/js/neon-chat.js"></script>
    <script src="{{asset('neon/')}}/html/neon/assets/js/icheck/icheck.min.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="{{asset('neon/')}}/html/neon/assets/js/neon-custom.js"></script>


<!-- Demo Settings -->
<script src="{{asset('neon/')}}/html/neon/assets/js/neon-demo.js"></script>
<script src="{{asset('js/')}}/moment.js"></script>
<script src="{{asset('js/')}}/echo.js"></script>
{{-- <script src="{{asset('neon/')}}/html/neon/assets/js/daterangepicker/daterangepicker.js"></script> --}}
<script src="https://js.pusher.com/5.0/pusher.min.js"></script>

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

</script>

  @yield('js')  
    @stack('js')
</body>
</html>