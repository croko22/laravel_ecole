<?php

namespace App\Livewire\Modals;

use Livewire\Component;
use App\Models\Attendance;


class TakeAttendance extends Component
{
    public $lesson;
    public $attendance;
    public $course;

    public function mount($lesson)
    {
        $this->lesson = $lesson;
        // Load attendance with students to avoid N+1 queries
        $this->lesson->load('attendance.student');
    }
    public function render()
    {
        return view('livewire.modals.take-attendance', [
            'course' => $this->lesson->course,
            'students' => $this->lesson->course->students,
            'attendance' => $this->lesson->attendance,
        ]);
    }


    public function updateAttendance($studentId, $isChecked)
    {
        // Use firstOrNew to avoid duplicate queries
        $attendance = Attendance::firstOrNew([
            'lesson_id' => $this->lesson->id,
            'student_id' => $studentId,
        ]);

        if ($isChecked) {
            if (!$attendance->exists) {
                $attendance->save();
            }
        } else {
            if ($attendance->exists) {
                $attendance->delete();
            }
        }

        $this->dispatch('attendance-updated', ['message' => 'Attendance updated successfully!']);
    }
}
