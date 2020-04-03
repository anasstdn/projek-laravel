<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Kecamatan
 * 
 * @property int $id
 * @property string $kd_kecamatan
 * @property string $kecamatan
 * @property int $id_kabupaten
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Kabupaten $kabupaten
 * @property Collection|Kelurahan[] $kelurahans
 *
 * @package App\Models
 */
class Kecamatan extends Model
{
	protected $table = 'kecamatan';

	protected $casts = [
		'id_kabupaten' => 'int'
	];

	protected $fillable = [
		'kd_kecamatan',
		'kecamatan',
		'id_kabupaten'
	];

	public function kabupaten()
	{
		return $this->belongsTo(Kabupaten::class, 'id_kabupaten');
	}

	public function kelurahans()
	{
		return $this->hasMany(Kelurahan::class, 'id_kecamatan');
	}
}
