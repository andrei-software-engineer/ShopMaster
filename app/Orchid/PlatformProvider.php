<?php

declare(strict_types=1);

namespace App\Orchid;

use App\Models\Base\Acl;
use App\Models\Base\Status;
use App\Models\Page\Page;
use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;
use Orchid\Support\Color;

class PlatformProvider extends OrchidServiceProvider
{
    /**
     * @param Dashboard $dashboard
     */
    public function boot(Dashboard $dashboard): void
    {
        parent::boot($dashboard);
    }

    /**
     * @return Menu[]
     */

    public function getAcl($rez){

        if(Acl::checkAccess('platform.example')){
            $rez[] = Menu::make('Example screen')
                        ->icon('monitor')
                        ->route('platform.example')
                        ->badge(fn () => 6);
        }

        if(Acl::checkAccess('platform.example.fields')){
            $rez[] = Menu::make('Basic Elements')
                        ->icon('note')
                        ->route('platform.example.fields');
        }

        if(Acl::checkAccess('platform.example.advanced')){
            $rez[] = Menu::make('Advanced Elements')
                        ->icon('briefcase')
                        ->route('platform.example.advanced');
        }

        if(Acl::checkAccess('platform.example.editors')){
            $rez[] = Menu::make('Text Editors')
                    ->icon('list')
                    ->route('platform.example.editors');
        }

        if(Acl::checkAccess('platform.example.layouts')){
            $rez[] = Menu::make('Overview layouts')
                        ->icon('layers')
                        ->route('platform.example.layouts');
        }

        if(Acl::checkAccess('platform.example.charts')){
            $rez[] = Menu::make('Chart tools')
                        ->icon('bar-chart')
                        ->route('platform.example.charts');
        }

        
        $rez[] = Menu::make('Documentation')
                    ->icon('docs')
                    ->url('https://orchid.software/en/docs');

        $rez[] = Menu::make('Changelog')
                    ->icon('shuffle')
                    ->url('https://github.com/orchidsoftware/platform/blob/master/CHANGELOG.md')
                    ->target('')
                    ->badge(fn () => Dashboard::version(), Color::DARK());

        if(Acl::checkAccess('platform.example.cards')){
            $rez[] = Menu::make('Cards')
                        ->icon('grid')
                        ->route('platform.example.cards')
                        ->divider();
        }

        return $rez;
    }

    public function getSystem($rez):array {
        

        if(Acl::checkAccess('platform.systems.users')){
            $rez[] = Menu::make(__('Users'))
                        ->icon('user')
                        ->route('platform.systems.users')
                        ->permission('platform.systems.users');

        }

        if(Acl::checkAccess('platform.infouser.list')){
            $rez[] = Menu::make('Info Users')
                        ->icon('envelope-letter')
                        ->route('platform.infouser.list');
        }

        if(Acl::checkAccess('platform.systems.roles')){
            $rez[] = Menu::make(__('Roles'))
                        ->icon('lock')
                        ->route('platform.systems.roles')
                        ->permission('platform.systems.roles');

        }

        // if(Acl::checkAccess('platform.acl.list')){
        //     $rez[] = Menu::make('Acl')
        //                 ->icon('envelope-letter')
        //                 ->route('platform.acl.list');
        // }

        if(Acl::checkAccess('platform.lang.list')){
            $rez[] = Menu::make('Lang')
                ->icon('globe-alt')
                ->route('platform.lang.list');
        }

        if(Acl::checkAccess('platform.label.list')){
            $rez[] = Menu::make('Label')
                            ->icon('tag')
                            ->route('platform.label.list');
        }

        // if(Acl::checkAccess('platform.config.list')){
        //     $rez[] = Menu::make('Config')
        //                 ->icon('key')
        //                 ->route('platform.config.list');
        // }

        if(Acl::checkAccess('platform.systemfile.list')){
            $rez[] = Menu::make('System File ')
                        ->icon('docs')
                        ->route('platform.systemfile.list');
        }

        // if(Acl::checkAccess('platform.systemmenu.list')){
        //     $rez[] = Menu::make('System Menu ')
        //                 ->icon('menu')
        //                 ->route('platform.systemmenu.list');
        // }

        if(Acl::checkAccess('platform.systemvideo.list')){
            $rez[] = Menu::make('System Video ')
                        ->icon('video')
                        ->route('platform.systemvideo.list');
        }


        return $rez;
    }

    
    public function getPages($rez){
        
        if(Acl::checkAccess('platform.faq.list')){
            $rez[] = Menu::make('Faq')
                        ->icon('text-middle')
                        ->route('platform.faq.list');
        }

        if(Acl::checkAccess('platform.page.list')){
            $rez[] = Menu::make('Page')
                        ->icon('speech')
                        ->route('platform.page.list');
        }


        if(Acl::checkAccess('platform.maps.list')){
            $rez[] = Menu::make('Maps ')
                        ->icon('map')
                        ->route('platform.maps.list');
        }

        if(Acl::checkAccess('platform.product.list')){
            $rez[] = Menu::make('Product')
                        ->icon('module')
                        ->route('platform.product.list');
        }

        if(Acl::checkAccess('platform.offer.list')){
            $rez[] = Menu::make('Product Offer')
            ->icon('modules')
            ->route('platform.offer.list');
        }

        
        if(Acl::checkAccess('platform.benefits.list')){
            $rez[] = Menu::make('Benefits')
                        ->icon('notebook')
                        ->route('platform.benefits.list');
        }

        // if(Acl::checkAccess('platform.publicity.list')){
        //     $rez[] = Menu::make('Publicity')
        //                 ->icon('save')
        //                 ->route('platform.publicity.list');
        // }



        // if(Acl::checkAccess('platform.location.list')){
        //     $rez[] = Menu::make('Location ')
        //                 ->icon('pointer')
        //                 ->route('platform.location.list');
        // }

        if(Acl::checkAccess('platform.favorite.list')){
            $rez[] = Menu::make('Favorites')
                        ->icon('heart')
                        ->route('platform.favorite.list');
        }


        if(Acl::checkAccess('platform.socialmedia.list')){
            $rez[] = Menu::make('Social Media')
                        ->icon('share')
                        ->route('platform.socialmedia.list');
        }



        return $rez;
    }


