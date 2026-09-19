<?php
namespace App\Http\Controllers;

use App\Models\Dua;

class HomeController extends Controller {
    public function index() {
        return view('welcome');
    }

    public function about() {
        return view('about');
    }

    public function hajjChecklist() {
        return view('tools.hajj-checklist');
    }

    public function qibla() {
        return view('tools.qibla');
    }

    public function prayerTimes() {
        return view('tools.prayer-times');
    }
}