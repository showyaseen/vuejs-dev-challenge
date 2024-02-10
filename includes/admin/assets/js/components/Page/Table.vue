<!-- assets/js/src/Table.vue -->
<template>
  <ContentCard>
    <HeadTitle>
      <DataIcon></DataIcon>
      Data
    </HeadTitle>

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
      <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
          <tr>
            <th scope="col" class="px-4 py-3">
              <span class="sr-only">#</span>
              #
            </th>
            <th v-for="header in headers" scope="col" class="px-6 py-3">
              {{ header }}
            </th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="(row, index) in rows"
            class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600">
            <td class="p-2 px-4 py-2 text-gray-900 dark:text-white whitespace-nowrap">
              {{ index + 1 }}
            </td>
            <td v-for="header in headers" class="px-4 py-2 text-gray-700 dark:text-white text-xs">
              <a v-if="'url' === header.toLowerCase()" :href="row.url"
                class="font-medium text-orange-600 dark:text-orange-500 hover:underline">{{ row.url }}
              </a>
              <h4 v-else>{{ row[header.toLowerCase()] || '' }}</h4>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

  </ContentCard>
</template>

<script>
import ContentCard from '../Layout/ContentCard.vue';
import HeadTitle from '../Form/HeadTitle.vue';
import DataIcon from '../Icons/DataIcon.vue';

export default {
  data() {
    return {
      headers: ["ID", "Url", "Title", "Pageviews", "Date"],
      rows: [
        {
          date: 1707093477,
          id: 42,
          pageviews: 3452,
          title: "Awesome Page 7064",
          url: "http://www.test.com/6161/"
        },
        {
          date: 1707093477,
          id: 42,
          pageviews: 3452,
          title: "Awesome Page 7064",
          url: "http://www.test.com/6161/"
        },
        {
          date: 1707093477,
          id: 42,
          pageviews: 3452,
          title: "Awesome Page 7064",
          url: "http://www.test.com/6161/"
        },
      ],
    };
  },
  components: {
    ContentCard,
    HeadTitle,
    DataIcon
  }
};
</script>
