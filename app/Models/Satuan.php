<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Satuan
 * 
 * @property int $id
 * @property string $satuan
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Barang[] $barangs
 *
 * @package App\Models
 */
class Satuan extends Model
{
	protected $table = 'satuan';

	protected $fillable = [
		'satuan'
	];

	public function barangs()
	{
		return $this->hasMany(Barang::class, 'id_satuan');
	}
}
