<template>
    <div>
      Tab Contents
      <div v-show="currentTab === 'settings'">Content for Tab Setting</div>
      <div v-show="currentTab === 'table'">Content for Tab Table</div>
      <div v-show="currentTab === 'graph'">Content for Tab Graph</div>
    </div>
  </template>

  <script>
  export default {
    name: 'Tabs',
    props: ['tab_name'],
    data() {
      return {
        currentTab: 'settings',
      };
    },
    watch: {
      '$props.tab_name'(newTab, oldTab) {
        console.log('newTab', newTab);
        console.log('oldTab', oldTab);
        this.currentTab = newTab || 'settings';
      },
      '$route.params'(newTab, oldTab) {
        console.log('newParams', newTab);
        console.log('oldParams', oldTab);
        this.currentTab = newTab || 'settings';
      },
      '$route.query'(newTab, oldTab) {
        console.log('newQuery', newTab);
        console.log('oldQuery', oldTab);
        this.currentTab = newTab || 'settings';
      },
    },
    created() {
      // Set the initial tab based on the router query parameters
      this.currentTab = this.$props.tab_name || 'settings';
      console.log('this.currentTab', this.currentTab);
      console.log('tab_name _', this.tab_name);
    },
  };
  </script>