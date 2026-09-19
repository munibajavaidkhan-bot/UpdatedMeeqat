<?php

namespace App\Services;

use App\Models\ChaddarSizeRule;

class ChadarSizeService
{
    /**
     * Calculate fabric meters based on height and style
     */
    public function calculate(float $heightCm, string $style): array
    {
        // Find matching rule from database
        $rule = ChaddarSizeRule::active()
            ->byStyle($style)
            ->where('height_min_cm', '<=', $heightCm)
            ->where('height_max_cm', '>=', $heightCm)
            ->first();

        if (!$rule) {
            // If no exact match found, find the closest rule
            $rule = $this->getClosestRule($heightCm, $style);
        }

        if (!$rule) {
            return [
                'success' => false,
                'message' => 'No rule found for this height.',
            ];
        }

        return [
            'success'           => true,
            'fabric_meters'     => $rule->fabric_meters,
            'size_label'        => $rule->size_label,
            'style'             => $style,
            'style_label'       => $rule->style_label,
            'height_cm'         => $heightCm,
            'height_feet'       => $this->cmToFeet($heightCm),
            'height_range'      => $rule->height_range,
            'size_badge_color'  => $rule->size_badge_color,
            'description'       => $rule->description,
            'tip'               => $this->getStyleTip($style),
            'buying_tips'       => $this->getBuyingTips($rule->size_label),
        ];
    }

    /**
     * Find the closest matching rule
     */
    private function getClosestRule(float $heightCm, string $style): ?ChaddarSizeRule
    {
        return ChaddarSizeRule::active()
            ->byStyle($style)
            ->orderByRaw('ABS(height_min_cm - ?)', [$heightCm])
            ->first();
    }

    /**
     * Convert CM to Feet/Inches
     */
    public function cmToFeet(float $cm): string
    {
        $totalInches = $cm / 2.54;
        $feet   = floor($totalInches / 12);
        $inches = round(fmod($totalInches, 12));
        return "{$feet}'{$inches}\"";
    }

    /**
     * Convert Feet/Inches to CM
     */
    public function feetToCm(int $feet, int $inches): float
    {
        return round(($feet * 12 + $inches) * 2.54, 2);
    }

    /**
     * Style tips
     */
    private function getStyleTip(string $style): string
    {
        return match($style) {
            'full'     => 'In full body style, the chaddar reaches the feet. This is the most recommended Sunnah style for Umrah.',
            'shoulder' => 'In shoulder style, the chaddar starts from the shoulder. More lightweight and comfortable.',
            default    => '',
        };
    }

    /**
     * Buying tips by size
     */
    private function getBuyingTips(string $sizeLabel): array
    {
        $tips = [
            'XS'  => ['Prefer lightweight fabric', 'Pure cotton is more comfortable', '3.5 meters is exact'],
            'S'   => ['Choose cotton or cotton-blend fabric', 'Keep a little extra margin', 'Prefer soft texture'],
            'M'   => ['Medium weight fabric is ideal', 'Pure Egyptian cotton is best', 'Easily available in the market'],
            'L'   => ['Invest in quality fabric', 'Extra half meter for safety', 'Pre-washed fabric prevents shrinkage'],
            'XL'  => ['Choose heavy duty quality', 'Extra meter recommended', 'Professional tailoring is better'],
            'XXL' => ['Custom stitching is the best option', 'Always take extra 0.5 meter', 'Must take premium quality fabric'],
        ];

        return $tips[$sizeLabel] ?? ['Prefer quality fabric', 'Pure cotton is the best choice'];
    }

    /**
     * All rules for comparison table
     */
    public function getAllRules(string $style): \Illuminate\Support\Collection
    {
        return ChaddarSizeRule::active()
            ->byStyle($style)
            ->orderBy('height_min_cm')
            ->get();
    }
}