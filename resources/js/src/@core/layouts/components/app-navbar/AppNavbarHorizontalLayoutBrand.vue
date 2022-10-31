<template>
  <div class="bookmark-wrapper align-items-center flex-grow-1 d-none d-lg-flex">
    <ul class="nav navbar-nav">
      <li class="nav-item">
        <b-link class="navbar-brand" to="/">
          <span class="brand-logo">
            <!-- <b-img :src="appLogoImage" alt="logo"/> -->
          </span>
        </b-link>
      </li>
    </ul>
  </div>
</template>

<script>
import { BLink, BImg } from 'bootstrap-vue'
import { $themeConfig } from '@themeConfig'

export default {
  components: {
    BLink,
    BImg,
  },
  setup() {
    // App Name
    const { appName, appLogoImage } = $themeConfig.app
    return {
      appName,
      appLogoImage,
    }
  },
}
</script>