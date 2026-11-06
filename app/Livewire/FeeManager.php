<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FeeType;
use App\Models\FeeStructure;
use App\Models\FeePayment;
use App\Models\Student;
use App\Models\ClassLevel;
use App\Models\AcademicSession;
use Barryvdh\DomPDF\Facade\Pdf;

class FeeManager extends Component
{
    public $activeTab = 'types';
    public $typeName = '';
    public $structureFeeTypeId = '';
    public $structureClassId = '';
    public $structureAmount = '';
    public $paymentStudentId = '';
    public $paymentFeeTypeId = '';
    public $paymentAmount = '';
    public $paymentMethod = 'Cash';
    public $paymentDate = '';
    public $paymentReference = '';

    public function mount()
    {
        $this->paymentDate = date('Y-m-d');
    }

    public function saveFeeType()
    {
        try {
            $this->validate(['typeName' => 'required|unique:fee_types,name']);
            FeeType::create(['name' => $this->typeName]);
            $this->typeName = '';
            session()->flash('message', 'Fee Type added!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error adding type.');
        }
    }

    public function deleteFeeType($id)
    {
        try {
            FeeType::find($id)?->delete();
            session()->flash('message', 'Deleted!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting.');
        }
    }

    public function saveFeeStructure()
    {
        try {
            $this->validate([
                'structureFeeTypeId' => 'required',
                'structureClassId' => 'required',
                'structureAmount' => 'required|numeric|min:0'
            ]);

            $session = AcademicSession::where('is_active', true)->first();
            if (!$session) {
                session()->flash('error', 'No active session found.');
                return;
            }

            FeeStructure::updateOrCreate(
                [
                    'fee_type_id' => $this->structureFeeTypeId,
                    'class_level_id' => $this->structureClassId,
                    'academic_session_id' => $session->id
                ],
                ['amount' => $this->structureAmount]
            );

            $this->structureFeeTypeId = '';
            $this->structureClassId = '';
            $this->structureAmount = '';
            session()->flash('message', 'Fee structure saved!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error saving structure.');
        }
    }

    public function deleteFeeStructure($id)
    {
        try {
            FeeStructure::find($id)?->delete();
            session()->flash('message', 'Deleted!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error deleting.');
        }
    }

    public function recordPayment()
    {
        try {
            $this->validate([
                'paymentStudentId' => 'required',
                'paymentFeeTypeId' => 'required',
                'paymentAmount' => 'required|numeric|min:1',
                'paymentDate' => 'required|date'
            ]);

            $session = AcademicSession::where('is_active', true)->first();
            if (!$session) {
                session()->flash('error', 'No active session found.');
                return;
            }

            FeePayment::create([
                'student_id' => $this->paymentStudentId,
                'fee_type_id' => $this->paymentFeeTypeId,
                'academic_session_id' => $session->id,
                'amount_paid' => $this->paymentAmount,
                'payment_method' => $this->paymentMethod,
                'reference_number' => $this->paymentReference,
                'payment_date' => $this->paymentDate
            ]);

            $this->paymentAmount = '';
            $this->paymentReference = '';
            session()->flash('message', 'Payment recorded!');
        } catch (\Exception $e) {
            session()->flash('error', 'Error recording payment.');
        }
    }

    // --- THE ULTIMATE UTF-8 FIX ---
    public function printReceipt($paymentId)
    {
        try {
            $payment = FeePayment::with(['student.classLevel', 'feeType', 'session'])->findOrFail($paymentId);
            $student = $payment->student;
            $session = $payment->session ?? AcademicSession::where('is_active', true)->first();

            if (!$session) {
                session()->flash('error', 'No session found.');
                return;
            }

            $structure = FeeStructure::where('fee_type_id', $payment->fee_type_id)
                ->where('class_level_id', $student->class_level_id)
                ->where('academic_session_id', $session->id)
                ->first();

            $totalRequired = $structure?->amount ?? 0;
            $totalPaid = FeePayment::where('student_id', $student->id)
                ->where('fee_type_id', $payment->fee_type_id)
                ->where('academic_session_id', $session->id)
                ->sum('amount_paid');

            // 1. Render the view to a string first
            $html = view('pdf.fee-receipt', compact('payment', 'student', 'totalRequired', 'totalPaid'))->render();
            
            // 2. Force the entire HTML string to be valid UTF-8
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
            
            // 3. Load the clean HTML into DomPDF with DejaVu Sans font
            $pdf = Pdf::loadHtml($html)->setOptions(['defaultFont' => 'DejaVu Sans']);
            
            return $pdf->download('Receipt_' . $student->admission_number . '_' . $payment->id . '.pdf');
            
        } catch (\Exception $e) {
            // We catch the error silently so it doesn't break the JSON response
            session()->flash('error', 'Could not generate PDF. Please try again.');
        }
    }

    public function render()
    {
        $feeTypes = FeeType::latest()->get();
        $feeStructures = FeeStructure::with(['feeType', 'classLevel'])->latest()->get();
        $students = Student::with('classLevel')->latest()->get();
        $recentPayments = FeePayment::with(['student', 'feeType'])->latest()->take(10)->get();
        $session = AcademicSession::where('is_active', true)->first();

        return view('livewire.fee-manager', compact('feeTypes', 'feeStructures', 'students', 'recentPayments', 'session'));
    }
}