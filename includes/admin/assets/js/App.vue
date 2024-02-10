<!-- App.vue -->
<template>
  <div id="vuejs-dev-challenge">
    <router-view :header="header" :tabs="tabs" />
  </div>
</template>

<script>
export default {
  name: 'App',
  watch: {
    '$route.name'(newTab, oldTab) {
      this.tabs.currentTab = newTab || this.tabs.defaultTab;
      this.tabs.tabItems.map((item) => item.id === newTab ? item.is_active = true : item.is_active = false);
    },
  },
  data() {
    return {
      header: {
        title: 'Yaseen Taha - VueJS Dev Challenge'
      },
      tabs: {
        tabItems: [
          {
            id: 'table',
            title: 'Table',
            path: 'table',
            is_active: false
          },
          {
            id: 'graph',
            title: 'Graph',
            path: 'graph',
            is_active: false
          },
          {
            id: 'settings',
            title: 'Settings',
            path: 'settings',
            is_active: false
          },
        ],
        currentTab: '',
        defaultTab: 'table',
      },
    };
  }
};
</script>
<style scoped>
#vuejs-dev-challenge {
  margin-left: -19px;
}
</style>
