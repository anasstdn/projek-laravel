<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Supplier
 * 
 * @property int $id
 * @property string $nama_supplier
 * @property string $alamat_supplier
 * @property string $kota
 * @property int $id_provinsi
 * @property string $no_telp
 * @property string $no_fax
 * @property string $cp_nama
 * @property string $cp_telp
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Provinsi $provinsi
 * @property Collection|Pembelian[] $pembelians
 * @property Collection|PurchaseOrder[] $purchase_orders
 *
 * @package App\Models
 */
class Supplier extends Model
{
	protected $table = 'supplier';

	protected $casts = [
		'id_provinsi' => 'int'
	];

	protected $fillable = [
		'nama_supplier',
		'alamat_supplier',
		'kota',
		'id_provinsi',
		'no_telp',
		'no_fax',
		'cp_nama',
		'cp_telp'
	];

	public function provinsi()
	{
		return $this->belongsTo(Provinsi::class, 'id_provinsi');
	}

	public function pembelians()
	{
		return $this->hasMany(Pembelian::class, 'id_supplier');
	}

	public function purchase_orders()
	{
		return $this->hasMany(PurchaseOrder::class, 'id_supplier');
	}
}
