<?php

namespace MsgService;

use Illuminate\Support\ServiceProvider;
use Laravel\Lumen\Application as LumenApplication;

class MsgServiceProvider extends ServiceProvider
{
    public function boot()
    {
        $this->app->group(['namespace' => __NAMESPACE__ . '\Http\Controllers', 'prefix' => 'msgser', 'middleware' => 'msgser'], function ($app) {
            require __DIR__ . '/routes/web.php';
        });
        $this->loadViewsFrom(__DIR__ . '/views', 'msgser');
    }

    public function register()
    {
        if ($this->app instanceof LumenApplication) {
            $this->app->configure('msgser');
        }
        
        $this->mergeConfigFrom(
            __DIR__ . '/config/msgser.php', 'msgser'
        );

        $this->app->bind('MsgService\Services\ShortMsgService', 'MsgService\Services\MiaoDi\ShortMsgService');
        $this->app->bind('MsgService\Services\VoiceCodeService', 'MsgService\Services\MiaoDi\VoiceCodeService');
        
        $this->app->routeMiddleware([
            'msgser' => \MsgService\Http\Middleware\Authenticate::class,
        ]);        
    }
}
