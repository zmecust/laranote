<template>
  <div v-cloak>
    <div class="sidebar-top submenu-title">
      <el-button class="button-collapse" :icon="isCollapse ? 'el-icon-d-arrow-right' : 'el-icon-d-arrow-left'" plain @click="active()"></el-button>
      <span>
        <el-button icon="el-icon-plus" type="success" @click="create()"></el-button>
      </span>
    </div>
    <el-menu :default-active="$route.path" class="el-menu-vertical-demo" :collapse="isCollapse" router mode="vertical" background-color="#f4f4f4" text-color="#555" active-text-color="#20c997">
      <div class='menu-wrapper'>
        <el-menu-item index="/home" class='submenu-title-noDropdown'>
          <i class="el-icon-menu"></i>
          <span>首页</span>
        </el-menu-item>

        <el-submenu index="11">
          <template slot="title">
            <i class="el-icon-tickets"></i>
            <span>笔记本</span>
          </template>
          <el-menu-item :index="'/categories/' + category.id" v-for="category in categories" :key="category.id">
            <template slot="title">
              <div style="display: flex; justify-content: space-between;">
                <div>{{ category.name }}</div>
                <div>{{ category.notes_count }}</div>
              </div>
            </template>
          </el-menu-item>
        </el-submenu>

        <el-menu-item index="/trash" class='submenu-title-noDropdown'>
          <i class="el-icon-delete"></i>
          <span>废纸篓</span>
          <span style="padding-left: 30%">{{ counts.trash_count }}</span>
        </el-menu-item>

        <el-menu-item index="/important" class='submenu-title-noDropdown'>
          <i class="el-icon-star-on"></i>
          <span>我的收藏</span>
          <span style="padding-left: 21%">{{ counts.important_count }}</span>
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
      counts: '',
      isCollapse: false
    }
  },
  mounted() {
    axios.get('/api/categories').then(res => {
      if (res.data.status) {
        this.categories = res.data.data;
      }
    });
    axios.get('/api/get_count').then(res => {
      if (res.data.status) {
        this.counts = res.data.data;
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
