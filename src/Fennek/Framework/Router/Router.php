<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework\Router;


use Fennek\Framework\Container;
use Fennek\Framework\Contoller\ControllerAbstract;
use Fennek\Framework\Request;
use Fennek\Framework\Response;

/**
 * Class Router
 *
 * @package Fennek\Router
 */
class Router implements RouterInterface
{
    /**
     * @var Container
     */
    protected $container;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Response
     */
    protected $response;

    /**
     * Router constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @return string
     */
    public function route()
    {
        $this->handleRequest();

        if (($response = $this->dispatch()) instanceof Response) {
            $this->response = $response;
        } else {
            $this->response->setBody($response);
        }

        return $this->response;
    }

    /**
     * Analyze the get parameters.
     */
    protected function handleRequest()
    {
        $action     = isset($_GET['actn']) ? $_GET['actn'] : 'index';
        $controller = isset($_GET['ctrl']) ? $_GET['ctrl'] : 'index';

        // Extract params from GET and POST. POST data wins!
        $params = array_diff_key($_GET, array_flip(['ctrl', 'actn']));
        $params = array_merge($params, $_POST);

        $this->request->setAction($action)
            ->setController($controller)
            ->setParams($params);
    }

    /**
     * Dispatch the request.
     *
     * @return Response|string
     */
    protected function dispatch()
    {
        try {
            // Get controller
            $controllerId = 'controller.' . $this->request->getController();

            /** @var ControllerAbstract $controller */
            $controller = $this->container->get($controllerId);

            return $controller->dispatch($this->request);

        } catch (\Exception $e) {
            $this->response->setStatusCode(Response::STATUS_INTERNAL_SERVER_ERROR);
            $this->request->addParam('exception', $e)
                ->setAction('index')
                ->setController('error');

            return $this->dispatch();
        }
    }

    /**
     * @codeCoverageIgnore
     * @return Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param Request $request
     *
     * @return $this
     */
    public function setRequest($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     * @return Response
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param Response $response
     *
     * @return $this
     */
    public function setResponse($response)
    {
        $this->response = $response;

        return $this;
    }
}