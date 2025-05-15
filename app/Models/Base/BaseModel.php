<?php

namespace App\Models\Base;

use App\Models\Base\Slug;
use App\Models\Base\BaseWord;
use App\Models\Base\BaseText;
use App\Models\Base\SystemFile;
use App\Models\Base\Lang;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Route;
use Illuminate\Pagination\LengthAwarePaginator;

use Illuminate\Support\Facades\DB;

abstract class BaseModel extends Model 
{
    protected $_systemAttr = array();
    protected $_wordsAttr = array();
    protected $_textsAttr = array();

    protected $_keys = array();


    protected $_systems = [
        '_requestInfo',
        '_idlang',
        'isInFavorite',
        'canDelete',
        '_defaultGalleryObj',
        '_musttranslate',
        '_usecache'
    ];

    // public function __construct()
    // {

    //     // $this->_systemAttr['canDelete'] = false;
    // }

    // ==============================================================================
    public function getCacheLifeTime()
    {
        return 3600;
    }

    // ==============================================================================
    public function _setIdLang($idLang)
    {
        $this->_setSystemAttr('_idlang', $idLang);
    }

    // ==============================================================================
    public function _setSystemAttr($key, $val)
    {
        if (!isset($this->_systemAttr) || !is_array($this->_systemAttr))
            $this->_systemAttr = [];
        $this->_systemAttr[$key] = $val;
    }

    // ==============================================================================
    public function _setWord($key, $val)
    {
        if (!isset($this->_wordsAttr) || !is_array($this->_wordsAttr))
            $this->_wordsAttr = [];
        $this->_wordsAttr[$key] = $val;
    }

    // ==============================================================================
    public function _setText($key, $val)
    {
        if (!isset($this->_textsAttr) || !is_array($this->_textsAttr))
            $this->_textsAttr = [];
        $this->_textsAttr[$key] = $val;
    }

    // ==============================================================================
    public function _getIdLang()
    {
        if (isset($this->_systemAttr) && is_array($this->_systemAttr) && isset($this->_systemAttr['_idlang'])) {
            return $this->_systemAttr['_idlang'];
        }

        return Lang::_getSessionId();
    }

    // ==============================================================================
    public function _getSystemAttribute($key)
    {
        if (isset($this->_systemAttr) && is_array($this->_systemAttr) && isset($this->_systemAttr[$key])) {
            return $this->_systemAttr[$key];
        }
        return null;
    }

    // ==============================================================================
    public static function _get($id, $params = array())
    {
        $params = (array) $params;
        $selfObj = self::GetObj();

        // ------------------------------
        $cache = CacheTools::GET_CACHE($selfObj, __FUNCTION__, ['id' => $id], $params);
        if ($cache !== null) return $cache;
        // ------------------------------

        $obj = $selfObj->query()->where('id', $id)->first();

        if (!$obj)
            return false;
        $obj->processObject($obj, $params);

        // ------------------------------
        CacheTools::SAVE_CACHE($obj, $selfObj, __FUNCTION__, ['id' => $id], $params);
        // ------------------------------

        return $obj;
    }

    
    // ==============================================================================
    public static function _getByUuid($uuid, $params = array())
    {
        $params = (array) $params;
        $selfObj = self::GetObj();

        // ------------------------------
        $cache = CacheTools::GET_CACHE($selfObj, __FUNCTION__, ['uuid' => $uuid], $params);
        if ($cache !== null) return $cache;
        // ------------------------------

        $obj = $selfObj->query()->where('uuid', $uuid)->first();

        if (!$obj)
            return false;
        $obj->processObject($obj, $params);

        // ------------------------------
        CacheTools::SAVE_CACHE($obj, $selfObj, __FUNCTION__, ['uuid' => $uuid], $params);
        // ------------------------------

        return $obj;
    }

    // ==============================================================================
    private static function _queryProcessFilter($filter, $selfObj, &$table)
    {
        $filter = (array) $filter;

        $table = $selfObj->table;

        if (
            !isset($filter['_where'])
            && !isset($filter['_orderby'])
        ) {
            return $filter;
        }


        $_words = $selfObj->_words;
        $_words = (array) $_words;

        $filter['_leftJoin'] = (isset($filter['_leftJoin'])) ? (array) $filter['_leftJoin'] : [];
        $filter['_orderby'] = (isset($filter['_orderby'])) ? (array) $filter['_orderby'] : [];
        $filter['_where'] = (isset($filter['_where'])) ? (array) $filter['_where'] : [];
        $filter['_whereand'] = (isset($filter['_whereand'])) ? (array) $filter['_whereand'] : [];

        $index = 1;
        foreach ($_words as $v) {
            if (!isset($filter['_where'][$v]))
                continue;

            $filter['_whereand'][] = ['_tbwspecf_' . $index . '.attr' => $v, '_tbwspecf_' . $index . '.value' => $filter['_where'][$v]];
            unset($filter['_where'][$v]);

            $filter['_leftJoin'][] = ['_tb' => $table . '_word', '_alias' => '_tbwspecf_' . $index, '_fromc' => 'id', '_toc' => 'idparent'];

            $index++;
        }

        // -------------------------------
        $_orderby = [];
        foreach ($filter['_orderby'] as $v) {
            if (!in_array($v['_c'], $_words)) {
                $_orderby[] = $v;
                continue;
            }


            $filter['_whereand'][] = ['_tbwspecf_' . $index . '.attr' => $v['_c']];

            $filter['_leftJoin'][] = ['_tb' => $table . '_word', '_alias' => '_tbwspecf_' . $index, '_fromc' => 'id', '_toc' => 'idparent'];

            $v['_c'] = '_tbwspecf_' . $index . '.value';
            $_orderby[] = $v;
        }
        $filter['_orderby'] = $_orderby;

        return $filter;
    }

    // ==============================================================================
    private static function _queryProcessBetweenItem($q, $item)
    {
        $item = (array) $item;
        if (!isset($item['_f']))
            return $q;
        if (!isset($item['_t']))
            return $q;

        // ------------------------------------
        $include = (isset($item['_i'])) ? $item['_i'] : true;
        $t1 = ($include) ? '<=' : '<';
        $t2 = ($include) ? '>=' : '>';
        // ------------------------------------

        $strong = (isset($item['_s'])) ? $item['_s'] : false;

        if ($strong) {
            $q = $q->where($item['_f'], $t1, $item['_v']);
            $q = $q->where($item['_t'], $t2, $item['_v']);
        } else {
            $q = $q->where(function ($query) use ($t1, $item) {
                $query
                    ->orWhere($item['_f'], $t1, $item['_v'])
                    ->orWhere($item['_f'], '=', '0')
                    ->orWhereNull($item['_f']);
            });

            $q = $q->where(function ($query) use ($t2, $item) {
                $query
                    ->orWhere($item['_t'], $t2, $item['_v'])
                    ->orWhere($item['_t'], '=', '0')
                    ->orWhereNull($item['_t']);
            });
        }

        return $q;
    }

