<template>
  <div :class="{ 'opacity-20': isLoading }">
    <SectionTitle>
      <ChartIcon></ChartIcon>
      {{ graphPageTitle }}
    </SectionTitle>
    <LineChart :chartOptions="chartOptions" :chartData="graphData" />
  </div>
</template>

<script>
import SectionTitle from '../Form/SectionTitle.vue';
import ChartIcon from '../Icons/ChartIcon.vue';
import { useDataStore } from "../../stores/data";
const { __ } = wp.i18n;

import { LineChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";
Chart.register(...registerables);
export default {
  name: 'GraphPage',
  components: {
    LineChart,
    SectionTitle,
    ChartIcon
  },
  created() {
    this.__ = __;
    this.graphStore = useDataStore();
  },
  data() {
    return {
      textDomain: vuejs_dev_challenge.text_domain,
      graphPageTitle: __('Graph', vuejs_dev_challenge.text_domain),
      graphData: {
        labels: [],
        datasets: [
          {
            label: __('Dialy Page Views Counts', vuejs_dev_challenge.text_domain),
            data: [],
            backgroundColor: '#e27730',
          },
        ],
      },
      chartOptions: {
        responsive: true,
        legend: {
          display: false,
        },
        tooltips: {
          titleFontSize: 20,
          bodyFontSize: 25,
        },
        scales: {
          xAxes: [],
          yAxes: [
            {
              ticks: {
                beginAtZero: false,
              },
            },
          ],
        },
      },
      graphStore: null
    }
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
