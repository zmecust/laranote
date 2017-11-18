<template>
    <div id="container">
        <div class="left">
            <p>hello world</p>
        </div>

        <div class="right">
            <router-view></router-view>
        </div>
    </div>
</template>

<script>

  export default {
    data() {
      return {
        categories: '',
      }
    },
    mounted() {
      axios.get('/api/categories').then(res => {
        if (res.data.status) {
          this.categories = res.data.data;
        }
      });
    }
  }
</script>