    // ==============================================================================
    private static function _queryProcessBetween($mTb, $q, $filter = array())
    {
        $filter = (array) $filter;
        if (!isset($filter['_between']))
            return $q;

        $_between = (array) $filter['_between'];
        foreach ($_between as $v) {
            $q = self::_queryProcessBetweenItem($q, $v);
        }

        return $q;
    }

    // ==============================================================================
    private static function _queryProcessSelectItem($mTb, $item)
    {

        if (!isset($item['_tb']) && !isset($item['_field'])) {
            return [$mTb . '.*'];
        }

        $tarr = [];
        $tb = (isset($item['_tb'])) ? $item['_tb'] : $mTb;

        if (!isset($item['_field'])) {
            return [$tb . '.*'];
        }

        if (!is_array($item['_field'])) {
            $_alias = (isset($item['_alias'])) ? ((is_array($item['_alias'])) ? reset($item['_alias']) : $item['_alias']) : '';
            $str = $tb;
            $str .= '.';
            $str .= $item['_field'];

            if ($_alias) {
                $str .= ' as ' . $_alias;
            }

            return [$str];
        }

        $_alias = (isset($item['_alias'])) ? (array) $item['_alias'] : array();

        $tarr = array();
        foreach ($item['_field'] as $v) {
            $str = $tb;
            $str .= '.';
            $str .= $v;

            if (isset($_alias[$v])) {
                $str .= ' as ' . $_alias[$v];
            }

            $tarr[] = $str;
        }

        return $tarr;
    }

    // ==============================================================================
    private static function _queryProcessSelect($mTb, $q, $filter = array())
    {
        $filter = (array) $filter;
        if (!isset($filter['_select'])) {
            $q = $q->select($mTb . '.*');
            return $q;
        }

        $_select = (array) $filter['_select'];

        $tarr = [];
        foreach ($_select as $v) {
            $t = self::_queryProcessSelectItem($mTb, $v);
            $tarr = array_merge($tarr, $t);
        }

        if (!count($tarr)) {
            $q = $q->select($mTb . '.*');
            return $q;
        }

        $q = $q->select($tarr);

        return $q;
    }

    // ==============================================================================
    private static function _queryProcessWhereItem($mTb, $q, $field, $item)
    {
        $item = (array) $item;
        $_act = (isset($item['_act'])) ? $item['_act'] : '=';
        if (isset($item['_act']))
            unset($item['_act']);

        if (!is_array($field)) {
            if (strpos($field, '.') === false) {
                $field = $mTb . '.' . $field;
            }
        }

        $q = $q->where(function ($query) use ($field, $item, $_act) {
            foreach ($item as $v) {
                $query = $query->orWhere($field, $_act, $v);
            }
        });

        return $q;
    }

    // ==============================================================================
    private static function _queryProcessWhere($mTb, $q, $filter = array())
    {
        $filter = (array) $filter;
        if (!isset($filter['_where']))
            return $q;

        $_where = (array) $filter['_where'];
        foreach ($_where as $k => $v) {
            $q = self::_queryProcessWhereItem($mTb, $q, $k, $v);
        }

        return $q;
    }

    // ==============================================================================
    private static function _queryProcessOrderByItem($q, $field, $item)
    {
        if (!isset($item['_c']))
            return $q;

        $_d = (isset($item['_d']) && strtolower($item['_d']) == 'desc') ? 'desc' : 'asc';

        $q = $q->orderBy($item['_c'], $_d);

        return $q;
    }

    // ==============================================================================
    private static function _queryProcessOrderBy($mTb, $q, $filter = array())
    {
        $filter = (array) $filter;
        if (!isset($filter['_orderby']))
            return $q;

        $_orderby = (array) $filter['_orderby'];
        foreach ($_orderby as $k => $v) {
            $q = self::_queryProcessOrderByItem($q, $k, $v);
        }

        return $q;
    }

    // ==============================================================================
    private static function _queryProcessWhereAndItem($mTb, $q, $field, $item)
    {
        $item = (array) $item;

        $q = $q->where(function ($query) use ($field, $item, $mTb) {
            foreach ($item as $k => $v) {
                $query = self::_queryProcessWhereItem($mTb, $query, $k, $v);
            }
        });

        return $q;
    }

    // ==============================================================================
    private static function _queryProcessWhereAnd($mTb, $q, $filter = array())
    {
        $filter = (array) $filter;
        if (!isset($filter['_whereand']))
            return $q;

        $_whereand = (array) $filter['_whereand'];
        foreach ($_whereand as $k => $v) {
            $q = self::_queryProcessWhereAndItem($mTb, $q, $k, $v);
        }

        return $q;
    }

    // ==============================================================================
    private static function _queryProcessLimit($mTb, $q, $filter = array())
    {
        $filter = (array) $filter;

        if (isset($filter['_start'])) {
            $q = $q->skip($filter['_start']);
        }

        if (isset($filter['_limit'])) {
            $q = $q->take($filter['_limit']);
        }

        return $q;
    }

    // ==============================================================================
    private static function _queryProcessLeftJoinItem($mTb, $q, $item)
    {
        $item = (array) $item;

        if (!isset($item['_fromc']))
            return $q;
        if (!isset($item['_toc']))
            return $q;
        if (!isset($item['_tb']))
            return $q;

        $joinTb = ($item['_alias']) ? $item['_tb'] . ' AS ' . $item['_alias'] : $item['_tb'];
        $_alias = (isset($item['_alias'])) ? $item['_alias'] : $joinTb;
        $_action = (isset($item['_action'])) ? $item['_action'] : '=';

        $q = $q->leftJoin($joinTb, $mTb . '.' . $item['_fromc'], $_action, $_alias . '.' . $item['_toc']);

        return $q;
    }

    // ==============================================================================
    private static function _queryProcessLeftJoin($mTb, $q, $filter = array())
    {
        $filter = (array) $filter;

        if (!isset($filter['_leftJoin'])) {
            return $q;
        }

        $_leftJoin = (array) $filter['_leftJoin'];
        foreach ($_leftJoin as $k => $v) {
            $q = self::_queryProcessLeftJoinItem($mTb, $q, $v);
        }


        return $q;
    }

    // ==============================================================================
    // filter example: 
    // $f = [];
    // $f['_where']['status1'] = ['_act' => 'LIKE', Status::ACTIVE, Status::INACTIVE];
    // $f['_where']['status'] = ['_act' => '>', Status::ACTIVE, Status::INACTIVE];
    // $f['_where']['fixed'] = [3,4];
    // $f['_where']['_title'] = [1, 3];
    // $f['_where']['_name'] = [1, 3, 5];
    // $f['_where']['tpw.attr'] = ['name', 'title'];

    // $f['_whereand'][] = ['and_status' => ['_act' => '>', 'st1', 'st2'], 'and_attr' => ['attr1', 'attr2', 'attr3']];
    // $f['_whereand'][] = ['and_status1' => ['st11_1', 'st11_2'], 'and_attr1' => ['attr11_1', 'attr11_2', 'attr11_3']];

