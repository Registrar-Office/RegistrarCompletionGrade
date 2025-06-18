<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Grade Completion Approval</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }
        .header h1 {
            margin-bottom: 5px;
            color: #003366;
        }
        .content {
            margin-bottom: 40px;
        }
        .content h2 {
            color: #003366;
            border-bottom: 1px solid #ddd;
            padding-bottom: 5px;
        }
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .info-table th, .info-table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }
        .info-table th {
            background-color: #f5f5f5;
        }
        .signature-section {
            margin-top: 50px;
            display: flex;
            justify-content: space-between;
        }
        .signature-box {
            width: 45%;
            text-align: center;
        }
        .signature-line {
            border-top: 1px solid #333;
            margin-top: 10px;
            padding-top: 5px;
        }
        .signature-image {
            max-height: 80px;
            margin-bottom: 10px;
        }
        .approval-stamp {
            position: absolute;
            top: 20px;
            right: 20px;
            color: #006400;
            font-size: 24px;
            font-weight: bold;
            border: 3px solid #006400;
            padding: 5px 15px;
            transform: rotate(15deg);
            opacity: 0.8;
        }
        @media print {
            body {
                padding: 0;
                margin: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="approval-stamp">APPROVED</div>
    
    <div class="header">
        <h1>GRADE COMPLETION APPROVAL</h1>
        <p>Office of the Dean</p>
    </div>
    
    <div class="content">
        <h2>Student Information</h2>
        <table class="info-table">
            <tr>
                <th>Name:</th>
                <td>{{ $incompleteGrade->user->name }}</td>
                <th>ID Number:</th>
                <td>{{ $incompleteGrade->user->id_number }}</td>
            </tr>
        </table>
        
        <h2>Course Information</h2>
        <table class="info-table">
            <tr>
                <th>Course Code:</th>
                <td>{{ $incompleteGrade->course->code }}</td>
                <th>Course Title:</th>
                <td>{{ $incompleteGrade->course->title }}</td>
            </tr>
            <tr>
                <th>Instructor:</th>
                <td>{{ $incompleteGrade->course->instructor_name }}</td>
                <th>College:</th>
                <td>{{ $incompleteGrade->course->college }}</td>
            </tr>
        </table>
        
        <h2>Completion Details</h2>
        <table class="info-table">
            <tr>
                <th>Reason for Incompleteness:</th>
                <td colspan="3">{{ $incompleteGrade->reason_for_incompleteness }}</td>
            </tr>
            <tr>
                <th>Submission Deadline:</th>
                <td>{{ $incompleteGrade->submission_deadline->format('F d, Y') }}</td>
                <th>Approval Date:</th>
                <td>{{ now()->format('F d, Y') }}</td>
            </tr>
            <tr>
                <th>Status:</th>
                <td colspan="3">
                    <strong style="color: #006400;">APPROVED</strong>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="signature-section">
        <div class="signature-box">
            <p>Approved by:</p>
            @if($dean->signature && $dean->signature->signature_image)
                <img src="{{ asset('storage/signatures/' . $dean->signature->signature_image) }}" alt="Dean's Signature" class="signature-image">
            @endif
            <div class="signature-line">
                <strong>{{ $dean->name }}</strong><br>
                Dean, {{ $dean->college }}
            </div>
        </div>
        
        <div class="signature-box">
            <p>Acknowledged by:</p>
            <div style="height: 80px;"></div>
            <div class="signature-line">
                <strong>{{ $incompleteGrade->course->instructor_name }}</strong><br>
                Course Instructor
            </div>
        </div>
    </div>
    
    <div class="no-print" style="margin-top: 40px; text-align: center;">
        <button onclick="window.print()" style="padding: 10px 20px; background-color: #003366; color: white; border: none; cursor: pointer;">
            Print Document
        </button>
        <a href="{{ route('dean.dashboard') }}" style="display: inline-block; margin-left: 10px; padding: 10px 20px; background-color: #666; color: white; text-decoration: none;">
            Back to Dashboard
        </a>
    </div>
</body>
</html> 