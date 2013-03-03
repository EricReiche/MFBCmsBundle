$(document).ready(function() {
    function reloadImageChooser()
    {
        var fileChooser = $('#filechooser');
        fileChooser.load(fileChooserUrl, function() {
            // loading done
        });
    }
});