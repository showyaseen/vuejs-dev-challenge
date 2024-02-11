<!-- assets/js/src/Table.vue -->
<template>
  <div>
    <SectionTitle>
      <DataIcon></DataIcon>
      Data
    </SectionTitle>

    <Table :headers="headers" :rows="rows"></Table>

    <SectionTitle>
      <ListIcon></ListIcon>
      Emails List
    </SectionTitle>
    <ContentCard>
      <InputGroup>
        <EmailList :emails="emails"></EmailList>
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
          url: "http://www.tesdsfsdfsdfsdft.com/6161/sdfsdfsdf"
        },
        {
          date: 1707093477,
          id: 42,
          pageviews: 3452,
          title: "Awesome Page 7064",
          url: "http://www.test.com/6161/"
        },
      ],
      emails: [
        'asdf@asdfsf.com',
      ]
    };
  },
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
  }
};
</script>
