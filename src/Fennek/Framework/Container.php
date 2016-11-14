<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework;

use Fennek\Framework\Container\Definition;
use Fennek\Framework\Container\FactoryDefinition;
use Fennek\Framework\Container\InstanceDefinition;
use Fennek\Framework\Exception\ContainerException;
use Fennek\Framework\Exception\NotFoundException;
use Interop\Container\ContainerInterface;


/**
 * A simple service container with service factory support.
 *
 * @package Bank\Util
 */
class Container implements ContainerInterface
{
    /**
     * @var array
     */
    protected $parameters;

    /**
     * @var array
     */
    protected $services;

    /**
     * The service related tags.
     *
     * @var array
     */
    protected $tags;

    /**
     * @var Definition[]
     */
    protected $definitions;

    /**
     * Container constructor.
     *
     * @param array $parameters
     */
    public function __construct(array $parameters = null)
    {
        $this->parameters = (array) $parameters;
        $this->services   = [];
        $this->tags       = [];
    }

    /**
     * Add a new parameter.
     *
     * @param string $name
     * @param mixed $value
     *
     * @return $this
     */
    public function addParam(string $name, $value)
    {
        $this->parameters[$name] = $value;

        return $this;
    }

    /**
     * Adds multiple parameters to container.
     *
     * @param array $params
     *
     * @return $this
     */
    public function addParams(array $params)
    {
        foreach ($params as $key => $value) {
            $this->addParam($key, $value);
        }

        return $this;
    }

    /**
     * Returns the value of the given parameter if exists. Otherwise the default value is returned.
     *
     * @param string $name
     * @param mixed $default
     *
     * @return mixed
     */
    public function getParam($name, $default = null)
    {
        if (isset($this->parameters[$name])) {
            return $this->parameters[$name];
        }

        return $default;
    }

    /**
     * Set a new parameter
     *
     * @param array $params
     *
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->parameters = $params;

        return $this;
    }

    /**
     * @param Definition $definition
     *
     * @return $this
     */
    public function addDefinition(Definition $definition)
    {
        $this->definitions[$definition->getId()] = $definition;

        return $this;
    }

    /**
     * Adds a already created service instance to the container.
     *
     * @param string $id
     * @param object $service
     *
     * @return Definition
     * @throws ContainerException If no object is supplied.
     */
    public function addInstance($id, $service)
    {
        $def = new InstanceDefinition($id, $service);

        $this->addDefinition($def);

        return $def;
    }

    /**
     * Adds a service factory.
     *
     * @param string $id
     * @param callable $factory
     *
     * @return Definition
     */
    public function addFactory($id, callable $factory)
    {
        $def = new FactoryDefinition($id, $factory);

        $this->addDefinition($def);

        return $def;
    }

    /**
     * Finds an entry of the container by its identifier and returns it.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @throws NotFoundException  No entry was found for this identifier.
     * @throws ContainerException Error while retrieving the entry.
     *
     * @return mixed Entry.
     */
    public function get($id)
    {
        if (isset($this->services[$id])) {
            return $this->services[$id];
        }

        if (isset($this->definitions[$id])) {
            $service = ($this->definitions[$id]->getCallable())($this);

            if (!is_object($service)) {
                throw new ContainerException(
                    sprintf(
                        'The factory "%s" returns no service instance. Found "%s"',
                        $id,
                        gettype($service)
                    )
                );
            }

            if ($this->definitions[$id]->isShared()) {
                $this->services[$id] = $service;
            }

            return $service;
        }

        throw new NotFoundException('Service with ID "' . $id . '" not found');
    }

    /**
     * Returns all ids of services tagged with the given value.
     *
     * @param string $value
     *
     * @return string[]
     */
    public function getIdsByTag($value)
    {
        $serviceIds = [];

        foreach ($this->definitions as $id => $definition) {
            foreach ($definition->getTags() as $tag) {
                if ($tag === $value) {
                    $serviceIds[] = $id;
                }
            }
        }

        return $serviceIds;
    }

    /**
     * Returns the service instances tagged with the supplied value.
     *
     * @param string $value
     *
     * @return object[]
     */
    public function getByTag($value)
    {
        $services = [];

        foreach ($this->getIdsByTag($value) as $id) {
            $services[] = $this->get($id);
        }

        return $services;
    }

    /**
     * Returns true if the container can return an entry for the given identifier.
     * Returns false otherwise.
     *
     * @param string $id Identifier of the entry to look for.
     *
     * @return boolean
     */
    public function has($id)
    {
        return isset($this->definitions[$id]);
    }
}