	<!-- Modal 7 (Ajax Modal)-->
	<div class="modal-dialog" style="font-family: sans-serif;">
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h4 class="modal-title" style="font-weight: bold">{{$user->exists()?'Edit':'Add'}} Users</h4>
			</div>

			<div class="modal-body">
				<div class="form-group row" style="margin-bottom: 1.429rem;">
					<label class="col-form-label col-md-3">Nama</label>
					<div class="col-md-7">
						<input type="text" class="form-control" id="nama" name="nama" value="{{($user->exists)?isset($user->name)?$user->name:'':''}}">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group row" style="margin-bottom: 1.429rem;">
					<label class="col-form-label col-md-3">Username</label>
					<div class="col-md-7">
						<input type="text" class="form-control" id="username" name="username" value="{{($user->exists)?isset($user->username)?$user->username:'':''}}">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group row" style="margin-bottom: 1.429rem;">
					<label class="col-form-label col-md-3">Email</label>
					<div class="col-md-7">
						<input type="text" class="form-control" id="email" name="email" value="{{($user->exists)?isset($user->email)?$user->email:'':''}}">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group row" style="margin-bottom: 1.429rem;">
					<label class="col-form-label col-md-3">Password Lama</label>
					<div class="col-md-7">
						<input type="password" class="form-control" id="password" name="password" value="">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group row" style="margin-bottom: 1.429rem;">
					<label class="col-form-label col-md-3">Password Baru</label>
					<div class="col-md-7">
						<input type="password" class="form-control" id="password_new" name="password_new" value="">
						<span class="help-block"></span>
					</div>
				</div>
				<div class="form-group row" style="margin-bottom: 1.429rem;">
					<label class="col-form-label col-md-3">Roles</label>
					<div class="col-md-7">
						
						<span class="help-block"></span>
					</div>
				</div>
			</div>

			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
				<button type="button" class="btn btn-info">Save changes</button>
			</div>
		</div>
	</div>