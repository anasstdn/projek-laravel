<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BarangGolongan
 * 
 * @property int $id
 * @property string $barang_golongan
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class BarangGolongan extends Model
{
	protected $table = 'barang_golongan';

	protected $fillable = [
		'barang_golongan'
	];
}
