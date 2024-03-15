<?php

namespace App\Providers;

use App\Models\Languages;
use App\Models\Settings;
use Illuminate\Filesystem\Cache;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

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
        //Added
        Paginator::useBootstrap();

        //check if languages Table exist
        if (Schema::hasTable('languages')) {
            if (Languages::count() > 0) {
                $user_lang = optional(auth()->user())->language;
                $userlang = isset($user_lang) ? $user_lang : get_config('set_locale');

                $new_locales = array();

                foreach (Languages::where('status', '1')->get() as $lang) {

                    $new_locales[$lang->code] = ['name' => $lang->name, 'script' => $lang->script, 'native' => $lang->native, 'regional' => $lang->regional];
                }

                //\Illuminate\Support\Facades\Config::set('app.locale', get_config('set_locale'));
                //overide laravellocalization default supportedLocales
                \Illuminate\Support\Facades\Config::set('laravellocalization.supportedLocales', $new_locales);
                //overide laravel default locales
                \Illuminate\Support\Facades\Config::set('app.locale',  $userlang);
            }
        }
        if (Schema::hasTable('site_settings')) {

            //override default mail configurations
            if (get_config('default_mailer') == 'smtp') {

                $mail_config = [
                    'transport' => 'smtp',
                    'host' => get_config('default_mailer_host'),
                    'port' => get_config('default_mailer_port'),
                    'encryption' => get_config('default_mailer_encryption'),
                    'username' => get_config('default_mailer_username'),
                    'password' => get_config('default_mailer_password'),
                ];
                \Illuminate\Support\Facades\Config::set(['mail.mailers.smtp' => $mail_config]);
            }
            if (get_config('default_mailer') == 'mailgun') {

                $mail_config = [
                    'domain' => get_config('default_mailer_mailgun_domain'),
                    'secret' => get_config('default_mailer_mailgun_key'),
                ];
                \Illuminate\Support\Facades\Config::set(['services.mailgun' => $mail_config]);
            }

            $mail_config_sender = [
                'name' => get_config('default_mailer_sender_name'),
                'address' => get_config('default_mailer_sender_email'),
            ];
            \Illuminate\Support\Facades\Config::set(['mail.from' => $mail_config_sender]);

            //override default sms configurations
            if (get_config('default_sms_gateway') == 'twilo') {

                $sms_config = [
                    'account_sid' => get_config('sms_twilo_sid'),
                    'auth_token' => get_config('sms_twilo_auth_token'),
                    'sms_from' => get_config('sms_sender_number'),
                ];
                \Illuminate\Support\Facades\Config::set(['laratwilo' => $sms_config]);
            }

        }

        //Add Permissions
        // admins
        Gate::define('do_admin', function (User $user) {
            return $user->role >= 5;
        });

        //moderator
        Gate::define('do_moderator', function (User $user) {
            return $user->role >= 4;
        });

        //staff
        Gate::define('do_staff', function (User $user) {
            return $user->role >= 3;
        });

        //agents
        Gate::define('do_agent', function (User $user) {
            return $user->role >= 2;
        });

        //customers
        Gate::define('do_customer', function (User $user) {
            return $user->role >= 1;
        });
    }
}
