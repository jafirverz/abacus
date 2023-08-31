<?php

namespace App\Providers;

use App\Traits\GetSmartBlock;
use App\Traits\SystemSettingTrait;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;

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
        ]);

        if (!Collection::hasMacro('paginate')) {

            Collection::macro('paginate', 
                function ($perPage = 10, $page = null, $options = []) {
                $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
                return (new LengthAwarePaginator(
                    $this->forPage($page, $perPage)->values()->all(), $this->count(), $perPage, $page, $options))
                    ->withPath('');
            });
        }
    }
}
