<div wire:ignore x-data {{ $attributes }}>
    <script src="https://cdn.tiny.cloud/1/cy4ya733uwo3aasce11oqbt6mnbyqi6ehdpue5twfs38uxh6/tinymce/7/tinymce.min.js"
        referrerpolicy="origin"></script>
    <script>
        tinymce.init({
            selector: '#description',
            allow_conditional_comments: true,
            // All your init stuff here, then the super important part at the bottom
            setup: function(editor) {
                editor.on('init change', function() {
                    editor.save();
                });

                editor.on('blur', function(e) {
                    @this.set('description', editor.getContent());
                });
            },
        });
    </script>
    <textarea id="description">
        {{ $description }}
    </textarea>
</div>
