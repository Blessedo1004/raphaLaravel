# Explanation of Updated JavaScript for Analytics Display (`public/js/main.js`)

The `fetchYearAnalytics` and `fetchUserYearAnalytics` functions in `public/js/main.js` have been updated to handle the new backend API response structure. The backend now returns a list of *all* rooms and their respective booking counts for a given year, rather than just the single most booked room.

### New Backend API Response Structure

The API endpoint `/admin/year/{year}` (and presumably `/user/year/{year}`) now returns a JSON array, like this:

```json
[
  { "room_name": "Luxury Suite", "bookings_count": 50, "room_id": 1 },
  { "room_name": "Standard Room", "bookings_count": 45, "room_id": 3 },
  { "room_name": "Family Room", "bookings_count": 30, "room_id": 2 }
]
```
If no bookings are found for the year, it will return an empty array `[]`.

### Updated JavaScript Functions

The `fetchYearAnalytics` and `fetchUserYearAnalytics` functions now perform the following steps:

1.  **Loading State**: Immediately sets the `innerHTML` of the display elements (`#mostBookedAdmin`, `#mostBookedUser`) to a "Loading..." message and clears the booking count element (`#bookingsCountAdmin`, `#bookingsCountUser`) while the data is being fetched.
    ```javascript
    mostBookedAdmin.innerHTML = '<h5>Loading...</h5>';
    bookingsCountAdmin.innerHTML = '';
    ```

2.  **Fetch Data**: Uses the `fetch` API to make an asynchronous request to the respective backend endpoint (e.g., `/admin/year/${year}`).
    ```javascript
    fetch(`/admin/year/${year}`)
        .then(response => response.json())
    ```

3.  **Process Data**:
    *   **Check for Data**: After receiving the JSON `data`, it checks if the `data` array is not empty (`data && data.length > 0`).
    *   **Generate Table**: If data exists, it dynamically generates an HTML table (`<table>`) to display each room's name and its booking count.
        ```javascript
        let tableHtml = '<table class="table"><thead><tr><th>Room Name</th><th>Number of Bookings</th></tr></thead><tbody>';
        data.forEach(room => {
            tableHtml += `<tr><td>${room.room_name}</td><td>${room.bookings_count}</td></tr>`;
        });
        tableHtml += '</tbody></table>';
        ```
    *   **Display Table**: The generated `tableHtml` is then inserted into the primary display element (`#mostBookedAdmin` or `#mostBookedUser`).
        ```javascript
        mostBookedAdmin.innerHTML = tableHtml;
        ```
    *   **No Data Message**: If the `data` array is empty, a "No booking data found for this year." message is displayed.
        ```javascript
        mostBookedAdmin.innerHTML = '<h5>No booking data found for this year.</h5>';
        ```

4.  **Error Handling**: Includes a `.catch()` block to log any network or parsing errors to the console and display a user-friendly error message on the frontend.
    ```javascript
    .catch(error => {
        console.error('Error fetching admin analytics:', error);
        mostBookedAdmin.innerText = `Couldn't fetch analytics data.`;
    });
    ```

### Example Display (HTML Structure after Update)

If your HTML has a structure like this:
```html
<div id="mostBookedAdmin"></div>
<div id="bookingsCountAdmin"></div>
```
After a successful fetch, `#mostBookedAdmin` will contain the generated table, and `#bookingsCountAdmin` will be cleared (as the booking counts are now integrated into the table).

This updated JavaScript ensures that all relevant booking data for the selected year is presented clearly to the user in a tabular format.
