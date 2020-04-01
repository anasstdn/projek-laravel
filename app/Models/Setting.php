<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Setting
 * 
 * @property int $id
 * @property string $name
 * @property string $val
 * @property string $type
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @package App\Models
 */
class Setting extends Model
{
	protected $table = 'settings';

	protected $fillable = [
		'name',
		'val',
		'type'
	];
}
