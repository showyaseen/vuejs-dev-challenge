<template>
  <div :class="{ 'opacity-20': isLoading }">
    <SectionTitle>
      <ChartIcon></ChartIcon>
      {{ graphPageTitle }}
    </SectionTitle>
    <LineChart :chartData="graphData" />
    <Spinner v-if="isLoading"></Spinner>
  </div>
</template>

<script>
/**
 * AdminDashboard Plugin - GraphPage Component
 * @file GraphPage.vue
 * @description This component renders a graph page within the Admin Dashboard plugin.
 *              It fetches graph data from the store and displays it using a line chart.
 *              The component also shows a loading spinner while data is being fetched.
 */

import SectionTitle from '../Form/SectionTitle.vue';
import ChartIcon from '../Icons/ChartIcon.vue';
import Spinner from '../Form/Spinner.vue';
import { useDataStore } from "../../stores/data";
import { LineChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";

const { __ } = wp.i18n;
Chart.register(...registerables);

export default {
  name: 'GraphPage',
  components: {
    LineChart,
    SectionTitle,
    ChartIcon,
    Spinner
  },
  data() {
    return {
      textDomain: admin_dashboard.text_domain,
      graphPageTitle: __('Graph', admin_dashboard.text_domain),
      graphData: {
        labels: [],
        datasets: [
          {
            label: __('Daily Page Views Counts', admin_dashboard.text_domain),
            data: [],
            backgroundColor: '#e27730',
          },
        ],
      },
      graphStore: null
    }
  },
  created() {
    this.__ = __;
    this.graphStore = useDataStore();
  },
  computed: {
    isLoading() {
      return this.graphStore.isLoading;
    }
  },
  methods: {
    toHumanDate(timestamp) {
      const myDate = new Date(timestamp * 1000);
      return myDate.toDateString();
    }
  },
  watch: {
    'graphStore.graph': {
      handler(graphData) {
        if (!graphData || 0 === graphData.length) {
          return;
        }
        this.graphData.labels = [];
        this.graphData.datasets[0].data = [];
        graphData.forEach(data => {
          this.graphData.labels.push(this.toHumanDate(data.date));
          this.graphData.datasets[0].data.push(data.value);
        });
      },
      deep: true
    }
  }
}
</script>
