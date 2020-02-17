<?php

namespace App\Providers;

use App\Http\Controllers\api\wechatAddress;
use App\Http\Controllers\api\wechatCachet;
use App\Http\Controllers\api\wechatCakind;
use App\Http\Controllers\api\wechatCompanyInfo;
use App\Http\Controllers\api\wechatExpress;
use App\Http\Controllers\api\wechatOrder;
use App\Http\Controllers\api\wechatRemindinfo;
use App\Http\Controllers\api\wechatShopcar;
use App\Http\Controllers\api\wechatUsers;
use App\Repositories\AddressRepository;
use App\Repositories\BaseRepository;
use App\Repositories\CachetRepository;
use App\Repositories\CakindRepository;
use App\Repositories\ExpressRepository;
use App\Repositories\MakerInfoRepository;
use App\Repositories\OrderRepository;
use App\Repositories\RemindinfoRepository;
use App\Repositories\ShopcarRepository;
use App\Repositories\UsersRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
        $this->app->when(wechatUsers::class)
            ->needs(BaseRepository::class)
            ->give(UsersRepository::class);
        $this->app->when(wechatCachet::class)
            ->needs(BaseRepository::class)
            ->give(CachetRepository::class);
        $this->app->when(wechatCakind::class)
            ->needs(BaseRepository::class)
            ->give(CakindRepository::class);
        $this->app->when(wechatShopcar::class)
            ->needs(BaseRepository::class)
            ->give(ShopcarRepository::class);
        $this->app->when(wechatOrder::class)
            ->needs(BaseRepository::class)
            ->give(OrderRepository::class);
        $this->app->when(wechatAddress::class)
            ->needs(BaseRepository::class)
            ->give(AddressRepository::class);
        $this->app->when(wechatRemindinfo::class)
            ->needs(BaseRepository::class)
            ->give(RemindinfoRepository::class);

        $this->app->when(wechatCompanyInfo::class)
            ->needs(BaseRepository::class)
            ->give(MakerInfoRepository::class);
        $this->app->when(wechatExpress::class)
            ->needs(BaseRepository::class)
            ->give(ExpressRepository::class);
    }
}
