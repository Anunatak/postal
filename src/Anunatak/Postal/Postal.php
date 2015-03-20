<?php namespace Anunatak\Postal;

use DB;

class Postal {

	/**
	 * Gets the place of a postal code
	 *
	 * @return void
	 * @author 
	 **/
	public static function getPlace( $code ) {

		return DB::table('postal')->where('code', $code)->pluck('place');

	}

}