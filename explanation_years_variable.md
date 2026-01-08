# Explanation of the `$years` variable in `showAdminDashboard`

The `showAdminDashboard` method is responsible for preparing data to display on the administrator's main dashboard view.

The primary purpose of the `$years` variable is to fetch a list of all unique years in which completed reservations have occurred. This list is typically used in the frontend (e.g., in a dropdown menu or filter) to allow the administrator to select a year and view analytics specific to that year.

### How it works (step-by-step):

The code to generate this variable is:
```php
        $driver = DB::connection()->getDriverName();
        $yearExpression = ($driver === 'sqlite')
            ? "strftime('%Y', created_at)"
            : "YEAR(created_at)";

        $years = CompletedReservation::withoutGlobalScope('user')
            ->select(DB::raw("{$yearExpression} as year"))
            ->distinct()
            ->orderBy('year', 'DESC')
            ->pluck('year')
            ->toArray();
```

1.  **`$driver = DB::connection()->getDriverName();`**: This line detects the current database driver being used (e.g., 'sqlite', 'mysql', 'pgsql').
2.  **`$yearExpression = ...`**: This is a conditional (ternary) operator that sets the correct SQL function for extracting the year based on the driver. It uses `strftime('%Y', created_at)` for SQLite and `YEAR(created_at)` for other common databases like MySQL and PostgreSQL. This makes the query portable across different database systems.
3.  **`CompletedReservation::withoutGlobalScope('user')`**: This starts an Eloquent query on the `CompletedReservation` model. The `withoutGlobalScope('user')` part is crucial. It tells Laravel to temporarily ignore a global filter that would normally restrict queries to only show reservations made by the currently authenticated user. For an admin dashboard, we want to see data for *all* users, so this ensures the query includes all completed reservations in the database.
4.  **`->select(DB::raw("{$yearExpression} as year"))`**: This selects the year from the `created_at` timestamp column using the database-appropriate function determined in step 2. The result is aliased as `year`.
5.  **`->distinct()`**: This ensures that only unique year values are returned. If completed reservations exist for 2024 multiple times, 2024 will only appear once in the result.
6.  **`->orderBy('year', 'DESC')`**: This sorts the unique years in descending order, meaning the most recent year will appear first.
7.  **`->pluck('year')`**: This retrieves only the values from the `year` column of the results, creating a simple list of years (e.g., `[2026, 2025, 2024]`).
8.  **`->toArray()`**: This converts the resulting collection of years into a plain PHP array.

Finally, this `$years` array is passed to the `rapha.admin.dashboard` view for display on the dashboard.
