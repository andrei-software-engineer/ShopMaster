<?php

namespace App\Http\Controllers;

use App\Models\Base\Slug;
use App\Models\Base\Status;
use Illuminate\Http\Request;
use App\Models\Base\SystemMenu;
use App\GeneralClasses\SEOTools;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Faq\FaqController;
use Illuminate\Foundation\Bus\DispatchesJobs;
use App\Http\Controllers\Home\HomeController;
use App\Http\Controllers\General\TopController;
use App\Http\Controllers\Lang\LangController;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\Order\OrderController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Filter\FilterController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Publicity\PublicityController;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Http\Controllers\SocialMedia\SocialMediaController;
use App\Http\Controllers\SpecialFilter\SpecialFilterController;
use App\Models\Page\Page;
use Orchid\Platform\Models\Role;
use Orchid\Platform\Models\User;
use App\Models\Allegro\AllegroTools;
use App\Models\Payment\Paynetwallet;

use function GuzzleHttp\Promise\queue;

// class TestController 
// {    
//     $adminRole = Role::where('slug', 'admin')->first();
//     $user = User::find(1); // Get user by ID
//     $user->roles()->attach($adminRole);
// }
