<template>
    <div>
        <div class="col-md-12 text-right note-show">
            <button type="submit" class="btn">
                <span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
                编辑
            </button>
            <button type="submit" class="btn btn-danger">
                <span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                删除
            </button>
        </div>

        <div class="markdown-body editormd-html-preview" style="padding: 0 20px 20px 20px;" v-html="note.body"></div>
    </div>
</template>

<script>
  export default {
    data() {
      return {
        note: ''
      }
    },
    mounted() {
      this.reload();
    },
    methods: {
      reload() {
        axios.get('/api/notes/' + this.$route.params.id).then((res) => {
          if (res.data.status) {
            this.note = res.data.data;
          }
        });
      }
    },
    watch: {
      $route(to, from) {
        this.reload();
      }
    }
  }
</script>