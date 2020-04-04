<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Barang
 * 
 * @property int $id
 * @property int $id_barang_golongan
 * @property string $barcode
 * @property string $nama_barang
 * @property int $id_satuan
 * @property float $harga_beli
 * @property float $harga_jual
 * @property float $diskon
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property BarangGolongan $barang_golongan
 * @property Satuan $satuan
 *
 * @package App\Models
 */
class Barang extends Model
{
	protected $table = 'barang';

	protected $casts = [
		'id_barang_golongan' => 'int',
		'id_satuan' => 'int',
		'harga_beli' => 'float',
		'harga_jual' => 'float',
		'diskon' => 'float'
	];

	protected $fillable = [
		'id_barang_golongan',
		'barcode',
		'nama_barang',
		'id_satuan',
		'harga_beli',
		'harga_jual',
		'diskon'
	];

	public function barang_golongan()
	{
		return $this->belongsTo(BarangGolongan::class, 'id_barang_golongan');
	}

	public function satuan()
	{
		return $this->belongsTo(Satuan::class, 'id_satuan');
	}
}
