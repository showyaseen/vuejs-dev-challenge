<!-- App.vue -->
<template>
  <div id="vuejs-dev-challenge">
    THIS IS APP.VUE
    INITIALIZED
    <router-link :to="{ path: '/settings'}">Settings</router-link>
    <router-link :to="{ path: '/table'}">Table Data</router-link>
    <router-link :to="{ path: '/graph'}">Graph</router-link>
    <router-view />
    ROUTE PATH : {{$route.path}}
  </div>
</template>

<script>
export default {
  name: 'App',
};
</script>

<style>
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  text-align: center;
  color: #2c3e50;
  margin-top: 60px;
}

/* Add global styles here */
</style>
