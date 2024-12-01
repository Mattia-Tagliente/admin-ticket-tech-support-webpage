<?php
//Function that returns the current timestamp in 'YYYY-MM-DD HH:MM:SS' format
function getCurrentTimestamp() { 
    // Create a DateTime object for the current time
    $date = new DateTime();

    // Set the timezone if needed (optional)
    $date->setTimezone(new DateTimeZone('Europe/Rome')); // Change to your preferred timezone

    // Get microseconds and convert to milliseconds
    $microseconds = $date->format('u'); // Get microseconds (6 digits)
    $milliseconds = substr($microseconds, 0, 3); // Get the first 3 digits as milliseconds

    // Format the timestamp with actual milliseconds and timezone offset
    return $date->format('Y-m-d\TH:i:s.') . $milliseconds . $date->format('P');     
}
?>