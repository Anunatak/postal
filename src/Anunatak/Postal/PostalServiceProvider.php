<?php namespace Anunatak\Postal;

use Illuminate\Support\ServiceProvider;

class PostalServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

    protected $commands = [
        'Anunatak\Postal\Command\ParseCommand'
    ];

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->commands($this->commands);
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return ['Postal'];
	}

	public function boot() {
		$this->publishes([
		    realpath(__DIR__.'/../../../migrations') => $this->app->databasePath().'/migrations',
		]);
	}

}
