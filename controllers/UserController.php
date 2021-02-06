<?php

namespace Igniter\Dusk\Controllers;

use ApplicationException;

class UserController
{
    /**
     * Retrieve the authenticated user identifier and class name.
     *
     * @param string|null $appContext
     * @return array
     */
    public function user($appContext = null)
    {
        $user = $this->getAuthManager($appContext)->getUser();
        if (!$user) {
            return [];
        }

        return [
            'id' => $user->getAuthIdentifier(),
            'className' => get_class($user),
        ];
    }

    /**
     * Login using the given user ID.
     *
     * @param string $userId
     * @param string|null $appContext
     * @return void
     */
    public function login($userId, $appContext = 'admin')
    {
        $loggedIn = $this->getAuthManager($appContext)->loginUsingId($userId);

        if (!$loggedIn)
            throw new ApplicationException('Invalid user ID');
    }

    /**
     * Log the user out of the application.
     *
     * @param string $appContext
     * @return void
     */
    public function logout($appContext = 'admin')
    {
        $this->getAuthManager($appContext)->logout();
    }

    /**
     * @param $appContext
     * @return \Igniter\Flame\Auth\Manager
     */
    protected function getAuthManager($appContext)
    {
        return app($appContext == 'admin' ? $appContext.'.auth' : 'auth');
    }
}
