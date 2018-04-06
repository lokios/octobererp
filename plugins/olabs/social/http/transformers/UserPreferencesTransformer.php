<?php

namespace Olabs\Social\Http\Transformers;

use Olabs\Social\Models\UserPreferences;
use League\Fractal\TransformerAbstract;

class UserPreferencesTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(UserPreferences $item)
    {
        return [
            'id'         => (int)$item->id,
            'created_at' => (string)$item->created_at,
            'updated_at' => (string)$item->updated_at,
        ];
    }
}
