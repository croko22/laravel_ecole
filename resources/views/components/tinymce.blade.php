<div x-data="tinymceEditor(@entangle('description'))" wire:ignore>
    <textarea :id="$id('tinymce')" x-ref="tinymce" placeholder="Write something..."></textarea>
</div>
