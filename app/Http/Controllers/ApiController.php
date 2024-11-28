<?php

namespace App\Http\Controllers;

use App\Models\Configurations;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ApiController extends Controller
{
    public function index()
    {
        return view('calender.index');
    }

    public function getEvents(Request $request)
    {
        try {
            $events = Event::all();
            return response()->json($events);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to get events. Please try again.',
            ], 500);
        }
    }

    public function addEvents(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'start' => 'required|date',
                'end' => 'nullable|date|after_or_equal:start',
            ]);   
            $event = Event::create($validated);
        return response()->json($event);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to add event. Please try again.',
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string|max:255',
                'start' => 'required|date',
                'end' => 'nullable|date|after_or_equal:start',
            ]);
            $event = Event::findOrFail($id);
            $event->update($validatedData);
            return response()->json($event);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to update event. Please try again.',
            ], 500);
        }
    }

    public function deleteEvent($eventId, Request $request)
    {
        try {
            $event = Event::findOrFail($eventId);
            $event->delete();
            return response()->json([
                'message' => 'Event deleted successfully!',
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete event. Please try again.',
            ], 500);
        }
    }
}
