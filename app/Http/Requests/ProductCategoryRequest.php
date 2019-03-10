<?php

namespace App\Http\Requests;

class ProductCategoryRequest extends ApiRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required',
            'parent_category_id' => 'numeric|nullable'
        ];
    }
}
