import { createRouter, createWebHashHistory } from 'vue-router';

import Settings from './components/Settings.vue';
import Table from './components/Table.vue';
import Graph from './components/Graph.vue';
import Tabs from './components/Tabs.vue';

const routes = [
  { path: '/', redirect: '/settings', name: 'home'},
  // { path: '/tabs/table', component: Tabs, name: 'table' },
  // { path: '/tabs/graph', component: Tabs, name: 'graph' },
  { path: '/:tab_name', component: Tabs, name: 'tabs', props: true },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
