<?php
/*
 * Copyright (c) 2016 Babymarkt.de GmbH - All Rights Reserved
 *
 * All information contained herein is, and remains the property of Baby-Markt.de
 * and is protected by copyright law. Unauthorized copying of this file or any parts,
 * via any medium is strictly prohibited.
 */

namespace Fennek\Framework\Contoller;


use Fennek\Framework\Request;

/**
 * Interface ControllerInterface
 *
 * @package Bank\Contoller
 */
interface ControllerInterface
{

    /**
     * Dispatches the controller action.
     *
     * @param Request $request
     *
     * @return mixed
     */
    public function dispatch(Request $request);

}