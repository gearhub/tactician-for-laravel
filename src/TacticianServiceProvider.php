<?php

namespace GearHub\Tactician;

use GearHub\Tactician\Contracts\Bus\Dispatcher as DispatcherContract;
use GearHub\Tactician\Dispatcher;
use GearHub\Tactician\Locator;
use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;
use League\Tactician\CommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\CommandNameExtractor;
use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;

class TacticianServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/config/config.php' => config_path('tactician.php')
        ]);

        $this->bootBindings();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/config.php', 'tactician');

        $this->registerLocator();
        $this->registerExtractor();
        $this->registerInflector();
        $this->registerCommandHandler();
        $this->registerMiddleware();
        $this->registerCommandBus();
        $this->registerDispatcher();
    }

    /**
     * Bind some interfaces and implementations.
     *
     * @return void
     */
    protected function bootBindings()
    {
        $this->app[CommandBus::class] = function($app) {
            return $app['tactician.commandbus'];
        };

        $this->app[CommandHandlerMiddleware::class] = function($app) {
            return $app['tactician.handler'];
        };

        $this->app[CommandNameExtractor::class] = function($app) {
            return $app['tactician.extractor'];
        };

        $this->app[MethodNameInflector::class] = function($app) {
            return $app['tactician.inflector'];
        };

        $this->app[HandlerLocator::class] = function($app) {
            return $app['tactician.locator'];
        };

        $this->app[DispatcherContract::class] = function($app) {
            return $app['tactician.dispatcher'];
        };
    }

    /**
     * Register bindings for the Command Handler.
     *
     * @return void
     */
    public function registerCommandBus()
    {
        $this->app->singleton('tactician.commandbus', function($app) {
            return new CommandBus($app['tactician.middleware']);
        });
    }

    /**
     * Register bindings for the Command Handler.
     *
     * @return void
     */
    public function registerCommandHandler()
    {
        $this->app->singleton('tactician.handler', function($app) {
            return new CommandHandlerMiddleware(
                $app['tactician.extractor'],
                $app['tactician.locator'],
                $app['tactician.inflector']
            );
        });
    }


    /**
     * Register bindings for the Dispatcher.
     *
     * @return void
     */
    public function registerDispatcher()
    {
        $this->app->singleton('tactician.dispatcher', function($app) {
            return new Dispatcher($app['tactician.commandbus']);
        });
    }

    /**
     * Register bindings for the Command Name Extractor.
     *
     * @return void
     */
    protected function registerExtractor()
    {
        $this->app->singleton('tactician.extractor', function($app) {
            return $app->make($this->config('extractor'));
        });
    }

    /**
     * Register bindings for the Method Name Inflector.
     *
     * @return void
     */
    protected function registerInflector()
    {
        $this->app->singleton('tactician.inflector', function($app) {
            return $app->make($this->config('inflector'));
        });
    }

    /**
     * Register bindings for the Handler Locator.
     *
     * @return void
     */
    protected function registerLocator()
    {
        $this->app->singleton('tactician.locator', function($app) {

            $commandNamespace = $this->config('command_namespace');
            $handlerNamespace = $this->config('handler_namespace');
            $locator           = $this->config('locator');

            return (new $locator($this->app, $commandNamespace, $handlerNamespace));
        });
    }


    /**
     * Register bindings for all the middleware.
     *
     * @return void
     */
    protected function registerMiddleware()
    {
        $this->app->bind('tactician.middleware', function() {
            $middleware = $this->config('middleware');
            $resolved   = array_map(function($name) {
                if (is_string($name)) {
                    return $this->app->make($name);
                }
                return $name;
            }, $middleware);

            $resolved[] = $this->app['tactician.handler'];

            return $resolved;
        });
    }

    /**
     * Helper to get the config values.
     *
     * @param  string $key
     *
     * @return string
     */
    protected function config($key, $default = null)
    {
        return config('tactician.' . $key, $default);
    }
}
