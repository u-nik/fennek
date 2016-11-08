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

/**
 * A user login session.
 *
 * @package Bank\Util
 */
class Session
{

    /**
     * @var User
     */
    protected $user;

    /**
     * Checks if a user is loged in.
     * @return bool
     */
    public function isLogedIn()
    {
        return $this->user instanceof User;
    }

    /**
     * @codeCoverageIgnore
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @codeCoverageIgnore
     *
     * @param User $user
     *
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Removes the current user from session.
     * @return $this
     */
    public function removeUser()
    {
        $this->user = null;

        return $this;
    }
}