    public function getFilters($rez){
        
        if(Acl::checkAccess('platform.filter.list')){
            $rez[] = Menu::make('Filter')
                        ->icon('fingerprint')
                        ->route('platform.filter.list');
        }

        if(Acl::checkAccess('platform.category.list')){
            $rez[] = Menu::make('Category')
                        
                        ->icon('envelope-letter')
                        ->route('platform.category.list');
        }


        if(Acl::checkAccess('platform.filtervalue.list')){
            $rez[] = Menu::make('Filter value')
                        ->icon('speedometer')
                        ->route('platform.filtervalue.list');
        }


        return $rez;
    }

    // public function getNotifications($rez):array {
        
    //     if(Acl::checkAccess('platform.fromemail.list')){
    //         $rez[] = Menu::make(__('From Email'))
    //                     ->icon('envelope-letter')
    //                     ->route('platform.fromemail.list');
    //     }

    //     if(Acl::checkAccess('platform.mailtosend.list')){
    //         $rez[] = Menu::make('Mail to send')
    //             ->icon('envelope')
    //             ->route('platform.mailtosend.list');
    //     }

    //     if(Acl::checkAccess('platform.subscription.list')){
    //         $rez[] = Menu::make('Subscription')
    //             ->icon('user-follow')
    //             ->route('platform.subscription.list');
    //     }


    //     if(Acl::checkAccess('platform.smstosend.list')){
    //         $rez[] = Menu::make('Sms to send')
    //             ->icon('compass')
    //             ->route('platform.smstosend.list');
    //     }
        
    //     if(Acl::checkAccess('platform.smstemplate.list')){
    //         $rez[] = Menu::make('Sms Template')
    //             ->icon('drawer')
    //             ->route('platform.smstemplate.list');
    //     }

    //     if(Acl::checkAccess('platform.emailtemplate.list')){
    //         $rez[] = Menu::make('Email Template')
    //             ->icon('crop')
    //             ->route('platform.emailtemplate.list');
    //     }


    //     return $rez;
    // }    


