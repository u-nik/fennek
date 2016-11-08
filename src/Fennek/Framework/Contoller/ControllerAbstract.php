<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework\Contoller;

use Fennek\Framework\Exception\NotFoundException;
use Fennek\Framework\Request;
use Fennek\Framework\Response;
use Fennek\Framework\View\View;

/**
 * Class ControllerAbstract
 *
 * @package Bank\Contoller
 */
class ControllerAbstract implements ControllerInterface
{
    /**
     * @var View
     */
    protected $view;

    /**
     * @var Request
     */
    protected $request;

    /**
     * This function is called before the first action is dispatched.
     */
    protected function preDispatch() {

    }

    /**
     * Dispatches the controller action.
     *
     * @param Request $request
     *
     * @return Response|string
     * @throws NotFoundException
     */
    public function dispatch(Request $request)
    {
        $viewName = sprintf('%s/%s', $request->getController(), $request->getAction());

        $this->view->setId($viewName);
        $this->request = $request;

        $this->preDispatch();

        if (method_exists($this, $request->getAction())) {
            $method = $request->getAction();
            $result = $this->$method($request->getParams());

            if ($result === null) {
                $result = $this->view->render();
            }

            return $result;
        }

        throw (new NotFoundException(
            sprintf(
                'Controller action "%s" not found in controller "%s"',
                $request->getAction(),
                $request->getController()
            )
        ))->setRequest($request);
    }

    /**
     * @param string $action
     * @param string $controller
     *
     * @return Response
     */
    protected function redirect($action, $controller = null)
    {
        if ($controller === null) {
            $controller = $this->request->getController();
        }

        $response = new Response();
        $response->setRedirectUrl('/?ctrl=' . $controller . '&actn=' . $action);

        return $response;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param View $view
     *
     * @return $this
     */
    public function setView($view)
    {
        $this->view = $view;

        return $this;
    }
}