    // $f['_between'][] = array('_v' => time(), '_f' => 'status', '_t' => 'fixed', '_s' => '1');
    // $f['_between'][] = array('_v' => time(), '_f' => 'fixed', '_t' => 'fixed', '_s' => '0');

    // $f['_leftJoin'][] = ['_tb' => 'page_word', '_alias' => 'tpw', '_fromc' => 'id', '_toc' => 'idparent'];

    // $f['_select'][] = [];
    // // $f['_select'][] = ['_tb' => 'page_word', '_field' => 'id', '_alias' => 'id11' ];
    // $f['_select'][] = ['_tb' => 'tpw', '_field' => ['attr', 'value'], '_alias' => ['attr' => 'attr111', 'value' => 'value111']];

    // $f['_orderby'][] = ['_d' => 'asc', '_c' => 'col1'];
    // $f['_orderby'][] = ['_d' => 'desc', '_c' => 'col2'];

    // $f['_start'] = 2;
    // $f['_limit'] = 3;
    public static function _getAll($filter = array(), $params = array())
    {
        
        $selfObj = self::GetObj();
        $filter = self::_queryProcessFilter($filter, $selfObj, $table);
        
        // ------------------------------
        $cache = CacheTools::GET_CACHE($selfObj, __FUNCTION__, $filter, $params);
        if ($cache !== null) return $cache;
        // ------------------------------

        $params = (array) $params;
        $q = $selfObj->query();
        $q = self::_queryProcessWhereAnd($table, $q, $filter);
        $q = self::_queryProcessWhere($table, $q, $filter);
        $q = self::_queryProcessBetween($table, $q, $filter);
        $q = self::_queryProcessLimit($table, $q, $filter);
        $q = self::_queryProcessLeftJoin($table, $q, $filter);
        $q = self::_queryProcessSelect($table, $q, $filter);
        $q = self::_queryProcessOrderBy($table, $q, $filter);
        
        $q = $q->distinct()->get();
        $objects = $q->all();
        
        $rez = array();
        foreach ($objects as $v) {
            $v->processObject($v, $params);
            $rez[] = $v;
        }
        
        // ------------------------------
        CacheTools::SAVE_CACHE($rez, $selfObj, __FUNCTION__, $filter, $params);
        // ------------------------------

        return $rez;
    }

    // ==============================================================================
    // $f = [];
    // $f['_where']['status1'] = ['_act' => 'LIKE', Status::ACTIVE, Status::INACTIVE];
    // $f['_where']['status'] = ['_act' => '>', Status::ACTIVE, Status::INACTIVE];
    // $f['_where']['fixed'] = [3,4];
    // $f['_where']['_title'] = [1, 3];
    // $f['_where']['_name'] = [1, 3, 5];
    // $f['_where']['tpw.attr'] = ['name', 'title'];

    // $f['_whereand'][] = ['and_status' => ['_act' => '>', 'st1', 'st2'], 'and_attr' => ['attr1', 'attr2', 'attr3']];
    // $f['_whereand'][] = ['and_status1' => ['st11_1', 'st11_2'], 'and_attr1' => ['attr11_1', 'attr11_2', 'attr11_3']];

    // $f['_between'][] = array('_v' => time(), '_f' => 'status', '_t' => 'fixed', '_s' => '1');
    // $f['_between'][] = array('_v' => time(), '_f' => 'fixed', '_t' => 'fixed', '_s' => '0');

    // $f['_leftJoin'][] = ['_tb' => 'page_word', '_alias' => 'tpw', '_fromc' => 'id', '_toc' => 'idparent'];

    // $f['_select'][] = [];
    // // $f['_select'][] = ['_tb' => 'page_word', '_field' => 'id', '_alias' => 'id11' ];
    // $f['_select'][] = ['_tb' => 'tpw', '_field' => ['attr', 'value'], '_alias' => ['attr' => 'attr111', 'value' => 'value111']];
    public static function _getCount($filter = array(), $params = array())
    {
        $selfObj = self::GetObj();
        $filter = self::_queryProcessFilter($filter, $selfObj, $table);
    
        // ------------------------------
        $cache = CacheTools::GET_CACHE($selfObj, __FUNCTION__, $filter, $params);
        if ($cache !== null) return $cache;
        // ------------------------------

        $params = (array) $params;
        $q = $selfObj->query();

        $q = self::_queryProcessWhereAnd($table, $q, $filter);
        $q = self::_queryProcessWhere($table, $q, $filter);
        $q = self::_queryProcessBetween($table, $q, $filter);
        // $q = self::_queryProcessLimit($table, $q, $filter);
        $q = self::_queryProcessLeftJoin($table, $q, $filter);
        $q = self::_queryProcessSelect($table, $q, $filter);

        $rez = $q->count();
        
        // ------------------------------
        CacheTools::SAVE_CACHE($rez, $selfObj, __FUNCTION__, $filter, $params);
        // ------------------------------

        return $rez;
    }

    // ==============================================================================
    public function _getAllAdmin($onPage = false)
    {
        $onPage = ($onPage) ? (int) $onPage : (int) _CGC('adminOnPage');
        if ($onPage < 1)
            $onPage = 10;

        $allowedFilters = $this->allowedFilters;

        $f = [];

        $rQuery = request()->query();

        // -------------------------------------------------
        if (isset($rQuery['filter'])) {
            foreach ($rQuery['filter'] as $k => $v) {
                $v = trim($v);
                if ($v === '')
                    continue;
                $_act = (isset($allowedFilters[$k])) ? '=' : 'LIKE';
                $_val = ($_act == 'LIKE') ? '%' . $v . '%' : $v;

                $f['_where'][$k] = ['_act' => $_act, $_val];
            }
        }

        // -------------------------------------------------
        if (isset($rQuery['sort'])) {
            $sort = (array) $rQuery['sort'];
            foreach ($sort as $k => $v) {
                $v = trim($v);
                if (!$v)
                    continue;

                $_d = (substr($v, 0, 1) == '-') ? 'desc' : 'asc';
                $_c = ($_d == 'desc') ? substr($v, 1) : $v;


                $f['_orderby'][] = ['_d' => $_d, '_c' => $_c];
            }
        }

        // -------------------------------------------------
        $page = (isset($rQuery['page'])) ? (int) $rQuery['page'] : 1;
        if ($page < 1)
            $page = 1;

        $f['_start'] = ($page - 1) * $onPage;
        $f['_limit'] = $onPage;

        // -------------------------------------------------

        $params = array('_admin' => '1', '_musttranslate' => 1);

        $this->perPage = $onPage;

        // if (Route::currentRouteName() == 'platform.category.list') {
        //     if (!isset(request()->query()['filter'])) {
        //         $f['_where']['idparent'] = 0;

        //     }else{
        //         $fl = request()->query()['filter'];
        //         if (isset($fl['idparent'])) {
        //             if ($fl['idparent'] == 0) {
        //                 $f['_where']['idparent'] = 0;
        //             }
        //         } 
        //     }
        // }

        $objects = self::_getAll($f, $params);
        $total = self::_getCount($f, $params);


        $options = [];
        $options['query'] = $rQuery;
        $options['pageName'] = 'page';
        $options['path'] = route(Route::currentRouteName());

        return new LengthAwarePaginator($objects, $total, $onPage, $page, $options);
    }

