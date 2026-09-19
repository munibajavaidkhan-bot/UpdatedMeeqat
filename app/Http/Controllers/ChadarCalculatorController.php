<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChadarCalculatorRequest;
use App\Models\ChaddarCalculation;
use App\Models\ChaddarSizeRule;
use App\Services\ChadarSizeService;
use App\Services\ActivityLogService;
use Illuminate\Http\Request;

class ChadarCalculatorController extends Controller
{
    public function __construct(
        private readonly ChadarSizeService $sizeService
    ) {}

    // =========================================
    // INDEX — Show Calculator Page
    // =========================================
    public function index()
    {
        // All rules for size comparison table
        $fullRules     = $this->sizeService->getAllRules('full');
        $shoulderRules = $this->sizeService->getAllRules('shoulder');

        return view('calculator.chaddar', compact(
            'fullRules',
            'shoulderRules',
        ));
    }

    // =========================================
    // CALCULATE — Handle Form Submission
    // =========================================
    public function calculate(ChadarCalculatorRequest $request)
    {
        // Convert height to CM
        $heightCm = $request->getHeightInCm();
        $style    = $request->style;

        // Perform calculation
        $result = $this->sizeService->calculate($heightCm, $style);

        if (!$result['success']) {
            return back()
                ->withInput()
                ->with('error', $result['message']);
        }

        // Save to database
        $calculation = ChaddarCalculation::create([
            'user_id'           => auth()->id(),
            'session_id'        => session()->getId(),
            'height_cm'         => $heightCm,
            'style'             => $style,
            'calculated_meters' => $result['fabric_meters'],
            'size_label'        => $result['size_label'],
            'ip_address'        => $request->ip(),
        ]);

        // Activity log
        ActivityLogService::log(
            action:  'calculator_used',
            module:  'chaddar_calculator',
            details: [
                'height_cm'     => $heightCm,
                'style'         => $style,
                'result_meters' => $result['fabric_meters'],
                'size'          => $result['size_label'],
            ]
        );

        // Redirect to result page
        return redirect()->route('calculator.chaddar.result', $calculation->id)
            ->with('result', $result);
    }

    // =========================================
    // RESULT — Show Calculation Result Page
    // =========================================
    public function result(Request $request, int $id)
    {
        $calculation = ChaddarCalculation::findOrFail($id);

        // Security: logged-in users can only see their own results
        if ($calculation->user_id && $calculation->user_id !== auth()->id()) {
            abort(403);
        }

        // Guests can only see results from their own session
        if (!$calculation->user_id && $calculation->session_id !== session()->getId()) {
            abort(403);
        }

        // Rebuild result data
        $result = $this->sizeService->calculate(
            $calculation->height_cm,
            $calculation->style
        );

        // Size table for comparison (both style tables for toggle)
        $fullRules = $this->sizeService->getAllRules('full');
        $shoulderRules = $this->sizeService->getAllRules('shoulder');

        return view('calculator.chaddar-result', compact(
            'calculation',
            'result',
            'fullRules',
            'shoulderRules',
        ));
    }
}