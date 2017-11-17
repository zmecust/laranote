<template>
  <el-row class="tac">
    <el-col :span="24">
      <h4>菜单</h4>
      <el-menu mode="vertical" default-openeds="['1', '2', '3']" :default-active="router" class="el-menu-vertical-demo" theme="light" unique-opened>

        <el-submenu index="1">
          <template slot="title">
            <i class="el-icon-tickets"></i>
            <span>笔记本</span>
          </template>
          <el-submenu :index="category.name" v-for="category in categories" :key="category.id">
            <template slot="title">{{ category.name }} (共 {{ category.notes.length }} 篇)</template>
            <el-menu-item :index="'/notes/' + note.id" v-for="note in category.notes" :key="note.id">
              {{ note.title }} {{ note.created_at }}
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
      categories: '',
    }
  },
  computed: {
    router() {
      return this.GetUrlRelativePath();
    }
  },
  mounted() {
    this.$http.get('/categories').then(res => {
      if (res.data.status) {
        this.categories = res.data.data;
      }
    });
    console.log(this.router);
  },
  methods: {
    handleSelect(index) {
      console.log(index);
    },
    GetUrlRelativePath() {
      var url = document.location.toString();
      var arrUrl = url.split("//");
      var start = arrUrl[1].indexOf("/");
      var relUrl = arrUrl[1].substring(start);
      if (relUrl.indexOf("?") != -1) {
        relUrl = relUrl.split("?")[0];
      }
      return relUrl;
    }
  }
}
</script>