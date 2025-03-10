<?php

namespace App\Services;

use App\Models\LeaveRequest;
use PhpOffice\PhpWord\TemplateProcessor;
use PhpOffice\PhpWord\IOFactory;
use Carbon\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\File;

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
            // Verify template exists
            if (!file_exists($templatePath)) {
                Log::error('Leave document template not found: ' . $templatePath);
                throw new \Exception('Leave document template not found.');
            }

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
            
            // Process staff signature - Using the correct ${placeholder} format
            $this->processSignature($templateProcessor, 'Tanda Tangan', $staffSignaturePath, $user->name);
            
            // Set placeholders for approval signatures with correct ${placeholder} format
            $templateProcessor->setValue('${manager_signature}', '[Tanda Tangan Manager]');
            $templateProcessor->setValue('${manager_name}', '[Nama Manager]');
            $templateProcessor->setValue('${hr_signature}', '[Tanda Tangan HR]');
            $templateProcessor->setValue('${hr_name}', '[Nama HR]');
            $templateProcessor->setValue('${director_signature}', '[Tanda Tangan Direktur]');
            $templateProcessor->setValue('${director_name}', '[Nama Direktur]');
            
            // If approvals have been done, update the signatures
            if ($leaveRequest->manager_id && $leaveRequest->manager_approved_at) {
                $this->processSignature(
                    $templateProcessor, 
                    '${manager_signature}', 
                    $leaveRequest->manager_signature,
                    $leaveRequest->manager->name ?? '[Nama Manager]',
                    $leaveRequest->manager_approved_at
                );
                $templateProcessor->setValue('${manager_name}', $leaveRequest->manager->name ?? '[Nama Manager]');
            }
            
            if ($leaveRequest->hr_id && $leaveRequest->hr_approved_at) {
                $this->processSignature(
                    $templateProcessor, 
                    '${hr_signature}', 
                    $leaveRequest->hr_signature,
                    $leaveRequest->hr->name ?? '[Nama HR]',
                    $leaveRequest->hr_approved_at
                );
                $templateProcessor->setValue('${hr_name}', $leaveRequest->hr->name ?? '[Nama HR]');
            }
            
            if ($leaveRequest->director_id && $leaveRequest->director_approved_at) {
                $this->processSignature(
                    $templateProcessor, 
                    '${director_signature}', 
                    $leaveRequest->director_signature,
                    $leaveRequest->director->name ?? '[Nama Direktur]',
                    $leaveRequest->director_approved_at
                );
                $templateProcessor->setValue('${director_name}', $leaveRequest->director->name ?? '[Nama Direktur]');
            }
            
            // Save the document
            $templateProcessor->saveAs($outputPath);
            
            // Return the relative path for storage in the database
            return 'leave-documents/' . $outputFilename;
            
        } catch (\Exception $e) {
            Log::error('Error generating leave document: ' . $e->getMessage());
            Log::error('Error trace: ' . $e->getTraceAsString());
            throw $e;
        }
    }

    /**
     * Process a signature in the document, either as an image or as text
     * 
     * @param TemplateProcessor $templateProcessor
     * @param string $placeholder The placeholder name in the template
     * @param string|null $signaturePath Path to the signature image
     * @param string $name Name of the signer (for fallback)
     * @param \DateTime|null $approvedAt Date of approval (for fallback)
     * @return void
     */
    private function processSignature(
        TemplateProcessor $templateProcessor, 
        string $placeholder, 
        ?string $signaturePath = null,
        string $name = '',
        ?\DateTime $approvedAt = null
    ): void {
        // First try with the image
        if ($signaturePath && file_exists(public_path($signaturePath))) {
            try {
                Log::info("Trying to set {$placeholder} image from: " . public_path($signaturePath));
                
                // Check if placeholder starts with ${ and ends with }
                if (strpos($placeholder, '${') === 0 && strrpos($placeholder, '}') === strlen($placeholder) - 1) {
                    // Use the placeholder as is
                    $templateProcessor->setImageValue($placeholder, public_path($signaturePath));
                } else {
                    // Try with proper ${...} wrapper
                    $wrappedPlaceholder = '${' . $placeholder . '}';
                    try {
                        $templateProcessor->setImageValue($wrappedPlaceholder, public_path($signaturePath));
                    } catch (\Exception $e) {
                        // If wrapped placeholder fails, try with unwrapped
                        Log::warning("Failed with wrapped placeholder. Trying unwrapped. Error: " . $e->getMessage());
                        $templateProcessor->setImageValue($placeholder, public_path($signaturePath));
                    }
                }
            } catch (\Exception $e) {
                // If all image approaches fail, fall back to text
                Log::error("Failed to set {$placeholder} image: " . $e->getMessage());
                $this->setSignatureAsText($templateProcessor, $placeholder, $name, $approvedAt);
            }
        } else {
            // No image or image doesn't exist, use text
            if ($signaturePath) {
                Log::warning("Signature image not found: " . public_path($signaturePath));
            }
            $this->setSignatureAsText($templateProcessor, $placeholder, $name, $approvedAt);
        }
    }

    /**
     * Set a signature as text when image insertion fails
     * 
     * @param TemplateProcessor $templateProcessor
     * @param string $placeholder
     * @param string $name
     * @param \DateTime|null $approvedAt
     * @return void
     */
    private function setSignatureAsText(
        TemplateProcessor $templateProcessor, 
        string $placeholder, 
        string $name,
        ?\DateTime $approvedAt = null
    ): void {
        $text = '';
        
        if ($approvedAt) {
            $date = $approvedAt->format('d/m/Y');
            $text = "✓ {$name}\nDisetujui pada {$date}";
        } else {
            $text = "✓ {$name}";
        }
        
        try {
            // Check if placeholder starts with ${ and ends with }
            if (strpos($placeholder, '${') === 0 && strrpos($placeholder, '}') === strlen($placeholder) - 1) {
                // Use the placeholder as is
                $templateProcessor->setValue($placeholder, $text);
            } else {
                // Try with proper ${...} wrapper
                $wrappedPlaceholder = '${' . $placeholder . '}';
                try {
                    $templateProcessor->setValue($wrappedPlaceholder, $text);
                } catch (\Exception $e) {
                    // If wrapped placeholder fails, try with unwrapped
                    Log::warning("Failed with wrapped placeholder. Trying unwrapped. Error: " . $e->getMessage());
                    $templateProcessor->setValue($placeholder, $text);
                }
            }
        } catch (\Exception $e) {
            Log::error("All attempts to set signature text failed: " . $e->getMessage());
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