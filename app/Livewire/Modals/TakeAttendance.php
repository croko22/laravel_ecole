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

        $this->attendance = $lesson->attendance;

    }
    public function render()
    {
        return view('livewire.modals.take-attendance', [
            'course' => $this->lesson->course,
            'students' => $this->lesson->course->students,
            'attendance' => $this->attendance,
        ]);
    }


    public function updateAttendance($studentId, $isChecked)
    {
        $attendance = Attendance::where('lesson_id', $this->lesson->id)
            ->where('student_id', $studentId)
            ->first();

        if ($isChecked && !$attendance) {
            Attendance::create([
                'lesson_id' => (int) $this->lesson->id,
                'student_id' => (int) $studentId,
            ]);
        } elseif (!$isChecked && $attendance) {
            $attendance->delete();
        }
        $this->dispatch('attendance-updated', ['message' => 'Attendance updated successfully!']);
    }
}
