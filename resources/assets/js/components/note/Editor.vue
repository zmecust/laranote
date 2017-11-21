<template>
  <div id="editor-md">
    <textarea id="body" name="body" style="display:none"></textarea>
  </div>
</template>

<script>
import $script from "scriptjs";

export default {
  data() {
    return {
      editorPath: '../../../../../vendor/markdown/',
    }
  },
  mounted() {
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
            imageUploadURL: "/markdown/upload",
            emoji: true
          });
        }
      });
    },
  }
}
</script>