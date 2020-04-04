<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PurchaseOrder
 * 
 * @property int $id
 * @property string $no_order
 * @property string $nama_supplier
 * @property Carbon $tgl_order
 * @property int $id_supplier
 * @property int $id_barang
 * @property int $id_user
 * @property float $jumlah
 * @property string $flag_purchase
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Barang $barang
 * @property Supplier $supplier
 * @property User $user
 *
 * @package App\Models
 */
class PurchaseOrder extends Model
{
	protected $table = 'purchase_order';

	protected $casts = [
		'id_supplier' => 'int',
		'id_barang' => 'int',
		'id_user' => 'int',
		'jumlah' => 'float'
	];

	protected $dates = [
		'tgl_order'
	];

	protected $fillable = [
		'no_order',
		'nama_supplier',
		'tgl_order',
		'id_supplier',
		'id_barang',
		'id_user',
		'jumlah',
		'flag_purchase'
	];

	public function barang()
	{
		return $this->belongsTo(Barang::class, 'id_barang');
	}

	public function supplier()
	{
		return $this->belongsTo(Supplier::class, 'id_supplier');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id_user');
	}
}
