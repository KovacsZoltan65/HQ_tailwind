<?php

namespace App\Providers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        /**
         * Share the errors with Inertia.
         *
         * The errors are typically used to display validation errors after a form submission.
         *
         * @return object The errors as an object with keys corresponding to the fields and values
         *                corresponding to the error messages.
         */
        Inertia::share([
            'errors' => function(){
                // Retrieve the errors from the session.
                // If there are no errors, return an empty object.
                return Session::get('errors') 
                    ? Session::get('errors')->getBag('default')->getMessages()
                    : (object)[];
            }
        ]);

        /**
         * Share the flash message with Inertia.
         *
         * The flash message is typically used to display a success or error message after a form submission.
         *
         * @return array The flash message as an associative array with a 'message' key.
         */
        Inertia::share('flash', function(){
            // Retrieve the flash message from the session.
            return [
                'message' => Session::get('message'),
            ];
        });

        /**
         * Share the CSRF token with Inertia.
         *
         * @return string
         */
        Inertia::share('csrf_token', function(){
            // Retrieve the CSRF token from the session.
            return csrf_token();
        });

        /**
         * Observe the Book model with the BookObserver class.
         *
         * This allows us to hook into various events of the Book model and
         * perform actions accordingly.
         *
         * @see \App\Observers\BookObserver
         */
        \App\Models\Book::observe(\App\Observers\BookObserver::class);
    }
}
