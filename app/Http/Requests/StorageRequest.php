<?php

namespace App\Http\Requests;

class StorageRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     * @return array
     */
    public function rules()
    {
        return [
            'geo_lat' => 'required_with:geo_lon|numeric',
            'geo_lon' => 'required_with:geo_lat|numeric',
            'address' => 'required|string',
            'type_id' => 'required|numeric|min:1',
            'name'    => 'required|string',
        ];
    }
}
