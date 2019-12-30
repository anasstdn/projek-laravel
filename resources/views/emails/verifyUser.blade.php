<!DOCTYPE html>
<html lang="en">
    <link href="http://steveville.org/assets/css/cosmo.css" rel="stylesheet" type="text/css" media="all" />  
    <body style="background-color: #ccc;">
        <div class="maincontent" style="background-color: #FFF; margin: auto; padding: 20px; width: 450px; border-top: 2px solid #27ae60;border-bottom:2px solid #27ae60">
            <div class="text-center">
                <h1>Dear {{$user['name']}}</h1>
                <p>Welcome to the [site name] website!</p>
                <p>
                    Your registered email-id is {{$user['email']}}, please click on the below link to verify your email account
                </p>
                <p>If this was you, please finish the registration process by confirming your email below.</p>
                <p><a class="btn btn-success btn-lg" href="{{url('user/verify',$user->verifyUser->token)}}"><i class="fa fa-check"></i> CONFIRM E-MAIL</a></p>

                <p>If you did not register for our website, please ignore this email.</p>
            </div>
        </div>
    </body>
</html>
