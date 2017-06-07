<?php

namespace App\Http\Controllers;

use App\TimeSlots;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TimeSlotController extends Controller
{
    public function addTimeSlot(Request $request)
    {
        $data = $request->only(
            [
                'dayOfWeek', 'startTime', 'endTime'
            ]);

        $this->validate($request, [
            'dayOfWeek' => 'required|max:255',
            'startTime' => 'required|max:255',
            'endTime' => 'required|max:255'
        ]);

        TimeSlots::create([
            'dayOfWeek' => $data['dayOfWeek'],
            'startTime' => $data['startTime'],
            'endTime' => $data['endTime']
        ]);

        return redirect('/admin/timeSlots')->with('message', 'Créneau ajouté.');

    }

    public function updateTimeSlot(Request $request)
    {
        $data = $request->only(
            [
                'dayOfWeekOld', 'dayOfWeekNew',
                'startTimeOld', 'startTimeNew',
                'endTimeOld', 'endTimeNew'
            ]);

        $this->validate($request, [
            'dayOfWeekNew' => 'required|max:255',
            'startTimeNew' => 'required|max:255',
            'endTimeNew' => 'required|max:255'
        ]);

        DB::table('timeSlots')
            ->where([
                ['dayOfWeek', $data['dayOfWeekOld']],
                ['startTime', $data['startTimeOld']],
                ['endTime', $data['endTimeOld']]
            ])
            ->update(
                [
                    'dayOfWeek' => $data['dayOfWeekNew'],
                    'startTime' => $data['startTimeNew'],
                    'endTime' => $data['endTimeNew']
                ]
            );

        return redirect('/admin/timeSlots')->with('message', 'Créneau mis à jour.');
    }

    public function deleteTimeSlot(Request $request)
    {
        $data = $request->only(
            [
                'dayOfWeek', 'startTime', 'endTime'
            ]);

        if ($this->isTimeSlotCantDelete($data['dayOfWeek'], $data['startTime'], $data['endTime'])) {
            DB::table('timeSlots')->where([
                ['dayOfWeek', $data['dayOfWeek']],
                ['startTime', $data['startTime']],
                ['endTime', $data['endTime']]
            ])->delete();
            return redirect('/admin/timeSlots')->with('message', 'Le créneau a été supprimé.');
        } else {
            return redirect('/admin/timeSlots')->with('message', 'Ce créneau est utilisé, il ne peut donc pas être supprimé.');
        }
    }

    private function isTimeSlotCantDelete($dayOfWeek, $startTime, $endTime)
    {
        $timeSlotId = DB::table('timeSlots')->where([
            ['dayOfWeek', $dayOfWeek],
            ['startTime', $startTime],
            ['endTime', $endTime]
        ])->value('id');

        $timeSlot = DB::table('sessions')->where('timeSlot_id', $timeSlotId)->get();

        if (empty($timeSlot->all())) {
            return true;
        } else {
            return false;
        }
    }
}
