/**
 * This file sets up the Vue Router for the Admin Dashboard plugin.
 *
 * It defines the different routes available in the application and their corresponding components.
 *
 * @package YTAHA\AdminDashboard
 */

import { createRouter, createWebHashHistory } from 'vue-router';
import Settings from './components/Page/SettingsPage.vue';
import Table from './components/Page/TablePage.vue';
import Graph from './components/Page/GraphPage.vue';
import Tabs from './components/Tab/Tabs.vue';

/**
 * Define the routes for the application.
 */
const routes = [
  {
    path: "/",
    name: "Tabs",
    component: Tabs,
    props: true,
    children: [
      { path: '', redirect: 'table', name: 'home' },
      { path: 'table', component: Table, name: 'table', props: true },
      { path: 'graph', component: Graph, name: 'graph', props: true },
      { path: 'settings', component: Settings, name: 'settings', props: true },
    ]
  }
];

/**
 * Create and export the router instance.
 */
const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
