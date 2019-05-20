<?php
namespace DeployStudio\Style\Providers;

use Illuminate\Support\ServiceProvider;

class PackageServiceProvider extends ServiceProvider
{
	/**
	* Bootstrap the application services.
	*
	* @return void
	*/
	public function boot()
	{
		//$this->loadMigrationsFrom(__DIR__ . '/../../database/migrations');
		//$this->loadViewsFrom(__DIR__.'/../../resources/views', 'package_views');
		$this->loadTranslationsFrom(__DIR__.'/../../resources/lang', 'universal_stylelib');
	}
}