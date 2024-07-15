#### Plugin Description

**Admin Dashboard** is a WordPress plugin designed to fetch and display data from an external API on the WordPress admin dashboard. It provides settings for configuring the data display and includes RESTful API endpoints for managing the data. This plugin demonstrates the use of WordPress admin hooks, Vue.js for the frontend, and PHP for backend logic and API integration.

#### User Documentation and Usage

1. **Configuration**
   - Navigate to the Admin Dashboard settings page via the admin menu.
   - Configure the data display settings such as date formats and email list management.

2. **Usage**
   - The plugin fetches data from a specified external API and displays it in tables and charts on the admin dashboard.
   - Users can customize settings to tailor the data presentation according to their preferences.

### Technical Documentation

#### Main Plugin File: `admin-dashboard.php`

This file serves as the entry point for the plugin. It sets up the plugin initialization, hooks, and includes necessary dependencies.

#### Initialization and Setup: `Plugin.php`

- **`Plugin.php`**: Contains the core functionality of the plugin, including initialization and setup of hooks and filters.
- **`RestfulAPIController.php`**: Manages the RESTful API endpoints for data operations.

#### Admin Interface: `views/admin-dashboard.php`

The admin interface is built using Vue.js components and Tailwind CSS for styling. The following files are involved:

- **JavaScript Components:**
  - **`App.vue`**: Main application component.
  - **`router.js`**: Defines routes for different views.
  - **Stores**:
    - `data.js`: Manages the state of the fetched data.
    - `settings.js`: Manages the state of the plugin settings.
  - **Components**:
    - Page Components: `SettingsPage.vue`, `TablePage.vue`, `GraphPage.vue`
    - Form Components: Various input and message components.
    - Layout Components: `ContentCard.vue`
    - Tab Components: `Tabs.vue`, `TabContent.vue`, `TabButton.vue`, `TabHeader.vue`
    - Table Components: `Table.vue`, `TableBody.vue`, `TableHead.vue`, `Row.vue`
    - Icon Components: Various SVG icons.

- **Tailwind CSS:**
  - Configuration: `tailwind.config.js`
  - Custom Styles: `custom/base.pcss`, `custom/fonts.pcss`, `custom/components/components.pcss`


### Files Brief Description

1. **`admin-dashboard.php`**: Main plugin file.
2. **`Plugin.php`**: Core plugin functionality.
3. **`RestfulAPIController.php`**: Manages RESTful API endpoints.
4. **Vue Components**:
   - **Page Components**: Handle different admin views.
   - **Form Components**: Handle user inputs.
   - **Layout Components**: Handle content layout.
   - **Tab Components**: Handle tabbed navigation.
   - **Table Components**: Handle data display in table format.
   - **Icon Components**: Provide various SVG icons.
5. **Tailwind CSS Files**: Handle styling and custom CSS.


### Technologies Used

- **WordPress**: Plugin development framework.
- **PHP**: Backend development language.
- **JavaScript (Vue.js)**: Frontend development framework for admin interface.
- **Tailwind CSS**: Utility-first CSS framework for styling.
- **Composer**: Dependency management for PHP.
- **NPM/Yarn**: Dependency management for JavaScript.
