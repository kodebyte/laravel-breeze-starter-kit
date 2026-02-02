@props(['selector' => '.tinymce']) {{-- Default selector class .tinymce --}}

{{-- Load Library (Self-Hosted) --}}
<script src="{{ asset('vendor/tinymce/tinymce.min.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const editorConfig = {
            // Config Base
            selector: '{{ $selector }}', // <--- Selector Dinamis
            base_url: '{{ asset("vendor/tinymce") }}', 
            suffix: '.min', 
            license_key: 'gpl', 
            promotion: false, 
            branding: false, 

            // Config UI
            height: 500,
            menubar: false,
            plugins: 'anchor autolink charmap codesample emoticons image link lists media searchreplace table visualblocks wordcount',
            toolbar: 'undo redo | blocks fontfamily fontsize | bold italic underline strikethrough | link image media table | align lineheight | numlist bullist indent outdent | emoticons charmap | removeformat',
            content_style: 'body { font-family:Inter,sans-serif; font-size:14px }',
            
            // Sync Data Logic
            setup: function (editor) {
                editor.on('change', function () {
                    editor.save();
                });
            }
        };

        // Init Editor
        tinymce.init(editorConfig);
    });
</script>