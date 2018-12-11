<?php

namespace SamuelSemegne\LaravelTouchThingGate;

use Gate;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class TouchThingGateProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        /**
         * This gate checks whether the user and the given model are related.
         */
        Gate::define('touch-thing', function (User $user, Model $model) {
            // Match against the model's user_id property (if it has any).
            if ($model->user_id) {
                return ($model->user_id == $user->id);
            } 
            // Match against the model belongsTo User relation (if it has any).
            elseif ($model->user) {
                return ($model->user->id == $user->id);
            }
            // Check if the model IS of type User.
            elseif (get_class($model) == 'App\User') {
                return ($model->id == $user->id);
            }
            else {
                return false;
            }
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
