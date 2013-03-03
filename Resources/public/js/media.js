$(document).ready(function() {
    var parentTypeInput = $('#form_parentType');
    var parentIdInput = $('#form_id');

    function refreshUploadParams()
    {
        Dropzone.options.mediaDropzone.params.type = parentTypeInput.val();
        Dropzone.options.mediaDropzone.params.parentId = parentIdInput.val();
    }

    function getTypeInputValue()
    {
        return parentTypeInput.val();
    }

    $('#form_search').autocomplete({
        serviceUrl: searchUrl,
        onSelect: function (suggestion) {
            $('#form_id').val(suggestion.data);
            refreshUploadParams();
        },
        params: {
            'type': getTypeInputValue
        }
    });

    parentTypeInput.change( refreshUploadParams );
    parentIdInput.change( refreshUploadParams );

    refreshUploadParams();
});