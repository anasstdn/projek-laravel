<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Neon Admin Panel" />
    <meta name="author" content="" />

    <link rel="icon" href="{{asset('neon/')}}/html/neon/assets/images/favicon.ico">

    <title>Laravel 5.5 Project</title>

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

    <script src="{{asset('neon/')}}/html/neon/assets/js/jquery-1.11.3.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://skywalkapps.github.io/bootstrap-notifications/stylesheets/bootstrap-notifications.css">

    <!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


</head>
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
        {{-- <footer class="main">
            
            &copy; 2015 <strong>Neon</strong> Admin Theme by <a href="http://laborator.co" target="_blank">Laborator</a>
        
        </footer> --}}
    </div>

    
    
</div>


<!-- Bottom scripts (common) -->
<script src="{{asset('neon/')}}/html/neon/assets/js/gsap/TweenMax.min.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/bootstrap.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/joinable.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/resizeable.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/neon-api.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/jquery.validate.min.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/neon-login.js"></script>
<script src="{{asset('neon/')}}/html/neon/assets/js/datatables/datatables.js"></script>



<!-- Imported scripts on this page -->
    <script src="{{asset('neon/')}}/html/neon/assets/js/fileinput.js"></script>
    <script src="{{asset('neon/')}}/html/neon/assets/js/dropzone/dropzone.js"></script>
    <script src="{{asset('neon/')}}/html/neon/assets/js/neon-chat.js"></script>


<!-- JavaScripts initializations and stuff -->
<script src="{{asset('neon/')}}/html/neon/assets/js/neon-custom.js"></script>


<!-- Demo Settings -->
<script src="{{asset('neon/')}}/html/neon/assets/js/neon-demo.js"></script>
<script src="{{asset('js/')}}/moment.js"></script>
<script src="{{asset('js/')}}/echo.js"></script>
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
        function showAjaxModal()
        {
            jQuery('#modal-7').modal('show', {backdrop: 'static'});
            
            jQuery.ajax({
                url: "",
                success: function(response)
                {
                    jQuery('#modal-7 .modal-body').html(response);
                }
            });
        }
        </script>

  @yield('js')  
    @stack('js')
</body>
</html>