<?php

namespace App\Orchid\Screens\SystemVideo;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use App\Models\Base\SystemVideo;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;

class SystemVideoEditScreen extends BaseEditScreen
{
    /**
     * @var SystemFile
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = SystemVideo::GetObj();
    }

    /**
     * Query data.
     *
     * @param SystemVideo $obj
     *
     * @return array
     */
    public function query(SystemVideo $obj): array
    {
        return parent::_query($obj);
    }

    /**
     * Views.
     *
     * @return Layout[]
     */
    public function layout(): array
    { 
        return [
            Layout::rows([

                Input::make('obj._requestInfo')
                    ->set('hidden', true),
                Input::make('raw_video')
                    ->title('Video url')
                    ->horizontal(),
            ])
        ];
    }


    /**
     * @param SystemVideo    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(SystemVideo $obj, Request $request)
    {   
        $url = request()->request;
        $url= $url->get('raw_video');
        
        $obj = SystemVideo::SV_URL($url, $obj->id);
        
        Alert::info('You have successfully created a file');
        return redirect()->route('platform.systemvideo.list', array()); 
    }

    public function backroute(SystemVideo $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }

}

