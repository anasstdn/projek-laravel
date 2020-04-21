<!-- Modal 7 (Ajax Modal)-->

<div class="modal-dialog modal-lg" role="document" style="font-family: sans-serif;">
	<div class="modal-content">
		<form method="post" id="form" action="#" enctype="multipart/form-data">
			{{ csrf_field() }}
			 <div class="block block-themed block-transparent mb-0">
			 	<div class="block-header bg-primary-dark">
                            <h3 class="block-title">{{isset($user) && $user->exists()? __("form.add"): __('form.edit')}} {{ __('form.user') }}</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" id="mode" name="mode" value="{{isset($user) && $user->exists()?'edit':'add'}}">
			<input type="hidden" id="id" value="{{isset($user) && $user->exists()?$user->id:''}}">
			<div class="modal-body">
				<div class="form-group row" style="margin-bottom: 1.429rem;">
					<label class="col-form-label col-md-3">{{ __('form.name') }}</label>
					<div class="col-md-7">
						<input type="text" class="form-control form-control-sm" id="nama" name="nama" value="{{(isset($user) && $user->exists)?isset($user->name)?$user->name:'':''}}">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group row" style="margin-bottom: 1.429rem;">
					<label class="col-form-label col-md-3">{{ __('form.username') }}</label>
					<div class="col-md-7">
						<input type="text" class="form-control form-control-sm" id="username" name="username" value="{{(isset($user) && $user->exists)?isset($user->username)?$user->username:'':''}}">
						<span class="help-block"></span>
					</div>
					<span class="col-md-1 help-block" id="message"></span>
				</div>
				<div class="form-group row" style="margin-bottom: 1.429rem;">
					<label class="col-form-label col-md-3">{{ __('form.email') }}</label>
					<div class="col-md-7">
						<input type="text" class="form-control form-control-sm" id="email" name="email" value="{{(isset($user) && $user->exists)?isset($user->email)?$user->email:'':''}}">
						<span class="help-block"></span>
					</div>
					<span class="col-md-1 help-block" id="message1"></span>
				</div>
				<div class="form-group row" style="margin-bottom: 1.429rem;">
					<label class="col-form-label col-md-3">{{ __('form.password') }}</label>
					<div class="col-md-7">
						<input type="password" class="form-control form-control-sm" id="password" name="password" value="">
						<span class="help-block"></span>
					</div>
				</div>
		{{-- 		<div class="form-group row" style="margin-bottom: 1.429rem;">
					<label class="col-form-label col-md-3">Password Baru</label>
					<div class="col-md-7">
						<input type="password" class="form-control" id="password_new" name="password_new" value="">
						<span class="help-block"></span>
					</div>
				</div> --}}
				<div class="form-group row" style="margin-bottom: 1.429rem;">
					<label class="col-form-label col-md-3">{{ __('form.role') }}</label>
					<div class="col-md-7">
						<select class="select2 form-control" name="roles" id="roles" style="width: 100%;" data-placeholder="Select Roles">
							<option value="">-Silahkan Pilih-</option><!-- Required for data-placeholder attribute to work with Select2 plugin -->
							@foreach($role as $r)
							<option value="{{$r->id}}" {{isset($user->roleUser->role_id) && $user->roleUser->role_id==$r->id?'selected':''}}>{{$r->display_name}}</option>
							@endforeach
						</select>
						<span class="help-block"></span>
					</div>
				</div>

				<div class="form-group row" style="margin-bottom: 1.429rem;"> <label
					class="col-form-label col-md-3">{{ __('form.verified') }}</label> <div class="col-md-7">
						{{-- <p> <input type="radio" id="test1" name="verified" value="1" {{isset($user->verified) && $user->verified=='1'?'checked':''}}>
							<label for="test1">TRUE</label> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <input
							type="radio" id="test2" name="verified" value="0" {{isset($user->verified) && $user->verified=='0'?'checked':''}}> <label
							for="test2">FALSE</label> </p>  --}}
							<div class="col-6">
                                            <label class="css-control css-control-primary css-radio">
                                                <input type="radio" class="css-control-input" name="verified" value="1" id="test1" {{isset($user->verified) && $user->verified=='1'?'checked':''}}>
                                                <span class="css-control-indicator"></span> {{ __('form.true') }}
                                            </label>
                                            <label class="css-control css-control-primary css-radio">
                                                <input type="radio" class="css-control-input"  name="verified" value="0" id="test2" {{isset($user->verified) && $user->verified=='0'?'checked':''}}>
                                                <span class="css-control-indicator"></span> {{ __('form.false') }}
                                            </label>
                                        </div>
							<span class="help-block" id="radio_a"></span> </div>
						</div>
					</div>
			 </div>
		{{-- 	<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold">{{isset($user) && $user->exists()?'Edit':'Add'}} Users</h4>
			</div> --}}

			
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">{{ __('button.close') }}</button>
						<button type="submit" id="simpan" class="btn btn-info btn-sm">{{ __('button.save') }}</button>
					</div>
				</form>
			</div>
		</div>

