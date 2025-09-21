<?php

namespace Libs;

/**
 * Simple Dependency Injection Container
 *
 * Manages service dependencies and provides a centralized way to resolve them.
 */
class Container
{
    /**
     * @var array Registered services and their factories
     */
    private array $services = [];

    /**
     * @var array Resolved service instances
     */
    private array $resolved = [];

    /**
     * Register a service with the container
     *
     * @param string $name Service name
     * @param callable $factory Factory function to create the service
     * @return void
     */
    public function register(string $name, callable $factory): void
    {
        $this->services[$name] = $factory;
        // Remove from resolved cache if it was previously resolved
        unset($this->resolved[$name]);
    }

    /**
     * Register a singleton service
     *
     * @param string $name Service name
     * @param callable $factory Factory function to create the service
     * @return void
     */
    public function singleton(string $name, callable $factory): void
    {
        $this->register($name, function () use ($factory) {
            static $instance = null;
            if ($instance === null) {
                $instance = $factory($this);
            }
            return $instance;
        });
    }

    /**
     * Resolve a service from the container
     *
     * @param string $name Service name
     * @return mixed Resolved service instance
     * @throws \RuntimeException If service is not registered
     */
    public function resolve(string $name)
    {
        // Return cached instance if already resolved
        if (isset($this->resolved[$name])) {
            return $this->resolved[$name];
        }

        // Check if service is registered
        if (!isset($this->services[$name])) {
            throw new \RuntimeException("Service '{$name}' is not registered in the container");
        }

        // Resolve the service
        $instance = $this->services[$name]($this);
        $this->resolved[$name] = $instance;

        return $instance;
    }

    /**
     * Check if a service is registered
     *
     * @param string $name Service name
     * @return bool
     */
    public function has(string $name): bool
    {
        return isset($this->services[$name]);
    }

    /**
     * Clear all registered services and resolved instances
     *
     * @return void
     */
    public function clear(): void
    {
        $this->services = [];
        $this->resolved = [];
    }
}
