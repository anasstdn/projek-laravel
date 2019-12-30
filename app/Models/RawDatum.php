<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class RawDatum
 * 
 * @property int $id
 * @property Carbon $tgl_transaksi
 * @property string $no_nota
 * @property float $pasir
 * @property float $gendol
 * @property float $abu
 * @property float $split2_3
 * @property float $split1_2
 * @property float $lpa
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class RawDatum extends Model
{
	protected $table = 'raw_data';

	protected $casts = [
		'pasir' => 'float',
		'gendol' => 'float',
		'abu' => 'float',
		'split2_3' => 'float',
		'split1_2' => 'float',
		'lpa' => 'float'
	];

	protected $dates = [
		'tgl_transaksi'
	];

	protected $fillable = [
		'tgl_transaksi',
		'no_nota',
		'pasir',
		'gendol',
		'abu',
		'split2_3',
		'split1_2',
		'lpa'
	];
}
