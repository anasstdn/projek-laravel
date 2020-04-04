<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Pembelian
 * 
 * @property int $id
 * @property string $no_faktur_pembelian
 * @property int $id_supplier
 * @property int $id_user
 * @property Carbon $tgl_masuk
 * @property float $total
 * @property string $flag_kirim
 * @property string $flag_terima
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Supplier $supplier
 * @property User $user
 * @property Collection|DetailPembelian[] $detail_pembelians
 *
 * @package App\Models
 */
class Pembelian extends Model
{
	protected $table = 'pembelian';

	protected $casts = [
		'id_supplier' => 'int',
		'id_user' => 'int',
		'total' => 'float'
	];

	protected $dates = [
		'tgl_masuk'
	];

	protected $fillable = [
		'no_faktur_pembelian',
		'id_supplier',
		'id_user',
		'tgl_masuk',
		'total',
		'flag_kirim',
		'flag_terima'
	];

	public function supplier()
	{
		return $this->belongsTo(Supplier::class, 'id_supplier');
	}

	public function user()
	{
		return $this->belongsTo(User::class, 'id_user');
	}

	public function detail_pembelians()
	{
		return $this->hasMany(DetailPembelian::class, 'id_pembelian');
	}
}
