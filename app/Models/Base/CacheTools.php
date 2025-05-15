<?php

namespace App\Models\Base;

use Illuminate\Support\Facades\Cache;

class CacheTools
{
	public static function GET_CACHE($obj, $function, $filter, $params){
		$params = (array) $params;
		if (!isset($params['_usecache']) || !$params['_usecache'])
			return null;

		$id = self::GET_CACHE_ID($obj, $function, $filter, $params);

		return Cache::get($id);
    }

	public static function SAVE_CACHE($value, $obj, $function, $filter, $params){
		$params = (array) $params;
		if (!isset($params['_usecache']) || !$params['_usecache'])
			return;

		$id = self::GET_CACHE_ID($obj, $function, $filter, $params);
		$lifeTime = self::GET_CACHE_LIFETIME($obj, $params);
		if ($lifeTime < 1)
			return;

		Cache::put($id, $value, $lifeTime);
	}

	protected static function GET_CACHE_ID($obj, $function, $filter, $params)
	{
		$prefix = $obj->table;
		self::recursive_ksort($filter);
		self::recursive_ksort($params);

		$f = serialize($filter);
		$p = serialize($params);

		$str = $prefix . '_' . $function . '_' . $f . '_' . $p;

		$id = strtolower($prefix) . '_' . md5($str);

		return $id;
	}

	protected static function GET_CACHE_LIFETIME($obj, $params)
	{
		if (isset($params['_cachelifetime']) && (int)$params['_cachelifetime'] > 0)
			return (int) $params['_cachelifetime'];


		return $obj->getCacheLifeTime();
	}

	protected static function recursive_ksort(&$array)
	{
		$array = (array) $array;
		foreach ($array as &$v) {
			if (is_array($v)) {
				self::recursive_ksort($v);
			}
		}
		ksort($array);
	}
}