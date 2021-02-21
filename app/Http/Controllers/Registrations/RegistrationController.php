<?php

namespace App\Http\Controllers\Registrations;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RegistrationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $registrations = Registration::paginate(15);

        return view('registrations.index', compact('registrations'));
    }

    public function search()
    {
        $str = request()->get('str');

        $registrations = Registration::where('last_name', 'like', $str . '%')
            ->orwhere('first_name', 'like', $str . '%')
            ->orwhere('email', 'like', '%'. $str . '%')
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')->paginate(15);

        $registrations->appends(['str' => $str]);

        return view('registrations.index', compact('registrations'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('registrations.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'event_id' => 'required',
            'email' => ['required', 'email', 'max:255', Rule::unique('registrations')
                ->where('event_id', request()->event_id)
                ->where('email', request()->email)],
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'contact_no' => 'required|string|min:11|max:11|regex:/(0)[0-9]{10}/',
            'position' => 'required|string|max:255',
            'office_name' => 'required|string|max:255',
            'status' => 'required',
        ]);

        $registration = Registration::create($validated);
        $event = $registration->event;

        return redirect()->route('events.show', compact('event'))->with('message', 'Registration was saved.');
        // return redirect()->route('registrations.edit', compact('registration'))->with('message', 'Registration was saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function show(Registration $registration)
    {
        return view('registrations.edit', compact('registration'));
    }

    public function confirm(Registration $registration, $type)
    {
        $registration->update(['status' => $type]);
        $event = $registration->event;

        return redirect()->route('events.show', compact('event'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function edit(Registration $registration)
    {
        return view('registrations.edit', compact('registration'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Registration $registration)
    {
        $validated = $request->validate([
            'email' => ['required', 'email', 'max:255', Rule::unique('registrations')
                ->where('event_id', request()->event_id)
                ->where('email', request()->email)->ignore($registration->id)],
            'last_name' => 'required|string|max:255',
            'first_name' => 'required|string|max:255',
            'middle_name' => 'nullable|string|max:255',
            'contact_no' => 'required|string|min:11|max:11|regex:/(0)[0-9]{10}/',
            'position' => 'required|string|max:255',
            'office_name' => 'required|string|max:255',
        ]);

        $registration->update($validated);
        $event = $registration->event;

        return redirect()->route('events.show', compact('event'))->with('message', 'Registration was updated.');
        //return redirect()->route('registrations.edit', compact('registration'))->with('message', 'Registration was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Registration  $registration
     * @return \Illuminate\Http\Response
     */
    public function destroy(Registration $registration)
    {
        $event = $registration->event;
        $registration->delete();        

        return redirect()->route('events.show', compact('event'))->with('message', 'Registration was deleted.');
        //return redirect()->route('registrations')->with('message', 'Registration was deleted.');
    }
}