<script type="text/javascript">
	var status=false;
	var email=false;
	var username=false;
	$(document).ready(function(){
		  $(".select2").select2({
        dropdownParent: $("#form"),
        width: '100%'
      });

	$.validator.addMethod("noSpace", function(value, element) { 
		return value.indexOf(" ") < 0 && value != ""; 
	}, "{{ __('alert.not_space') }}");

		  $('#form').validate({
            ignore: [],
             button: {
            selector: "#simpan",
            disabled: "disabled"
        },
       		debug: false,
            errorClass: 'invalid-feedback',
            errorElement: 'div',
            errorPlacement: (error, e) => {
                jQuery(e).parents('.form-group > div').append(error);
            },
            highlight: e => {
                jQuery(e).closest('.form-group').removeClass('is-invalid').addClass('is-invalid');
            },
            success: e => {
                jQuery(e).closest('.form-group').removeClass('is-invalid');
                jQuery(e).remove();
            },
            rules: {
            	'nama': {
                    required: true,
                    minlength: 1,
                    maxlength: 100,
                },
                'username': {
                	required: true,
                	noSpace: true,     
                	remote: {
                		url: "user/check-username",
                		type: "post",
                		data: {
                			"_token": "{{ csrf_token() }}",
                			username: function()
                          {
                              return $('#form :input[name="username"]').val();
                          },
                          mode: function()
                          {
                              return $('#form :input[name="mode"]').val();
                          }
                		},
                		beforeSend: function () {
                			$('.ajax-loader').fadeIn();
                			$("#status").html("{{ __('alert.loading') }}");
         					$('#loader').css('width','100%');
                		},
                		dataFilter: function (data) {
                			// console.log(data);
                			var json = JSON.parse(data);
                			$('.ajax-loader').fadeOut();
                			if (json.msg == "true") {
                				toastr.warning('{{ __('alert.username_confirm') }}','{{ __('alert.warning') }}')
                				return "\"" + "{{ __('alert.username_confirm') }}" + "\"";
                			} else {
                				toastr.success('{{ __('alert.username_available') }}','{{ __('alert.message') }}');
                				return 'true';
                			}
                		}
                	}
                }, 
                 'email': {
                	required: true,     
                	email:true,
                	remote: {
                		url: "user/check-email",
                		type: "post",
                		data: {
                			"_token": "{{ csrf_token() }}",
                			email_username: function()
                          {
                              return $('#form :input[name="email"]').val();
                          },
                          mode: function()
                          {
                              return $('#form :input[name="mode"]').val();
                          }
                		},
                		beforeSend: function () {
                			$('.ajax-loader').fadeIn();
                			$("#status").html("{{ __('alert.loading') }}");
         					$('#loader').css('width','100%');
                		},
                		dataFilter: function (data) {
                			// console.log(data);
                			var json = JSON.parse(data);
                			$('.ajax-loader').fadeOut();
                			if (json.msg == "true") {
                				toastr.warning('{{ __('alert.email_confirm') }}','{{ __('alert.warning') }}')
                				return "\"" + "{{ __('alert.email_confirm') }}" + "\"";
                			} else {
                				toastr.success('{{ __('alert.email_available') }}','{{ __('alert.message') }}');
                				return 'true';
                			}
                		}
                	}
                },
                'password': {
                    required: true,
                    minlength: 8,
                },
                'roles': {
                    required: true,
                },
                'verified': {
                    required: true,
                },
            },
            messages: {
            	'nama': {
                    required: '{{ __('alert.required') }}',
                    minlength: '{{ __('alert.lim') }} 1',
                    maxlength: '{{ __('alert.lim') }} 100',
                },
                'username': {
                    required: '{{ __('alert.required') }}',
                    remote: $.validator.format("{0} is already taken.")
                },
                'email': {
                    required: '{{ __('alert.required') }}',
                    remote: $.validator.format("{0} is already taken."),
                    email:"{{ __('alert.email') }}"
                },
                'password': {
                    required: '{{ __('alert.required') }}',
                    minlength: '{{ __('alert.lim') }} 8',
                },
                'roles': {
                    required: '{{ __('alert.required') }}',
                },
                'verified': {
                   	required: '{{ __('alert.required') }}',
                },
            }
        });

	$('input').on('focus focusout keyup', function () {
		$(this).valid();
	});

	$("select").on("select2:close", function (e) {  
        $(this).valid(); 
    });

    if($('#mode').val()=='edit')
    {
    	$('#password').rules('remove', 'required');
    }


    $('#form').submit('#simpan',function(e){
    	e.preventDefault();
    	if($(e.currentTarget).valid()==true)
    	{
    		post_data();
    	}
    })

});

	// 	$('#form').find('#nama').bind('keyup change',function(){
	// 		if (!$.trim($(this).val())) 
	// 		{
	// 			$(this).next().fadeIn();
	// 			$(this).next().html('Silahkan isi data');
	// 			$(this).next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$(this).css({"border-color": "red", 
	// 				"border-width":"1px", 
	// 				"border-style":"solid"});
	// 			$('#simpan').addClass('disabled');
	// 			$('#simpan').attr('disabled',true);
	// 			$('#simpan').css({'opacity':'0.3'});
	// 			status=false;
	// 		}
	// 		else
	// 		{
	// 			$(this).next().fadeOut();
	// 			$(this).next().html('');
	// 			$(this).next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$(this).css({"border": ""});
	// 			$('#simpan').removeClass('disabled');
	// 			$('#simpan').attr('disabled',false);
	// 			$('#simpan').css({'opacity':'1'});
	// 			status=true;
	// 		}
	// 	})

	// 	$('#form').find('#username').bind('keyup change',function(){
	// 		if (!$.trim($(this).val())) 
	// 		{
	// 			$(this).next().fadeIn();
	// 			$(this).next().html('Silahkan isi data');
	// 			$(this).next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$(this).css({"border-color": "red", 
	// 				"border-width":"1px", 
	// 				"border-style":"solid"});
	// 			$('#simpan').addClass('disabled');
	// 			$('#simpan').attr('disabled',true);
	// 			$('#simpan').css({'opacity':'0.3'});
	// 			status=false;
	// 		}
	// 		else
	// 		{
	// 			$(this).next().fadeOut();
	// 			$(this).next().html('');
	// 			$(this).next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$(this).css({"border": ""});
	// 			$('#simpan').removeClass('disabled');
	// 			$('#simpan').attr('disabled',false);
	// 			$('#simpan').css({'opacity':'1'});
	// 			status=true;
	// 		}
	// 	})

	// 	$('#form').find('#email').bind('keyup change',function(){
	// 		if (!$.trim($(this).val())) 
	// 		{
	// 			$(this).next().fadeIn();
	// 			$(this).next().html('Silahkan isi data');
	// 			$(this).next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$(this).css({"border-color": "red", 
	// 				"border-width":"1px", 
	// 				"border-style":"solid"});
	// 			$('#simpan').addClass('disabled');
	// 			$('#simpan').attr('disabled',true);
	// 			$('#simpan').css({'opacity':'0.3'});
	// 			status=false;
	// 		}
	// 		else
	// 		{
	// 			$(this).next().fadeOut();
	// 			$(this).next().html('');
	// 			$(this).next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$(this).css({"border": ""});
	// 			$('#simpan').removeClass('disabled');
	// 			$('#simpan').attr('disabled',false);
	// 			$('#simpan').css({'opacity':'1'});
	// 			status=true;
	// 		}
	// 	})

	// 	$('#form').find('#password').bind('keyup change',function(){
	// 		if (!$.trim($(this).val())) 
	// 		{
	// 			$(this).next().fadeIn();
	// 			$(this).next().html('Silahkan isi data');
	// 			$(this).next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$(this).css({"border-color": "red", 
	// 				"border-width":"1px", 
	// 				"border-style":"solid"});
	// 			$('#simpan').addClass('disabled');
	// 			$('#simpan').attr('disabled',true);
	// 			$('#simpan').css({'opacity':'0.3'});
	// 			status=false;
	// 		}
	// 		else
	// 		{
	// 			if($(this).val().length<8)
	// 			{
	// 				$(this).next().fadeIn();
	// 				$(this).next().html('Karakter minimal 8');
	// 				$(this).next().css({"color":"red",
	// 					"font-size":"11px",
	// 					"font-family":"arial"});
	// 				$(this).css({"border-color": "red", 
	// 					"border-width":"1px", 
	// 					"border-style":"solid"});
	// 				$('#simpan').addClass('disabled');
	// 				$('#simpan').attr('disabled',true);
	// 				$('#simpan').css({'opacity':'0.3'});
	// 				status=false;
	// 			}
	// 			else
	// 			{
	// 				$(this).next().fadeOut();
	// 				$(this).next().html('');
	// 				$(this).next().css({"color":"red",
	// 					"font-size":"11px",
	// 					"font-family":"arial"});
	// 				$(this).css({"border": ""});
	// 				$('#simpan').removeClass('disabled');
	// 				$('#simpan').attr('disabled',false);
	// 				$('#simpan').css({'opacity':'1'});
	// 				status=true;
	// 			}
	// 		}
			
	// 	})

	// 	$('#form').find('#roles').bind('keyup change',function(){
	// 		if (!$.trim($(this).val())) 
	// 		{
	// 			$(this).next().next().fadeIn();
	// 			$(this).next().next().html('Silahkan isi data');
	// 			$(this).next().next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$(this).css({"border-color": "red", 
	// 				"border-width":"1px", 
	// 				"border-style":"solid"});
	// 			$('#simpan').addClass('disabled');
	// 			$('#simpan').attr('disabled',true);
	// 			$('#simpan').css({'opacity':'0.3'});
	// 			status=false;
	// 		}
	// 		else
	// 		{
	// 			$(this).next().next().fadeOut();
	// 			$(this).next().next().html('');
	// 			$(this).next().next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$(this).css({"border": ""});
	// 			$('#simpan').removeClass('disabled');
	// 			$('#simpan').attr('disabled',false);
	// 			$('#simpan').css({'opacity':'1'});
	// 			status=true;
	// 		}
	// 	})

	// 	$('#form').find('input[type="radio"][name=verified]').bind('keyup change',function(){
	// 		if (!$.trim($(this).val())) 
	// 		{
	// 			$('#radio_a').fadeIn();
	// 			$('#radio_a').html('Silahkan isi data');
	// 			$('#radio_a').css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$('input[type="radio"][name=verified]').css({"border-color": "red", 
	// 				"border-width":"1px", 
	// 				"border-style":"solid"});
	// 			$('#simpan').addClass('disabled');
	// 			$('#simpan').attr('disabled',true);
	// 			$('#simpan').css({'opacity':'0.3'});
	// 			status=false;
	// 		}
	// 		else
	// 		{
	// 			$('#radio_a').fadeOut();
	// 			$('#radio_a').html('');
	// 			$('#radio_a').css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$('input[type="radio"][name=verified]').css({"border": ""});
	// 			$('#simpan').removeClass('disabled');
	// 			$('#simpan').attr('disabled',false);
	// 			$('#simpan').css({'opacity':'1'});
	// 			status=true;
	// 		}
	// 	})

	// 	$('#form').submit('#simpan',function(e){
	// 		e.preventDefault();
	// 		if($('#nama').val()=='')
	// 		{
	// 			$('#nama').next().fadeIn();
	// 			$('#nama').next().html('Silahkan isi data');
	// 			$("#nama").next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$('#nama').css({"border-color": "red", 
	// 				"border-width":"1px", 
	// 				"border-style":"solid"});
	// 			$('#simpan').addClass('disabled');
	// 			$('#simpan').attr('disabled',true);
	// 			$('#simpan').css({'opacity':'0.3'});
	// 		}
	// 		else
	// 		{
	// 			$('#nama').next().fadeOut();
	// 			$('#nama').next().html('');
	// 			$("#nama").next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$('#nama').css({"border": ""});
	// 			$('#simpan').removeClass('disabled');
	// 			$('#simpan').attr('disabled',false);
	// 			$('#simpan').css({'opacity':'1'});
	// 		}

	// 		if($('#username').val()=='')
	// 		{
	// 			$('#username').next().fadeIn();
	// 			$('#username').next().html('Silahkan isi data');
	// 			$("#username").next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$('#username').css({"border-color": "red", 
	// 				"border-width":"1px", 
	// 				"border-style":"solid"});
	// 			$('#simpan').addClass('disabled');
	// 			$('#simpan').attr('disabled',true);
	// 			$('#simpan').css({'opacity':'0.3'});
	// 		}
	// 		else
	// 		{
	// 			$('#username').next().fadeOut();
	// 			$('#username').next().html('');
	// 			$("#username").next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$('#username').css({"border": ""});
	// 			$('#simpan').removeClass('disabled');
	// 			$('#simpan').attr('disabled',false);
	// 			$('#simpan').css({'opacity':'1'});
	// 		}

	// 		if($('#email').val()=='')
	// 		{
	// 			$('#email').next().fadeIn();
	// 			$('#email').next().html('Silahkan isi data');
	// 			$("#email").next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$('#email').css({"border-color": "red", 
	// 				"border-width":"1px", 
	// 				"border-style":"solid"});
	// 			$('#simpan').addClass('disabled');
	// 			$('#simpan').attr('disabled',true);
	// 			$('#simpan').css({'opacity':'0.3'});
	// 		}
	// 		else
	// 		{
	// 			$('#email').next().fadeOut();
	// 			$('#email').next().html('');
	// 			$("#email").next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$('#email').css({"border": ""});
	// 			$('#simpan').removeClass('disabled');
	// 			$('#simpan').attr('disabled',false);
	// 			$('#simpan').css({'opacity':'1'});
	// 		}

	// 		if($('#roles').val()=='')
	// 		{
	// 			$('#roles').next().next().fadeIn();
	// 			$('#roles').next().next().html('Silahkan isi data');
	// 			$("#roles").next().next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$('#roles').css({"border-color": "red", 
	// 				"border-width":"1px", 
	// 				"border-style":"solid"});
	// 			$('#simpan').addClass('disabled');
	// 			$('#simpan').attr('disabled',true);
	// 			$('#simpan').css({'opacity':'0.3'});
	// 		}
	// 		else
	// 		{
	// 			$('#roles').next().next().fadeOut();
	// 			$('#roles').next().next().html('');
	// 			$("#roles").next().next().css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$('#roles').css({"border": ""});
	// 			$('#simpan').removeClass('disabled');
	// 			$('#simpan').attr('disabled',false);
	// 			$('#simpan').css({'opacity':'1'});
	// 		}

	// 		if($('#mode').val()=='add')
	// 		{
	// 			if($('#password').val()=='')
	// 			{
	// 				$('#password').next().fadeIn();
	// 				$('#password').next().html('Silahkan isi data');
	// 				$("#password").next().css({"color":"red",
	// 					"font-size":"11px",
	// 					"font-family":"arial"});
	// 				$('#password').css({"border-color": "red", 
	// 					"border-width":"1px", 
	// 					"border-style":"solid"});
	// 				$('#simpan').addClass('disabled');
	// 				$('#simpan').attr('disabled',true);
	// 				$('#simpan').css({'opacity':'0.3'});
	// 			}
	// 			else
	// 			{
	// 				$('#password').next().fadeOut();
	// 				$('#password').next().html('');
	// 				$("#password").next().css({"color":"red",
	// 					"font-size":"11px",
	// 					"font-family":"arial"});
	// 				$('#password').css({"border": ""});
	// 				$('#simpan').removeClass('disabled');
	// 				$('#simpan').attr('disabled',false);
	// 				$('#simpan').css({'opacity':'1'});
	// 			}
	// 		}

	// 		if(!$('input[type="radio"][name=verified]').is(':checked'))
	// 		{
	// 			// console.log('aaaaa');	
	// 			$('#radio_a').fadeIn();
	// 			$('#radio_a').html('Silahkan isi data');
	// 			$('#radio_a').css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$('input[type="radio"][name=verified]').css({"border-color": "red", 
	// 				"border-width":"1px", 
	// 				"border-style":"solid"});
	// 			$('#simpan').addClass('disabled');
	// 			$('#simpan').attr('disabled',true);
	// 			$('#simpan').css({'opacity':'0.3'});
	// 		}
	// 		else
	// 		{
	// 			$('#radio_a').fadeOut();
	// 			$('#radio_a').html('');
	// 			$('#radio_a').css({"color":"red",
	// 				"font-size":"11px",
	// 				"font-family":"arial"});
	// 			$('input[type="radio"][name=verified]').css({"border": ""});
	// 			$('#simpan').removeClass('disabled');
	// 			$('#simpan').attr('disabled',false);
	// 			$('#simpan').css({'opacity':'1'});
	// 		}

			

	// 		// $("#message1").fadeIn();
	// 		// $("#message1").html("<img src='{{asset('js/') }}/ajax-loader_projek.gif'  height='25px' width='25px'/>");

			
	// 		if($("#simpan").is(":disabled")==false)
	// 		{
	// 			// $.when(check_username()).then(function(){
	// 			// 	$.when(check_email()).then(function(){
	// 			// 		$.when(post_data()).then(function(){

	// 			// 		})		
	// 			// 	})
	// 			// })
	// 			if(username==false)
	// 			{
	// 				check_username();
	// 			}	
	// 			if(email==false)
	// 			{
	// 				check_email();
	// 			}
	// 			if(username==true && email==true)
	// 			{
	// 				post_data();
	// 			}			
	// 		}
	// 		else
	// 		{
	// 			// toastr
	// 			toastr_notif('Silahkan lengkapi data!','gagal');
	// 		}
	// 	})
	// })

