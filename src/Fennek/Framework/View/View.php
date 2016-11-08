<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework\View;

use Fennek\Framework\View\Exception\UnknownHelperException;
use Fennek\Framework\View\Helper\HelperInterface;

/**
 * A simple view.
 *
 * @package Bank\View
 */
class View implements ViewInterface
{

    /**
     * @var string
     */
    protected $id;

    /**
     * @var array
     */
    protected $params;

    /**
     * @var string
     */
    protected $basePath;

    /**
     * @var HelperInterface[]
     */
    protected $helpers;

    /**
     * View constructor.
     *
     * @param string $id Template id.
     * @param array  $params
     */
    public function __construct($id = null, array $params = null)
    {
        $this->id     = $id;
        $this->params = (array) $params;
    }

    /**
     * Sets a parameter value.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return mixed
     */
    public function __set($name, $value)
    {
        return $this->params[$name] = $value;
    }

    /**
     * @param string $name
     *
     * @return mixed
     */
    public function __get($name)
    {
        if (isset($this->params[$name])) {
            return $this->params[$name];
        }

        return null;
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return string
     * @throws UnknownHelperException if the given helper name doesn't exists.
     */
    public function __call($name, $arguments)
    {
        if (isset($this->helpers[$name])) {
            $lname = strtolower($name);
            return $this->helpers[$name]->$lname(...$arguments);
        }

        throw new UnknownHelperException($name);
    }

    /**
     * The file to render.
     *
     * @param string $name
     *
     * @return $this
     */
    public function setId($name)
    {
        $this->id = $name;

        return $this;
    }

    /**
     * Renders the view with given parameters.
     *
     * @throws \RuntimeException if the view file is not found.
     * @return string
     */
    public function render()
    {
        $file = $this->basePath . '/' . $this->id . '.phtml';

        if (!file_exists($file)) {
            throw new \RuntimeException('View file "' . $file . '" not found');
        }

        ob_start();
        require $file;
        $content = ob_get_clean();

        return $content;
    }

    /**
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function assign($name, $value)
    {
        $this->params[$name] = $value;

        return $this;
    }

    /**
     * Renders a sub template.
     *
     * @param string              $name
     * @param ViewInterface|array $params
     */
    protected function part($name, $params = null)
    {
        if ($params instanceof ViewInterface) {
            $params = $params->getParams();
        }

        $view = new static($name, $params);
        $view->setBasePath($this->getBasePath());
        $view->setHelpers($this->helpers);
        return $view->render();
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getBasePath()
    {
        return $this->basePath;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param string $basePath
     *
     * @return $this
     */
    public function setBasePath($basePath)
    {
        $this->basePath = rtrim($basePath, DIRECTORY_SEPARATOR);

        return $this;
    }

    /**
     * Adds a helper to the view.
     *
     * @param HelperInterface $helper
     *
     * @return $this;
     */
    public function addHelper(HelperInterface $helper)
    {
        $helper->setView($this);
        $this->helpers[$helper->getName()] = $helper;

        return $this;
    }

    /**
     * @param array $helpers
     *
     * @return $this
     */
    public function setHelpers(array $helpers)
    {
        foreach ($helpers as $helper) {
            $this->addHelper($helper);
        }

        return $this;
    }

    /**
     * Returns the helper by given name. If not found, an exception is thrown.
     *
     * @param string $name
     *
     * @return HelperInterface
     * @throws UnknownHelperException if the given name is not exists.
     */
    public function getHelper($name)
    {
        if (isset($this->helpers[$name])) {
            return $this->helpers[$name];
        }

        // Helper not found
        throw new UnknownHelperException($name);
    }

    /**
     * @codeCoverageIgnore
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @codeCoverageIgnore
     * @return Helper\HelperInterface[]
     */
    public function getHelpers()
    {
        return $this->helpers;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getId()
    {
        return $this->id;
    }

}