<?php

namespace App\Models\Base;

use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;

class SystemVideo extends BaseModel 
{
    use RoleAccess, Filterable, AsSource, Chartable;

    /**
     * @var array
     */

    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
       if (self::$MainObj) return self::$MainObj;
       self::$MainObj = new SystemVideo;
       return self::$MainObj;
    } 
    // --------------------------------------------

    public $table = 'system_video';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'host',
        'videoid',
        'name',
        'video_img',
        'location',
        'script',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'host',
        'videoid',
        'name',
        'video_img',
        'location',
        'script',
    ];

        /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'host',
        'videoid',
        'name',
        'video_img',
        'location',
        'script',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
    ];

    public  function processObject($obj, $params)
    {
        $params = (array)$params;

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
        {
			$obj->canDelete = $obj->_canDelete();
        }

        $obj = parent::processObject($obj, $params);
        return $obj;
    }

	public function _canDelete()
    {       
        $t =  parent::_canDelete();
        if(!$t){
            return false;
        }
        return true;
    }

    public static function GETFILE($id)
    {
        return self::GetObj()->where('id', $id)->first();
    }

	// ============================================================================
    public static function GV($id)
	{
		$videoitem = SystemVideo::GetObj()->get($id);
		
		return $videoitem;
	}
	
	// ============================================================================
	public static function SV_Genral($obj)
	{
        // dd($obj);
        $obj->_save();
		return $obj;
	}
	
	// ============================================================================
	public static function SV_URL($url, $id = 0)
	{
		$videoitem = self::PARSE_URL($url);
		
		if (!$videoitem) return false;
		if ($id) self::DV($id);
		return self::SV_Genral($videoitem);
	}
	
	// ============================================================================
	public static function PARSE_URL($url)
	{
		$mini = false;
		$host = self::getUrlHost($url, $mini);
		
		$videoitem = false;
		
		if ($host == "youtube")
		{
			$videoitem = self::PARSE_URL_youtube($url, $mini);
		}
		
		if ($host == "vimeo")
		{
			$videoitem = self::PARSE_URL_vimeo($url);
		}
		
		return $videoitem;
	}
	
	// ============================================================================
	public function getHtmlScript($w = 560, $h = 315, $allowfullscreen = true, $controls = 1)
	{
		return self::getscript($this, $w, $h, $allowfullscreen, $controls);
	}
	
	// ============================================================================
	public static function getscript($videoitem, $w = 560, $h = 315, $allowfullscreen = true, $controls = 0)
	{
		$script = '';
		if ($videoitem->host == 'vimeo')
		{
			$script = '<iframe class="js_vimeoplayer" data-src="" src="//player.vimeo.com/video/'.$videoitem->videoid.'?badge=0&amp;color=ffffff" width="'.$w.'" height="'.$h.'" frameborder="0" '.( ($allowfullscreen) ? ' webkitallowfullscreen mozallowfullscreen allowfullscreen ' : '' ).'></iframe>';
		} 
		if ($videoitem->host == 'youtube')
		{
			$script = '<iframe width="'.$w.'" height="'.$h.'" class="js_youtubeplayer" data-src="" src="//www.youtube.com/embed/'.$videoitem->videoid.'?rel=0&amp;controls='.$controls.'&amp;showinfo=0" frameborder="0" '.( ($allowfullscreen) ? ' allowfullscreen ' : '' ).' ></iframe>';
		} 
		
		return $script;
	}
	
	// ============================================================================
	public static function getimageurl($videoitem, $q = 'max')
	{
		$url = '';
		if ($videoitem->host == 'vimeo')
		{
			$content = file_get_contents("https://vimeo.com/api/v2/video/".$videoitem->videoid.".json");
			$t = json_decode($content);
			$t = get_object_vars(reset($t));

			$url = $t['thumbnail_large'].'?';
			if ($q == 'max')
			{
				$t1 = explode('_', $t['thumbnail_large']);
				$url = $t1.'?';
			}
		} 
		if ($videoitem->host == 'youtube')
		{
			$url = 'https://img.youtube.com/vi/'.$videoitem->videoid.'/hqdefault.jpg?';
			if ($q == 'max')
			{
				// $url = 'https://img.youtube.com/vi/'.$videoitem->videoid.'/maxresdefault.jpg?';
			}


		} 
		
		return $url;
	}
	
	// ============================================================================
	private static function PARSE_URL_vimeo($url)
	{
		$urls = parse_url($url);
		$t1 = explode('/', $urls['path']);
		$videoid = (int)end($t1);
		unset($t1);
		
		if ($videoid === false) return false;
		
		$content = file_get_contents("https://vimeo.com/api/v2/video/".$videoid.".json");
		$t = json_decode($content);
		$t = get_object_vars(reset($t));
		
        
		$obj = new SystemVideo();
		$obj->host = "vimeo";
		$obj->videoid = $videoid;
		$obj->name = $t['title'];
		$obj->video_img = $t['thumbnail_large'].'?';
		$obj->location = $url;
		$obj->script = self::getscript($obj);
		
        
		
		return $obj;
	}
	
	// ============================================================================
	private static function PARSE_URL_youtube($url, $mini)
	{
		$pattern = '#^(?:https?://)?(?:www\.)?(?:youtu\.be/|youtube\.com(?:/embed/|/v/|/watch\?v=|/watch\?.+&v=))([\w-]{11})(?:.+)?$#x';
		preg_match($pattern, $url, $matches);
		$videoid = (isset($matches[1])) ? $matches[1] : false;
		
		if ($videoid === false) return false;
		
		$content = @file_get_contents("https://youtube.com/get_video_info?video_id=".$videoid);
		
		$t = array();
		parse_str($content, $t);
		
		$obj = new SystemVideo();
		$obj->host = "youtube";
		$obj->videoid = $videoid;
		$obj->name = 'temporar';
		$obj->video_img = 'https://img.youtube.com/vi/'.$videoid.'/mqdefault.jpg?';
		$obj->location = $url;
		$obj->script = self::getscript($obj);

        
		return $obj;
	}
    
	// ============================================================================
    private static function getUrlHost($url, &$mini)
	{
		if (stripos($url, "youtube.com") !== false) 
		{
			$mini = false;
			return "youtube";
		}
		if (stripos($url, "youtu.be") !== false) 
		{
			$mini = true;
			return "youtube";
		}
		if (stripos($url, "vimeo.com") !== false) 
		{
			return "vimeo";
		}
	}

}
    
