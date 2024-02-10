import { createRouter, createWebHashHistory } from 'vue-router';

import Settings from './components/Page/Settings.vue';
import Table from './components/Page/Table.vue';
import Graph from './components/Page/Graph.vue';
import Tabs from './components/Tab/Tabs.vue';

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
  },
];

const router = createRouter({
  history: createWebHashHistory(),
  routes,
});

export default router;
