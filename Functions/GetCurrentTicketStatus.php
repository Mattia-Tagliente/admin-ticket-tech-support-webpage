<?php
function calculateStatus($ticketStatuses) {
    // Check if ticketStatuses array is empty
    if (empty($ticketStatuses)) {
        return "no-status"; // or you can return a default value like "Pending"
    }

    // Initialize a variable to track the most recent status
    $latestStatus = null;
    $latestPostDate = null;

    // Loop through the ticket statuses to find the one with the most recent postDate
    foreach ($ticketStatuses as $status) {

        // Compare the postDate of each status
        $statusPostDate = $status['postDate'];
        
        // If this status has a newer postDate, update the latestStatus and latestPostDate
        if ($latestPostDate === null || strtotime($statusPostDate) > strtotime($latestPostDate)) {
            $latestStatus = $status['statusType'];
            $latestPostDate = $statusPostDate;
        }
    }

    // Return the status with the most recent postDate
    return $latestStatus;
}
?>