<?php

namespace App\Providers;

use App\Traits\GetSmartBlock;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    use SystemSettingTrait, GetSmartBlock;
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Commented by Bhupesh
        Schema::defaultStringLength(191);
        config([
            'system_settings' => $this->systemSetting(),
            'smart_blocks' => $this->smartBlock(),
        ]);


        // DB::listen(function ($query) {
        //     $query->sql;
        //     $query->bindings;
        //     $query->time;
        // });
    }
}