    // ==============================================================================
    public static function _getAllTest($filter = array(), $params = array())
    {
        $selfObj = self::GetObj();
        $filter = self::_queryProcessFilter($filter, $selfObj, $table);

        // dd($selfObj->filters());

        // $q = $this->_defaultSorting($selfObj->filters());

        $params = (array) $params;
        $q = $selfObj->query();
        // $q = $selfObj->_defaultSorting($selfObj->filters())->getQuery();
        // $q = $q->_defaultSorting($selfObj->filters());
        // dd(request()->query);

        $q = self::_queryProcessWhereAnd($table, $q, $filter);
        $q = self::_queryProcessWhere($table, $q, $filter);
        $q = self::_queryProcessBetween($table, $q, $filter);
        $q = self::_queryProcessLimit($table, $q, $filter);
        $q = self::_queryProcessLeftJoin($table, $q, $filter);
        $q = self::_queryProcessSelect($table, $q, $filter);
        $q = self::_queryProcessOrderBy($table, $q, $filter);



        // $q = $q->distinct()->get();
        // $objects = $q->all();
        // $objects = $q->count();

        dd($q->toSql(), $q->getBindings(), $table);
        // dd($objects);

        // $q = $q->get();


        // $objects = $q->all();

        // $rez = array();
        // foreach ($objects as $v) {
        //     $v->processObject($v, $params);
        //     $rez[] = $v;
        // }








        // $selfObj = self::GetObj();
        // $table = $selfObj->table;

        // dd($table, $filter, $q->toSql());

        // dd($table, $filter, $params, request());
    }

    // ==============================================================================
    // filter example: 
    // $f = [];
    // $f['_where']['status1'] = ['_act' => 'LIKE', Status::ACTIVE, Status::INACTIVE];
    // $f['_where']['status'] = ['_act' => '>', Status::ACTIVE, Status::INACTIVE];
    // $f['_where']['fixed'] = [3,4];
    // $f['_where']['_title'] = [1, 3];
    // $f['_where']['_name'] = [1, 3, 5];
    // $f['_where']['tpw.attr'] = ['name', 'title'];

    // $f['_whereand'][] = ['and_status' => ['_act' => '>', 'st1', 'st2'], 'and_attr' => ['attr1', 'attr2', 'attr3']];
    // $f['_whereand'][] = ['and_status1' => ['st11_1', 'st11_2'], 'and_attr1' => ['attr11_1', 'attr11_2', 'attr11_3']];

    // $f['_between'][] = array('_v' => time(), '_f' => 'status', '_t' => 'fixed', '_s' => '1');
    // $f['_between'][] = array('_v' => time(), '_f' => 'fixed', '_t' => 'fixed', '_s' => '0');

    // $f['_leftJoin'][] = ['_tb' => 'page_word', '_alias' => 'tpw', '_fromc' => 'id', '_toc' => 'idparent'];

    // $f['_select'][] = [];
    // // $f['_select'][] = ['_tb' => 'page_word', '_field' => 'id', '_alias' => 'id11' ];
    // $f['_select'][] = ['_tb' => 'tpw', '_field' => ['attr', 'value'], '_alias' => ['attr' => 'attr111', 'value' => 'value111']];

    // $f['_orderby'][] = ['_d' => 'asc', '_c' => 'col1'];
    // $f['_orderby'][] = ['_d' => 'desc', '_c' => 'col2'];

    // $f['_update'] = ['col1' => 'val', 'col2' => 'val2'];

    // $f['_start'] = 2;
    // $f['_limit'] = 3;
    public static function _updateAll($filter = array(), $params = array())
    {
        $selfObj = self::GetObj();
        $filter = self::_queryProcessFilter($filter, $selfObj, $table);

        $filter = (array) $filter;

        if (!isset($filter['_update'])) {
            return 0;
        }

        $params = (array) $params;
        $q = DB::table($table);

        $q = self::_queryProcessWhereAnd($table, $q, $filter);
        $q = self::_queryProcessWhere($table, $q, $filter);
        $q = self::_queryProcessBetween($table, $q, $filter);
        $q = self::_queryProcessLimit($table, $q, $filter);
        $q = self::_queryProcessLeftJoin($table, $q, $filter);
        return $q->update($filter['_update']);
    }

    // ==============================================================================
    public static function _updateAllTest($filter = array(), $params = array())
    {
        $selfObj = self::GetObj();
        $filter = self::_queryProcessFilter($filter, $selfObj, $table);

        $filter = (array) $filter;


        if (!isset($filter['_update'])) {
            return 0;
        }

        // dd($table);

        // dd($selfObj->filters());

        // $q = $this->_defaultSorting($selfObj->filters());

        $params = (array) $params;
        // $q = $selfObj->query();
        $q = DB::table($table);
        // $q = $selfObj->_defaultSorting($selfObj->filters())->getQuery();
        // $q = $q->_defaultSorting($selfObj->filters());
        // dd(request()->query);

        $q = self::_queryProcessWhereAnd($table, $q, $filter);
        $q = self::_queryProcessWhere($table, $q, $filter);
        $q = self::_queryProcessBetween($table, $q, $filter);
        $q = self::_queryProcessLimit($table, $q, $filter);
        $q = self::_queryProcessLeftJoin($table, $q, $filter);
        return $q->update($filter['_update']);

        // dd($t);



        // $q = $q->distinct()->get();
        // $objects = $q->all();
        // $objects = $q->count();

        dd($q->toSql(), $q->getBindings(), $table);
        // dd($objects);

        // $q = $q->get();


        // $objects = $q->all();

        // $rez = array();
        // foreach ($objects as $v) {
        //     $v->processObject($v, $params);
        //     $rez[] = $v;
        // }








        // $selfObj = self::GetObj();
        // $table = $selfObj->table;

        // dd($table, $filter, $q->toSql());

        // dd($table, $filter, $params, request());
    }

    // ==============================================================================
    public static function _getAllForSelect($filter = array(), $params = array(), $field = '_name', $idfield = 'id')
    {
        $objects = self::_getAll($filter, $params);

        $rez = array();
        foreach ($objects as $v) {
            $rez[$v->$idfield] = ($v->$field) ? $v->$field : $v->$idfield;
        }

        return $rez;
    }



    // ==============================================================================

    public function _paginate($params = array())
    {
        $all = parent::paginate();

        $res = array();
        foreach ($all as $item) {
            $res[] = $this->processObject($item, $params);
        }
        return $all;
    }

