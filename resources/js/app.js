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
            menubar: true,
            toolbar:
                "undo redo | blocks | bold italic backcolor | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | removeformat",

            content_css: "/app.css",
            skin: false,
            style_formats: [
                { title: "My heading", block: "h1", classes: "heading" },
                { title: "PEPE", block: "p", classes: "pepe" },
            ],

            target: this.$refs.tinymce,
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
