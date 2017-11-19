<template>
    <div class="left">
        <div style="border-bottom: 1px solid #ddd;">
            <el-input
                    placeholder="请输入内容"
                    prefix-icon="el-icon-search"
                    v-model="search">
            </el-input>
        </div>
        <div>
            <div v-for="(note, index) in notes">
                <router-link :to="'/notes/' + note.id">{{ note.title }}</router-link>
            </div>
        </div>
    </div>
</template>

<script>

  export default {
    data() {
      return {
        search: '',
        notes: ''
      }
    },
    mounted() {
      axios.get('/api/categories/' + this.$route.params.id).then(res => {
        if (res.data.status) {
          this.notes = res.data.data;
        }
      });
    },
    methods: {
      change(index) {
        this.$emit('show', this.notes[index]);
      }
    }
  }
</script>