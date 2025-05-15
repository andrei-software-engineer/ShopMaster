<?php
  
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

use App\Models\Base\SystemFile;
use App\Models\Base\Exceptions;
use Exception;

class SystemFileController 
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(Request $request, $id)
    {
        $obj = SystemFile::GETFILE($id);

        if (!$obj)
        {
            return Exceptions::errorNotFoundHTML();
        }

        if (!$obj->hasAccess()) 
        {
            return Exceptions::errorNotAuthorizedHTML();
        }

        if($obj->isImage()){
            return $this->getminiimage($request, $obj);
        }

        return $this->returnFile($request, $obj);
    }

    protected function returnFile(Request $request, $obj)
    {
        if (!file_exists($obj->getPath()))
        {
            return Exceptions::errorNotFoundHTML();
        }

        $headers = [];
        // $headers['ETag'] = $obj->md5;
        $headers['Last-Modified'] = date("r", filemtime($obj->getPath()));
        $headers['Expires'] = date("r", (time() + env('FILE_CACHE_LIFETIME', '86400')));
        $headers['Cache-Control'] = 'max-age='.env('FILE_CACHE_LIFETIME', '86400');
        $headers['Pragma'] = 'cache';
        $headers['Content-Disposition'] = 'inline; filename="'.$obj->name.'"';
        $headers['Content-type'] = $obj->filetype;

        return response()->file($obj->getPath(), $headers);
    }


    protected function getminiimage($request, $obj)
    {
        $w = ($request->get('w')) ? (int)$request->get('w') : 0;
        $h = ($request->get('h')) ? (int)$request->get('h') : 0;
        $nw = ($request->get('nw')) ? (int)$request->get('nw') : 0;
        
        if (!$w && !$h) 
        {
            return $this->returnFile($request, $obj);
        }

        $newPath = $obj->getPath($w, $h, $nw);

        if (file_exists($newPath))
        {
            $obj->location = $newPath;
            return $this->returnFile($request, $obj);
        }

        $newPath = $this->cropImage($obj, $newPath, $w, $h, $nw);

        $obj->location = $newPath;
        return $this->returnFile($request, $obj);
    }

    protected function cropImage($obj, $newPath, $w, $h, $nw)
    {
        $need_x = $w;
        $need_y = $h;
        $nw = $nw;

        if ($obj->filetype == 'image/webp')
        {            
            if (!function_exists('imagecreatefromwebp'))
            {
                return $this->returnFile(request(), $obj);
            }

            $src = imagecreatefromwebp($obj->getPath());
        } elseif($obj->filetype == "image/png") 
        {
            $src = imagecreatefrompng($obj->getPath());
        }
        elseif($obj->filetype == "image/jpeg")
        {
            $src = imagecreatefromjpeg($obj->getPath());
        }
        elseif($obj->filetype == "image/bpm")
        {
            $src = imagecreatefrombmp($obj->getPath());
        }
        elseif($obj->filetype == "image/webp")
        {
            $src = imagecreatefromwebp($obj->getPath());
        }

        $old_x = imagesx($src);
        $old_y = imagesy($src);

        if($need_x > $old_x)
        {
            $need_x = $old_x;
        }
        
        if($need_y > $old_y)
        {
            $need_y = $old_y;
        }
		
		$dst_x = 0;
		$dst_y = 0;
		$src_x = 0;
		$src_y = 0;
		
		if ($need_x && $need_y)
		{
			$new_x = $need_x;
			$new_y = $need_y;
			
			if ( ($old_x / $need_x) < ($old_y / $need_y))
			{
				// se taie din y
				$src_w = $old_x;
				$src_h = floor( ($need_y * $old_x) / $need_x );
				$src_y = floor( ($old_y - $src_h) / 2 );
			} else
			{
				// se taie din x
				$src_h = $old_y;
				$src_w = floor( ($need_x * $old_y) / $need_y );
				$src_x = floor( ($old_x - $src_w) / 2 );
			}
		} elseif ($need_x && !$need_y)
		{
			$new_x = $need_x;
			$new_y = floor( ($old_y * $need_x) / $old_x );
			
			$src_w = $old_x;
			$src_h = $old_y;
		} elseif (!$need_x && $need_y)
		{
			$new_x = floor( ($old_x * $need_y) / $old_y );
			$new_y = $need_y;
				
			$src_w = $old_x;
			$src_h = $old_y;
		} else
		{
			// ramin aceleasi
			$new_x = $old_x;
			$new_y = $old_y;
			$src_w = $old_x;
			$src_h = $old_y;
		}
		
		$dst_w = $new_x;
		$dst_h = $new_y;
		
		$newname = $obj->name;
		$new = imagecreatetruecolor($new_x, $new_y);
		
		imagealphablending($new, false);
		
		$transparent = imagecolorallocatealpha($new, 255, 255, 255, 127);
		imagefilledrectangle($new, 0, 0, $new_x, $new_y, $transparent);
		imagesavealpha($new, true);
		
		if (!$nw)
		{
			imagecopyresampled($new, $src, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		} else
		{
			$src_x = 0;
			$src_y = 0;
			$src_w = $old_x;
			$src_h = $old_y;
			
			
			if ($need_x && $need_y)
			{
				$new_x = $need_x;
				$new_y = $need_y;
				
				if ( ($old_x / $need_x) < ($old_y / $need_y))
				{
					// se taie din y
					$dst_h = $need_y;
					$dst_w = floor(($old_x * $dst_h) / $old_y);
					
					$dst_x = floor( abs($need_x - $dst_w) / 2 );
					$dst_y = 0;
				} else
				{
					// se taie din x
					$dst_w = $need_x;
					$dst_h = floor(($old_y * $dst_w) / $old_x);
					
					$dst_x = 0;
					$dst_y = floor( abs($need_y - $dst_h) / 2 );
				}
			} 
			
			imagecopyresampled($new, $src, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h);
		}
		
		imagesavealpha($new,true);

        if (!file_exists(dirname($newPath))) mkdir(dirname($newPath), 0777, true);

		if (supportsWebp())
		{
            imagewebp($new, $newPath, 100);
		} else
		{
			imagejpeg($new, $newPath, 100); 
		} 
        
		return $newPath;
    }
}