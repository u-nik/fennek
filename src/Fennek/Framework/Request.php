<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework;

/**
 * Request.
 *
 * @package Bank\Util
 */
class Request
{


    /**
     * @var string
     */
    protected $method;

    /**
     * @var string
     */
    protected $action;

    /**
     * @var string
     */
    protected $controller;

    /**
     * @var array
     */
    protected $params;

    /**
     * Request constructor.
     */
    public function __construct()
    {
        $action     = isset($_GET['actn']) ? $_GET['actn'] : 'index';
        $controller = isset($_GET['ctrl']) ? $_GET['ctrl'] : 'index';

        // Extract params from GET and POST. POST data wins!
        $params = array_diff_key($_GET, array_flip(['ctrl', 'actn']));
        $params = array_merge($params, $_POST);

        $this->action     = $action;
        $this->controller = $controller;
        $this->params     = $params;
    }


    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getAction()
    {
        return $this->action;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param string $action
     *
     * @return $this
     */
    public function setAction($action)
    {
        $this->action = $action;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return string
     */
    public function getController()
    {
        return $this->controller;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param string $controller
     *
     * @return $this
     */
    public function setController($controller)
    {
        $this->controller = $controller;

        return $this;
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
     *
     * @param array $params
     *
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * Adds a single parameter.
     *
     * @param string $name
     * @param mixed  $value
     *
     * @return $this
     */
    public function addParam($name, $value)
    {
        $this->params[$name] = $value;

        return $this;
    }

}