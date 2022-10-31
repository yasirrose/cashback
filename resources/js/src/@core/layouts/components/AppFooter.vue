<template>
  <p class="clearfix mb-0">
    <span class="float-md-left d-block d-md-inline-block mt-25">
     CashBackN & Company, Inc
      <b-link
        class="ml-25"
        href=""
        target="_blank"
      ></b-link>
      <!-- <span class="d-none d-sm-inline-block">, All rights Reserved</span> -->
    </span>

    <span class="float-md-right d-none d-md-block">CashBackN
      <feather-icon
        icon=""
        size="21"
        class="text-danger stroke-current"
      />
    </span>
  </p>
</template>

<script>
import { BLink } from 'bootstrap-vue'

export default {
  components: {
    BLink,
  },
}
</script>
