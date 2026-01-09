# Explanation of the `currentYear()` Function in `AdminController.php`

The `currentYear()` function in `AdminController.php` is designed to provide detailed analytics about room bookings for a specific year. It is a crucial component for the admin dashboard, allowing administrators to track and analyze reservation trends over time.

## Function Overview

This function is responsible for fetching and returning analytics data for a selected year from the `CompletedReservation` model. When a year is selected from the dropdown on the admin dashboard, this function is triggered to provide the corresponding data.

### Detailed Line-by-Line Breakdown:

The function begins by retrieving and processing booking data for the given year. Here's a step-by-step explanation of the code, starting from the `$allBookedRooms` variable.

```php
public function currentYear($year)
{
    // ... (totalBookings calculation)

    $allBookedRooms = CompletedReservation::withoutGlobalScope('user')
        ->whereYear('created_at', $year)
        ->select('room_id', DB::raw('count(*) as bookings_count'))
        ->groupBy('room_id')
        ->orderByDesc('bookings_count')
        ->get();
```
- **`$allBookedRooms = ...`**: This is an Eloquent query that builds a report of how many times each room was booked in the given `$year`.
- **`CompletedReservation::withoutGlobalScope('user')`**: Initiates a query on the `CompletedReservation` model. The `withoutGlobalScope('user')` method is called to ensure the query is not restricted to reservations made by the currently logged-in user, thus providing a complete administrative view.
- **`->whereYear('created_at', $year)`**: This filters the completed reservations, including only those that were created in the `$year` provided to the function.
- **`->select('room_id', DB::raw('count(*) as bookings_count'))`**: This specifies which columns to retrieve. It selects the `room_id` and uses a raw SQL `COUNT(*)` function to count all entries, aliasing this count as `bookings_count`.
- **`->groupBy('room_id')`**: This groups all the rows by their `room_id`, so the `count(*)` applies to each unique room.
- **`->orderByDesc('bookings_count')`**: This sorts the results in descending order based on the `bookings_count`, ensuring that the most frequently booked rooms appear first.
- **`->get()`**: This executes the query and returns a Laravel Collection of objects, where each object contains a `room_id` and its corresponding `bookings_count`.

---

```php
    if ($allBookedRooms->isEmpty()) {
        return response()->json([]); // Return an empty array if no data
    }
```
- **`if ($allBookedRooms->isEmpty())`**: This line checks if the database query returned any results.
- **`return response()->json([]);`**: If the `$allBookedRooms` collection is empty (meaning no completed reservations were found for that year), the function immediately stops and returns an empty JSON array `[]`. This is important for the frontend, which can then display a "No data" message instead of crashing.

---

```php
    $roomIds = $allBookedRooms->pluck('room_id');
```
- **`$roomIds = $allBookedRooms->pluck('room_id')`**: This line uses the `pluck` method to iterate through the `$allBookedRooms` collection and create a new, simpler collection (`$roomIds`) that contains only the values of the `room_id` property. This prepares a list of IDs needed for the next step.

---

```php
    $rooms = Room::find($roomIds)->keyBy('id'); // Key by ID for easy lookup
```
- **`$rooms = Room::find($roomIds)`**: This executes a query on the `Room` model to fetch all room details for the IDs contained in the `$roomIds` collection.
- **`->keyBy('id')`**: This is a performance optimization. It transforms the collection of `Room` objects into an associative array where the keys are the room IDs (`id`). This allows for direct and very fast lookups (e.g., `$rooms['123']`) instead of having to search through the collection in the next step.

---

```php
    $result = $allBookedRooms->map(function ($bookedRoom) use ($rooms) {
        $room = $rooms->get($bookedRoom->room_id);
        return [
            'room_name' => $room ? $room->name : 'Unknown Room',
            'bookings_count' => $bookedRoom->bookings_count,
            'room_id' => $bookedRoom->room_id,
        ];
    });
```
- **`$result = $allBookedRooms->map(...)`**: This iterates over each `$bookedRoom` object in the `$allBookedRooms` collection and transforms it into a new, more detailed format. The result of these transformations is stored in the `$result` collection.
- **`function ($bookedRoom) use ($rooms)`**: This is an anonymous function that processes each item. The `use ($rooms)` part makes the `$rooms` associative array (created in the previous step) available inside this function's scope.
- **`$room = $rooms->get($bookedRoom->room_id);`**: For each booking statistic, this line retrieves the full `Room` object from the `$rooms` collection using the `room_id`. Because `$rooms` is keyed by ID, this is a very efficient "get" operation.
- **`return [...]`**: This creates a new, formatted array for each room's booking data.
- **`'room_name' => $room ? $room->name : 'Unknown Room'`**: This line adds the room's name. It uses a ternary operator as a safety check: if a `$room` object was successfully found, it uses its `name` property. If not (which would indicate a data inconsistency), it defaults to the string `'Unknown Room'`.
- **`'bookings_count' => $bookedRoom->bookings_count`**: This adds the booking count from the original `$bookedRoom` object.
- **`'room_id' => $bookedRoom->room_id`**: This adds the room's ID.

---

```php
    return response()->json($result);
}
```
- **`return response()->json($result);`**: This line takes the final `$result` collection, automatically converts it into a JSON formatted string, and sends it back as the HTTP response. This JSON response is then consumed by the frontend JavaScript to dynamically render the analytics table on the admin dashboard.
