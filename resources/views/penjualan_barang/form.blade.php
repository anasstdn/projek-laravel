<!-- Modal 7 (Ajax Modal)-->

<div class="modal-dialog modal-lg" role="document" style="font-family: sans-serif;">
	<div class="modal-content">
		<form method="post" id="form" action="#" enctype="multipart/form-data">
			{{ csrf_field() }}
			 <div class="block block-themed block-transparent mb-0">
			 	<div class="block-header bg-primary-dark">
                            <h3 class="block-title">{{isset($user) && $user->exists()?'Ubah':'Tambah'}} Penjualan Barang</h3>
                            <div class="block-options">
                                <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                    <i class="si si-close"></i>
                                </button>
                            </div>
                        </div>
                        <input type="hidden" id="mode" value="{{isset($data) && $data->exists()?'edit':'add'}}">
			<input type="hidden" id="id" value="{{isset($data) && $data->exists()?$data->id:''}}">
			<div class="modal-body">
		{{-- 		<div class="form-group row" style="margin-bottom: 1.429rem;">
					<label class="col-form-label col-md-3">Satuan</label>
					<div class="col-md-7">
						<input type="text" class="form-control form-control-sm" id="satuan" name="satuan" value="{{(isset($data) && $data->exists)?isset($data->satuan)?$data->satuan:'':''}}">
						<span class="help-block"></span>
					</div>
				</div> --}}
				<table class="table table-bordered table-striped table-vcenter" style="text-align:center">
						<tr>
							<th rowspan="2">No Nota</th>
							<th rowspan="2">Tanggal Transaksi</th>
							<th colspan="6">Total Penjualan</th>
							<th rowspan="2">Campur</th>
						</tr>
						<tr>
							<th>Pasir Biasa</th>
							<th>Pasir Gendol</th>
							<th>Abu</th>
							<th>Split 2/3</th>
							<th>Split 1/2</th>
							<th>LPA</th>
						</tr>
						<tbody>
							<tr>
								<td>
									<input type="text" class="form-control form-control-sm" id="no_nota" name="no_nota" value="{{isset($data)?$data->no_nota!==null?$data->no_nota:'':''}}">
								</td>
								<td><input type="text" class="form-control form-control-sm" id="tgl_transaksi" name="tgl_transaksi"  value="{{isset($data)?$data->tgl_transaksi!==null?date('d-m-Y',strtotime($data->tgl_transaksi)):'':''}}"></td>
								<td><input type="text" class="form-control form-control-sm" id="pasir" name="pasir" value="{{isset($data)?$data->pasir!==null?$data->pasir:'':''}}"></td>
								<td><input type="text" class="form-control form-control-sm" id="gendol" name="gendol" value="{{isset($data)?$data->gendol!==null?$data->gendol:'':''}}"></td>
								<td><input type="text" class="form-control form-control-sm" id="abu" name="abu" value="{{isset($data)?$data->abu!==null?$data->abu:'':''}}"></td>
								<td><input type="text" class="form-control form-control-sm" id="split2_3" name="split2_3" value="{{isset($data)?$data->split2_3!==null?$data->split2_3:'':''}}"></td>
								<td><input type="text" class="form-control form-control-sm" id="split1_2" name="split1_2" value="{{isset($data)?$data->split1_2!==null?$data->split1_2:'':''}}"></td>
								<td><input type="text" class="form-control form-control-sm" id="lpa" name="lpa" value="{{isset($data)?$data->lpa!==null?$data->lpa:'':''}}"></td>
								<td>
									<div class="custom-control custom-checkbox mb-5">
										<input class="custom-control-input" type="checkbox" name="campur" id="campur" value="Y" {{isset($data)?$data->campur=='Y'?'checked':'':''}}>
										<label class="custom-control-label" for="campur">Ya</label>
									</div>
								</td>
							</tr>
						</tbody>
				</table>
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
			if($(e.currentTarget).valid()==true)
			{
				post_data();
			}
		})

		$('#tgl_transaksi').datepicker({
			format: "dd-mm-yyyy",
			changeMonth:true,
			changeYear:true
		}).on('change', function() {
        $(this).valid();  // triggers the validation test
        // '$(this)' refers to '$(".date")'
    });


		});


function post_data()
{

		var formData = new FormData();
		formData.append('id', $('#id').val());
		formData.append('mode', $('#mode').val());
		formData.append('no_nota', $('#no_nota').val());
		formData.append('tgl_transaksi', $('#tgl_transaksi').val());
		formData.append('pasir', $('#pasir').val());
		formData.append('gendol', $('#gendol').val());
		formData.append('abu', $('#abu').val());
		formData.append('split2_3', $('#split2_3').val());
		formData.append('split1_2', $('#split1_2').val());
		formData.append('lpa', $('#lpa').val());
		formData.append('campur', $('#campur:checked').val());
		formData.append('_token', '{{csrf_token()}}');

		$('.ajax-loader').fadeIn();
	    $("#status").html("Loading...Please Wait!");

	    $('#simpan').html('please wait...');
		$.ajax({
			url: '{{url('penjualan-barang/send-data')}}',
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
                jQuery(e).parents('tbody > tr > td').append(error);
            },
            highlight: e => {
                jQuery(e).closest('tbody > tr > td').removeClass('is-invalid').addClass('is-invalid');
            },
            success: e => {
                jQuery(e).closest('tbody > tr > td ').removeClass('is-invalid');
                jQuery(e).remove();
            },
            rules: {
                'no_nota': {
                    required: true,
                    minlength: 1,
                    maxlength: 100,
                },
                'tgl_transaksi': {
                    required: true,
                    minlength: 1,
                    maxlength: 100,
                },
            },
            messages: {
                'no_nota': {
                    required: 'Silahkan isi form',
                    minlength: 'Isian minimal 1 karakter',
                    maxlength: 'Isian maksimal 100 karakter',
                },
                'tgl_transaksi': {
                    required: 'Silahkan isi form',
                    minlength: 'Isian minimal 1 karakter',
                    maxlength: 'Isian maksimal 100 karakter',
                },
            }
        });
}
</script>
