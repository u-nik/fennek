<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework\View\Helper;


use Fennek\Framework\View\ViewInterface;

/**
 * An abstract view helper.
 *
 * @package Fennek\View\Helper
 */
class HelperAbstract implements HelperInterface
{

    /**
     * @var ViewInterface
     */
    protected $view;

    /**
     * Sets the view for the helper.
     *
     * @param ViewInterface $view
     *
     * @return $this
     */
    public function setView(ViewInterface $view)
    {
        $this->view = $view;

        return $this;
    }

    /**
     * Returns the name of the helper.
     *
     * @return string
     */
    public function getName()
    {
        return lcfirst(substr(strrchr(static::class, '\\'), 1));
    }
}