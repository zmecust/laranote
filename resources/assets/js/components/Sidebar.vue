<template>
  <div>
    <div class="sidebar-top submenu-title">
      <el-button class="button-collapse" :icon="isCollapse ? 'el-icon-d-arrow-right' : 'el-icon-d-arrow-left'" plain @click="active()"></el-button>
      <span>
        <el-button icon="el-icon-plus" type="success" @click="create()"></el-button>
      </span>
    </div>
    <el-menu :default-active="$route.path" class="el-menu-vertical-demo" :collapse="isCollapse" router mode="vertical"
             background-color="#f4f4f4" text-color="#555" active-text-color="#20c997">
      <div class='menu-wrapper'>
        <el-submenu index="11">
          <template slot="title">
            <i class="el-icon-tickets"></i>
            <span>笔记本</span>
          </template>
          <el-submenu :index="category.name" v-for="category in categories" :key="category.id">
            <template slot="title">{{ category.name }} (共 {{ category.notes.length }} 篇)</template>
            <el-menu-item :index="'/notes/' + note.id" v-for="note in category.notes" :key="note.id">
              {{ note.title }}
            </el-menu-item>
          </el-submenu>
        </el-submenu>

        <el-menu-item index="/trash" class='submenu-title-noDropdown'>
          <i class="el-icon-delete"></i>
          <span>废纸篓</span>
        </el-menu-item>

        <el-menu-item index="/important" class='submenu-title-noDropdown'>
          <i class="el-icon-star-on"></i>
          <span>我的收藏</span>
        </el-menu-item>

        <el-menu-item index="/setting" class='submenu-title-noDropdown'>
          <i class="el-icon-setting"></i>
          <span>设置</span>
        </el-menu-item>
      </div>
    </el-menu>
  </div>
</template>

<script>

export default {
  data() {
    return {
      categories: '',
      isCollapse: false
    }
  },
  mounted() {
    console.log(this.$route.path);
    axios.get('/api/notes').then(res => {
      if (res.data.status) {
        this.categories = res.data.data;
      }
    });
  },
  methods: {
    active() {
      this.isCollapse = !this.isCollapse;
      this.$emit('show', this.isCollapse);
    },
    create() {
      this.$router.push('/notes/create');
    }
  }
}
</script>