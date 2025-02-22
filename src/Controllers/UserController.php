<?php

declare(strict_types=1);

namespace Igniter\Dusk\Controllers;

use Igniter\Flame\Exception\ApplicationException;

class UserController
{
    /**
     * Retrieve the authenticated user identifier and class name.
     */
    public function user(?string $appContext = null): array
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
     * @throws ApplicationException
     */
    public function login($userId, string $appContext = 'admin'): void
    {
        $loggedIn = $this->getAuthManager($appContext)->loginUsingId($userId);

        if (!$loggedIn) {
            throw new ApplicationException('Invalid user ID');
        }
    }

    /**
     * Log the user out of the application.
     */
    public function logout(string $appContext = 'admin'): void
    {
        $this->getAuthManager($appContext)->logout();
    }

    /**
     * @return \Igniter\User\Auth\Manager
     */
    protected function getAuthManager(string $appContext)
    {
        return app($appContext === 'admin' ? $appContext.'.auth' : 'auth');
    }
}
