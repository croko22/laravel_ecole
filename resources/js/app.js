import "./bootstrap";
import "flowbite";
import { initFlowbite } from "flowbite";

import "tinymce/tinymce";
import "tinymce/skins/ui/oxide/skin.min.css";
import "tinymce/skins/content/default/content.min.css";
import "tinymce/skins/content/default/content.css";
import "tinymce/icons/default/icons";
import "tinymce/themes/silver/theme";
import "tinymce/models/dom/model";

document.addEventListener("livewire:navigating", () => {
    initFlowbite();
});

Alpine.data("tinymceEditor", (entangle) => ({
    value: entangle,
    editor: null,
    init() {
        tinymce.init({
            toolbar:
                "undo redo | formatselect | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat",
            menubar: false, // Set to true if you want to show the menubar
            plugins:
                "lists link image charmap print preview anchor searchreplace visualblocks code fullscreen insertdatetime media table paste code help wordcount",

            selector: "textarea",
            allow_conditional_comments: true,
            target: this.$refs.tinymce,

            skin: false,
            content_css: false,

            setup: (editor) => {
                editor.on("blur", (e) => {
                    this.value = editor.getContent();
                });

                editor.on("init", (e) => {
                    if (this.value != null) {
                        editor.setContent(this.value);
                    }
                });

                this.editor = editor;
            },
        });

        // Or, this.editor = tinymce.get(this.$refs.tinymce.id)
        if (this.editor) {
            this.$watch("value", (newValue) => {
                if (newValue !== this.editor.getContent()) {
                    this.editor.resetContent(newValue || "");
                    this.putCursorToEnd();
                }
            });
        }
    },

    putCursorToEnd() {
        this.editor.selection.select(this.editor.getBody(), true);
        this.editor.selection.collapse(false);
    },
}));
