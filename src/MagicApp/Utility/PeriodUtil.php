<?php

namespace MagicApp\Utility;

class PeriodUtil
{
    /**
     * Get the next period by adding a specified number of months.
     *
     * @param string $currentPeriod The current period in 'YYYYMM' format.
     * @param int $n The number of months to add.
     * @return string The next period in 'YYYYMM' format.
     */
    public static function nextPeriod($currentPeriod, $n) {
        // Convert to year and month
        $year = (int)substr($currentPeriod, 0, 4);
        $month = (int)substr($currentPeriod, 4, 2);

        // Calculate new month and year
        $totalMonths = ($year * 12 + $month + $n);
        $newYear = (int)($totalMonths / 12);
        $newMonth = $totalMonths % 12;

        // Adjust month to be 1-12
        if ($newMonth === 0) {
            $newYear -= 1;
            $newMonth = 12;
        }

        // Format as 'YYYYMM'
        return sprintf('%04d%02d', $newYear, $newMonth);
    }

    /**
     * Get the previous period by subtracting a specified number of months.
     *
     * @param string $currentPeriod The current period in 'YYYYMM' format.
     * @param int $n The number of months to subtract.
     * @return string The previous period in 'YYYYMM' format.
     */
    public static function previousPeriod($currentPeriod, $n) {
        // Convert to year and month
        $year = (int)substr($currentPeriod, 0, 4);
        $month = (int)substr($currentPeriod, 4, 2);

        // Calculate new month and year
        $totalMonths = ($year * 12 + $month - $n);
        $newYear = (int)($totalMonths / 12);
        $newMonth = $totalMonths % 12;

        // Adjust month to be 1-12
        if ($newMonth <= 0) {
            $newYear -= 1;
            $newMonth += 12;
        }

        // Format as 'YYYYMM'
        return sprintf('%04d%02d', $newYear, $newMonth);
    }
}