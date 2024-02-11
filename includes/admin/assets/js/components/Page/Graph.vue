<template>
  <div>
    <SectionTitle>
      <ChartIcon></ChartIcon>
      Graph
    </SectionTitle>
    <DoughnutChart :chartData="graphData" />
  </div>
</template>

<script>
import SectionTitle from '../Form/SectionTitle.vue';
import ChartIcon from '../Icons/ChartIcon.vue';

import { DoughnutChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";
Chart.register(...registerables);
export default {
  name: 'Home',
  components: {
    DoughnutChart,
    SectionTitle,
    ChartIcon
  },
  data() {
    return {
      graphData: {
        labels: ['Paris', 'Nîmes', 'Toulon', 'Perpignan', 'Autre'],
        datasets: [
          {
            data: [30, 40, 60, 70, 5],
            backgroundColor: ['#77CEFF', '#0079AF', '#123E6B', '#97B0C4', '#A5C8ED'],
          },
        ],
      }
    }
  },
}
</script>
