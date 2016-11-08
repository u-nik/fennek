<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework\Event;

/**
 * Representation of an event.
 *
 * @package Fennek\Framework\Event
 */
interface EventInterface
{
    /**
     * Get event name
     *
     * @return string
     */
    public function getName();

    /**
     * Get target/context from which event was triggered
     *
     * @return null|string|object
     */
    public function getTarget();

    /**
     * Get parameters passed to the event
     *
     * @return array
     */
    public function getParams();

    /**
     * Get a single parameter by name
     *
     * @param  string $name
     *
     * @return mixed
     */
    public function getParam($name);

    /**
     * Set the event name
     *
     * @param  string $name
     *
     * @return void
     */
    public function setName($name);

    /**
     * Set the event target
     *
     * @param  null|string|object $target
     *
     * @return void
     */
    public function setTarget($target);

    /**
     * Set event parameters
     *
     * @param  array $params
     *
     * @return void
     */
    public function setParams(array $params);

    /**
     * Indicate whether or not to stop propagating this event
     *
     * @param  bool $flag
     */
    public function stopPropagation($flag);

    /**
     * Has this event indicated event propagation should stop?
     *
     * @return bool
     */
    public function isPropagationStopped();
}