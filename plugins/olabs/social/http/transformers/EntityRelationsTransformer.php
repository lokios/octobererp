<?php

namespace Olabs\Social\Http\Transformers;

use Olabs\Social\Models\EntityRelations;
use League\Fractal\TransformerAbstract;

class EntityRelationsTransformer extends TransformerAbstract
{
    /**
     * Turn this item object into a generic array.
     *
     * @param $item
     * @return array
     */
    public function transform(EntityRelations $item)
    {
        return [
            'id'         => (int)$item->id,
            'created_at' => (string)$item->created_at,
            'updated_at' => (string)$item->updated_at,
        ];
    }
}
