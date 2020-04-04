<!-- Modal 7 (Ajax Modal)-->

<div class="modal-dialog modal-lg" role="document" style="font-family: sans-serif;">
	<div class="modal-content">
		<form method="post" id="form" action="#" enctype="multipart/form-data">
			{{ csrf_field() }}
			 <div class="block block-themed block-transparent mb-0">
			 	<div class="block-header bg-primary-dark">
                            <h3 class="block-title">{{isset($user) && $user->exists()?'Ubah':'Tambah'}} Golongan Barang</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" id="mode" value="{{isset($data) && $data->exists()?'edit':'add'}}">
			<input type="hidden" id="id" value="{{isset($data) && $data->exists()?$data->id:''}}">
			<div class="modal-body">
				<div class="form-group row" style="margin-bottom: 1.429rem;">
					<label class="col-form-label col-md-3">Golongan Barang</label>
					<div class="col-md-7">
						<input type="text" class="form-control form-control-sm" id="golongan_barang" name="golongan_barang" value="{{(isset($data) && $data->exists)?isset($data->barang_golongan)?$data->barang_golongan:'':''}}">
						<span class="help-block"></span>
					</div>
				</div>
					</div>
			 </div>
		{{-- 	<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold">{{isset($user) && $user->exists()?'Edit':'Add'}} Users</h4>
			</div> --}}

			
					<div class="modal-footer">
						<button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">Kembali</button>
						<button type="submit" id="simpan" class="btn btn-info btn-sm">Simpan</button>
					</div>
				</form>
			</div>
		</div>

<script type="text/javascript">
	var status=false;
	var email=false;
	var username=false;
	$(document).ready(function(){
		initValidationBootstrap();

		$(".select2").select2({
			dropdownParent: $("#form"),
			width: '100%'
		});

		$('#form').submit('#simpan',function(e){
			e.preventDefault();
			$('#form').find('.form-group').each(function(index,ele){
				if($(this).hasClass('is-invalid'))
				{
					initValidationBootstrap();
				}
				else
				{
					initValidationBootstrap();
					post_data();
				}
			});
		})

		});


function post_data()
{

		var formData = new FormData();
		formData.append('id', $('#id').val());
		formData.append('golongan_barang', $('#golongan_barang').val());
		formData.append('mode', $('#mode').val());
		formData.append('_token', '{{csrf_token()}}');

		$('.ajax-loader').fadeIn();
	    $("#status").html("Loading...Please Wait!");

	    $('#simpan').html('please wait...');
		$.ajax({
			url: '{{url('barang-golongan/send-data')}}',
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
						fetch_data(1);
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

function initValidationBootstrap()
{
	$('#form').validate({
            ignore: [],
             button: {
            selector: "#simpan",
            disabled: "disabled"
        },
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
                'golongan_barang': {
                    required: true,
                    minlength: 1,
                    maxlength: 100,
                },
            },
            messages: {
                'golongan_barang': {
                    required: 'Silahkan isi form',
                    minlength: 'Isian minimal 1 karakter',
                    maxlength: 'Isian maksimal 100 karakter',
                },
            }
        });
}
</script>
