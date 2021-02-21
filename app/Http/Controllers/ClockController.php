<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Registration;

class ClockController extends Controller
{
    public function index()
    {
        $events = Event::where('from_date', '>=', date('Y-m-d', strtotime(today())))
        ->orderBy('name', 'asc')->get();

        return view('welcome', compact('events'));
    }

    public function show(Event $event, $type)
    {
        return view('clock', compact('event', 'type'));
    }

    public function clock(Event $event, $type)
    {
        $registration_id = request()->get('registration_id');
        
        $registration = Registration::join('events', 'registrations.event_id', '=', 'events.id')
            ->where('registrations.event_id', '=', $event->id)
            ->where('registrations.id', '=', $registration_id)
            ->select('registrations.*')->first();

        if($registration == null)
            return redirect()->route('clocks.show', compact('event', 'type'))->with('message', 'Registrant not found, please try again.');

        $registration->update([
            'status' => 3,
            ]);

        $clocklog = $registration->clocklog()->create([
            'type' => $type,
            ]);
        
        return view('clock', compact('event', 'type', 'registration', 'clocklog'));
    }
}
