<template>
  <div :class="{ 'opacity-20': isLoading }">
    <SectionTitle>
      <DataIcon></DataIcon>
      {{ tableTitle }}
    </SectionTitle>

    <Table :headers="tableHeaders" :rows="rows"></Table>

    <SectionTitle>
      <ListIcon></ListIcon>
      {{ emailListTitle }}
    </SectionTitle>
    <ContentCard>
      <InputGroup>
        <EmailList :emails="settings?.extraEmail ?? []"></EmailList>
      </InputGroup>
    </ContentCard>
  </div>
</template>

<script>
import ContentCard from '../Layout/ContentCard.vue';
import SectionTitle from '../Form/SectionTitle.vue';
import Footer from '../Form/Footer.vue';
import InputGroup from '../Form/InputGroup.vue';
import EmailList from '../Form/EmailList.vue';
import DataIcon from '../Icons/DataIcon.vue';
import EmailIcon from '../Icons/EmailIcon.vue';
import ListIcon from '../Icons/ListIcon.vue';
import Table from '../Table/Table.vue';

import { useSettingStore } from "../../stores/settings";
import { useDataStore } from "../../stores/data";
const { __ } = wp.i18n;

export default {
  name: "TablePage",
  components: {
    ContentCard,
    SectionTitle,
    DataIcon,
    EmailIcon,
    ListIcon,
    Footer,
    InputGroup,
    EmailList,
    Table,
  },
  created() {
    this.__ = __;
    this.dataStore = useDataStore();
    this.settingStore = useSettingStore();
  },
  data() {
    return {
      emailListTitle: __('Email List', vuejs_dev_challenge.text_domain),
      rows: [],
      dataStore: null,
      settingStore: null,
    };
  },
  computed: {
    tableTitle() {
      return __(this.dataStore?.table?.title, vuejs_dev_challenge.text_domain);
    },
    tableHeaders() {
      return this.dataStore?.table?.headers;
    },
    tableRows() {
      return this.dataStore?.table?.rows;
    },
    settings() {
      return this.settingStore?.settings;
    },
    isLoading() {
      return this.dataStore.isLoading;
    }
  },
  watch: {
    settings: {
      handler() {
        if (0 === this.settings.length) {
          return;
        }
        this.applySettings();
      },
      deep: true
    },
    tableRows: {
      handler() {
        this.applySettings();
      },
      deep: true
    }
  },
  methods: {
    applySettings() {
      if (!this.tableRows || 0 === this.tableRows.length) {
        return;
      }

      if (this.settings?.rowNumber && this.tableRows.length > this.settings.rowNumber) {
        this.rows = this.tableRows.slice(0, this.settings.rowNumber);
      } else {
        this.rows = this.tableRows.slice()
      }
      this.rows = this.rows?.map((row) => {
        let mappedRow = Object.assign([], row);
        if (mappedRow['date'] && true == this.settings?.isHuman) {
          mappedRow['date'] = this.toHumanDate(mappedRow['date'])
        }
        return mappedRow;
      });
    },
    toHumanDate(timestamp) {
      const myDate = new Date(timestamp * 1000);
      return myDate.toDateString();
    }
  }
};
</script>
