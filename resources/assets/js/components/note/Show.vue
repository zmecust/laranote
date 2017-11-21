<template>
  <div id="container" v-cloak>
    <category-index></category-index>

    <div class="right">
      <div class="col-md-12 text-right note-show" v-show="note">
        <el-button type="success" size="small" icon="el-icon-edit" plain @click="edit()">
          编辑
        </el-button>
        <el-button type="danger" size="small" icon="el-icon-delete" @click="destroy()">
          删除
        </el-button>
      </div>
      <div v-show="note">
        <div class="row" style="margin: 0 6px 30px 6px">
          <div class="col-md-10">
            <span style="font-size: 30px; color: #333">{{ note.title }}</span>
            <span style="font-size: 25px; color: #777; padding-left: 10px">{{ note.created_at }}</span>
          </div>
          <div class="col-md-2 text-right">
            <el-button style="padding: 0">
              <span style="font-size: 30px;">
                <i :class="[note.is_important == 'T' ? 'el-icon-star-on' : 'el-icon-star-off']"></i>
              </span>
            </el-button>
          </div>
        </div>
        <div class="markdown-body" style="padding: 0 20px 20px 20px;" v-html="note.body"></div>
      </div>
    </div>
  </div>
</template>

<script>
import CategoryIndex from './Index';
import routeData from '../../libs/route-data';
import { mapState } from 'vuex';

export default {
  computed: mapState({
    note: state => state.note
  }),
  components: {
    CategoryIndex
  },
  methods: {
    edit() {
      this.$router.push('/notes/' + this.note.id + '/edit');
    },
    destroy() {
      this.$confirm('此操作将删除该笔记, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        axios.delete('/api/notes/' + this.note.id).then((res) => {
          if (res.data.status) {
            this.$message({
              type: 'success',
              message: '删除成功!'
            });
          }
        });
      }).catch(() => {
        this.$message({
          type: 'info',
          message: '已取消删除'
        });
      });
    }
  }
}
</script>

<style>
[v-cloak] {
  display: none;
}
</style>
