<!-- Modal 7 (Ajax Modal)-->

<div class="modal-dialog" style="font-family: sans-serif;">
	<div class="modal-content">
		<form method="post" id="form" action="#" enctype="multipart/form-data">
			{{ csrf_field() }}
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold">Delete Data</h4>
			</div>
			<div class="modal-body">
				<center><i class='entypo-trash' style="font-size: 5em;" aria-hidden='true'></i></center>
				<br/>
				<center><p style="font-family: sans-serif;font-size: 14pt;font-weight: bold">Are you sure to delete this data?</p></center>
			</div>
			<div class="modal-footer">
				<button type="submit" id="simpan" class="btn btn-danger">Delete</button>
				<button type="button" class="btn btn-info" data-dismiss="modal">Cancel</button>
			</div>
		</form>
	</div>
</div>

<script type="text/javascript">
	$(document).ready(function(){
		$('#form').submit('#simpan',function(e){
			e.preventDefault();
			var formData = new FormData();
			formData.append('id', {{$id}});
			formData.append('_token', '{{csrf_token()}}');

			$('.ajax-loader').fadeIn();
			$("#status").html("Loading...Please Wait!");

			$('#simpan').html('please wait...');
			$.ajax({
				url: '{{$url}}',
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
						setTimeout(function(){
							$('#formModal1').modal('hide');
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
		})
	})
</script>