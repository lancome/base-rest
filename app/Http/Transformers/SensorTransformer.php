<?php

namespace App\Http\Transformers;

use Carbon\Carbon;
class SensorTransformer extends Transformer
{
    public function transform($sensor)
    {
        return [
            'name' => $sensor['name'],
            'result' => (float) $sensor['result'],
            'date_time' => $sensor['created_at']
        ];
    }
}
