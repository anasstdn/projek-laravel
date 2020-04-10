<div class="table-responsive">
	<table class="table table-bordered table-striped table-vcenter">
		<tr>
			<th width="5%">No</th>
			<th>Tanggal Transaksi</th>
			<th>No Nota</th>
			<th>Pasir Biasa</th>
			<th>Pasir Gendol</th>
			<th>Abu</th>
			<th>Split 2/3</th>
			<th>Split 1/2</th>
			<th>LPA</th>
			<th>Campur</th>
			<th>Aksi</th>
		</tr>
		<tbody>
			@if(isset($data) && !$data->isEmpty())
			@foreach($data as $key=>$row)
			<tr style="text-align: center">
				<td>{{ $data->firstItem() + $key }}</td>
				<td>{{date('d-m-Y',strtotime($row->tgl_transaksi))}}</td>
				<td>{{$row->no_nota}}</td>
				<td>{{$row->pasir==0?0:$row->pasir}}</td>
				<td>{{$row->gendol==0?0:$row->gendol}}</td>
				<td>{{$row->abu==0?0:$row->abu}}</td>
				<td>{{$row->split2_3==0?0:$row->split2_3}}</td>
				<td>{{$row->split1_2==0?0:$row->split1_2}}</td>
				<td>{{$row->lpa==0?0:$row->lpa}}</td>
				<td>{{$row->campur}}</td>
				<td style="text-align:center"><a onclick='show_modal("<?php echo url("penjualan-barang/".$row->id)."/edit"?>")' style='color:white' class='btn btn-sm btn-primary' data-toggle='click-ripple' data-original-title='Edit' title='Edit'><i class='fa fa-edit' aria-hidden='true'></i> Edit</a>
					<a onclick='hapus("<?php echo url("penjualan-barang/".$row->id)?>")' style='color:white' class='btn btn-sm btn-danger' data-toggle='click-ripple' data-original-title='Remove' title='Remove'><i class='fa fa-trash-o' aria-hidden='true'></i> Delete</a>
				</td>
			</tr>
			@endforeach
			@else
			<tr>
				<td colspan="11" style="text-align: center">Data Kosong</td>
			</tr>
			@endif
		</tbody>
	</table>
	<?php
// config
$link_limit = 8; // maximum number of links (a little bit inaccurate, but will be ok for now)
?>

@if ($data->lastPage() > 1)
<nav aria-label="Page navigation">
	<ul class="pagination pagination-sm">
		<li class="page-item {{ ($data->currentPage() == 1) ? ' disabled' : '' }}">
			<a class="page-link" href="{{ $data->url(1) }}">First</a>
		</li>
		@for ($i = 1; $i <= $data->lastPage(); $i++)
		<?php
		$half_total_links = floor($link_limit / 2);
		$from = $data->currentPage() - $half_total_links;
		$to = $data->currentPage() + $half_total_links;
		if ($data->currentPage() < $half_total_links) {
			$to += $half_total_links - $data->currentPage();
		}
		if ($data->lastPage() - $data->currentPage() < $half_total_links) {
			$from -= $half_total_links - ($data->lastPage() - $data->currentPage()) - 1;
		}
		?>
		@if ($from < $i && $i < $to)
		<li class="page-item {{ ($data->currentPage() == $i) ? ' active' : '' }}">
			<a class="page-link" href="{{ $data->url($i) }}">{{ $i }}</a>
		</li>
		@endif
		@endfor
		<li class="page-item {{ ($data->currentPage() == $data->lastPage()) ? ' disabled' : '' }}">
			<a class="page-link" href="{{ $data->url($data->lastPage()) }}">Last</a>
		</li>
	</ul>
</nav>
@endif
</div>