// function check_username()
// {
// 		var formData = new FormData();
// 		formData.append('username', $('#username').val());
// 		formData.append('mode', $('#mode').val());
// 		formData.append('id', $('#id').val());
// 		formData.append('_token', '{{csrf_token()}}');
// 		$("#message").fadeIn();
// 		$("#message").html("<img src='{{asset('js/') }}/ajax-loader_projek.gif'  height='25px' width='25px'/>");

// 		$('#simpan').html('checking...');
// 		$.ajax({
// 			url: '{{url('user/cek-username')}}',
// 			type: 'POST',
// 			data: formData,
// 			headers: {
// 				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// 			},
// 			cache: false,
// 			contentType: false,
// 			processData: false,
// 			success:function(data){
				
// 				if(data.status==true)
// 				{
// 					toastr_notif(data.msg,'sukses');
// 					$("#message").fadeOut();
// 					username=true;
// 					$('#simpan').html({{ __('button.save') }});
// 				}
// 				else
// 				{
// 					toastr_notif(data.msg,'gagal');
// 					$("#message").fadeOut();
// 					$('#username').next().fadeIn();
// 					$('#username').next().html(data.msg);
// 					$("#username").next().css({"color":"red",
// 						"font-size":"11px",
// 						"font-family":"arial"});
// 					$('#username').css({"border-color": "red", 
// 						"border-width":"1px", 
// 						"border-style":"solid"});
// 					username=false;
// 					$('#simpan').html({{ __('button.validate') }});				
// 				}

