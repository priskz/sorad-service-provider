<?php

namespace Priskz\SORAD\ServiceProvider\Laravel;

use Config;
use Priskz\SORAD\ServiceProvider\Laravel\AbstractServiceProvider;

abstract class AbstractRootServiceProvider extends AbstractServiceProvider
{
    /**
     * @property array $aggregates
     */
	protected $aggregates = [];

	/**
	 * @OVERRIDE
	 * 
	 * Register.
	 *
	 * @return void
	 */
	public function register()
	{
		// Link this service's aggregate(s).
		$this->linkAggregates();

		// Register this service.
		$this->registerService();
	}

	/**
	 * Link Aggreagte Service(s) to be resolved when this service is resolved.
	 *
	 * @return void
	 */
	protected function linkAggregates()
	{
		// Provider key must be configured for linking.
		if($this->getProviderKey() !== null)
		{
			// Init
			$configuredAggregates = [];

			// Look for configured entity services to tag.
			if(Config::get('sorad.' . $this->getProviderKey() . '.aggregates'))
			{
				$configuredAggregates = Config::get('sorad.' . $this->getProviderKey() . '.aggregates');
			}

			// Combine all of our configured aggregates.
			$aggregates = array_merge($this->aggregates, $configuredAggregates);

			// Iterate configured aggregates and tag.
			foreach($aggregates as $aggregate)
			{
				$this->app->tag([$aggregate], $this->getProviderKey());
			}
		}
	}

	/**
	 * Get aggregate(s).
	 *
	 * @return array
	 */
	protected function getAggregateService()
	{
		// Init
		$aggregate = [];

		foreach($this->app->tagged($this->getProviderKey()) as $service)
		{
			$aggregate[$service->getAlias()] = $service;
		}

		return $aggregate;
	}
}