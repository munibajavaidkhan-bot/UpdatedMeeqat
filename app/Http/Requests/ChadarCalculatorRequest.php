<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChadarCalculatorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Guests can also use it
    }

    public function rules(): array
    {
        return [
            'unit'        => 'required|in:cm,feet',
            'height_cm'   => 'required_if:unit,cm|nullable|numeric|min:100|max:250',
            'height_feet' => 'required_if:unit,feet|nullable|integer|min:4|max:8',
            'height_inch' => 'nullable|integer|min:0|max:11',
            'style'       => 'required|in:full,shoulder',
        ];
    }

    public function messages(): array
    {
        return [
            'unit.required'            => 'Please select a height unit (CM or Feet).',
            'height_cm.required_if'    => 'Please fill in the height (CM).',
            'height_cm.min'            => 'Height must be at least 100cm.',
            'height_cm.max'            => 'Height can be up to 250cm.',
            'height_feet.required_if'  => 'Please fill in the height (Feet).',
            'height_feet.min'          => 'Height must be at least 4 feet.',
            'height_feet.max'          => 'Height can be up to 8 feet.',
            'style.required'           => 'Please select a style (Full or Shoulder).',
            'style.in'                 => 'Invalid style selected.',
        ];
    }

    /**
     * Calculate final height in CM
     */
    public function getHeightInCm(): float
    {
        if ($this->unit === 'cm') {
            return (float) $this->height_cm;
        }

        // Convert Feet + Inches to CM
        $feet   = (int) ($this->height_feet ?? 0);
        $inches = (int) ($this->height_inch ?? 0);
        return round(($feet * 12 + $inches) * 2.54, 2);
    }
}