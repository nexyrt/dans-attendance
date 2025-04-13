<!-- resources/views/livewire/staff/leave-pdf.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Request #{{ $leave->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #4b5563;
            padding-bottom: 20px;
        }
        .logo {
            max-height: 70px;
            margin-bottom: 10px;
        }
        h1 {
            font-size: 24px;
            margin: 0 0 10px;
            color: #1f2937;
        }
        .reference {
            font-size: 14px;
            color: #6b7280;
            margin-top: 5px;
        }
        .employee-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }
        .info-group {
            margin-bottom: 20px;
        }
        .info-label {
            font-weight: bold;
            font-size: 14px;
            color: #4b5563;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 16px;
        }
        .leave-details {
            margin-bottom: 30px;
        }
        .leave-dates {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }
        .reason-box {
            border: 1px solid #e5e7eb;
            padding: 15px;
            border-radius: 5px;
            background-color: #f9fafb;
            margin-bottom: 30px;
        }
        .status-badge {
            display: inline-block;
            padding: 5px 10px;
            font-size: 14px;
            font-weight: bold;
            border-radius: 20px;
            margin-top: 5px;
        }
        .pending-manager {
            background-color: #fef3c7;
            color: #92400e;
        }
        .pending-hr {
            background-color: #dbeafe;
            color: #1e40af;
        }
        .pending-director {
            background-color: #ede9fe;
            color: #5b21b6;
        }
        .approved {
            background-color: #d1fae5;
            color: #065f46;
        }
        .rejected {
            background-color: #fee2e2;
            color: #b91c1c;
        }
        .cancelled {
            background-color: #f3f4f6;
            color: #4b5563;
        }
        .signature-section {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            text-align: center;
            width: 45%;
        }
        .signature-line {
            border-top: 1px solid #9ca3af;
            margin-top: 50px;
            margin-bottom: 10px;
        }
        .footer {
            margin-top: 50px;
            font-size: 12px;
            color: #6b7280;
            text-align: center;
            border-top: 1px solid #e5e7eb;
            padding-top: 20px;
        }
        .signature-image {
            max-height: 80px;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        table, th, td {
            border: 1px solid #e5e7eb;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f9fafb;
            font-weight: bold;
            color: #4b5563;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>LEAVE APPLICATION FORM</h1>
            <div class="reference">Reference: LR-{{ str_pad($leave->id, 5, '0', STR_PAD_LEFT) }}</div>
            <div class="reference">Generated: {{ now()->format('F d, Y h:i A') }}</div>
        </div>

        <div class="employee-info">
            <div class="info-group">
                <div class="info-label">Employee Name</div>
                <div class="info-value">{{ $leave->user->name }}</div>
                
                <div class="info-label">Employee ID</div>
                <div class="info-value">{{ $leave->user->id }}</div>
            </div>
            
            <div class="info-group">
                <div class="info-label">Department</div>
                <div class="info-value">{{ $leave->user->department ? $leave->user->department->name : 'N/A' }}</div>
                
                <div class="info-label">Position</div>
                <div class="info-value">{{ ucfirst($leave->user->role) }}</div>
            </div>
        </div>

        <div class="leave-details">
            <h2>Leave Details</h2>
            
            <table>
                <tr>
                    <th>Leave Type</th>
                    <td>{{ ucfirst($leave->type) }} Leave</td>
                </tr>
                <tr>
                    <th>Start Date</th>
                    <td>{{ \Carbon\Carbon::parse($leave->start_date)->format('F d, Y (l)') }}</td>
                </tr>
                <tr>
                    <th>End Date</th>
                    <td>{{ \Carbon\Carbon::parse($leave->end_date)->format('F d, Y (l)') }}</td>
                </tr>
                <tr>
                    <th>Total Days</th>
                    <td>{{ \Carbon\Carbon::parse($leave->start_date)->diffInDays(\Carbon\Carbon::parse($leave->end_date)) + 1 }} day(s)</td>
                </tr>
                <tr>
                    <th>Current Status</th>
                    <td>
                        @php
                            $statusText = [
                                'pending_manager' => 'Pending Manager Approval',
                                'pending_hr' => 'Pending HR Approval',
                                'pending_director' => 'Pending Director Approval',
                                'approved' => 'Approved',
                                'rejected_manager' => 'Rejected by Manager',
                                'rejected_hr' => 'Rejected by HR',
                                'rejected_director' => 'Rejected by Director',
                                'cancel' => 'Cancelled',
                            ];
                            
                            $statusClass = match($leave->status) {
                                'pending_manager' => 'pending-manager',
                                'pending_hr' => 'pending-hr',
                                'pending_director' => 'pending-director',
                                'approved' => 'approved',
                                'rejected_manager', 'rejected_hr', 'rejected_director' => 'rejected',
                                default => 'cancelled'
                            };
                        @endphp
                        <span class="status-badge {{ $statusClass }}">
                            {{ $statusText[$leave->status] ?? 'Unknown' }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <th>Date Submitted</th>
                    <td>{{ $leave->created_at->format('F d, Y h:i A') }}</td>
                </tr>
            </table>
            
            <h3>Reason for Leave</h3>
            <div class="reason-box">
                {{ $leave->reason }}
            </div>
        </div>
        
        <div class="signature-section">
            <div class="signature-box">
                @if($leave->document_path && file_exists(public_path($leave->document_path)))
                    <img src="{{ public_path($leave->document_path) }}" alt="Employee Signature" class="signature-image">
                @else
                    <div class="signature-line"></div>
                @endif
                <div>{{ $leave->user->name }}</div>
                <div style="font-size: 14px; color: #6b7280;">Employee Signature</div>
            </div>
            
            <div class="signature-box">
                @if($leave->manager_signature && file_exists(public_path($leave->manager_signature)))
                    <img src="{{ public_path($leave->manager_signature) }}" alt="Manager Signature" class="signature-image">
                @else
                    <div class="signature-line"></div>
                @endif
                <div>{{ $leave->manager ? $leave->manager->name : 'Manager Name' }}</div>
                <div style="font-size: 14px; color: #6b7280;">Manager Approval</div>
            </div>
        </div>
        
        <div class="footer">
            <p>This is an official document of the leave request system. If you have any questions, please contact the HR department.</p>
            <p>Generated on {{ now()->format('F d, Y h:i A') }}</p>
        </div>
    </div>
</body>
</html>