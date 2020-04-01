<?php

namespace App\Traits;
use App\Models\Activity;
use carbon\carbon;
date_default_timezone_set(setting('timezone'));

trait ActivityTraits
{
    //
	public function logCreatedActivity($logModel,$changes,$request)
	{
		$activity = activity()
		->causedBy(\Auth::user())
		->performedOn($logModel)
		->withProperties(['attributes'=>$request])
		->log($changes);
		$lastActivity = Activity::all()->last();

		return true;
	}

	public function logUpdatedActivity($list,$before,$list_changes)
	{
		unset($list_changes['updated_at']);
		$old_keys = [];
		$old_value_array = [];
		if(empty($list_changes)){
			$changes = 'No attribute changed';

		}else{

			if(count($before)>0){

				foreach($before as $key=>$original){
					if(array_key_exists($key,$list_changes)){

						$old_keys[$key]=$original;
					}
				}
			}
			$old_value_array = $old_keys;
			$changes = 'Updated with attributes '.implode(', ',array_keys($old_keys)).' with '.implode(', ',array_values($old_keys)).' to '.implode(', ',array_values($list_changes));
		}

		$properties = [
			'attributes'=>$list_changes,
			'old' =>$old_value_array
		];

		$activity = activity()
		->causedBy(\Auth::user())
		->performedOn($list)
		->withProperties($properties)
		->log($changes.' made by '.\Auth::user()->name);

		return true;
	}

	public function logDeletedActivity($list,$changeLogs)
	{
		$attributes = $this->unsetAttributes($list);

		$properties = [
			'attributes' => $attributes->toArray()
		];

		$activity = activity()
		->causedBy(\Auth::user())
		->performedOn($list)
		->withProperties($properties)
		->log($changeLogs);

		return true;
	}

	public function logLoginDetails($user)
	{
		$updated_at = Carbon::now()->format('d/m/Y H:i:s');
		$properties = [
			'attributes' =>['name'=>$user->username,'description'=>'Login ke sistem pada '.$updated_at,'type'=>'Login']
		];

		$changes = 'User '.$user->username.' melakukan login';

		$activity = activity()
		->causedBy(\Auth::user())
		->performedOn($user)
		->withProperties($properties)
		->log($changes);

		return true;
	}

	public function logLogoutDetails($user)
	{
		$updated_at = Carbon::now()->format('d/m/Y H:i:s');
		$properties = [
			'attributes' =>['name'=>$user->username,'description'=>'Logout dari sistem pada '.$updated_at,'type'=>'Logout']
		];

		$changes = 'User '.$user->username.' melakukan logout';

		$activity = activity()
		->causedBy(\Auth::user())
		->performedOn($user)
		->withProperties($properties)
		->log($changes);

		return true;
	}

	public function menuAccess($user,$menu)
	{
		$updated_at = Carbon::now()->format('d/m/Y H:i:s');
		$properties = [
			'attributes' =>['name'=>$user->username,'description'=>'Akses ke menu '.$menu.' pada '.$updated_at,'type'=>'Access']
		];

		$changes = 'User '.$user->username.' mengakses menu '.$menu.'';

		$activity = activity()
		->causedBy(\Auth::user())
		->performedOn($user)
		->withProperties($properties)
		->log($changes);

		return true;
	}

	public function unsetAttributes($model){
		unset($model->created_at);
		unset($model->updated_at);
		return $model;
	}
}