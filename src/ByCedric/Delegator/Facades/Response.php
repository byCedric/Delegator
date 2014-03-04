<?php namespace ByCedric\Delegator\Facades;

class Response extends \Illuminate\Support\Facades\Response
{
	/**
	 * Return an API result.
	 *
	 * @param  mixed $data
	 * @return \ByCedric\Delegator\Delegator
	 */
	public static function api( $data = null )
	{
		return new \ByCedric\Delegator\Delegator($data);
	}
}