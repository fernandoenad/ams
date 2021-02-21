<?php

namespace App\Http\Controllers\Events;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Registration;
use App\Models\ClockLog;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Codedge\Fpdf\Fpdf\Fpdf;
use AsalNgoding\Fpdf\PDF_Code128;

class EventController extends Controller
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
        $events = Event::orderBy('created_at', 'desc')->paginate(15);

        return view('events.index', compact('events'));
    }

    public function search()
    {
        $str = request()->get('str');

        $events = Event::where('name', 'like', '%' . $str . '%')
            ->orderBy('name', 'asc')->paginate(15);

        $events->appends(['str' => $str]);

        return view('events.index', compact('events'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('events.create');
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
            'name' => 'required|unique:events|max:255',
            'from_date' => 'required|date|after_or_equal:today',
            'to_date' => 'required|date|after_or_equal:from_date',
            'venue' => 'required|max:255',
        ]);

        $event = Event::create($validated);

        return redirect()->route('events.edit', compact('event'))->with('message', 'Event was saved.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function show(Event $event)
    {
        $registrations = Registration::where('event_id', '=', $event->id)
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')->paginate(15);

        return view('events.show', compact('event', 'registrations'));
    }

    public function searchshow(Event $event)
    {
        $str = request()->get('str');

        $registrations = Registration::where('last_name', 'like', $str . '%')
            ->orwhere('first_name', 'like', $str . '%')
            ->orwhere('email', 'like', '%'. $str . '%')
            ->orwhere('id', '=', $str)
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')->paginate(15);

        $registrations->appends(['str' => $str]);

        return view('events.show', compact('event', 'registrations'));
    }

    public function monitor(Event $event)
    {
        $clocklogs = ClockLog::join('registrations', 'clock_logs.registration_id', '=', 'registrations.id')
            ->join('events', 'registrations.event_id', '=', 'events.id')
            ->where('events.id', '=', $event->id)
            ->orderBy('created_at', 'desc')
            ->select('clock_logs.*')->paginate(50);

        return view('events.monitor', compact('event', 'clocklogs'));
    }

    public function printid(Event $event)
    {
        $registrations = $event->registration;

        $fpdf = new PDF_Code128('P','mm','Letter');
        foreach($registrations as $registration){
        
            $fpdf->AddPage();   
            $fpdf->SetFont('Courier', '', 15);        
            $fpdf->Cell(95, 15, '0', 'TLR', 1, 'C');
            $fpdf->SetFillColor(0, 119, 190);
            $fpdf->SetTextColor(255,255,255);
            $fpdf->SetFont('Courier', '', 8, 'white');
            $fpdf->Cell(95, 3, '', 'LR', 1, 'C', true);
            $fpdf->Cell(95, 3, 'Republic of the Philippines', 'LR', 1, 'C', true);
            $fpdf->Cell(95, 3, 'Department of Education', 'LR', 1, 'C', true);
            $fpdf->Cell(95, 3, 'Central Visayas', 'LR', 1, 'C', true);
            $fpdf->SetFont('Courier', 'B', 8);
            $fpdf->Cell(95, 3, 'SCHOOLS DIVISION OFFICE - BOHOL', 'LR', 1, 'C', true);
            $fpdf->SetFont('Courier', '', 8);
            $fpdf->Cell(95, 3, 'Tagbilaran City', 'LR', 1, 'C', true);
            $fpdf->Cell(95, 3, '', 'LR', 1, 'C', true);
            $fpdf->Image('storage/assets/logo.png',91,30,10);
            $fpdf->Image('storage/assets/deped.png',15,30,13);
            
            $fpdf->SetTextColor(0,0,0);
            $fpdf->SetFillColor(255, 255, 255);

            $fpdf->SetFont('Courier', 'B', 20);
            $fpdf->Cell(95, 5, '', 'LR', 1, 'C');

            $text = $registration->event->name;
            $char_per_line = 20; 
            $text_arr = explode("\n", wordwrap($text, $char_per_line));
            $max_lines = 6;
            $line_count = 0;

            for($i=0; $i<sizeof($text_arr); $i++){
                $fpdf->Cell(95, 6, $text_arr[$i], 'LR', 1, 'C');
                $line_count++;
            } 

            for($i=$line_count; $i<$max_lines; $i++){
                $fpdf->Cell(95, 6, '', 'LR', 1, 'C');
            }

            $fpdf->SetFont('Courier', 'B', 9);
            $text = $registration->event->venue;
            $char_per_line = 30; 
            $text_arr = explode("\n", wordwrap($text, $char_per_line));
            $max_lines = 2;
            $line_count = 0;

            for($i=0; $i<sizeof($text_arr); $i++){
                $fpdf->Cell(95, 3, $text_arr[$i], 'LR', 1, 'C');
                $line_count++;
            } 

            for($i=$line_count; $i<$max_lines; $i++){
                $fpdf->Cell(95, 3, '', 'LR', 1, 'C');
            }

            $fpdf->SetFont('Courier', '', 9);
            $fpdf->Cell(95, 3, date('M d', strtotime($registration->event->from_date)) . ' - ' . date('M d, Y', strtotime($registration->event->to_date)), 'LR', 1, 'C');
            $fpdf->Cell(95, 10, '', 'LR', 1, 'C');
            $fpdf->SetFont('Courier', 'B', 15);
            $fpdf->Cell(95, 5, $registration->getFullname() ?? '' , 'LR', 1, 'C');
            $fpdf->SetFont('Courier', 'B', 12);
            $fpdf->Cell(95, 5, $registration->office_name ?? '', 'LR', 1, 'C');
            $fpdf->Cell(95, 3, '', 'LR', 1, 'C');
            $fpdf->SetFillColor(0, 0, 0);
            $fpdf->SetTextColor(255,255,255);
            $fpdf->Cell(95, 20, '', 'BTLR', 1, 'C');
            
            $code = $registration->id;
            $width = 50;
            $fpdf->Code128($width /2+7,122,$code,$width,10);
            $fpdf->SetTextColor(0,0,0);
            $fpdf->Cell(95, -10, 'Reg. ID: '. $code, 0, 0, 'C');
        }
        $fpdf->Output();
        exit;
    }

    public function printappearance(Event $event)
    {
        $registrations = $event->registration;

        $fpdf = new PDF_Code128('P','mm','Letter');
        foreach($registrations as $registration){
        
            $fpdf->AddPage();   
            $image_width = 18;
            $fpdf->Image('storage/assets/seal.png',(200/2) - ($image_width/2)+7,14,$image_width);
            $fpdf->SetFont('Courier', '', 10);        
            $fpdf->Cell(195, 23, '', 'TLR', 1, 'C');
            $fpdf->Cell(195, 3, 'Republic of the Philippines', 'LR', 1, 'C');
            $fpdf->Cell(195, 3, 'Department of Education', 'LR', 1, 'C');
            $fpdf->Cell(195, 3, 'Central Visayas', 'LR', 1, 'C');
            $fpdf->SetFont('Courier', 'B', 12);
            $fpdf->Cell(195, 5, 'SCHOOLS DIVISION OFFICE - BOHOL', 'LR', 1, 'C');
            $fpdf->SetFont('Courier', '', 10);
            $fpdf->Cell(195, 3, 'Tagbilaran City', 'LR', 1, 'C');
            $fpdf->Cell(195, 8, '', 'LR', 1, 'C');
            $fpdf->SetFont('Courier', 'B', 20);
            $fpdf->Cell(195, 5, 'CERTIFICATE OF APPEARANCE', 'LR', 1, 'C');
            $fpdf->SetFont('Courier', '', 8);
            $fpdf->SetFont('Courier', 'B', 20);
            $fpdf->Cell(195, 5, '', 'LR', 1, 'C');
            $fpdf->SetFont('Courier', '', 10);
            
            $registration_name = mb_strtoupper($registration->getFullname());
            $office_name = $registration->office_name;
            $event = $registration->event->name;
            $from_date = date('M d', strtotime($registration->event->from_date));
            $to_date = date('M d, Y', strtotime($registration->event->to_date));
            $venue = $registration->event->venue;
            $text1 = 'This is to certify that ';
            $text2 = $registration_name . ' of ' . $office_name;
            $text3 = 'has attended the recently concluded';
            $text4 = $event;
            $text5 = 'held on ' . $from_date . '-' . $to_date;
            $text6 = ' at ' . $venue . '.';
            $text7 = 'Issued on the '. date('dS', strtotime(now())) .' day of '. date('F', strtotime(now()))  . ', ' . date('Y', strtotime(now()))  . '.';

            $fpdf->Cell(195, 4, $text1, 'LR', 1, 'C');
            $fpdf->SetFont('Courier', 'B', 15);
            $fpdf->Cell(195, 6, $text2, 'LR', 1, 'C');
            $fpdf->SetFont('Courier', '', 10);
            $fpdf->Cell(195, 4, $text3, 'LR', 1, 'C');
            $fpdf->SetFont('Courier', 'B', 10);
            $fpdf->Cell(195, 4, $text4, 'LR', 1, 'C');
            $fpdf->SetFont('Courier', '', 10);
            $fpdf->Cell(195, 4, $text5, 'LR', 1, 'C');
            $fpdf->Cell(195, 4, $text6, 'LR', 1, 'C');
            $fpdf->Cell(195, 4, '', 'LR', 1, 'C');
            $fpdf->Cell(195, 4, $text7, 'LR', 1, 'C');
            $fpdf->Cell(195, 15, '', 'LR', 1, 'C');

            $image_width = 30;
            $fpdf->Image('storage/assets/sds.png',(200/2) - ($image_width/2)+7,106,$image_width);
            $fpdf->SetFont('Courier', 'B', 12);
            $fpdf->Cell(195, 5, 'BIANITO A. DAGATAN, PhD, CESO V', 'LR', 1, 'C');
            $fpdf->SetFont('Courier', '', 10);
            $fpdf->Cell(195, 5, 'Schools Division Superintendent', 'LR', 1, 'C');
            $fpdf->SetFont('Courier', '', 6);

            $width = 25;

            $fpdf->Cell($width+8, -1, $registration->event->id . '-' . $registration->id, 'L', 0, 'C');
            $fpdf->Cell(195-$width-8, -1, '', 'R', 1, 'C');
            $fpdf->Cell(195, 4, '', 'BLR', 1, 'L');

            $code = $registration->id;
            
            $fpdf->Code128($width /2+2,115,$code,$width,10);

        }
        $fpdf->Output();
        exit;
    }

    public function printattendance(Event $event)
    {
        $registrations = $event->registration;
       
        $fpdf = new PDF_Code128('P','mm','Letter');
        
        $fpdf->AddPage();   
        $image_width = 14;
        $fpdf->Image('storage/assets/seal.png',(200/2) - ($image_width/2)+7,8,$image_width);
        $fpdf->SetFont('Courier', '', 10);        
        $fpdf->Cell(195, 14, '', 0, 1, 'C');
        $fpdf->Cell(195, 3, 'Republic of the Philippines', 0, 1, 'C');
        $fpdf->Cell(195, 3, 'Department of Education', 0, 1, 'C');
        $fpdf->Cell(195, 3, 'Central Visayas', 0, 1, 'C');
        $fpdf->SetFont('Courier', 'B', 12);
        $fpdf->Cell(195, 5, 'SCHOOLS DIVISION OFFICE - BOHOL', 0, 1, 'C');
        $fpdf->SetFont('Courier', '', 10);
        $fpdf->Cell(195, 3, 'Tagbilaran City', 0, 1, 'C');
        $fpdf->Cell(195, 3, '', 0, 1, 'C');
        $fpdf->SetFont('Courier', 'B', 12);
        $fpdf->Cell(195, 5, 'ATTENDANCE LOGS', 0, 1, 'C');
        $fpdf->SetFont('Courier', 'B', 10);
        $fpdf->Cell(195, 3, $event->name, 0, 1, 'C');
        $fpdf->SetFont('Courier', '', 10);
        $fpdf->Cell(195, 4, date('M d', strtotime($event->from_date)) . '-' . date('M d, Y', strtotime($event->to_date)), 0, 1, 'C');
        $fpdf->Cell(195, 4, '', 0, 1, 'C');

        $fpdf->SetFont('Courier', 'B', 10);
        $fpdf->Cell(13, 4, '#', 'TBLR', 0, 'C');
        $fpdf->Cell(65, 4, 'Name', 'TBR', 0, 'C');
        $fpdf->Cell(45, 4, 'Office/District', 'TBR', 0, 'C');
        $fpdf->Cell(37, 4, 'Time In', 'TBR', 0, 'C');
        $fpdf->Cell(37, 4, 'Time Out', 'TBR', 1, 'C');

        $i=1;
        foreach($registrations as $registration){
            $fpdf->SetFont('Courier', '', 8);
            $fpdf->Cell(13, 4, $i++, 'BLR', 0, 'R');
            $fpdf->Cell(65, 4, $registration->getFullnameSorted(), 'BR', 0, 'L');
            $fpdf->Cell(45, 4, $registration->office_name, 'BR', 0, 'L');
            
            $clocklogs = ClockLog::join('registrations', 'clock_logs.registration_id', '=', 'registrations.id')
                ->where('clock_logs.registration_id', '=', $registration->id)
                ->where('type', '=', 'In')
                ->orderBy('clock_logs.created_at', 'asc')
                ->select('clock_logs.*')
                ->get()->first();
          
            //dd($clocklogs->id);
            //$in_date = date('M d, Y h:ia', strtotime($in->id)) . '';
            //dd($in->registration_id);
            $fpdf->Cell(37, 4, date('m/d/Y h:ia', strtotime($registration->created_at)), 'BR', 0, 'L');

            $out = ClockLog::join('registrations', 'clock_logs.registration_id', '=', 'registrations.id')
                ->where('clock_logs.registration_id', '=', $registration->id)
                ->where('type', '=', 'In')
                ->orderBy('clock_logs.created_at', 'asc')
                ->select('clock_logs.*')
                ->first();
            //$out_date = date('m-d-y h:ia', strtotime($out->created_at));
            $fpdf->Cell(37, 4, date('m/d/Y h:ia', strtotime($registration->created_at)), 'BLR', 1, 'L');
        }
        $fpdf->Cell(195, 5, '', 0, 1, 'C');
        $fpdf->SetFont('Courier', 'I', 7);
        $fpdf->Cell(195, 3, 'Auto-generated by the Bohol Attendance Management System (AMS) at ' . date('M d, Y h:ia', strtotime(now())), 0, 1, 'L');
        $fpdf->Output();
        exit;
    }

    public function searchmonitor(Event $event)
    {
        $str = request()->get('str');

        $clocklogs = ClockLog::join('registrations', 'clock_logs.registration_id', '=', 'registrations.id')
            ->join('events', 'registrations.event_id', '=', 'events.id')
            ->where('events.id', '=', $event->id)
            ->where('registrations.last_name', 'like', $str . '%')
            ->orderBy('clock_logs.created_at', 'desc')
            ->orderBy('last_name', 'asc')
            ->orderBy('first_name', 'asc')
            ->select('clock_logs.*')->paginate(50);

        return view('events.monitor', compact('event', 'clocklogs'));
    }    
   
    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function edit(Event $event)
    {
        return view('events.edit', compact('event'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Event $event)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:255', Rule::unique('events')->ignore($event->id)],
            'from_date' => 'required|date|after_or_equal:today',
            'to_date' => 'required|date|after_or_equal:from_date',
            'venue' => 'required|max:255',
        ]);

        $event->update($validated);
        
        return redirect()->route('events.edit', compact('event'))->with('message', 'Event was updated.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Event  $event
     * @return \Illuminate\Http\Response
     */
    public function destroy(Event $event)
    {
        $event->delete();

        return redirect()->route('events')->with('message', 'Event was deleted.');
    }
}
