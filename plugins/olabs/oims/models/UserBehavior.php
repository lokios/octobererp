<?php namespace Olabs\Oims\Models;

use Backend\Classes\AuthManager;
use Exception;
use System\Classes\ModelBehavior;

class UserBehavior extends ModelBehavior
{

    public function getUserIsBannedAttribute()
    {
        if (empty($userId = $this->model->attributes['id'] ?? null)) {
            return;
        }

        $throttle = AuthManager::instance()->findThrottleByUserId($userId, null);

        if (!empty($throttle) && $throttle->is_banned) {
            return true;
        }

        return false;
    }


    /**
     * @param $value
     *
     * @throws Exception
     */
    public function setUserIsBannedAttribute($value)
    {
        $loggedUser = AuthManager::instance()->getUser();

        if (empty($userId = $this->model->attributes['id'] ?? null)) {
            return;
        }

        if ($value && $loggedUser->id == $userId) {
            throw new \ApplicationException("You can't ban yourself");
        }

        $throttle = AuthManager::instance()->findThrottleByUserId($userId, null);

        if ($value) {
            $throttle->ban();

            return;
        }

        $throttle->unban();
    }

    
    
}
