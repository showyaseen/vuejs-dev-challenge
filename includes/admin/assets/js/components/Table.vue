<!-- assets/js/src/Table.vue -->
<template>
    <div>
      <h2>Table Tab</h2>
      <!-- Your table implementation goes here -->
      <table>
        <thead>
          <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Value</th>
          </tr>
        </thead>
        <tbody>
          <!-- Example rows, replace with dynamic data -->
          <tr>
            <td>1</td>
            <td>Item 1</td>
            <td>100</td>
          </tr>
          <tr>
            <td>2</td>
            <td>Item 2</td>
            <td>150</td>
          </tr>
        </tbody>
      </table>
    </div>
  </template>

  <script>
  export default {
    // Add any component logic here
  };
  </script>

  <style scoped>
  /* Add component-specific styles here */
  table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 20px;
  }

  th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
  }

  th {
    background-color: #f2f2f2;
  }
  </style>
