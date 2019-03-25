<?php

namespace App\Http\Requests;

class ProductRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            "image_paths" => "required|array|max:8",
            "brand" => "required|numeric",
            "price" => "required|numeric",
            "category_id" => "required|numeric",
            "storage_id"  => "required|numeric",
            "name" => "required|string",
            "description" => "sometimes|string|min:5|max:100",
            "quantity" => "required|numeric|min:1",
            "sales" => "sometimes|array",
            "sales.*.from" => "required_with:sales|date_format:Y-m-d",
            "sales.*.to" => "required_with:sales|date_format:Y-m-d|after:sales.*.from",
            "sales.*.percent" => "required_without:sales.*.value|numeric",
            "sales.*.value"   => "required_without:sales.*.percent|numeric",
            "price_groups" => "sometimes|array",
            "price_groups.*.price" => "required|numeric",
            "price_groups.*.group_id" => "required_without:price_groups.*.group|numeric",
            "price_groups.*.group" => "required_without:price_groups.*.group_id",
            "price_groups.*.group.label" => "required_with:price_groups.*.group",
            "price_groups.*.group.description" => "sometimes|string|min:5|max:100",
        ];
        
        return $rules;
    }
}
