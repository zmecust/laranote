<template>
  <div class="left">
    <div style="border-bottom: 1px solid #ddd; padding-bottom: 2px">
      <el-input placeholder="请输入内容" prefix-icon="el-icon-search" v-model="search">
      </el-input>
    </div>
    <div>
      <div v-for="(note, index) in notes">
        <div @click="change(index)" class="btn-note-list">
          <div class="item1">
            <h4>{{ note.title }}</h4>
            <p>{{ note.created_at }}</p>
          </div>
          <div class="item2">
            <el-button icon="el-icon-delete" plain @click="destroy(index, note.id)"></el-button>
            <el-button icon="el-icon-star-off" plain @click="like(index, note.id)"></el-button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>

export default {
  data() {
    return {
      search: '',
      notes: '',
      uri: '',
    }
  },
  mounted() {
    this.uri = this.$route.path;
    axios.get('/api' + this.uri).then(res => {
      if (res.data.status) {
        this.notes = res.data.data;
      }
    });
  },
  methods: {
    change(index) {
      this.$store.commit('NOTE', this.notes[index]);
    },
    destroy(index, id) {
      this.$confirm('此操作将删除该笔记, 是否继续?', '提示', {
        confirmButtonText: '确定',
        cancelButtonText: '取消',
        type: 'warning'
      }).then(() => {
        axios.delete('/api/notes/' + id).then((res) => {
          if (res.data.status) {
            this.notes.splice(index, 1);
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
    },
    like(index, id) {

    }
  }
}
</script>

<style lang="scss">
.btn-note-list {
  padding: 0 10px 0 10px;
  display: flex;
  justify-content: space-between;
  border-bottom: 1px solid #ddd;
  width: 100%;
  height: 56px;
  background-color: #fff;
  &:hover,
  &:focus,
  &:hover:active,
  &:active {
    background: #f4f4f4;
    border-bottom: 1px solid #ddd;
    color: #20c997;
    .item2 {
      display: block;
    }
  }
  .item1 {
    align-self: flex-start;
    height: 55px;
    text-align: left;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 1;
    -webkit-box-orient: vertical;
    h4 {
      font-size: 15px;
      line-height: 8px;
    }
    p {
      font-size: 13px;
      color: #999;
    }
  }
  .item2 {
    align-self: center;
    display: none;
    button {
      font-size: large;
      padding: 0;
      border: none;
      border-radius: 0;
      background: #f4f4f4;
      &:hover,
      &:active {
        background-color: #f4f4f4;
      }
    }
  }
}
</style>
