<!-- assets/js/src/Setting.vue -->
<template>
    <div>
      <h2>Settings Tab</h2>
      <!-- Your settings form implementation goes here -->
      <form @submit.prevent="submitForm">
        <label for="rowNumber">Number of Rows:</label>
        <input type="number" id="rowNumber" v-model="rowNumber" />

        <label for="isHuman">Is Human:</label>
        <input type="checkbox" id="isHuman" v-model="isHuman" />

        <label for="extraInfo">Extra Info:</label>
        <div v-for="(info, index) in extraInfo" :key="index">
          <input type="text" v-model="extraInfo[index]" />
          <button type="button" @click="removeExtraInfo(index)">Remove</button>
        </div>
        <button type="button" @click="addExtraInfo">Add More</button>

        <button type="submit">Submit</button>
      </form>
    </div>
  </template>

  <script>
  export default {
    data() {
      return {
        rowNumber: 5,
        isHuman: true,
        extraInfo: ['Info 1'],
      };
    },
    methods: {
      addExtraInfo() {
        this.extraInfo.push('');
      },
      removeExtraInfo(index) {
        this.extraInfo.splice(index, 1);
      },
      submitForm() {
        // Handle form submission logic
        console.log('Form submitted:', this.rowNumber, this.isHuman, this.extraInfo);
      },
    },
  };
  </script>

  <style scoped>
  /* Add component-specific styles here */
  form {
    margin-top: 20px;
  }

  label {
    display: block;
    margin-bottom: 5px;
  }

  input, checkbox, button {
    margin-bottom: 10px;
  }
  </style>
