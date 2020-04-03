<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Kelurahan
 * 
 * @property int $id
 * @property string $kd_kelurahan
 * @property string $kelurahan
 * @property int $id_kecamatan
 * @property string $kodepos
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property Kecamatan $kecamatan
 *
 * @package App\Models
 */
class Kelurahan extends Model
{
	protected $table = 'kelurahan';

	protected $casts = [
		'id_kecamatan' => 'int'
	];

	protected $fillable = [
		'kd_kelurahan',
		'kelurahan',
		'id_kecamatan',
		'kodepos'
	];

	public function kecamatan()
	{
		return $this->belongsTo(Kecamatan::class, 'id_kecamatan');
	}
}
