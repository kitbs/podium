<?php

namespace Podium\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Schema\Blueprint;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Blueprint::macro('belongsTo', function($relatedTable, $foreignKey = null, $primaryKey = 'id', $nullable = false, $index = true) {
            $foreignKey = $foreignKey ?: str_singular($relatedTable).'_id';

            if ($nullable) {
                $this->integer($foreignKey)->unsigned()->nullable();
            }
            else {
                $this->integer($foreignKey)->unsigned();
            }

            if ($index) {
                $this->foreign($foreignKey)->references($primaryKey)->on($relatedTable);
            }
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
