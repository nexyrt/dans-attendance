<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request - {{ $leave->id }}</title>
    <style>
        @page {
            size: A4;
            margin: 2cm; /* Standard 2cm margin for documents */
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12pt; /* Changed to 12pt as requested */
            line-height: 1.5;
            color: #333;
            margin: 0;
            padding: 0;
            background-color: white;
            position: relative;
            min-height: 100%;
        }
        .container {
            width: 100%;
            box-sizing: border-box;
            padding-bottom: 30px; /* Space for footer */
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 12px;
        }
        .header h1 {
            font-size: 18pt; /* Reduced from 24pt */
            margin: 0 0 8px;
            text-transform: uppercase;
            font-weight: bold;
            color: #222;
        }
        .header p {
            margin: 0;
            font-size: 12pt; /* Reduced from 14pt */
            color: #555;
        }
        .logo {
            max-height: 80px;
            margin-bottom: 8px;
        }
        .info-grid {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-row {
            margin-bottom: 10px;
            width: 100%;
            display: table;
        }
        .info-cell {
            display: table-cell;
            vertical-align: top;
            padding: 5px 10px 5px 0;
        }
        .info-label {
            font-weight: bold;
            width: 35%;
        }
        .info-value {
            width: 65%;
        }
        .section {
            margin-bottom: 25px;
            page-break-inside: avoid;
        }
        .section-heading {
            font-size: 14pt; /* Reduced from 18pt */
            font-weight: bold;
            margin-bottom: 12px;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
            color: #222;
        }
        .status {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: bold;
            font-size: 11pt; /* Reduced from 14pt */
            text-transform: uppercase;
        }
        .status-pending {
            background-color: #FFF3CD;
            color: #856404;
        }
        .status-approved {
            background-color: #D1E7DD;
            color: #0F5132;
        }
        .status-rejected {
            background-color: #F8D7DA;
            color: #842029;
        }
        .status-cancelled {
            background-color: #E2E3E5;
            color: #41464B;
        }
        .reason-box {
            border: 1px solid #ddd;
            padding: 15px;
            background: #f9f9f9;
            margin-bottom: 20px;
            min-height: 100px;
            font-size: 12pt; /* Changed to 12pt */
            border-radius: 4px;
            line-height: 1.5;
        }
        .signature-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 10px;
        }
        .signature-table td {
            width: 50%;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: #fafafa;
            vertical-align: top;
        }
        .signature-line {
            border-top: 1px solid #000;
            margin-top: 70px;
            width: 100%;
            margin-bottom: 10px;
        }
        .signature-name {
            font-weight: bold;
            font-size: 13pt;
            color: #333;
        }
        .signature-title {
            font-style: italic;
            color: #666;
            font-size: 12pt;
            margin-bottom: 5px;
        }
        .signature-image {
            height: 300px; /* Increased from 80px */
            max-width: 400px; /* Increased from 200px */
            margin-bottom: 10px;
            border-bottom: 1px dotted #ccc;
            background: transparent; /* Ensure transparency */
            -webkit-print-color-adjust: exact; /* Maintain transparency in printing */
            color-adjust: exact; /* For Firefox */
        }
        .signature-date {
            font-size: 11pt;
            color: #555;
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            font-size: 10pt; /* Reduced from 12pt */
            text-align: center;
            color: #666;
            border-top: 1px solid #ddd;
            padding-top: 10px;
            margin-top: 20px;
        }
        .page-number:after {
            content: counter(page);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            @if(file_exists(public_path('images/company-logo.png')))
                <img src="{{ public_path('images/company-logo.png') }}" alt="Company Logo" class="logo">
            @endif
            <h1>Leave Request Form</h1>
            <p>Reference #{{ str_pad($leave->id, 5, '0', STR_PAD_LEFT) }} | Generated: {{ now()->format('F j, Y') }}</p>
        </div>
        
        <!-- Employee and Leave Information -->
        <div class="section">
            <table class="info-grid" cellspacing="0" cellpadding="8">
                <tr>
                    <td class="info-label">Employee Name:</td>
                    <td class="info-value">{{ $leave->user->name }}</td>
                </tr>
                <tr>
                    <td class="info-label">Department:</td>
                    <td class="info-value">{{ $leave->user->department->name ?? 'N/A' }}</td>
                </tr>
                <tr>
                    <td class="info-label">Employee ID:</td>
                    <td class="info-value">{{ $leave->user->employee_id ?? $leave->user->id }}</td>
                </tr>
                <tr>
                    <td class="info-label">Position:</td>
                    <td class="info-value">{{ $leave->user->position ?? ucfirst($leave->user->role) }}</td>
                </tr>
                <tr>
                    <td class="info-label">Leave Type:</td>
                    <td class="info-value">{{ ucfirst($leave->type) }} Leave</td>
                </tr>
                <tr>
                    <td class="info-label">Duration:</td>
                    <td class="info-value">
                        <strong>{{ \Carbon\Carbon::parse($leave->start_date)->format('M d, Y') }}</strong>
                        @if($leave->start_date !== $leave->end_date)
                            to <strong>{{ \Carbon\Carbon::parse($leave->end_date)->format('M d, Y') }}</strong>
                        @endif
                        
                        @php
                            // Calculate working days
                            $start = \Carbon\Carbon::parse($leave->start_date);
                            $end = \Carbon\Carbon::parse($leave->end_date);
                            $workingDays = 0;
                            
                            for ($date = $start->copy(); $date->lte($end); $date->addDay()) {
                                if (!in_array($date->dayOfWeek, [0, 6])) {
                                    $workingDays++;
                                }
                            }
                        @endphp
                        <div style="font-size: 11pt; color: #555; margin-top: 5px;"> <!-- Reduced from 14pt -->
                            ({{ $workingDays }} working {{ \Illuminate\Support\Str::plural('day', $workingDays) }}, excluding weekends)
                        </div>
                    </td>
                </tr>
                <tr>
                    <td class="info-label">Status:</td>
                    <td class="info-value">
                        @php
                            $statusClass = '';
                            $statusText = ucfirst(str_replace('_', ' ', $leave->status));
                            
                            if (strpos($leave->status, 'pending') !== false) {
                                $statusClass = 'status-pending';
                                $displayStatus = str_replace('pending_', 'Pending ', $leave->status);
                                $displayStatus = str_replace('_', ' ', $displayStatus);
                                $statusText = ucwords($displayStatus);
                            } elseif (strpos($leave->status, 'approved') !== false) {
                                $statusClass = 'status-approved';
                                $statusText = 'Approved';
                            } elseif (strpos($leave->status, 'rejected') !== false) {
                                $statusClass = 'status-rejected';
                                $rejecter = str_replace('rejected_', '', $leave->status);
                                $statusText = 'Rejected by ' . ucfirst($rejecter);
                            } elseif ($leave->status == 'cancel') {
                                $statusClass = 'status-cancelled';
                                $statusText = 'Cancelled';
                            }
                        @endphp
                        <span class="status {{ $statusClass }}">{{ $statusText }}</span>
                    </td>
                </tr>
                <tr>
                    <td class="info-label">Request Date:</td>
                    <td class="info-value">{{ $leave->created_at->format('M d, Y') }}</td>
                </tr>
            </table>
        </div>
        
        <!-- Reason Section -->
        <div class="section">
            <div class="section-heading">Reason for Leave</div>
            <div class="reason-box">
                {{ $leave->reason }}
            </div>
        </div>
        
        <!-- Signatures Section with 2-column layout -->
        <div class="section">
            <div class="section-heading">Approval Signatures</div>
            
            <table class="signature-table">
                <!-- First row: Employee and Manager -->
                <tr>
                    <!-- Employee Signature -->
                    <td>
                        @if($leave->document_path && file_exists(public_path($leave->document_path)))
                            <img src="{{ public_path($leave->document_path) }}" alt="Employee Signature" class="signature-image" style="background: transparent;">
                        @else
                            <div class="signature-line"></div>
                        @endif
                        <div class="signature-name">{{ $leave->user->name }}</div>
                        <div class="signature-title">Employee</div>
                        <div class="signature-date">Date: {{ $leave->created_at->format('M d, Y') }}</div>
                    </td>
                    
                    <!-- Manager Signature -->
                    <td>
                        @php
                            $isHRStaff = $leave->user->department && strtolower($leave->user->department->name) === 'human resources';
                            
                            // Safely get manager name
                            $managerName = 'Department Manager';
                            if ($leave->manager_id && $manager = \App\Models\User::find($leave->manager_id)) {
                                $managerName = $manager->name;
                            } elseif ($leave->user->department && isset($leave->user->department->manager_id)) {
                                $manager = \App\Models\User::find($leave->user->department->manager_id);
                                if ($manager) {
                                    $managerName = $manager->name;
                                }
                            }
                        @endphp
                        
                        @if($isHRStaff)
                            <div class="signature-line"></div>
                            <div class="signature-name">Not Required</div>
                            <div class="signature-title">Manager (HR Staff)</div>
                            <div class="signature-date">N/A</div>
                        @else
                            @if($leave->manager_signature && file_exists(public_path($leave->manager_signature)))
                                <img src="{{ public_path($leave->manager_signature) }}" alt="Manager Signature" class="signature-image" style="background: transparent;">
                            @else
                                <div class="signature-line"></div>
                            @endif
                            <div class="signature-name">{{ $managerName }}</div>
                            <div class="signature-title">Manager</div>
                            <div class="signature-date">
                                Date: {{ $leave->manager_approved_at ? Carbon\Carbon::parse($leave->manager_approved_at)->format('M d, Y') : '________________' }}
                            </div>
                        @endif
                    </td>
                </tr>
                
                <!-- Second row: HR and Director -->
                <tr>
                    <!-- HR Signature -->
                    <td>
                        @if($leave->hr_signature && file_exists(public_path($leave->hr_signature)))
                            <img src="{{ public_path($leave->hr_signature) }}" alt="HR Signature" class="signature-image" style="background: transparent;">
                        @else
                            <div class="signature-line"></div>
                        @endif
                        <div class="signature-name">
                            {{ $leave->hr_id ? \App\Models\User::find($leave->hr_id)->name : 'HR Manager' }}
                        </div>
                        <div class="signature-title">Human Resources</div>
                        <div class="signature-date">
                            Date: {{ $leave->hr_approved_at ? Carbon\Carbon::parse($leave->hr_approved_at)->format('M d, Y') : '________________' }}
                        </div>
                    </td>
                    
                    <!-- Director Signature -->
                    <td>
                        @if($leave->director_signature && file_exists(public_path($leave->director_signature)))
                            <img src="{{ public_path($leave->director_signature) }}" alt="Director Signature" class="signature-image" style="background: transparent;">
                        @else
                            <div class="signature-line"></div>
                        @endif
                        <div class="signature-name">
                            {{ $leave->director_id ? \App\Models\User::find($leave->director_id)->name : 'Director' }}
                        </div>
                        <div class="signature-title">Director</div>
                        <div class="signature-date">
                            Date: {{ $leave->director_approved_at ? Carbon\Carbon::parse($leave->director_approved_at)->format('M d, Y') : '________________' }}
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        
        @if($leave->attachment_path)
        <div class="section">
            <div class="section-heading">Supporting Documents</div>
            <p style="font-size:11pt; font-style:italic; color:#555;"> <!-- Reduced from 14pt -->
                This leave request includes an attachment. Please refer to the original document for the attached file.
            </p>
        </div>
        @endif
    </div>
    
    <div class="footer">
        <p>This is an official leave request document. For any queries, please contact the HR Department.</p>
        <p class="page-number">Page </p>
    </div>
</body>
</html>