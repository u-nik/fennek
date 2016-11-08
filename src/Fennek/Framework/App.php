<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework;


use Bank\Entity\User;
use Bank\Util\ObjectHydrator;
use Bank\View\LayoutView;
use Fennek\Framework\Router\RouterInterface;

/**
 * Class App
 *
 * @package Bank\Util
 */
class App
{

    /**
     * @var RouterInterface
     */
    protected $router;

    /**
     * @var LayoutView
     */
    protected $layout;

    /**
     * @var Session
     */
    protected $session;

    /**
     * @var ObjectHydrator
     */
    protected $hydrator;

    /**
     * Runs the application
     */
    public function run()
    {
        $this->startSession();

        /** @var Response $response */
        $response = $this->router->route();

        // Skip layout if disabled.
        if (!$response->isLayoutDisabled()) {
            $this->layout->body    = $response->getBody();
            $this->layout->session = $this->session;

            $response->setBody($this->layout->render());
        }

        $this->stopSession();

        $response->send();
    }

    /**
     * Start the session.
     */
    protected function startSession()
    {
        session_start();

        if (isset($_SESSION['user'])) {
            $user = new User();
            $this->hydrator->hydrate($user, $_SESSION['user']);
            $this->session->setUser($user);
        }
    }

    /**
     * Stops the session
     */
    protected function stopSession()
    {
        if ($this->session->isLogedIn()) {
            $_SESSION['user'] = $this->hydrator->extract($this->session->getUser());
            session_write_close();

        } else {
            if (isset($_SESSION['user'])) {
                unset($_SESSION['user']);
                // Destroy the old session and generate a new id.
                session_regenerate_id(true);
            }
        }
    }

    /**
     * @codeCoverageIgnore
     *
     * @param RouterInterface $router
     *
     * @return $this
     */
    public function setRouter($router)
    {
        $this->router = $router;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param LayoutView $layout
     *
     * @return $this
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param Session $session
     *
     * @return $this
     */
    public function setSession($session)
    {
        $this->session = $session;

        return $this;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param ObjectHydrator $hydrator
     *
     * @return $this
     */
    public function setHydrator($hydrator)
    {
        $this->hydrator = $hydrator;

        return $this;
    }


}