<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MeeqatDistanceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'method'    => 'required|in:gps,manual',
            'latitude'  => 'required_if:method,gps|nullable|numeric|between:-90,90',
            'longitude' => 'required_if:method,gps|nullable|numeric|between:-180,180',
            'country'   => 'required_if:method,manual|nullable|string|max:100',
            'city'      => 'nullable|string|max:100',
        ];
    }

    public function messages(): array
    {
        return [
            'method.required'       => 'Detection method zaroor select karein.',
            'latitude.required_if'  => 'GPS latitude provide karein.',
            'longitude.required_if' => 'GPS longitude provide karein.',
            'latitude.between'      => 'Invalid latitude value.',
            'longitude.between'     => 'Invalid longitude value.',
            'country.required_if'   => 'Manual mode mein country zaroor enter karein.',
        ];
    }
}