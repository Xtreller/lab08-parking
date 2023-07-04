<?php

use Carbon\Carbon;

function duration($sdate,$edate)
{
     // Convert the date strings to DateTime objects
     $start = new DateTime($sdate);
     $end = new DateTime($edate);

     // Calculate the time difference in hours
     $interval = $end->diff($start);
     $hours = $interval->h; // Hours
     $hours += $interval->days * 24; // Add days converted to hours

     // Return the time difference in hours
     return $hours;
}
