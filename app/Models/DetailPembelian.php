<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DetailPembelian
 * 
 * @property int $id
 * @property int $id_pembelian
 * @property int $id_barang
 * @property float $harga_beli
 * @property float $jumlah
 * @property float $sub_total
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Barang $barang
 * @property Pembelian $pembelian
 *
 * @package App\Models
 */
class DetailPembelian extends Model
{
	protected $table = 'detail_pembelian';

	protected $casts = [
		'id_pembelian' => 'int',
		'id_barang' => 'int',
		'harga_beli' => 'float',
		'jumlah' => 'float',
		'sub_total' => 'float'
	];

	protected $fillable = [
		'id_pembelian',
		'id_barang',
		'harga_beli',
		'jumlah',
		'sub_total'
	];

	public function barang()
	{
		return $this->belongsTo(Barang::class, 'id_barang');
	}

	public function pembelian()
	{
		return $this->belongsTo(Pembelian::class, 'id_pembelian');
	}
}
