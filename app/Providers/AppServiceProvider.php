<?php

namespace App\Providers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Fields\Field;

class AppServiceProvider extends ServiceProvider
{
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
        date_default_timezone_set('Europe/Berlin');

        Field::macro('onlyOnExport', function(){
            $this->showOnIndex = request()->input('action') == 'download-excel';
            $this->showOnDetail = false;
            return $this;
        });
        Validator::extend('isImportable', 'App\Rules\RequestValidatorExtensions@isImportable');
        Validator::replacer('isImportable', 'App\Rules\RequestValidatorExtensions@isImportableReplacer');


        Validator::extend('purchasable', 'App\Rules\RequestValidatorExtensions@isPurchasable');
        Validator::replacer('purchasable', 'App\Rules\RequestValidatorExtensions@isPurchasableReplacer');

        Validator::extend('forWishlist', 'App\Rules\RequestValidatorExtensions@forWishlist');
        Validator::replacer('forWishlist', 'App\Rules\RequestValidatorExtensions@forWishlistReplacer');

        Validator::extend('vinValid', 'App\Rules\RequestValidatorExtensions@vinValid');
        Validator::replacer('vinValid', 'App\Rules\RequestValidatorExtensions@vinValidReplacer');

        Validator::extend('vpvuValid', 'App\Rules\RequestValidatorExtensions@vpvuValid');
        Validator::replacer('vpvuValid', 'App\Rules\RequestValidatorExtensions@vpvuValidReplacer');

        Validator::extend('nonAdmin', 'App\Rules\RequestValidatorExtensions@nonAdmin');
        Validator::replacer('nonAdmin', 'App\Rules\RequestValidatorExtensions@nonAdminReplacer');

        Validator::extend('xlsxExtension', 'App\Rules\RequestValidatorExtensions@xlsxExtension');
        Validator::replacer('xlsxExtension', 'App\Rules\RequestValidatorExtensions@xlsxExtensionReplacer');

        Validator::extend('externalId', 'App\Rules\RequestValidatorExtensions@externalId');
        Validator::replacer('externalId', 'App\Rules\RequestValidatorExtensions@externalIdReplacer');

        Validator::extend('validFirstRegDate', 'App\Rules\RequestValidatorExtensions@validFirstRegDate');
        Validator::replacer('validFirstRegDate', 'App\Rules\RequestValidatorExtensions@validFirstRegDateReplacer');

        Validator::extend('correctConditionType', 'App\Rules\RequestValidatorExtensions@correctConditionType');
        Validator::replacer('correctConditionType', 'App\Rules\RequestValidatorExtensions@correctConditionTypeReplacer');

        Validator::extend('correctBrand', 'App\Rules\RequestValidatorExtensions@correctBrand');
        Validator::replacer('correctBrand', 'App\Rules\RequestValidatorExtensions@correctBrandReplacer');
    }
}
