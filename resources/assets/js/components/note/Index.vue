<template>
    <div id="container">
        <div class="left">
            <category-index @show="show"></category-index>
        </div>

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
                        <span style="font-size: 30px; color: #333">{{ note.title }}</span> <span style="font-size: 25px; color: #777; padding-left: 10px">{{ note.created_at }}</span>
                    </div>
                    <div class="col-md-2 text-right">
                        <el-button>
                            <span style="font-size: 30px"><i :class="[note.is_important == 'T' ? 'el-icon-star-on' : 'el-icon-star-off']"></i></span>
                        </el-button>
                    </div>
                </div>
                <!--<div class="markdown-body editormd-html-preview" style="padding: 0 20px 20px 20px;" v-html="note.body"></div>-->
                <div id="editor" style="width: 100%">
                    <textarea id="body1" style="display:none">{{ note.body }}</textarea>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
  import CategoryIndex from '../category/Index';
  import $script from "scriptjs";

  export default {
    data() {
      return {
        note: '',
        instance: '',
        editorPath: '../../../../../vendor/markdown/',
      }
    },
    components: {
      CategoryIndex
    },
    mounted() {
      this.reload();
    },
    methods: {
      reload() {
        //document.getElementById("body1").value = this.note.body;
        $script(
          [ `${this.editorPath}js/jquery.min.js` ], () => {
            $script([`${this.editorPath}js/editormd.min.js`,
              `${this.editorPath}lib/marked.min.js`,
              `${this.editorPath}lib/prettify.min.js`], () => {
              this.initEditor();
            });
          }
        )
      },
      initEditor() {
        this.$nextTick((editorMD = window.editormd) => {
          if (editorMD) {
            // Vue 异步执行 DOM 更新，template 里面的 script 标签异步创建
            // 所以，只能在 nextTick 里面初始化 editor.md
            this.instance = editorMD.markdownToHTML('editor', {
              htmlDecode: "style,script,iframe",
              emoji: false,
              taskList: true,
              tex: false, // 默认不解析
              flowChart: false, // 默认不解析
              sequenceDiagram: false, // 默认不解析
              codeFold: true,
            });
          }
        });
      },
      edit() {
        this.$router.push('/notes/' + this.$route.params.id + '/edit');
      },
      destroy() {
        this.$confirm('此操作将删除该笔记, 是否继续?', '提示', {
          confirmButtonText: '确定',
          cancelButtonText: '取消',
          type: 'warning'
        }).then(() => {
          axios.delete('/api/notes/' + this.$route.params.id).then((res) => {
            if (res.data.status) {
              this.$router.push('/home');
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
      show(note) {
        this.note = note;
      }
    },
    watch: {
      note: function(val) {
        if (val !== null) {
          this.reload();
        }
      }
    }
  }
</script>

<style>
    @import "../../../../../public/vendor/markdown/css/editormd.min.css";
</style>