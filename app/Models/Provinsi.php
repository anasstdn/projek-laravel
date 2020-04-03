<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Provinsi
 * 
 * @property int $id
 * @property string $kd_provinsi
 * @property string $provinsi
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Collection|Kabupaten[] $kabupatens
 *
 * @package App\Models
 */
class Provinsi extends Model
{
	protected $table = 'provinsi';

	protected $fillable = [
		'kd_provinsi',
		'provinsi'
	];

	public function kabupatens()
	{
		return $this->hasMany(Kabupaten::class, 'id_provinsi');
	}
}
