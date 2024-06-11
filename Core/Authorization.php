<?php

namespace Core;

use Core\Session;

class Authorization
{
    /**
     * Comprobar si el usuario logueado es el propietario
     * del recurso
     * @param int $resourceId
     * @return bool
     */
    static function isOwner($resourceId)
    {
        $sessionUser = Session::get('user');

        if ($sessionUser !== null && isset($sessionUser['id'])) {
            return $sessionUser['id'] === $resourceId;
        }
        return false;
    }
}
