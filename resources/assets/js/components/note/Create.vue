<template>
  <div style="width: 96%; margin-left: 2%">
    <form class="form-horizontal" role="form">

      <div class="form-group">
        <div class="row note-create">
          <div class="col-md-3 text-left">
            <el-select v-model="category" placeholder="请选择笔记类别" filterable allow-create style="width: 100%">
              <el-option v-for="item in categories" :key="item.id" :label="item.name" :value="item.id">
              </el-option>
            </el-select>
          </div>
          <div class="col-md-3 text-left">
            <el-select v-model="tag" multiple filterable allow-create placeholder="请选择笔记标签" style="width: 100%">
              <el-option v-for="item in tags" :key="item.id" :label="item.name" :value="item.id">
              </el-option>
            </el-select>
          </div>
          <div class="col-md-6 text-right">
            <el-button type="success" icon="el-icon-close" plain @click="cancel()">
              取消
            </el-button>
            <el-button type="danger" icon="el-icon-circle-check-outline" @click="create()">
              保存
            </el-button>
          </div>
        </div>
      </div>

      <div class="form-group">
        <el-input id="title" name="title" v-model="title" type="title" placeholder="标题"></el-input>
      </div>

      <div class="form-group">
        <div id="editor-md" style="width: 100%">
          <textarea id="body" name="body" style="display:none"></textarea>
        </div>
      </div>
    </form>
  </div>
</template>

<script>
import $script from "scriptjs";

export default {
  data() {
    return {
      editorPath: '../../../../../vendor/markdown/',
      categories: '',
      category: '',
      tags: '',
      tag: [],
      title: ''
    }
  },
  mounted() {
    axios.get('/api/categories').then((res) => {
      if (res.data.status) {
        this.categories = res.data.data;
      }
    });
    axios.get('/api/tags').then((res) => {
      if (res.data.status) {
        this.tags = res.data.data;
      }
    });
    $script(
      [`${this.editorPath}js/jquery.min.js`], () => {
        $script(`${this.editorPath}js/editormd.min.js`, () => {
          this.initEditor();
        });
      }
    )
  },
  methods: {
    initEditor() {
      this.$nextTick((editorMD = window.editormd) => {
        if (editorMD) {
          // Vue 异步执行 DOM 更新，template 里面的 script 标签异步创建
          // 所以，只能在 nextTick 里面初始化 editor.md
          editorMD("editor-md", {
            width: "100%",
            height: 750,
            markdown: "",
            path: `${this.editorPath}lib/`,
            toolbarIcons: function() {
              return ["undo", "redo", "|", "bold", "del", "italic", "quote", "ucwords", "uppercase", "lowercase", "|",
                "h1", "h2", "h3", "h4", "h5", "h6", "|", "list-ul", "list-ol", "hr", "|", "link", "reference-link",
                "image", "code", "preformatted-text", "code-block", "table", "datetime", "emoji", "html-entities",
                "pagebreak", "||", "goto-line", "watch", "clear", "preview", "fullscreen"]
            },
            imageUpload: true,
            imageFormats: ["jpg", "jpeg", "gif", "png", "bmp", "webp"],
            imageUploadURL: "/api/markdown/upload",
            emoji: true
          });
        }
      });
    },
    cancel() {
      this.$router.back();
    },
    create() {
      let data = {
        title: this.title,
        body: document.querySelector('#body').value,
        category: this.category,
        tags: this.tag
      }
      axios.post('/api/notes', data).then((res) => {
        if (res.data.status) {
          this.$router.go(-1);
        }
      });
    }
  }
}
</script>
