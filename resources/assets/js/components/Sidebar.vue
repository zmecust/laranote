<template>
  <div id="container">
    <div class="left">
      <el-row class="tac">
        <el-col :span="24">
          <h4>菜单</h4>
          <el-menu mode="vertical" :default-openeds="['11', '测试', $route.path]" :default-active="$route.path" class="el-menu-vertical-demo" theme="light" unique-opened router>

            <el-submenu index="11">
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

            <el-menu-item index="/trash">
              <i class="el-icon-delete"></i>
              <span slot="title">垃圾桶</span>
            </el-menu-item>

            <el-menu-item index="/important">
              <i class="el-icon-star-on"></i>
              <span slot="title">我的收藏</span>
            </el-menu-item>

            <el-menu-item index="/setting">
              <i class="el-icon-setting"></i>
              <span slot="title">设置</span>
            </el-menu-item>

          </el-menu>
        </el-col>
      </el-row>
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