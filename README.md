Room Reservation System

A full-featured room reservation system built with Laravel, SQLite, Bootstrap 5, and Vanilla JavaScript, designed to simulate real-world booking workflows with role-based access control, analytics, caching, and real-time notifications.

🚀 Features
👤 User Features

Create and manage reservations (pending, active, completed)

View latest pending reservations (limited to 5) on the dashboard

Analyze reservations by selecting a custom date range

View analytics using both table and bar chart

Write and manage reviews

Receive checkout notifications via email

🛠️ Admin Features

View latest pending reservations across all users (limited to 5)

View total number of registered users from the dashboard

Manage all reservations (check-in / check-out)

Receive real-time alerts for new reservations

Access system-wide analytics using custom date ranges (table + bar chart)

Filter and manage user reviews (by date and rating)

📊 Analytics

Analyze reservation data by selecting a start date and end date

Interactive data visualization with table and bar chart views

Visualization powered by Chart.js

⚡ Performance Optimization

Implemented caching using Redis to improve performance and reduce database load

Optimized frequently accessed data (e.g., dashboard insights, analytics queries)

🔔 Notifications
Real-time Notifications

Implemented using Laravel Reverb

Admins receive instant alerts when new reservations are made

Clicking the alert loads the latest pending reservations

Email Notifications

Reservation checkout updates sent via Resend

🧱 Tech Stack

Backend: Laravel

Database: SQLite

Frontend: Bootstrap 5, Vanilla JavaScript

Caching: Redis

Real-time: Laravel Reverb

Mailing: Resend

Charts: Chart.js

📌 Recent Improvements

Added dashboard view for latest pending reservations (users & admins)

Implemented date-range-based analytics (table + chart)

Introduced real-time admin alerts using Laravel Reverb

Integrated Redis caching for performance optimization

Added email notifications using Resend

Improved dashboard insights (including total users count)