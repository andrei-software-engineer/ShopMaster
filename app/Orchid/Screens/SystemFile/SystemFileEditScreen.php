<?php

namespace App\Orchid\Screens\SystemFile;

use Illuminate\Http\Request;
use Orchid\Screen\Fields\Input;
use App\Models\Base\SystemFile;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;
use App\Orchid\Screens\BaseEditScreen;

class SystemFileEditScreen extends BaseEditScreen
{
    /**
     * @var SystemFile
     */
    public $obj;
    
    public $targetClass = false;

    public function __construct()
    {
        $this->targetClass = SystemFile::GetObj();
    }

    /**
     * Query data.
     *
     * @param SystemFile $obj
     *
     * @return array
     */
    public function query(SystemFile $obj): array
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

                Input::make('raw_file')
                    ->type('file')
                    ->title('File input ')
                    ->horizontal(),
            ])
        ];
    }


    /**
     * @param SystemFile    $obj
     * @param Request $request
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function createOrUpdate(SystemFile $obj, Request $request)
    {   
        $obj = SystemFile::saveFiles($request->file('raw_file'));

        Alert::info('You have successfully created a file');
        return redirect()->route('platform.systemfile.list', array()); 
    }

    public function backroute(SystemFile $obj, Request $request)
    {
        return parent::_backroute($obj, $request);
    }

}

