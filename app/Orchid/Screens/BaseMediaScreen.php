<?php

namespace App\Orchid\Screens;


use App\Orchid\Screens\BaseListScreen ;
use Orchid\Screen\Actions\Link;

class BaseMediaScreen extends BaseListScreen
{

    protected $stricktMode = true;

        /**
     * Button commands.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        $rez = [];

        if(request()->get('_backurl'))
        {
            $rez[] =                 
                Link::make(__('Back to main list'))
                    ->icon('plus')
                    ->href(request()->get('_backurl'));
        }

        return $rez;
    }

    public function view(array $httpQueryArguments = [])
    {
        if (!$this->checkNeedParams())
        {
            return redirect(route('platform.main'));
        }

        return parent::view($httpQueryArguments);
    }


    protected function checkNeedParams()
    {
        $rez = true;

        if (!request()->get('filter') && $rez) $rez = false;

        $tf = request()->get('filter');
        if (!isset($tf['parentmodel']) && $rez) $rez = false;
        if (!isset($tf['parentmodelid']) && $rez) $rez = false;
        

        if ($this->stricktMode) return $rez;

        if (!$rez) return $this->setDefaultData();

        return true;
    }

    protected function setDefaultData()
    {
        $tf = (isset(request()->query()['filter'])) ? (array)request()->query()['filter'] : array();
        if (!isset($tf['parentmodel'])) $tf['parentmodel'] = '-1';
        if (!isset($tf['parentmodelid'])) $tf['parentmodelid'] = '-1';
        request()->merge(array('filter' => $tf));
        return true;
    }

}
