<template>
  <div class="table-responsive">
    <table class="table table-sm">
      <thead id="header-table">
        <tr>
          <th
            v-for="column in columns"
            :key="column.name"
            @click="$emit('sort', column.name)"
            :class="
              sortKey === column.name
                ? sortOrders[column.name] > 0
                  ? 'sorting_up'
                  : 'sorting_down'
                : 'sorting_both'
            "
            style="cursor:pointer;"
          >
            {{ column.label }}
          </th>
        </tr>
      </thead>
      <slot></slot>
    </table>
  </div>
</template>

<script>
export default {
  props: ["columns", "sortKey", "sortOrders"],
};
</script>
