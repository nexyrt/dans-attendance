<?php

namespace App\Services;

use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;

class QRCodeService
{
    public function generateUserQRCode($user, $action = 'check-in')
    {
        $fileName = "user_{$user->id}_qr.png";
        $qrPath = "qr-codes/users/{$fileName}";
        $fullPath = storage_path("app/public/{$qrPath}");

        // Check if QR code already exists
        if (file_exists($fullPath)) {
            return asset("storage/{$qrPath}");
        }

        // Create directory if it doesn't exist
        $directory = dirname($fullPath);
        if (!file_exists($directory)) {
            mkdir($directory, 0755, true);
        }

        // Generate QR code data
        $qrData = [
            'user_id' => $user->id,
            'action' => $action,
            'timestamp' => now()->timestamp,
            'hash' => hash('sha256', $user->id . $action . config('app.key'))
        ];

        $qrUrl = route('director.attendance.qr.scan', ['data' => base64_encode(json_encode($qrData))]);

        // Generate and save QR code
        QrCode::format('png')
            ->size(300)
            ->margin(2)
            ->generate($qrUrl, $fullPath);

        return asset("storage/{$qrPath}");
    }

    public function deleteUserQRCode($userId)
    {
        $fileName = "user_{$userId}_qr.png";
        $qrPath = "qr-codes/users/{$fileName}";
        $fullPath = storage_path("app/public/{$qrPath}");

        if (file_exists($fullPath)) {
            unlink($fullPath);
            return true;
        }

        return false;
    }
}