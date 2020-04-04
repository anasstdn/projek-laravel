<!-- Modal 7 (Ajax Modal)-->

<div class="modal-dialog modal-md" role="document" style="font-family: sans-serif;">
	<div class="modal-content">
		<form method="post" id="form" action="#" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="block block-themed block-transparent mb-0">
				<div class="block-header bg-primary-dark">
					<h3 class="block-title">{{isset($user) && $user->exists()?'Ubah':'Tambah'}} Barang</h3>
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
						<label class="col-form-label col-md-3">Barcode</label>
						<div class="col-md-7">
							<input type="text" class="form-control form-control-sm" id="barcode" name="barcode" value="{{(isset($data) && $data->exists)?isset($data->barcode)?$data->barcode:'':''}}">
							<span class="help-block"></span>
						</div>
					</div>

					<div class="form-group row" style="margin-bottom: 1.429rem;">
						<label class="col-form-label col-md-3">Nama Barang</label>
						<div class="col-md-7">
							<input type="text" class="form-control form-control-sm" id="nama_barang" name="nama_barang" value="{{(isset($data) && $data->exists)?isset($data->nama_barang)?$data->nama_barang:'':''}}">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group row" style="margin-bottom: 1.429rem;">
						<label class="col-form-label col-md-3">Golongan Barang</label>
						<div class="col-md-7">
							<select class="form-control form-control-sm" id="id_barang_golongan" name="id_barang_golongan">
								<?php
								$barang_golongan=App\Models\BarangGolongan::get();
								?>
								@if(isset($barang_golongan) && !$barang_golongan->isEmpty())
								<option value="">Silahkan Pilih</option>
								@foreach($barang_golongan as $row)
								<option value="{{$row->id}}" {{(isset($data) && $data->exists)?isset($data->id_barang_golongan)?'selected':'':''}}>{{$row->barang_golongan}}</option>
								@endforeach
								@else
								<option value="">Data Kosong</option>
								@endif
							</select>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group row" style="margin-bottom: 1.429rem;">
						<label class="col-form-label col-md-3">Satuan</label>
						<div class="col-md-7">
							<select class="form-control form-control-sm" id="id_satuan" name="id_satuan">
								<?php
								$satuan=App\Models\Satuan::get();
								?>
								@if(isset($satuan) && !$satuan->isEmpty())
								<option value="">Silahkan Pilih</option>
								@foreach($satuan as $row)
								<option value="{{$row->id}}" {{(isset($data) && $data->exists)?isset($data->id_satuan)?'selected':'':''}}>{{$row->satuan}}</option>
								@endforeach
								@else
								<option value="">Data Kosong</option>
								@endif
							</select>
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group row" style="margin-bottom: 1.429rem;">
						<label class="col-form-label col-md-3">Harga Beli</label>
						<div class="col-md-7">
							<input type="number" min="0" class="form-control form-control-sm" id="harga_beli" name="harga_beli" value="{{(isset($data) && $data->exists)?isset($data->harga_beli)?$data->harga_beli:0:0}}">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group row" style="margin-bottom: 1.429rem;">
						<label class="col-form-label col-md-3">Harga Jual</label>
						<div class="col-md-7">
							<input type="number" min="0" class="form-control form-control-sm" id="harga_jual" name="harga_jual" value="{{(isset($data) && $data->exists)?isset($data->harga_jual)?$data->harga_jual:0:0}}">
							<span class="help-block"></span>
						</div>
					</div>
					<div class="form-group row" style="margin-bottom: 1.429rem;">
						<label class="col-form-label col-md-3">Diskon</label>
						<div class="col-md-7">
							<input type="number" min="0" max="100" class="form-control form-control-sm" id="diskon" name="diskon" value="{{(isset($data) && $data->exists)?isset($data->diskon)?$data->diskon:0:0}}">
							<span class="help-block"></span>
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
			if($(e.currentTarget).valid()==true)
			{
				post_data();
			}
		})

	});


	function post_data()
	{

		var formData = new FormData();
		formData.append('id', $('#id').val());
		formData.append('barcode', $('#barcode').val());
		formData.append('nama_barang', $('#nama_barang').val());
		formData.append('id_barang_golongan', $('#id_barang_golongan').val());
		formData.append('id_satuan', $('#id_satuan').val());
		formData.append('harga_beli', $('#harga_beli').val());
		formData.append('harga_jual', $('#harga_jual').val());
		formData.append('diskon', $('#diskon').val());
		formData.append('mode', $('#mode').val());
		formData.append('_token', '{{csrf_token()}}');

		$('.ajax-loader').fadeIn();
		$("#status").html("Loading...Please Wait!");

		$('#simpan').html('please wait...');
		$.ajax({
			url: '{{url('barang/send-data')}}',
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
				'nama_barang': {
					required: true,
					minlength: 1,
					maxlength: 100,
				},
				'id_barang_golongan': {
					required: true,
				},
				'id_satuan': {
					required: true,
				},
				'harga_beli': {
					required: true,
					minlength: 1,
					maxlength: 12,
				},
				'harga_jual': {
					required: true,
					minlength: 1,
					maxlength: 12,
				},
				'diskon': {
					required: true,
					minlength: 1,
					maxlength: 3,
				},
			},
			messages: {
				'nama_barang': {
					required: 'Silahkan isi form',
					minlength: 'Isian minimal 1 karakter',
					maxlength: 'Isian maksimal 100 karakter',
				},
				'id_barang_golongan': {
					required: 'Silahkan isi form',
				},
				'id_satuan': {
					required: 'Silahkan isi form',
				},
				'harga_beli': {
					required: 'Silahkan isi form',
					minlength: 'Isian minimal 1 karakter',
					maxlength: 'Isian maksimal 12 karakter',
				},
				'harga_jual': {
					required: 'Silahkan isi form',
					minlength: 'Isian minimal 1 karakter',
					maxlength: 'Isian maksimal 12 karakter',
				},
				'diskon': {
					required: 'Silahkan isi form',
					minlength: 'Isian minimal 1 karakter',
					maxlength: 'Isian maksimal 3 karakter',
				},
			}
		});
	}
</script>
