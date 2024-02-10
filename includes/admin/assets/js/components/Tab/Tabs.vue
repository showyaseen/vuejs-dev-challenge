<template>
  <div>
    <!--Tabs header-->
    <TabHeader :title="header.title">
      <TabButton v-for="tab_item in tabs.tabItems" :data="tab_item" :is_active="tabs.currentTab === tab_item.id">
      </TabButton>
    </TabHeader>
    <!--Tabs header-->

    <!--Tabs content-->
    <TabContent>
      <router-view />
    </TabContent>
    <!--Tabs content-->
  </div>
</template>

<script>
import TabHeader from './TabHeader.vue';
import TabButton from './TabButton.vue';
import TabContent from './TabContent.vue';

export default {
  name: 'Tabs',
  props: {
    header: {
      title: String
    },
    tabs: {
      tabItems: Array,
      currentTab: String,
      defaultTab: String
    }
  },
  components: {
    TabHeader,
    TabButton,
    TabContent,
  },
};
</script>