    public function getOrder($rez):array {

        if(Acl::checkAccess('platform.order.list')){
            $rez[] = Menu::make('New ')
                        ->icon('new-doc')
                        ->route('platform.order.list', ['filter[status]'=> Status::NEW]);
        }


        if(Acl::checkAccess('platform.order.list')){
            $rez[] = Menu::make('Pending  ')
                        ->icon('open')
                        ->route('platform.order.list',['filter[status]'=> Status::PENDING]);
        }


        if(Acl::checkAccess('platform.order.list')){
            $rez[] = Menu::make('Verified ')
                        ->icon('envelope-letter')
                        ->route('platform.order.list',['filter[status]'=> Status::VERIFIED]);
        }


        if(Acl::checkAccess('platform.order.list')){
            $rez[] = Menu::make('In process ')
                        ->icon('reload')
                        ->route('platform.order.list',['filter[status]'=> Status::INPROCESS]);
        }


        if(Acl::checkAccess('platform.order.list')){
            $rez[] = Menu::make('Processed ')
                        ->icon('plus')
                        ->route('platform.order.list',['filter[status]'=> Status::PROCESSED]);
        }


        if(Acl::checkAccess('platform.order.list')){
            $rez[] = Menu::make('On transit ')
                        ->icon('rocket')
                        ->route('platform.order.list',['filter[status]'=> Status::ONTRANSIT]);
        }


        if(Acl::checkAccess('platform.order.list')){
            $rez[] = Menu::make('On delivery ')
                        ->icon('pin')
                        ->route('platform.order.list',['filter[status]'=> Status::ONDELIVERY]);
        }


        if(Acl::checkAccess('platform.order.list')){
            $rez[] = Menu::make('Delivered ')
                        ->icon('home')
                        ->route('platform.order.list',['filter[status]'=> Status::DELIVERED]);
        }


        if(Acl::checkAccess('platform.order.list')){
            $rez[] = Menu::make('Confirmed ')
                        ->icon('like')
                        ->route('platform.order.list',['filter[status]'=> Status::CONFIRMED]);
        }


        if(Acl::checkAccess('platform.order.list')){
            $rez[] = Menu::make('Canceled ')
                        ->icon('ban')
                        ->route('platform.order.list',['filter[status]'=> Status::CANCELED]);
        }

        if(Acl::checkAccess('platform.order.list')){
            $rez[] = Menu::make('Arhived ')
                        ->icon('briefcase')
                        ->route('platform.order.list',['filter[status]'=> Status::ARHIVED]);
        }

        return $rez;
    }  


    public function getPayment($rez):array {

        if(Acl::checkAccess('platform.transaction.list')){
            $rez[] = Menu::make('Transaction ')
                        ->icon('cursor')
                        ->route('platform.transaction.list');
        }


        if(Acl::checkAccess('platform.paynetwallet.list')){
            $rez[] = Menu::make('Paynet Wallet  ')
                        ->icon('dollar')
                        ->route('platform.paynetwallet.list');
        }

        if(Acl::checkAccess('platform.paynettransaction.list')){
            $rez[] = Menu::make('Paynet Transaction ')
                        ->icon('money')
                        ->route('platform.paynettransaction.list');
        }

        if(Acl::checkAccess('platform.paynettransactionjurnal.list')){
            $rez[] = Menu::make('Paynet Transaction Jurnal')
                        ->icon('note')
                        ->route('platform.paynettransactionjurnal.list');
        }

        return $rez;
    }    


    public function registerMainMenu(): array
    {
        $rez = array();
        $system = array();
        $general = array();
        $filters = array();
        $notifications = array();
        $order = array();
        $payment = array();
        $orchild = array();


        $rez[]=  Menu::make('System list')
                ->icon('settings')
                ->list($this->getSystem($system));

        $rez[]=  Menu::make('General list')
                ->icon('organization')
                ->list($this->getPages($general));

        $rez[]=  Menu::make('Filters list')
                ->icon('filter')
                ->list($this->getFilters($filters));

        // $rez[]=  Menu::make('Notification list')
        //         ->icon('bubbles')
        //         ->list($this->getNotifications($notifications));

        $rez[]=  Menu::make('Order list')
                ->icon('handbag')
                ->list($this->getOrder($order));

        $rez[]=  Menu::make('Payment list')
                ->icon('credit-card')
                ->list($this->getPayment($payment));
        
        // $rez[]=  Menu::make('Orchild list')
        //         ->icon('orchid')
        //         ->list($this->getAcl($orchild));

        return $rez;
    }

    /**
     * @return Menu[]
     */
    public function registerProfileMenu(): array
    {
        return [
            Menu::make(__('Profile'))   
                ->route('platform.profile')
                ->icon('user'),
        ];
    }

    /**
     * @return ItemPermission[]
     */
    public function registerPermissions(): array
    {
        return [
            ItemPermission::group(__('System'))
                ->addPermission('platform.systems.roles', __('Roles'))
                ->addPermission('platform.systems.users', __('Users')),
        ];
    }
}
