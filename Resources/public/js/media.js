$(document).ready(function() {
    var parentTypeInput = $('#form_parentType');
    var parentIdInput = $('#form_id');
    var parentSearchInput = $('#form_search');

    function refreshUploadParams()
    {
        Dropzone.options.mediaDropzone.params.type = parentTypeInput.val();
        Dropzone.options.mediaDropzone.params.parentId = parentIdInput.val();
    }

    function getTypeInputValue()
    {
        return parentTypeInput.val();
    }

    parentSearchInput.autocomplete({
        serviceUrl: searchUrl,
        onSelect: function (suggestion) {
            $('#form_id').val(suggestion.data);
            refreshUploadParams();
        },
        params: {
            'type': getTypeInputValue
        }
    });

    parentTypeInput.change(function(){
        parentIdInput.val('');
        parentSearchInput.val('');
        refreshUploadParams();
    });
    parentIdInput.change( refreshUploadParams );

    refreshUploadParams();
});