// 		},
// 		error:function (xhr, status, error)
// 		{
// 			toastr_notif(xhr.responseText,'gagal');
// 		},
// 	});
// 		return username;
// }

// function check_email()
// {
// 		var formData = new FormData();
// 		formData.append('email', $('#email').val());
// 		formData.append('mode', $('#mode').val());
// 		formData.append('id', $('#id').val());
// 		formData.append('_token', '{{csrf_token()}}');
// 		$("#message1").fadeIn();
// 		$("#message1").html("<img src='{{asset('js/') }}/ajax-loader_projek.gif'  height='25px' width='25px'/>");

// 		$('#simpan').html('checking...');
// 		$.ajax({
// 			url: '{{url('user/cek-email')}}',
// 			type: 'POST',
// 			data: formData,
// 			headers: {
// 				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
// 			},
// 			cache: false,
// 			contentType: false,
// 			processData: false,
// 			success:function(data){
				
// 				if(data.status==true)
// 				{
// 					toastr_notif(data.msg,'sukses');
// 					$("#message1").fadeOut();
// 					email=true;
// 					$('#simpan').html({{ __('button.save') }});
// 				}
// 				else
// 				{
// 					toastr_notif(data.msg,'gagal');
// 					$("#message1").fadeOut();
// 					$('#email').next().fadeIn();
// 					$('#email').next().html(data.msg);
// 					$("#email").next().css({"color":"red",
// 						"font-size":"11px",
// 						"font-family":"arial"});
// 					$('#email').css({"border-color": "red", 
// 						"border-width":"1px", 
// 						"border-style":"solid"});
// 					email=false;		
// 					$('#simpan').html({{ __('button.validate') }});		
// 				}

