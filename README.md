### Admin Dashboard Plugin

#### Plugin Description

The Ytaha Admin Dashboard plugin enhances the WordPress admin dashboard by integrating external data and providing additional functionality. It allows users to view and manage data fetched from an external API, configure settings, and display data in a user-friendly manner using Vue.js.

---

#### Installation

1. **Download the Plugin:**
   - Download the Ytaha Admin Dashboard plugin from the official website or plugin repository.

2. **Upload the Plugin:**
   - Navigate to the WordPress admin dashboard.
   - Go to `Plugins > Add New > Upload Plugin`.
   - Choose the downloaded plugin file and click `Install Now`.

3. **Activate the Plugin:**
   - After installation, click `Activate` to enable the plugin.

#### Configuration

1. **Access Plugin Settings:**
   - Navigate to `Settings > Ytaha Admin Dashboard`.
   - Configure the settings as per your requirements:
     - **Rows Number:** Set the number of rows to display.
     - **Date Format:** Choose between human-readable or standard date format.
     - **Extra Emails:** Add additional email addresses to receive notifications.

2. **View Dashboard:**
   - Go to `Dashboard > Ytaha Admin Dashboard` to view the integrated data.
   - The dashboard displays data fetched from the external API, including graphs and tables.

#### Usage

1. **Fetching Data:**
   - The plugin automatically fetches data from the external API at regular intervals.
   - The data is cached to improve performance and reduce the number of API requests.

2. **Updating Settings:**
   - Update settings from the `Settings > Ytaha Admin Dashboard` page.
   - Changes are saved and applied immediately.

3. **Data Visualization:**
   - The dashboard provides visual representation of the data using charts and tables.
   - Users can interact with the data to gain insights and make informed decisions.

---

### Technical Documentation

#### Overview

The Ytaha Admin Dashboard plugin is designed to fetch and display data from an external API on the WordPress admin dashboard. It provides settings for configuring the data display and includes RESTful API endpoints for managing the data.

#### File Structure

1. **Main Plugin File:** `ytaha-admin-dashboard.php`
   - This file initializes the plugin, registers activation hooks, and loads necessary dependencies.

2. **Includes:**
   - `class-dashboard.php`: Contains the `Dashboard` class responsible for rendering the dashboard page.
   - `class-restful-api-controller.php`: Contains the `RestfulAPIController` class that handles RESTful API endpoints.
   - `class-plugin-activator.php`: Contains the `Plugin_Activator` class that manages plugin activation tasks.
   - `class-plugin-deactivator.php`: Contains the `Plugin_Deactivator` class that handles plugin deactivation tasks.

3. **Admin:**
   - `class-admin.php`: Contains the `Admin` class that adds menu items and enqueues admin scripts and styles.
   - `partials/ytaha-admin-dashboard-display.php`: The template file for displaying the admin dashboard page.

4. **Assets:**
   - `css/ytaha-admin-dashboard-admin.css`: Contains the CSS styles for the admin dashboard.
   - `js/ytaha-admin-dashboard-admin.js`: Contains the JavaScript code for the admin dashboard.

#### Implementation Details

1. **Dashboard Class (`class-dashboard.php`):**
   - Responsible for rendering the admin dashboard page.
   - Fetches and displays data using Vue.js components.

2. **RESTful API Controller (`class-restful-api-controller.php`):**
   - Registers RESTful API endpoints using the `rest_api_init` action hook.
   - Defines routes for fetching and updating settings (`/settings`) and fetching data (`/data`).
   - Implements permission checks to ensure only authorized users can access the API.
   - Retrieves, sanitizes, and caches data fetched from the external API.

3. **Settings Management:**
   - Settings are managed through the WordPress options API.
   - Users can update settings via the RESTful API or the admin settings page.

#### RESTful API Endpoints

1. **GET /settings:**
   - Fetches the current plugin settings.

2. **PUT /settings:**
   - Updates the plugin settings based on the request payload.

3. **GET /data:**
   - Retrieves data from the external API and caches it for efficient retrieval.

---

### Technology Used

1. **WordPress:**
   - The plugin is built as a WordPress plugin, utilizing WordPress hooks, filters, and the REST API.

2. **PHP:**
   - Core plugin functionality is implemented in PHP.
   - Classes and methods are used to organize code and follow best practices.

3. **JavaScript (Vue.js):**
   - The admin dashboard interface is built using Vue.js for a reactive and interactive experience.
   - Vue components handle data visualization and user interactions.

4. **HTML/CSS:**
   - The plugin's admin pages are styled using custom CSS.
   - HTML templates are used for rendering the admin dashboard and settings pages.

5. **External API:**
   - The plugin fetches data from an external API to display on the admin dashboard.
   - Data is sanitized and cached for performance optimization.

---