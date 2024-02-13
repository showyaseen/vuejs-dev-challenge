<!-- App.vue -->
<template>
  <div id="vuejs-dev-challenge" class="-ml-3 lg:-ml-5">
    {{ console.log('vuejs_dev_challenge', vuejs_dev_challenge) }}
    <router-view :header="header" :tabs="tabs" />
  </div>
</template>

<script>
import { useSettingStore } from "./stores/settings";
import { useDataStore } from "./stores/data";
const { __ } = wp.i18n;
export default {
  name: 'App',
  watch: {
    '$route.name'(newTab) {
      this.tabs.currentTab = newTab || this.tabs.defaultTab;
      this.tabs.tabItems.map((item) => item.id === newTab ? item.is_active = true : item.is_active = false);
    },
  },
  data() {
    return {
      header: {
        title: __('Awesome Motive', vuejs_dev_challenge.text_domain),
        subTitle: __('Yaseen Taha - VueJS Developer Challenge', vuejs_dev_challenge.text_domain)
      },
      tabs: {
        tabItems: [
          {
            id: 'table',
            title: __('Data', vuejs_dev_challenge.text_domain),
            path: 'table',
            is_active: false
          },
          {
            id: 'graph',
            title: __('Graph', vuejs_dev_challenge.text_domain),
            path: 'graph',
            is_active: false
          },
          {
            id: 'settings',
            title: __('Settings', vuejs_dev_challenge.text_domain),
            path: 'settings',
            is_active: false
          },
        ],
        currentTab: '',
        defaultTab: 'table',
      },
    };
  },
  created() {
    useSettingStore().fetchSettings();
    useDataStore().fetchData();
  }
};
</script>
