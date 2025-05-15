<?php

namespace App\Orchid\Screens\Acl;

use Illuminate\Http\Request;
use App\Models\Base\Acl;
use Orchid\Platform\Models\Role;
use Orchid\Support\Facades\Layout;
use Illuminate\Support\Facades\Route;
use App\Orchid\Screens\BaseListScreen;

class AclListScreen extends BaseListScreen
{
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = Acl::GetObj();
    }
    
    public function query(): array
    {   $data = $this->parseRoutes();
        $data = $data['platform'];

        $saveurl = route('platform.acl.editcl');
        $saveurl .= '?';

        $params = array();
        $params['roles'] = Role::get()->all();
        $params['routes'] = $this->parseRoutes();
        $params['saveurl'] = $saveurl;
        $params = $this->loadCheckeds($params);
        
        return [
            'data' => $params,
        ];
    }
    
    /**
     * Views.
     *
     * @return Layout[]
     */
     public function layout(): array
     {         
        return [
            Layout::view('Orchid.acl'),
        ];
     } 

     public function saveACL(Request $request) {
        
        $tobj = Acl::GetObj();
        
        $tobj->route = $request->get('route');
        $tobj->value = $request->get('value');
        $tobj->role_id = $request->get('role_id');
        $tobj->module = $request->get('module');
        $tobj->method = $request->get('method');
        
        $tobj->_save();

        return $tobj->_toArray();
     }

     protected function parseRoutes()
     {
        $allRoutes = Route::getRoutes()->compile();
        $attr = $allRoutes['attributes'];
        
        $arr = array();
        foreach($attr as $k => $v)
        {
            $t = explode('.', $k, 2);
            $group = array_shift($t);

            if (!isset($arr[$group])) 
            {
                $arr[$group] = array();
            }
            
            $arr[$group][implode('.',$t)] = $v['methods'];
        }
        return $arr;

     }

     protected function loadCheckeds($params)
     {
        $results = array();
        foreach ($params['routes'] as $k => $v)
        {
            if (!isset($results['routes'][$k])) $results['routes'][$k] = array();
            foreach ($v as $k1 => $v1)
            {
                if (!isset($results['routes'][$k][$k1])) $results['routes'][$k][$k1] = array();
                foreach ($v1 as $k2 => $v2)
                {
                    if (!isset($results['routes'][$k][$k1][$v2])) $results['routes'][$k][$k1][$v2] = array();
                    $route = $k.'.'.$k1;
                    $method = $v2;

                    foreach ($params['roles'] as $role)
                    {
                        $t = Acl::GetObj()->query()->where('route', $route)->where('method', $method)->where('role_id', $role->id)->first();
                        if (!$t)
                        {
                            $results['routes'][$k][$k1][$v2][$role->id] = 1;
                        } else
                        {
                            $results['routes'][$k][$k1][$v2][$role->id] = (int)$t->value;
                        }
                    }
                }
            }
        }

        $params['results'] = $results;

        return $params;
     }

}