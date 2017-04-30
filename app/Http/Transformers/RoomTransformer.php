<?php

namespace App\Http\Transformers;

class RoomTransformer extends Transformer
{
    public function transform($room)
    {
        return [
            'name' => $room['name']
        ];
    }
}
