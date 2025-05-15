<?php

namespace App\Models\Base;

use App\Models\Base\Status;
use Orchid\Screen\AsSource;
use Orchid\Access\RoleAccess;
use Orchid\Filters\Filterable;
use Orchid\Metrics\Chartable;
use Orchid\Filters\Types\Like;
use App\Models\Base\BaseModel;
use Exception;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;


class SystemFile extends BaseModel
{
    use RoleAccess, Filterable, AsSource, Chartable;

    /**
     * @var array
     */

    // --------------------------------------------
    private static $MainObj = false;

    public static function GetObj()
    {
        if (self::$MainObj)
            return self::$MainObj;
        self::$MainObj = new SystemFile;
        return self::$MainObj;
    }
    // --------------------------------------------

    public $table = 'system_file';

    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'size',
        'filetype',
        'location',
        'md5',
        'isused',
        'permission',
        'group',
    ];

    protected $allowedFilters = [
        'id' => Like::class,
        'name',
        'size',
        'filetype',
        'location',
        'md5',
        'isused',
        'permission',
        'group',
    ];

    /**
     * @var array
     */
    protected $allowedSorts = [
        'id',
        'name',
        'size',
        'filetype',
        'location',
        'md5',
        'isused',
        'permission',
        'group',
    ];

    protected $sortCriteria = [
        'id' => 'desc',
    ];

    protected $_keys = [
        'id',
        array('permission', 'md5'),
    ];

    public function processObject($obj, $params)
    {
        $params = (array) $params;

        if ((isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1'))
         {
            $obj->url = Status::GL($obj->url);
            $obj->url_canonical = Status::GL($obj->url_canonical);
            $obj->canDelete = $obj->_canDelete();

        }

        $obj = parent::processObject($obj, $params);

        return $obj;
    }

    // ------------------------------------------------------------------------------------------------
    public function _canDelete()
    {
        $t = parent::_canDelete();
        if (!$t) {
            return false;
        }
        return true;
    }

    public function isImage()
    {
        $extensions = ["image/jpeg", "image/png", "image/webp"];
        $file_type = $this->filetype;

        if (in_array($file_type, $extensions)) {
            return true;
        }

        return false;
    }

    public function hasAccess()
    {
        return Acl::checkAccessRole($this->permission);
    }

    public function getPath($w = 0, $h = 0, $nw = '')
    {
        $w = (int) $w;
        $h = (int) $h;
        $nw = ($nw) ? '1' : '0';

        if ($this->filetype == 'url') {
            $url = $this->location;
            if ($this->group == 'allegroimg') {
                $rp = '';
                if ($w > 0 && $w <= 200) {
                    $rp = '/s200/';
                } elseif ($w > 200 && $w <= 500) {
                    $rp = '/s500/';
                } elseif ($w > 500 && $w <= 800) {
                    $rp = '/s800/';
                }
                if ($rp) {
                    $url = str_replace('/original/', $rp, $url);
                }
            }
            return $url;
        }

        if (!$w && !$h) {
            $disk = Storage::disk('local')->getConfig()['root'] . '/';
            if (strpos($this->location, $disk) !== false)
                return $this->location;
            return Storage::disk('local')->getConfig()['root'] . '/' . $this->location;
        }

        $ext = (supportsWebp()) ? 'webp' : 'jpg';

        $path = 'cropedimages/' . $this->group . '/' . $this->id . '_' . $w . '-' . $h . '-' . $nw . '.' . $ext;

        return Storage::disk('local')->getConfig()['root'] . '/' . $path;
    }

    public static function GETGROUP()
    {
        $t = Str::uuid()->toString();
        $r = substr($t, 0, 2);
        $r = strtolower($r);
        return $r;
    }

    public static function GETFILE($id)
    {
        return self::GetObj()->where('id', $id)->first();
    }

    public static function saveFiles($files, $id = 0, $permission = '-1')
    {
        $idr = $id;

        if (isset($files)) {
            $md5 = md5_file($files->getPathname());

            $obj = self::GetObj()->where('md5', $md5)->where('permission', $permission)->first();

            if ($obj) {
                $obj->isused++;
                $obj->_save();
                return $obj->id;
            }

            $obj = new SystemFile();

            $obj->name = $files->getClientOriginalName();
            $obj->size = $files->getSize();
            $obj->filetype = $files->getClientMimeType();
            $obj->md5 = $md5;
            $obj->isused = 0;
            $obj->permission = $permission;
            $obj->group = self::GETGROUP();

            $path = 'systemfiles/' . $obj->group;

            $location = Storage::disk('local')->put($path, $files);

            $obj->location = $location;

            $obj->_save();
            return $obj->id;
        }

        return $idr;
    }

    public static function cdnUrl($id, $w = 0, $h = 0, $nw = '')
    {
        $params = [];
        $params['id'] = $id;
        if ($w)
            $params['w'] = $w;
        if ($h)
            $params['h'] = $h;
        if ($nw)
            $params['nw'] = $nw;

        return route('web.images', $params);
    }

    public function getUrl($w = 0, $h = 0, $nw = '')
    {
        if ($this->filetype == 'url') {
            $url = $this->location;
            if ($this->group == 'allegroimg') {
                $rp = '';
                if ($w > 0 && $w <= 100) {
                    $rp = '/s100/';
                } elseif ($w > 100 && $w <= 200) {
                    $rp = '/s200/';
                } elseif ($w > 200 && $w <= 500) {
                    $rp = '/s400/';
                } elseif ($w > 500 && $w <= 800) {
                    $rp = '/s800/';
                }
                if ($rp) {
                    $url = str_replace('/original/', $rp, $url);
                }
            }
            return $url;
        }

        return self::cdnUrl($this->id, $w, $h, $nw);
    }

    public function _delete()
    {
        Storage::disk('local')->delete($this->location);

        $t = array_filter(Storage::disk('local')->allfiles('cropedimages/' . $this->group . '/'), function ($item) {
            if (strpos(basename($item), $this->id . '_') === 0) {
                return true;
            }

            return false;
        });

        foreach ($t as $item) {
            Storage::disk('local')->delete($item);
        }
        return parent::_delete();
    }



}