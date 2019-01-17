<?php namespace vsb\Locations;
use Illuminate\Support\ServiceProvider as LaravelServiceProvider;
use vsb\Locations\LocationManager;

class LocationServiceProvider extends LaravelServiceProvider
{
    // Delay initializing this service for good performance
    protected $defer = true;
    public function provides()
    {
        return [LocationManager::class];
    }
    public function boot()
    {
        $this->publishes([
            __DIR__.'/Config/locations.php' => config_path('locations.php'),
        ]);
    }

    public function register()
    {
        // Register Locations as service
        $this->app->bind('vsb\Locations\LocationManager', function ($app) {
            return new LocationManager($app);
        });
        $this->app->singleton('test.locations', function ($app) {
            return new LocationManager($app);
        });
        $this->mergeConfigFrom(__DIR__.'/Config/locations.php', 'locations');
    }
}
?>
