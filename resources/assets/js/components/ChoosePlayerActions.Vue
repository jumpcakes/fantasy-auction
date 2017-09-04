<template>
    <div class="custom-actions">
      <button class="ui basic button" @click="savePick(rowData)"><i class="fa fa-check-square" aria-hidden="true"></i></button>
    </div>
  </template>

  <script>
  export default {
    props: {
      rowData: {
        type: Object,
        required: true
      },
      rowIndex: {
        type: Number
      }
    },
    methods: {
      savePick(rowData) {
        Event.$emit('close');

        axios.post('/save_pick', {
            id: rowData.id,
          })
          .then(function (response) {
            console.log(response);
          })
          .catch(function (error) {
            console.log(error);
          });

      }
    }
  }
  </script>

  <style>
    .custom-actions button.ui.button {
      padding: 8px 8px;
    }
    .custom-actions button.ui.button > i.icon {
      margin: auto !important;
    }
  </style>