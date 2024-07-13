<template>
  <div id="admin-dashboard" class="-ml-3 lg:-ml-5">
    <router-view :header="header" :tabs="tabs" />
  </div>
</template>

<script>
import { useSettingStore } from "./stores/settings";
import { useDataStore } from "./stores/data";
const { __ } = wp.i18n;

/**
 * This component represents the main application for the Admin Dashboard plugin.
 *
 * It sets up the header, tabs, and manages the active tab state based on the current route.
 *
 * @package YTAHA\AdminDashboard
 */
export default {
  name: 'App',

  watch: {
    /**
     * Watch for changes in the route name and update the active tab.
     */
    '$route.name'(newTab) {
      this.tabs.currentTab = newTab ?? this.tabs.defaultTab;
      this.tabs.tabItems.forEach(item => item.is_active = (item.id === newTab));
    },
  },

  data() {
    return {
      header: {
        title: __('Admin Dashboard', admin_dashboard.text_domain),
        subTitle: __('Developed with ❤ by Yaseen Taha', admin_dashboard.text_domain),
      },
      tabs: {
        tabItems: [
          {
            id: 'table',
            title: __('Data', admin_dashboard.text_domain),
            path: 'table',
            is_active: false,
          },
          {
            id: 'graph',
            title: __('Graph', admin_dashboard.text_domain),
            path: 'graph',
            is_active: false,
          },
          {
            id: 'settings',
            title: __('Settings', admin_dashboard.text_domain),
            path: 'settings',
            is_active: false,
          },
        ],
        currentTab: '',
        defaultTab: 'table',
      },
    };
  },

  created() {
    // Fetch settings and data when the component is created
    useSettingStore().fetchSettings();
    useDataStore().fetchData();
  },
};
</script>

<style scoped>
/* Add your component-specific styles here */
</style>
