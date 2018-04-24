<?php

namespace Olabs\Social\Http\Controllers;

use Olabs\Social\Models\UserPreferences as UserPreferencesModel;
use Olabs\Social\Http\Transformers\UserPreferencesTransformer;
use Autumn\Api\Classes\ApiController;

class UserPreferences extends ApiController
{



    protected $defaultLimit = 5;

     protected $fillable  =['preferences','app_id','user_id','android_reg_id','android_not_preference'];



    /**
     * Eloquent model.
     *
     * @return \October\Rain\Database\Model
     */
    protected function model()
    {
        return new UserPreferencesModel;
    }

    /**
     * Transformer for the current model.
     *
     * @return \League\Fractal\TransformerAbstract
     */
    protected function transformer()
    {
        return new UserPreferencesTransformer;
    }
}
