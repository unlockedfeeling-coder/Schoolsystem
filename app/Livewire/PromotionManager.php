<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\ExamResult;

class PromotionManager extends Component
{
    // NEW CRITERIA SETTINGS
    public $min_pass_score = 45; 
    public $min_subjects_to_pass = 5; 
    
    public $logs = [];

    public function runPromotion()
    {
        $this->logs = [];
        $students = Student::with('classLevel')->get();
        $promotedCount = 0;
        $retainedCount = 0;

        foreach ($students as $student) {
            // 1. Get all exam results for this student
            $results = ExamResult::where('student_id', $student->id)->get();
            
            // 2. Count how many subjects they passed based on the criteria
            $passed_subjects = 0;
            $total_subjects = $results->count();

            foreach ($results as $result) {
                if ($result->marks >= $this->min_pass_score) {
                    $passed_subjects++;
                }
            }

            // 3. Check if they meet the criteria (e.g., passed at least 5 subjects)
            if ($passed_subjects >= $this->min_subjects_to_pass && $total_subjects > 0) {
                
                // Find the next class level
                $nextClass = ClassLevel::where('order', '>', $student->classLevel->order)
                                       ->orderBy('order')
                                       ->first();

                if ($nextClass) {
                    // PROMOTE Student
                    $student->update(['class_level_id' => $nextClass->id]);
                    $this->logs[] = [
                        'name' => $student->first_name . ' ' . $student->last_name,
                        'from' => $student->classLevel->name,
                        'to' => $nextClass->name,
                        'passed' => $passed_subjects,
                        'total' => $total_subjects,
                        'status' => 'Promoted'
                    ];
                    $promotedCount++;
                } else {
                    $this->logs[] = [
                        'name' => $student->first_name . ' ' . $student->last_name,
                        'from' => $student->classLevel->name,
                        'to' => 'Graduated / Highest Class',
                        'passed' => $passed_subjects,
                        'total' => $total_subjects,
                        'status' => 'Completed'
                    ];
                }
            } else {
                // RETAIN Student
                $this->logs[] = [
                    'name' => $student->first_name . ' ' . $student->last_name,
                    'from' => $student->classLevel->name,
                    'to' => $student->classLevel->name,
                    'passed' => $passed_subjects,
                    'total' => $total_subjects,
                    'status' => 'Retained'
                ];
                $retainedCount++;
            }
        }

        session()->flash('message', "Promotion Complete! {$promotedCount} Promoted, {$retainedCount} Retained.");
    }

    public function render() { return view('livewire.promotion-manager'); }
}