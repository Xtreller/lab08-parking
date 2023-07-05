<?php

use Carbon\Carbon;

function getDayNightHourCount($startDateTime, $endDateTime)
{
    // Convert the date strings to DateTime objects
    $start = new DateTime($startDateTime);
    $end = new DateTime($endDateTime);

    // Initialize counters
    $dayHours = 0;
    $nightHours = 0;

    // Loop through each hour between the start and end dates
    while ($start < $end) {
        // Check if the current hour is during the day (6 AM to 6 PM)
        if (duration($startDateTime, $endDateTime)) {
            if ($start->format('G') >= 6 && $start->format('G') < 18) {
                $dayHours++;
            } else {
                $nightHours++;
            }
        }
        // Increment the hour
        $start->add(new DateInterval('PT1H'));
    }

    // Return the day and night hour counts
    return [
        'day' => $dayHours,
        'night' => $nightHours
    ];
}