// 		},
// 		error:function (xhr, status, error)
// 		{
// 			toastr_notif(xhr.responseText,'gagal');
// 		},
// 	});
// 		return email;
// }



function post_data()
{
		var formData = new FormData();
		formData.append('id', $('#id').val());
		formData.append('nama', $('#nama').val());
		formData.append('username', $('#username').val());
		formData.append('email', $('#email').val());
		formData.append('password', $('#password').val());
		formData.append('roles', $('#roles').val());
		formData.append('verified', document.querySelector('input[name="verified"]:checked').value);
		formData.append('mode', $('#mode').val());
		formData.append('_token', '{{csrf_token()}}');

		$('.ajax-loader').fadeIn();
	    $("#status").html("{{ __('alert.loading') }}");

	    $('#simpan').html('{{ __('alert.wait') }}');
		$.ajax({
			url: '{{url('user/send-data')}}',
			type: 'POST',
			data: formData,
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			},
			xhr: function () {
				var xhr = new window.XMLHttpRequest();
				xhr.upload.addEventListener("progress",
					uploadProgressHandler,
					false
					);
				xhr.addEventListener("load", loadHandler, false);
				xhr.addEventListener("error", errorHandler, false);
				xhr.addEventListener("abort", abortHandler, false);

				return xhr;
			},
			cache: false,
			contentType: false,
			processData: false,
			success:function(data){
				
				if(data.status==true)
				{
					toastr_notif(data.msg,'sukses');
					$('#simpan').html('Finished');

					setTimeout(function(){
						$('#formModal').modal('hide');
						reload_table();
					}, 2000);
				}
				else
				{
					toastr_notif(data.msg,'gagal');
				}

		},
		error:function (xhr, status, error)
		{
			toastr_notif(xhr.responseText,'gagal');
		},
	});	
}
</script>