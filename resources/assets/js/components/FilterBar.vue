<template>
    <div class="filter-bar">
      <form @submit.prevent class="form-inline">
        <div class="form-group">
          <input type="text" v-model="filterText" class="form-control" @keyup.enter="doFilter" placeholder="Search By Name">
        </div>
      </form>
    </div>
</template>

<script>
  export default {
    data () {
      return {
        filterText: ''
      }
    },
    methods: {
      doFilter () {
        this.$events.fire('filter-set', this.filterText)
      },
    },

    props: ['type']
  }
</script>