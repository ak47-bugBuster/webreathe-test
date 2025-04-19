# Monitoring Demo Website

## Project Goal

This project is a demo website to **simulate and monitor devices**. These virtual devices generate **fake data** (e.g., temperature or speed), and the site displays their status, history, and errors in a visual format.

---

## Modules to Build

### 1. Database Setup

Create a **MySQL** database with the following tables:

#### `modules`
- `id` (Primary Key)
- `name` (e.g., "Temperature Sensor A")
- `type` (e.g., "temperature", "speed")
- `status` (e.g., "working", "broken")
- `created_at`, `updated_at`

#### `measurements`
- `id` (Primary Key)
- `module_id` (Foreign Key → `modules.id`)
- `value` (e.g., 21.4°C or 58 km/h)
- `measured_at` (timestamp)

#### Optional: `status_log`
- To track module breakdowns and repairs over time.

---

### 2. Module Registration Form

Create a web form to:
- Add a new module with:
  - Name
  - Type
- Save the module in the `modules` table.

---

### 3. Monitoring Dashboard

A page that shows:
- List of all registered modules.
- For each module:
  - **Current measured value**
  - **How long it's been active**
  - **Total number of data points**
  - **Working or broken status**
  - **Line graph** of values over time
  - **Visual alerts** for malfunctions:
    - Green = Working
    - Red = Broken with warning icon/message

---

### 4. Data Simulation Script

A **PHP or JavaScript script** that:
- Runs in the background or on page load.
- For each module:
  - Generates a **random value** (e.g., 21.4°C).
  - Randomly sets the status as "working" or "broken".
  - Saves the value and status to the database.
- Continues simulating while the user browses the dashboard.

---

### 5. Visual Notification System

Display module status visually:
- **Green** for working modules
- **Red** with warning icons for broken ones
- Use Bootstrap alerts, icons, or cards to represent the status clearly

---

## Tech Stack

- **Frontend:** HTML, CSS, Bootstrap  
- **Backend:** PHP (optionally Laravel or Symfony)  
- **Database:** MySQL  

---

## How Everything Works Together

1. Admin registers new modules via the form.
2. A background script simulates sensor data and status changes.
3. Dashboard fetches real-time data from the database.
4. Status indicators and graphs keep updating visually.
5. All data is stored for future analysis and history tracking.
