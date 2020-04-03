<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Kabupaten
 * 
 * @property int $id
 * @property string $kd_kabupaten
 * @property string $kabupaten
 * @property int $id_provinsi
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Provinsi $provinsi
 * @property Collection|Kecamatan[] $kecamatans
 *
 * @package App\Models
 */
class Kabupaten extends Model
{
	protected $table = 'kabupaten';

	protected $casts = [
		'id_provinsi' => 'int'
	];

	protected $fillable = [
		'kd_kabupaten',
		'kabupaten',
		'id_provinsi'
	];

	public function provinsi()
	{
		return $this->belongsTo(Provinsi::class, 'id_provinsi');
	}

	public function kecamatans()
	{
		return $this->hasMany(Kecamatan::class, 'id_kabupaten');
	}
}
