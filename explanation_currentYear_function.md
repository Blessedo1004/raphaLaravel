# Explanation of the `currentYear()` Function in `AdminController.php`

The `currentYear()` function in `AdminController.php` is designed to provide detailed analytics about room bookings for a specific year. It is a crucial component for the admin dashboard, allowing administrators to track and analyze reservation trends over time.

## Function Overview

This function is responsible for fetching and returning analytics data for a selected year from the `CompletedReservation` model. When a year is selected from the dropdown on the admin dashboard, this function is triggered to provide the corresponding data.

### Detailed Breakdown:

1.  **Input Parameter**:
    *   The function accepts a `$year` parameter, which is the year selected by the admin to view the analytics.

2.  **Total Bookings Calculation**:
    *   It calculates the `$totalBookings` for the given `$year` by counting all records in the `completed_reservations` table where the `created_at` field matches the specified year.
    *   `withoutGlobalScope('user')` is used to ensure that the query is not limited to the currently authenticated user, providing a global view of all reservations.

3.  **Room Booking Counts**:
    *   It retrieves a list of all rooms that were booked in the given `$year`, along with a count of how many times each room was booked (`bookings_count`).
    *   This is achieved by grouping the completed reservations by `room_id` and counting the occurrences for each group.
    *   The results are ordered in descending order based on the `bookings_count` to show the most popular rooms first.

4.  **Handling No Data**:
    *   If no booking data is found for the selected year (`$allBookedRooms` is empty), the function returns an empty JSON array. This ensures that the frontend can gracefully handle cases where there is no data to display.

5.  **Fetching Room Details**:
    *   To provide more meaningful analytics, the function fetches the names of the booked rooms from the `rooms` table.
    *   It uses the `room_id`s from the `$allBookedRooms` collection to query the `Room` model and retrieves the corresponding room details.
    *   The `keyBy('id')` method is used to create an associative array of rooms with their IDs as keys, which allows for efficient lookup of room details.

6.  **Mapping Results for Response**:
    *   The function then maps over the `$allBookedRooms` collection to create a structured array of results.
    *   For each booked room, it combines the `bookings_count` with the room's name (and `room_id`).
    *   If a room name is not found (which would be unusual in a consistent database), it defaults to `'Unknown Room'`.

7.  **JSON Response**:
    *   Finally, the function returns the structured analytics data as a JSON response. This response is then used by the JavaScript on the admin dashboard to dynamically display the analytics in a table, including the total number of bookings for the selected year.