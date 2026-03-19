<?php

namespace App\Services;

use App\Models\Setting;

class AttendanceIpRestrictionService
{
    /**
     * Check if the given IP (or current request IP) is allowed for instructor check-in.
     * Returns true if no restriction is configured (empty or "any").
     */
    public function isAllowed(?string $ip = null): bool
    {
        $ip = $ip ?? request()->ip();
        $allowed = Setting::get('attendance_allowed_ips', '');

        if ($allowed === '' || strtolower(trim($allowed)) === 'any') {
            return true;
        }

        $list = array_map('trim', explode(',', $allowed));
        foreach ($list as $entry) {
            if ($entry === '') {
                continue;
            }
            if ($this->ipMatches($ip, $entry)) {
                return true;
            }
        }

        return false;
    }

    private function ipMatches(string $ip, string $entry): bool
    {
        if (str_contains($entry, '/')) {
            return $this->ipInCidr($ip, $entry);
        }

        return $ip === $entry;
    }

    private function ipInCidr(string $ip, string $cidr): bool
    {
        [$subnet, $bits] = explode('/', $cidr) + ['', '32'];
        $mask = -1 << (32 - (int) $bits);
        $ipLong = ip2long($ip);
        $subnetLong = ip2long(trim($subnet));

        if ($ipLong === false || $subnetLong === false) {
            return false;
        }

        return ($ipLong & $mask) === ($subnetLong & $mask);
    }
}
