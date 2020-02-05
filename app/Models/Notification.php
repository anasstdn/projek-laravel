<?php

/**
 * Created by Reliese Model.
 */

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 * 
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * 
 * @property User $user
 *
 * @package App\Models
 */
class Notification extends Model
{
	protected $table = 'notification';

	protected $casts = [
		'user_id' => 'int'
	];

	protected $fillable = [
		'title',
		'content',
		'user_id'
	];

	public function user()
	{
		return $this->belongsTo(User::class);
	}
}
