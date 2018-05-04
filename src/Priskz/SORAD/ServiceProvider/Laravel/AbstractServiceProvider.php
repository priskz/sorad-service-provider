<?php

namespace Priskz\SORAD\ServiceProvider\Laravel;

use Config;
use Illuminate\Support\ServiceProvider;

abstract class AbstractServiceProvider extends ServiceProvider
{
	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = true;

    /**
     * @property string $providerKey
     */
	protected static $providerKey = null;

    /**
     * @property string $connection
     */
	protected $connection = null;

    /**
     * Create a new service provider instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function __construct($app)
    {
        parent::__construct($app);

        // Set default connection if not configured.
        if( ! is_null($this->getConnection()))
        {
			// Set the connection for this to the configured default.
			$this->setConnection(Config::get('database.default'));
        }
    }

	/**
	 * Get Provider Key.
	 *
	 * @return string
	 */
	public static function getProviderKey()
	{
		return static::$providerKey; 
	}

	/**
	 * @OVERRIDE
	 * 
	 * Get the services provided by this provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return [$this->getProviderKey()];
	}

	/**
	 * Register.
	 *
	 * @return void
	 */
	public function register()
	{
		// Register the service.
		$this->registerService();
	}


	/**
	 * Get connection property.
	 *
	 * @return string
	 */
	public function getConnection()
	{
		return $this->connection;
	}

	/**
	 * Set connection property.
	 *
	 * @param  string $connection 
	 * @return void
	 */
	public function setConnection($connection)
	{
		return $this->connection = $connection;
	}

	/**
	 * Register Service.
	 *
	 * @return void
	 */
	protected abstract function registerService();
}