<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index(): RedirectResponse
    {
        return redirect()->route('calendar.month', ['date' => Carbon::today()->format('Y-m-d')]);
    }

    public function day(string $date): View
    {
        $currentDate = Carbon::parse($date);
        return view('calendar.index', [
            'view' => 'day',
            'currentDate' => $currentDate,
        ]);
    }

    public function week(string $date): View
    {
        $currentDate = Carbon::parse($date);
        return view('calendar.index', [
            'view' => 'week',
            'currentDate' => $currentDate,
        ]);
    }

    public function month(string $date): View
    {
        $currentDate = Carbon::parse($date);
        return view('calendar.index', [
            'view' => 'month',
            'currentDate' => $currentDate,
        ]);
    }

    public function year(int $year): View
    {
        $currentDate = Carbon::createFromDate($year, 1, 1);
        return view('calendar.index', [
            'view' => 'year',
            'currentDate' => $currentDate,
        ]);
    }
}
