<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class PropertyResource extends JsonResource
{

    protected $model = Property::class;

    public function __construct(Request $request){
        parent::__construct($request);
        $this->filters = [
            'name' => function($query, $value){
                return $query->where('name', 'like', "%$value%");
            },
            'price_from' => function($query, $value){
                return $query->where('price', '>=', $value);
            },
            'price_to' => function($query, $value){
                return $query->where('price', '<=', $value);
            },
        ];
    }

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $model_query = $this->model::query();
        foreach($request->query() as $key => $value){
            if(array_key_exists($key, $this->filters)){
                $model_query = $this->filters[$key]($model_query, $value);
            }else{
                $model_query->where($key, $value);
            }
        }
        return $model_query->get();
    }
}