    public function processObjectMeta($obj, $params)
    {
        $params = (array) $params;

        if (
            (isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1')
        ) {
            if ($obj->_author_meta) {
                $obj->_author_meta_show = $obj->_author_meta;
            } else {
                $obj->_author_meta_show = _GLA('_author_meta_show');
            }

            if ($obj->_key_meta) {
                $obj->_key_meta_show = $obj->_key_meta;
            } else {
                $obj->_key_meta_show = _GLA('_key_meta_show');
            }

            if ($obj->_description_meta) {
                $obj->_description_meta_show = $obj->_description_meta;
            } else {
                $obj->_description_meta_show = _GLA('_description_meta_show');
            }
        }

        $temp = false;
        // foreach($obj->_activeGallery as $v)
        // {
        //     if($v->isdefault)
        //     {
        //         $temp = $v;
        //         break;
        //     }

        //     if(!$temp) $temp = $v;
        // }

        if ($temp) {
            $obj->_imgUrl = SystemFile::cdnUrl($temp->idsystemfile);
            $obj->_imgId = $temp->idsystemfile;
        }



        return $obj;
    }

    protected function setIdLang($obj, $params)
    {
        $_words = $this->_words;
        $_texts = $this->_texts;
        if (
            ($_words == null || !is_array($_words))
            && ($_texts == null || !is_array($_texts))
        )
            return;

        if ($obj->_idlang)
            return;
        $obj->_idlang = (isset($params['_idlang']) && $params['_idlang']) ? $params['_idlang'] : Lang::_getSessionId();
    }

    public function processObject($obj, $params)
    {
        $params = (array) $params;

        if (isset($params['_wr']) && $params['_wr'] == '1') {
            $obj->_requestInfo = json_encode($this->_getModifyAdminParams(array('id')));
        }

        $this->setIdLang($obj, $params);

        // ---------------------------------
        if (
            (isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1')
            || (isset($params['_words']) && $params['_words'] == '1')
        ) {
            $obj->_loadWords($params);
        }

        // ---------------------------------
        if (
            (isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1')
            || (isset($params['_texts']) && $params['_texts'] == '1')
        ) {
            $obj->_loadTexts($params);
        }

        // ---------------------------------
        if (
            (isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_videos']) && $params['_videos'] == '1')
        ) {
            $obj->_loadVideos($params);
        }

        if (
            (isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1')
            || (isset($params['_videos']) && $params['_videos'] == '1')
        ) {
            $obj->_loadActiveVideos($params);
        }

        // ---------------------------------
        if (
            (isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_gallery']) && $params['_gallery'] == '1')
        ) {
            $obj->_loadGallery($params);
        }

        if (
            (isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1')
            || (isset($params['_gallery']) && $params['_gallery'] == '1')
        ) {
            $obj->_loadActiveGallery($params);
            $obj->_setDefaultGalleryObj();
        }


        // ---------------------------------
        if (
            (isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_attachements']) && $params['_attachements'] == '1')
        ) {
            $obj->_loadAttachements($params);
        }

        if (
            (isset($params['_admin']) && $params['_admin'] == '1')
            || (isset($params['_full']) && $params['_full'] == '1')
            || (isset($params['_attachements']) && $params['_attachements'] == '1')
        ) {
            $obj->_loadActiveAttachements($params);
        }

        return $obj;
    }

    public function _getFiltersMedia($excluded = array())
    {
        $rez = array();
        $rez = $this->_getModifyAdminParams($excluded);

        return $rez;
    }

    public function _getModifyRequestInfo()
    {
        $request = request();
        $data = $request->get('obj');

        $t = $this->_getFiltersMedia(array('id'));

        if (!$data)
            return $t;
        if (!is_array($data))
            return $t;
        if (!isset($data['_requestInfo']))
            return $t;

        $ri = json_decode($data['_requestInfo'], true);
        $ri = (array) $ri;

        $ri = array_merge($t, $ri);

        return $ri;
    }

    public function _getClassName($toLower = false)
    {
        $cl = (new \ReflectionClass($this))->getShortName();
        if ($toLower)
            $cl = strtolower($cl);
        return ($toLower) ? strtolower((new \ReflectionClass($this))->getShortName()) : (new \ReflectionClass($this))->getShortName();
    }

    public function _getAdminName()
    {
        // temporar
        return $this->_getClassName() . ' Admin Title';
    }

    public function _getAdminDescription()
    {
        // temporar
        return $this->_getClassName() . ' Admin Description';
    }

    public function _sortingByName($obj)
    {

        if ($obj->idparent == $obj->id && $obj->attr == '_name') {
            // join tabela words cu tabela create de obj
        }
        return $obj;
    }

    public function _defaultSorting($obj)
    {
        $criteria = $this->sortCriteria;

        if (!is_array($criteria))
            $criteria = array();

        if (!count($criteria)) {
            $criteria = array('id' => 'asc');
        }

        foreach ($criteria as $k => $v) {
            $obj->defaultSort($k, $v);
        }

        return $obj;
    }

    public function _fill($data)
    {
        parent::fill($data);

        $this->_fill_system($data);
        $this->_fill_words($data);
        $this->_fill_texts($data);

        return true;
    }

    private function _fill_attr_gen($data, $arr, $destination)
    {
        if ($arr == null || !is_array($arr))
            return;

        $this->$destination = array();

        foreach ($arr as $v) {
            if (!isset($data[$v]))
                $data[$v] = '';

            $this->$destination[$v] = $data[$v];
        }
    }

    private function _fill_system($data)
    {
        $this->_fill_attr_gen($data, $this->_systems, '_systemAttr');
    }

    private function _fill_words($data)
    {
        $this->_fill_attr_gen($data, $this->_words, '_wordsAttr');
    }

    private function _fill_texts($data)
    {
        $this->_fill_attr_gen($data, $this->_texts, '_textsAttr');
    }

    protected function _prepare_for_save()
    {
        $attributes = $this->attributes;
        $fillable = $this->fillable;
        $_systems = $this->_systems;

        foreach ($attributes as $k => $v) {
            if (in_array($k, $fillable))
                continue;

            if (in_array($k, $_systems)) {
                $this->_setSystemAttr($k, $v);
                unset($this->$k);
            }
        }
    }

    public function _save(&$error = NULL, &$message = NULL)
    {
        $this->_saveCheckExist();

        $t = $this->_check_slugs();

        if (!$t) {
            $error = true;
            $message = "Use another slug";
            return false;
        }

        // $this->syncChanges();
        // $this->syncChanges();

        $this->_prepare_for_save();

        // $this->refresh();
        parent::save();

        $this->_save_words();
        $this->_save_texts();
        $this->_save_slugs();

        return true;
    }

    public function _delete()
    {
        $this->_delete_words();
        $this->_delete_texts();
        $this->_delete_slugs();
        $this->_delete_attachements();
        $this->_delete_gallery();
        $this->_delete_videos();

        return parent::delete();
    }

    private function _delete_words()
    {
        $_words = $this->_words;
        if ($_words == null || !is_array($_words))
            return;

        $table = strtolower($this->_getClassName()) . '_word';

        $tobj = BaseWord::GetObj($table);

        $tquery = $tobj->query();
        $tquery = $tquery->where('idparent', $this->id);
        $tquery->from($table);
        $data = $tquery->get();

        foreach ($data as $item) {
            $item->_remove($table);
        }
    }


    private function _delete_texts()
    {
        $_texts = $this->_texts;
        if ($_texts == null || !is_array($_texts))
            return;

        $table = strtolower($this->_getClassName()) . '_text';

        $tobj = BaseText::GetObj($table);

        $tquery = $tobj->query();
        $tquery = $tquery->where('idparent', $this->id);
        $tquery->from($table);
        $data = $tquery->get();

        foreach ($data as $item) {
            $item->_remove($table);
        }
    }

    private function _delete_slugs()
    {
        $_words = $this->_words;
        if ($_words == null || !is_array($_words))
            return;
        if (!in_array('_slug', $_words))
            return;

        $tobj = Slug::GetObj();

        $tquery = $tobj->query();
        $tquery = $tquery->where('parentmodel', strtolower($this->_getClassName()));
        $tquery = $tquery->where('parentmodelid', $this->id);
        $tquery->delete();
    }

    private function _delete_attachements()
    {

        $all = Attachements::GetObj()->_getAll(array('_where' => array('parentmodel' => strtolower($this->_getClassName()), 'parentmodelid' => $this->id)));
        foreach ($all as $v) {
            $v->_delete();
        }
    }

    private function _delete_gallery()
    {

        $all = Gallery::GetObj()->_getAll(array('_where' => array('parentmodel' => strtolower($this->_getClassName()), 'parentmodelid' => $this->id)));
        foreach ($all as $v) {
            $v->_delete();
        }
    }

    private function _delete_videos()
    {

        $all = Video::GetObj()->_getAll(array('_where' => array('parentmodel' => strtolower($this->_getClassName()), 'parentmodelid' => $this->id)));
        foreach ($all as $v) {
            $v->_delete();
        }
    }

    private function _saveCheckExist()
    {
        if ($this->id)
            return;

        $_keys = $this->_keys;
        if ($_keys == null || !is_array($_keys))
            return;

        foreach ($_keys as $v) {
            if (is_array($v)) {
                if (!count($v))
                    continue;

                $exist = true;
                foreach ($v as $field) {
                    if (!$field)
                        continue;
                    if (!isset($this->$field)) {
                        $exist = false;
                        break;
                    }
                }
                if (!$exist)
                    continue;

                $tquery = $this->query();
                foreach ($v as $field) {
                    if (!$field)
                        continue;
                    $tquery = $tquery->where($field, $this->$field);
                }

                $tquery->from($this->getTable());

                $t = $tquery->first();
                if ($t == null)
                    continue;
                $this->id = $t->id;
                break;
            } else {
                if (!isset($this->$v))
                    continue;

                $tquery = $this->query();
                $tquery = $tquery->where($v, $this->$v);
                $tquery->from($this->getTable());

                $t = $tquery->first();
                if ($t == null)
                    continue;
                $this->id = $t->id;
                break;
            }
        }

        if ($this->id)
            $this->exists = true;
    }


    private function _save_words()
    {
        $_words = $this->_words;
        if ($_words == null || !is_array($_words))
            return;

        if (!is_array($this->_systemAttr))
            return;
        if (!count($this->_systemAttr))
            return;
        if (!$this->_systemAttr['_idlang'])
            return;

        if (!is_array($this->_wordsAttr))
            return;
        if (!count($this->_wordsAttr))
            return;

        $table = strtolower($this->_getClassName()) . '_word';

        foreach ($this->_wordsAttr as $attr => $value) {
            $tobj = BaseWord::GetObj($table);

            $tobj->idparent = $this->id;
            $tobj->idlang = $this->_systemAttr['_idlang'];
            $tobj->attr = $attr;
            $tobj->value = $value;

            $tobj->_save();
        }
    }

    private function _save_texts()
    {
        $_texts = $this->_texts;
        if ($_texts == null || !is_array($_texts))
            return;

        if (!is_array($this->_systemAttr))
            return;
        if (!count($this->_systemAttr))
            return;
        if (!$this->_systemAttr['_idlang'])
            return;

        if (!is_array($this->_textsAttr))
            return;
        if (!count($this->_textsAttr))
            return;

        $table = strtolower($this->_getClassName()) . '_text';

        foreach ($this->_textsAttr as $attr => $value) {
            $tobj = BaseText::GetObj($table);

            $tobj->idparent = $this->id;
            $tobj->idlang = $this->_systemAttr['_idlang'];
            $tobj->attr = $attr;
            $tobj->value = $value;

            $tobj->_save();
        }
    }


    private function _save_slugs()
    {

        $_words = $this->_words;
        if ($_words == null || !is_array($_words))
            return;

        if (!in_array('_slug', $_words))
            return;

        if (!is_array($this->_systemAttr))
            return;
        if (!count($this->_systemAttr))
            return;
        if (!$this->_systemAttr['_idlang'])
            return;

        if (!is_array($this->_wordsAttr))
            return;
        if (!count($this->_wordsAttr))
            return;
        if (!isset($this->_wordsAttr['_slug']) || !$this->_wordsAttr['_slug'])
            return true;


        $tobj = Slug::GetObj();

        $tobj->parentmodel = strtolower($this->_getClassName());
        $tobj->parentmodelid = $this->id;
        $tobj->idlang = $this->_systemAttr['_idlang'];
        $tobj->slug = $this->_wordsAttr['_slug'];

        $tobj->_save();
    }

    private function _check_slugs()
    {
        $_words = $this->_words;
        if ($_words == null || !is_array($_words))
            return true;
        if (!in_array('_slug', $_words))
            return true;

        if (!isset($this->_wordsAttr['_slug']) || !$this->_wordsAttr['_slug'])
            return true;

        $t = Slug::GetObj()->where('slug', $this->_wordsAttr['_slug'])->get();
        $t = $t->all();
        if (!count($t))
            return true;
        $obj = reset($t);

        if ($obj->parentmodel != strtolower($this->_getClassName()))
            return false;
        if ($obj->parentmodelid != $this->id)
            return false;

        return true;
    }

    protected function _loadVideos($params)
    {
        $parentmodel = strtolower($this->_getClassName());
        $tall = Video::GetObj()->query()->where('parentmodel', $parentmodel)->where('parentmodelid', $this->id)->get();
        $items = $tall->all();

        $arr = array();
        foreach ($items as $v) {
            $v->processObject($v, $params);
            $arr[] = $v;
        }

        $this->_videos = $arr;
    }

    protected function _loadActiveVideos($params)
    {
        $parentmodel = strtolower($this->_getClassName());
        $tall = Video::GetObj()->query()->where('parentmodel', $parentmodel)->where('parentmodelid', $this->id)->where('status', Status::ACTIVE)->get();
        $items = $tall->all();

        $arr = array();
        foreach ($items as $v) {
            $v->processObject($v, $params);
            $arr[] = $v;
        }

        $this->_activeVideos = $arr;
    }

    protected function _loadGallery($params)
    {

        $parentmodel = strtolower($this->_getClassName());
        $tall = Gallery::GetObj()->query()->where('parentmodel', $parentmodel)->where('parentmodelid', $this->id)->get();
        $items = $tall->all();
        $arr = array();
        foreach ($items as $v) {
            $v->processObject($v, $params);
            $arr[] = $v;
        }

        $this->_gallery = $arr;
    }

    protected function _loadActiveGallery($params)
    {
        $parentmodel = strtolower($this->_getClassName());
        $tall = Gallery::GetObj()->query()->where('parentmodel', $parentmodel)->where('parentmodelid', $this->id)->where('status', Status::ACTIVE)->get();
        $items = $tall->all();

        $arr = array();
        foreach ($items as $v) {
            $v->processObject($v, $params);
            $arr[] = $v;
        }
        
        $this->_activeGallery = $arr;
    }

    protected function _setDefaultGalleryObj()
    {
        if (!is_array(($this->_activeGallery))) {
            return;
        }
        if (!count(($this->_activeGallery))) {
            return;
        }

        $tmpObj = false;
        foreach ($this->_activeGallery as $item) {
            if ($item->isdefault == Status::YES) {
                $tmpObj = $item;
                break;
            }
            if (!$tmpObj)
                $tmpObj = $item;
        }
        if (!$tmpObj) {
            return;
        }


        $this->_setSystemAttr('_defaultGalleryObj', $tmpObj);
    }

    protected function _loadAttachements($params)
    {
        $parentmodel = strtolower($this->_getClassName());
        $tall = Attachements::GetObj()->query()->where('parentmodel', $parentmodel)->where('parentmodelid', $this->id)->get();
        $items = $tall->all();

        $arr = array();
        foreach ($items as $v) {
            $v->processObject($v, $params);
            $arr[] = $v;
        }

        $this->_attachements = $arr;
    }

    protected function _loadActiveAttachements($params)
    {
        $parentmodel = strtolower($this->_getClassName());
        $tall = Attachements::GetObj()->query()->where('parentmodel', $parentmodel)->where('parentmodelid', $this->id)->where('status', Status::ACTIVE)->get();
        $items = $tall->all();

        $arr = array();
        foreach ($items as $v) {
            $v->processObject($v, $params);
            $arr[] = $v;
        }

        $this->_activeAttachements = $arr;
    }

    protected function _loadWords($params)
    {
        $_words = $this->_words;
        if ($_words == null || !is_array($_words))
            return;

        $table = strtolower($this->_getClassName()) . '_word';

        $tobj = BaseWord::GetObj($table);

        $tquery = $tobj->query();
        $tquery = $tquery->where('idparent', $this->id);
        $tquery = $tquery->where('idlang', $this->_idlang);
        $tquery->from($tobj->getTable());

        $data = $tquery->get();

        if (!count($data) && isset($params['_musttranslate']) && $params['_musttranslate'] == 1) {
            $tquery = $tobj->query();
            $tquery = $tquery->where('idparent', $this->id);
            $tquery = $tquery->where('idlang', Lang::_getSessionId());
            $tquery->from($tobj->getTable());

            $data = $tquery->get();
        }

        if (!count($data) && isset($params['_musttranslate']) && $params['_musttranslate'] == 1) {
            $tquery = $tobj->query();
            $tquery = $tquery->where('idparent', $this->id);
            $tquery = $tquery->limit(1);
            $tquery->from($tobj->getTable());

            $td = $tquery->get()->first();
            if ($td) {
                $tquery = $tobj->query();
                $tquery = $tquery->where('idparent', $this->id);
                $tquery = $tquery->where('idlang', $td->idlang);
                $tquery->from($tobj->getTable());

                $data = $tquery->get();
            }
        }

        foreach ($data as $item) {
            $var = $item->attr;
            $this->$var = $item->value;
        }
    }

    protected function _loadTexts($params)
    {
        $_texts = $this->_texts;
        if ($_texts == null || !is_array($_texts))
            return;

        $table = strtolower($this->_getClassName()) . '_text';

        $tobj = BaseText::GetObj($table);

        $tquery = $tobj->query();
        $tquery = $tquery->where('idparent', $this->id);
        $tquery = $tquery->where('idlang', $this->_idlang);
        $tquery->from($tobj->getTable());

        $data = $tquery->get();

        if (!count($data) && isset($params['_musttranslate']) && $params['_musttranslate'] == 1) {
            $tquery = $tobj->query();
            $tquery = $tquery->where('idparent', $this->id);
            $tquery = $tquery->where('idlang', Lang::_getSessionId());
            $tquery->from($tobj->getTable());

            $data = $tquery->get();
        }

        foreach ($data as $item) {
            $var = $item->attr;
            $this->$var = $item->value;
        }
    }

    public static function _getSession($key)
    {
        $all = session()->all();

        if (!isset($all[$key]))
            return null;

        $t = $all[$key];
        if (is_array($t) && array_key_first($t) == 0) {
            $t = reset($t);
        }
        return $t;
    }

    public static function _putSession($key, $val)
    {
        session()->put($key, $val);
    }

    public static function _pushSession($key, $val)
    {
        session()->push($key, $val);
    }

    public function _getAdminId($field)
    {
        return 'edit_label_' . $this->id . '_' . $field;
    }

    public function _adminChangeLang($id, $_idlang)
    {
        $obj = self::findOrFail($id);
        if (!$obj)
            exit();

        $params = array();
        $params['_admin'] = '1';
        $params['_wr'] = '1';
        $params['_idlang'] = $_idlang;

        $obj->processObject($obj, $params);

        $rez = array();

        $_words = $obj->_words;
        $_texts = $obj->_texts;

        if (is_null($_words))
            $_words = array();
        if (is_null($_texts))
            $_texts = array();

        $fields = array_merge($_words, $_texts);

        $rez['vals'] = array();
        foreach ($fields as $v) {
            $t = array();
            $t['field'] = $v;
            $t['mainin'] = $obj->_getAdminId($v);
            $t['selected'] = '#' . $obj->_getAdminId($v);
            $t['value'] = $obj->$v;
            $rez['vals'][] = $t;
        }

        return response()->json($rez);
    }
    public function _adminChangePage($id, $idpage)
    {
        $obj = self::findOrFail($id);
        if (!$obj)
            exit();

        $params = array();
        $params['_admin'] = '1';
        $params['_wr'] = '1';
        $params['idpage'] = $idpage;

        $obj->processObject($obj, $params);

        $rez = array();

        $_words = $obj->_words;
        $_texts = $obj->_texts;

        if (is_null($_words))
            $_words = array();
        if (is_null($_texts))
            $_texts = array();

        $fields = array_merge($_words, $_texts);

        $rez['vals'] = array();
        foreach ($fields as $v) {
            $t = array();
            $t['field'] = $v;
            $t['mainin'] = $obj->_getAdminId($v);
            $t['selected'] = '#' . $obj->_getAdminId($v);
            $t['value'] = $obj->$v;
            $rez['vals'][] = $t;
        }

        return response()->json($rez);
    }

    public function _toArray()
    {
        $rez = $this->toArray();
        $rez = array_merge($rez, $this->_toArray_words());
        $rez = array_merge($rez, $this->_toArray_texts());

        return $rez;
    }

    private function _toArray_words()
    {
        $_words = $this->_words;
        if ($_words == null || !is_array($_words))
            return array();

        $rez = array();
        if ($this->_idlang != null)
            $rez['_idlang'] = $this->_idlang;
        foreach ($_words as $v) {
            if ($this->$v == null)
                continue;
            $rez[$v] = $this->$v;
        }

        return $rez;
    }

    private function _toArray_texts()
    {
        $_texts = $this->_texts;
        if ($_texts == null || !is_array($_texts))
            return array();

        $rez = array();
        if ($this->_idlang != null)
            $rez['_idlang'] = $this->_idlang;
        foreach ($_texts as $v) {
            if ($this->$v == null)
                continue;
            $rez[$v] = $this->$v;
        }

        return $rez;
    }


    public function _setParams()
    {
    }

    protected function _setMediaParams()
    {
        if (!$this)
            return;

        $t = request()->query('filter');
        if (is_array($t) && isset($t['parentmodel']) && !$this->parentmodel)
            $this->parentmodel = $t['parentmodel'];
        else{
            $this->parentmodel = -1;
        }
        if (is_array($t) && isset($t['parentmodelid']) && !$this->parentmodelid)
            $this->parentmodelid = $t['parentmodelid'];
        else{
            $this->parentmodelid = -1;
        }
    }

    protected function _setOfferParams()
    {
        if (!$this)
            return;

        $t = request()->query('filter');
        if (is_array($t) && isset($t['idproduct']) && !$this->idproduct)
            $this->idproduct = $t['idproduct'];
    }

    protected function _setParamsParent()
    {
        if (!$this)
            return;

        $t = request()->query('filter');
        if (is_array($t) && isset($t['idparent']) && !$this->idparent)
            $this->idparent = $t['idparent'];
    }

    protected function _setFilterCategory()
    {
        if (!$this)
            return;

        $t = request()->query('filter');
        if (is_array($t) && isset($t['idcategory']) && !$this->idcategory)
            $this->idcategory = $t['idcategory'];
    }

    protected function _setFilterProduct()
    {
        if (!$this)
            return;

        $t = request()->query('filter');
        if (is_array($t) && isset($t['idproduct']) && !$this->idproduct)
            $this->idproduct = $t['idproduct'];
    }

    protected function _setUserParent()
    {
        if (!$this)
            return;

        $t = request()->query('filter');
        if (is_array($t) && isset($t['iduser']) && !$this->iduser)
            $this->iduser = $t['iduser'];
    }

    protected function _setProductParent()
    {
        if (!$this)
            return;

        $t = request()->query('filter');
        if (is_array($t) && isset($t['idproduct']) && !$this->idproduct)
            $this->idproduct = $t['idproduct'];
    }

    // =================================================================


    public function _getModifyAdminParams($excluded = array())
    {
        $excluded = (array) $excluded;

        $rez = (array) request()->query();

        if (!in_array('id', $excluded))
            $rez['id'] = $this->id;

        return $rez;
    }

    public function _getMediaAdminParams($backRoute)
    {
        $rez = array();
        $rez['filter[parentmodel]'] = $this->_getClassName(true);
        $rez['filter[parentmodelid]'] = $this->id;
        $rez['_mediainfo'] = $this->_name;
        $rez['_backurl'] = route($backRoute, $this->_getModifyAdminParams());

        return $rez;
    }

    public function _getFilterParams($backRoute)
    {
        $rez = array();
        $rez['filter[idcategory]'] = $this->id;
        $rez['_mediainfo'] = $this->_name;
        $rez['_backurl'] = route($backRoute, $this->_getModifyAdminParams());

        return $rez;
    }

    public function _getFilterProduct($backRoute)
    {
        $rez = array();
        $rez['filter[idproduct]'] = $this->id;
        $rez['_mediainfo'] = $this->_name;
        $rez['_backurl'] = route($backRoute, $this->_getModifyAdminParams());

        return $rez;
    }

    public function _getAutoParams($backRoute)
    {
        $rez = array();
        $rez['filter[idproduct]'] = $this->id;
        $rez['_mediainfo'] = $this->_name;
        $rez['_backurl'] = route($backRoute, $this->_getModifyAdminParams());

        return $rez;
    }

    public function _getOfferParams($backRoute)
    {
        $rez = array();
        $rez['filter[idproduct]'] = $this->id;
        $rez['_backurl'] = route($backRoute, $this->_getModifyAdminParams());

        return $rez;
    }

    public function _getUserParams($backRoute)
    {
        $rez = array();
        $rez['filter[iduser]'] = $this->id;
        $rez['_backurl'] = route($backRoute, $this->_getModifyAdminParams());

        return $rez;
    }

    // public function _getFaqSpecialAdminParams($backRoute){
    //     $rez = $this->_getMediaAdminParams($backRoute);
    //     return $rez;
    // }

    public function _getChildAdminParams($backRoute)
    {
        $rez = array();
        $rez['filter[idparent]'] = $this->id;
        $rez['_mediainfo'] = $this->_name;
        $rez['_backurl'] = route($backRoute, $this->_getModifyAdminParams());

        return $rez;
    }

    public function _getFaqAdminParams($backRoute)
    {
        $rez = array();
        $rez['filter[idfaq]'] = $this->id;
        $rez['_mediainfo'] = $this->_name;
        $rez['_backurl'] = route($backRoute, $this->_getModifyAdminParams());

        return $rez;
    }

    public function getWords()
    {
        return $this->_words;
    }


    public function _defaultGalleryGetUrl($w = 0, $h = 0)
    {
        $obj = $this->getDefaultImage();
        if ($obj) {
            return $obj->systemfileobj->getUrl($w, $h);
        } else {
            return "/assets/images/nofile.png";
        }
    }
    public function getDefaultImage()
    {
        return $this->_getSystemAttribute('_defaultGalleryObj');
    }

    public function _canDelete()
    {

        if (!$this->id) {
            return false;
        }

        if ($this->fixed || $this->fixed == 1) {
            return false;
        }

        if (is_array($this->_gallery) && count($this->_gallery)) {
            return false;
        }

        if (is_array($this->_attachements) && count($this->_attachements)) {
            return false;
        }

        if (is_array($this->_videos) && count($this->_videos)) {
            return false;
        }

        return true;
    }
}