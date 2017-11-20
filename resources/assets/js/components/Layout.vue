<template>
  <div class="app-wrapper" :class="{hideSidebar: !sidebar_opened}">
    <sidebar class="sidebar-container" @show="show"></sidebar>
    <div class="main-container">
      <section class="app-main" style="min-height: 100%">
        <transition name="fade" mode="out-in">
          <router-view :key="key"></router-view>
        </transition>
      </section>
    </div>
  </div>
</template>

<script>
import Sidebar from './Sidebar';

export default {
  name: 'layout',
  components: {
    Sidebar
  },
  data() {
    return {
      sidebar_opened: true
    }
  },
  computed: {
    key() {
      return this.$route.name !== undefined ? this.$route.name + +new Date() : this.$route + +new Date();
    }
  },
  methods: {
    show(data) {
      this.sidebar_opened = !data;
    }
  }
}
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
@mixin clearfix {
  &:after {
    content: "";
    display: table;
    clear: both;
  }
}

.app-wrapper {
  @include clearfix;
  position: relative;
  height: 100%;
  width: 100%;
  &.hideSidebar {
    .sidebar-container {
      width: 60px;
      overflow: inherit;
    }
    .main-container {
      margin-left: 60px;
    }
  }
  .sidebar-container {
    transition: width 0.28s ease-out;
    width: 200px;
    height: 100%;
    position: fixed;
    top: 0;
    bottom: 0;
    left: 0;
    z-index: 1001;
    overflow-y: auto;
    &::-webkit-scrollbar {
      display: none
    }
  }
  .main-container {
    min-height: 100%;
    transition: margin-left 0.28s ease-out;
    margin-left: 200px;
  }
}
</style>
