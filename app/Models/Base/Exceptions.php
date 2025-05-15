<?php

namespace App\Models\Base;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Metrics\Chartable;
use App\Models\Base\BaseModel;
use Illuminate\Support\Facades\Response;
use Orchid\Filters\Filterable;

class Exceptions extends BaseModel 
{
    use RoleAccess, Filterable, AsSource, Chartable;
    
	// Not Authorized ------------------------------------------------
	public static function errorNotAuthorizedJSON($message = '')
	{
		$message = $message ? $message : 'Not authorized.';
		return response()->json(['error' => $message],401);
	}

	public static function errorNotAuthorizedHTML($message = '')
	{
		$message = $message ? $message : 'Not authorized.';
		return abort(401);
	}

	// Not Found ------------------------------------------------
	public static function errorNotFoundJSON($message = '')
	{
		$message = $message ? $message : 'Not found.';
		return response()->json(['error' => $message],404);
	}

	public static function errorNotFoundHTML($message = '')
	{
		return $message;
	}

}
    
