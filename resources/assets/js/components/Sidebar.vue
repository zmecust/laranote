<template>
<el-row class="tac">
  <el-col :span="24">
    <h3>菜单</h3>
    <el-menu
      default-active="1"
      class="el-menu-vertical-demo"
      @open="handleOpen"
      @close="handleClose"
      background-color="#f4f4f4"
      text-color="#555"
      active-text-color="#20c997">

      <el-submenu index="1">
        <template slot="title">
          <i class="el-icon-tickets"></i>
          <span>笔记本</span>
        </template>
        <el-submenu :index="category.id" v-for="category in categories" :key="category.id">
          <template slot="title">{{ category.name }} (共 {{ category.notes.length }} 篇)</template>
          <el-menu-item :index="note.id" v-for="note in category.notes" :key="note.id">
            <a :href="note.id">
            {{ note.title }} {{ note.created_at }}
            </a>
          </el-menu-item>
        </el-submenu>
      </el-submenu>
      
      <el-menu-item index="2">
        <i class="el-icon-delete"></i>
        <span slot="title">垃圾桶</span>
      </el-menu-item>

      <el-menu-item index="3">
        <i class="el-icon-star-on"></i>
        <span slot="title">我的收藏</span>
      </el-menu-item>

      <el-menu-item index="4">
        <i class="el-icon-setting"></i>
        <span slot="title">设置</span>
      </el-menu-item>

    </el-menu>
  </el-col>
</el-row>
</template>

<script>

export default {
  data() {
    return {
      categories: ''
    }
  },
  mounted() {
    this.$http.get('/categories').then(res => {
      if (res.data.status) {
        this.categories = res.data.data;
        console.log(this.categories);
      }
    });
  },
  methods: {
    handleOpen(key, keyPath) {
      console.log(key, keyPath);
    },
    handleClose(key, keyPath) {
      console.log(key, keyPath);
    }
  }
}
</script>