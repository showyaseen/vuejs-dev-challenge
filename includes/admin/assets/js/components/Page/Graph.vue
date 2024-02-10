<template>
  <div>
    <HeadTitle>
      <ChartIcon></ChartIcon>
      Graph
    </HeadTitle>
    <DoughnutChart :chartData="graphData" />
  </div>
</template>

<script>
import HeadTitle from '../Form/HeadTitle.vue';
import ChartIcon from '../Icons/ChartIcon.vue';

import { DoughnutChart } from 'vue-chart-3';
import { Chart, registerables } from "chart.js";
Chart.register(...registerables);
export default {
  name: 'Home',
  components: {
    DoughnutChart,
    HeadTitle,
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
