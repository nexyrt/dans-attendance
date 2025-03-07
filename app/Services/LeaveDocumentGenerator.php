<?php

namespace App\Services;

use App\Models\LeaveRequest;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;

class LeaveDocumentGenerator
{
    /**
     * Generate a filled leave document based on the leave request
     *
     * @param LeaveRequest $leaveRequest
     * @param string|null $staffSignaturePath Path to the staff signature image
     * @return string The path to the generated document
     */
    public function generate(LeaveRequest $leaveRequest, ?string $staffSignaturePath = null)
    {
        $templatePath = public_path('templates/Format-Izin-Cuti.docx');
        $user = $leaveRequest->user;
        $department = $user->department;

        // Create a unique filename for the generated document
        $outputFilename = 'leave_request_' . $leaveRequest->id . '_' . time() . '.docx';
        $outputPath = public_path('leave-documents/' . $outputFilename);
        
        // Ensure the directory exists
        if (!file_exists(public_path('leave-documents'))) {
            mkdir(public_path('leave-documents'), 0755, true);
        }

        try {
            // Create template processor
            $templateProcessor = new TemplateProcessor($templatePath);
            
            // Set basic information
            $templateProcessor->setValue('tanggal hari ini', Carbon::now()->locale('id')->isoFormat('D MMMM Y'));
            $templateProcessor->setValue('Nama Pemohon', $user->name);
            $templateProcessor->setValue('Jabatan Pemohon', $user->position ?? 'Staff');
            $templateProcessor->setValue('Jabatan_Departemen', ($user->position ?? 'Staff') . '_' . ($department->name ?? 'General'));
            
            // Get formatted leave type
            $leaveType = $this->getFormattedLeaveType($leaveRequest->type);
            $templateProcessor->setValue('leave_type', $leaveType);
            
            // Set leave information
            $duration = $leaveRequest->getDurationInDays();
            $templateProcessor->setValue('Durasi Cuti', $duration);
            $templateProcessor->setValue('Tanggal Mulai Cuti', Carbon::parse($leaveRequest->start_date)->locale('id')->isoFormat('D MMMM Y'));
            $templateProcessor->setValue('Tanggal Selesai Cuti', Carbon::parse($leaveRequest->end_date)->locale('id')->isoFormat('D MMMM Y'));
            $templateProcessor->setValue('reason', $leaveRequest->reason);
            
            // Set department information
            $templateProcessor->setValue('department_name', $department->name ?? 'General');
            
            // Set staff signature if provided
            if ($staffSignaturePath && file_exists(public_path($staffSignaturePath))) {
                // Log for debugging
                Log::info('Staff signature path: ' . $staffSignaturePath);
                Log::info('Staff signature exists: ' . (file_exists(public_path($staffSignaturePath)) ? 'Yes' : 'No'));
                
                try {
                    // Try different placeholder formats
                    $templateProcessor->setImageValue('[Tanda Tangan]', public_path($staffSignaturePath));
                } catch (\Exception $e) {
                    Log::error('Error setting signature image: ' . $e->getMessage());
                    
                    try {
                        // Try alternative placeholder format
                        $templateProcessor->setValue('[Tanda Tangan]', '✓ Signed electronically');
                    } catch (\Exception $e2) {
                        Log::error('Error setting signature text: ' . $e2->getMessage());
                    }
                }
            } else {
                $templateProcessor->setValue('[Tanda Tangan]', '[Tanda Tangan]');
            }
            
            // Set placeholder for other signatures
            $templateProcessor->setValue('manager_signature', '[Tanda Tangan Manager]');
            $templateProcessor->setValue('manager_name', '[Nama Manager]');
            $templateProcessor->setValue('hr_signature', '[Tanda Tangan HR]');
            $templateProcessor->setValue('hr_name', '[Nama HR]');
            $templateProcessor->setValue('director_signature', '[Tanda Tangan Direktur]');
            $templateProcessor->setValue('director_name', '[Nama Direktur]');
            
            // If approvals have been done, update the signatures
            if ($leaveRequest->manager_id && $leaveRequest->manager_approved_at) {
                if ($leaveRequest->manager_signature && file_exists(public_path($leaveRequest->manager_signature))) {
                    try {
                        $templateProcessor->setImageValue('manager_signature', public_path($leaveRequest->manager_signature));
                    } catch (\Exception $e) {
                        $templateProcessor->setValue('manager_signature', 'Disetujui pada ' . $leaveRequest->manager_approved_at->format('d/m/Y'));
                    }
                } else {
                    $templateProcessor->setValue('manager_signature', 'Disetujui pada ' . $leaveRequest->manager_approved_at->format('d/m/Y'));
                }
                $templateProcessor->setValue('manager_name', $leaveRequest->manager->name ?? '[Nama Manager]');
            }
            
            if ($leaveRequest->hr_id && $leaveRequest->hr_approved_at) {
                if ($leaveRequest->hr_signature && file_exists(public_path($leaveRequest->hr_signature))) {
                    try {
                        $templateProcessor->setImageValue('hr_signature', public_path($leaveRequest->hr_signature));
                    } catch (\Exception $e) {
                        $templateProcessor->setValue('hr_signature', 'Disetujui pada ' . $leaveRequest->hr_approved_at->format('d/m/Y'));
                    }
                } else {
                    $templateProcessor->setValue('hr_signature', 'Disetujui pada ' . $leaveRequest->hr_approved_at->format('d/m/Y'));
                }
                $templateProcessor->setValue('hr_name', $leaveRequest->hr->name ?? '[Nama HR]');
            }
            
            if ($leaveRequest->director_id && $leaveRequest->director_approved_at) {
                if ($leaveRequest->director_signature && file_exists(public_path($leaveRequest->director_signature))) {
                    try {
                        $templateProcessor->setImageValue('director_signature', public_path($leaveRequest->director_signature));
                    } catch (\Exception $e) {
                        $templateProcessor->setValue('director_signature', 'Disetujui pada ' . $leaveRequest->director_approved_at->format('d/m/Y'));
                    }
                } else {
                    $templateProcessor->setValue('director_signature', 'Disetujui pada ' . $leaveRequest->director_approved_at->format('d/m/Y'));
                }
                $templateProcessor->setValue('director_name', $leaveRequest->director->name ?? '[Nama Direktur]');
            }
            
            // Save the document
            $templateProcessor->saveAs($outputPath);
            
            // Return the relative path for storage in the database
            return 'leave-documents/' . $outputFilename;
            
        } catch (\Exception $e) {
            Log::error('Error generating leave document: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Get formatted leave type in Indonesian
     *
     * @param string $type
     * @return string
     */
    private function getFormattedLeaveType(string $type): string
    {
        return match($type) {
            LeaveRequest::TYPE_SICK => 'Cuti Sakit',
            LeaveRequest::TYPE_ANNUAL => 'Cuti Tahunan',
            LeaveRequest::TYPE_IMPORTANT => 'Cuti Penting',
            LeaveRequest::TYPE_OTHER => 'Cuti Lainnya',
            default => 'Cuti'
        };
    }
}