<?php

namespace App\Helpers;

use App\Models\Setting;
use Carbon\Carbon;

/**
 * Central helper for DSIMT/LMS display and formatting.
 * Edit this file to change date formats, currency display, or other site-wide display logic.
 */
class DsimtHelper
{
    /**
     * Format a date for display (e.g. "27 Feb 2025").
     * Uses institute preference; override format here to change site-wide.
     */
    public static function formatDate(?Carbon $date, string $format = 'd M Y'): string
    {
        if ($date === null) {
            return '—';
        }

        return $date->format($format);
    }

    /**
     * Format a time for display (e.g. "09:15 AM").
     */
    public static function formatTime(?Carbon $datetime): string
    {
        if ($datetime === null) {
            return '—';
        }

        return $datetime->format('h:i A');
    }

    /**
     * Format date and time for display (e.g. "27 Feb 2025, 09:15 AM").
     */
    public static function formatDateTime(?Carbon $datetime, string $dateFormat = 'd M Y'): string
    {
        if ($datetime === null) {
            return '—';
        }

        return $datetime->format($dateFormat . ', h:i A');
    }

    /**
     * Format a number as currency using the institute's currency symbol from settings.
     * Edit .env or Super Admin → Settings to change currency (e.g. PKR, Rs).
     */
    public static function formatCurrency(float $amount, ?int $decimals = 0): string
    {
        $currency = Setting::get('currency', 'PKR');
        $symbol = self::currencySymbol($currency);

        return $symbol . number_format($amount, $decimals);
    }

    /**
     * Return the symbol or code to display for the given currency key.
     */
    public static function currencySymbol(string $currencyCode): string
    {
        return match (strtoupper($currencyCode)) {
            'PKR', 'RS' => 'Rs ',
            'USD' => '$',
            'GBP' => '£',
            'EUR' => '€',
            default => $currencyCode . ' ',
        };
    }

    /**
     * Get the institute name from settings for use in emails, PDFs, and headers.
     */
    public static function instituteName(): string
    {
        return (string) Setting::get('institute_name', 'Digital Sindh Institute');
    }

    /**
     * Format minutes as hours and minutes (e.g. "2h 30m"). Used for attendance duration display.
     */
    public static function formatDurationMinutes(int $totalMinutes): string
    {
        if ($totalMinutes <= 0) {
            return '—';
        }
        $hours = (int) floor($totalMinutes / 60);
        $mins = $totalMinutes % 60;
        if ($hours > 0 && $mins > 0) {
            return "{$hours}h {$mins}m";
        }
        if ($hours > 0) {
            return "{$hours}h";
        }

        return "{$mins}m";
    }
}
