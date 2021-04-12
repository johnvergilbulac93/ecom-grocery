<style lang="scss">
.pagination {
  justify-content: flex-end !important;
  .page-stats {
    align-items: center;
    margin-right: 5px;
  }
  i {
    color: #3273dc !important;
  }
}
</style>

<template>
  <nav v-if="!client">
    <span class="page-stats"
      >Showing {{ pagination.from }} to {{ pagination.to }} of
      {{ pagination.total }} Entries</span
    >
    <div class="float-right">
      <a
        v-if="pagination.prevPageUrl"
        class="btn btn-primary btn-sm text-white"
        @click="$emit('prev')"
      >
         <i class="fas fa-chevron-left"></i>
      </a>
      <a class="btn btn-primary btn-sm text-white" v-else :disabled="true"> <i class="fas fa-chevron-left"></i> </a>

      <a
        v-if="pagination.nextPageUrl"
        class="btn btn-primary btn-sm text-white"
        @click="$emit('next')"
      >
       <i class="fas fa-chevron-right"></i>
      </a>
      <a class="btn btn-primary btn-sm text-white" v-else :disabled="true"> <i class="fas fa-chevron-right"></i> </a>
    </div>
  </nav>

  <!-- <nav class="pagination" v-else>
    <span class="page-stats">
      {{ pagination.from }} - {{ pagination.to }} of {{ filtered.length }}
      <span v-if="filtered.length < pagination.total"
        >(filtered from {{ pagination.total }} total entries)</span
      >
    </span>
    <div class="float-right">
      <a
        v-if="pagination.prevPage"
        class="btn btn-primary btn-sm text-white"
        @click="$emit('prev')"
      >
        <i class="fas fa-chevron-left"></i>
      </a>
      <a class="btn btn-primary btn-sm text-white" v-else :disabled="true"> <i class="fas fa-chevron-left"></i> </a>

      <a
        v-if="pagination.nextPage"
        class="btn btn-primary btn-sm text-white"
        @click="$emit('next')"
      >
        <i class="fas fa-chevron-right"></i>
      </a>
      <a class="btn btn-primary btn-sm text-white" v-else :disabled="true"> <i class="fas fa-chevron-right"></i> </a>
    </div>
  </nav> -->
</template>

<script>
export default {
  props: ["pagination", "client", "filtered"],
};
</script>
