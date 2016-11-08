<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework\Container;

/**
 * Class InstanceDefinition
 *
 * @package Fennek\Framework\Container
 */
class InstanceDefinition extends Definition
{
    /**
     * @var object
     */
    protected $instance;

    /**
     * InstanceDefinition constructor.
     *
     * @param string $id
     * @param object $instance
     */
    public function __construct($id, $instance)
    {
        $this->id       = $id;
        $this->instance = $instance;
    }

    /**
     * @codeCoverageIgnore
     * @return object
     */
    public function getInstance()
    {
        return $this->instance;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param object $instance
     *
     * @return $this
     */
    public function setInstance($instance)
    {
        $this->instance = $instance;

        return $this;
    }
}