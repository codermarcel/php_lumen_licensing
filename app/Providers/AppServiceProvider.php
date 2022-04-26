<?php

namespace App\Providers;

use App\Contracts\Services\Password\PasswordServiceInterface;
use App\Entity\ApiKey;
use App\Entity\User;
use App\Service\Password\PBKDF2;
use App\Service\Permission\PermissionService;
use App\Service\Permission\TestPermissionService;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Redis\RedisServiceProvider;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
	   	Relation::morphMap([
		    'user' => User::class,
		    'apikey' => ApiKey::class,
		]);

        $this->registerDatabaseListener();

        $this->app->bind(PasswordServiceInterface::class, PBKDF2::class);
    }

    /**
     * Register database listener.
     * Example $query usages : $query->sql, $query->bindings, $query->time
     */
    public function registerDatabaseListener()
    {
        $log_path = storage_path('logs/db.log');

        $view_log = new Logger('View Logs');
        $view_log->pushHandler(new StreamHandler($log_path, Logger::INFO));

        DB::listen(function($query) use($view_log) {
            $view_log->addInfo(sprintf('%s | took %s ms', $query->sql, $query->time));
        });
    }
}
