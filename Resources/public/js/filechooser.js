
function reloadImageChooser()
{
    var fileChooser = $('#filechooser');
    fileChooser.load(fileChooserUrl, function() {
        // loading done
    });
}

function addImage(id)
{
    var link = "&#123;&#123; img(" + id + ", 150, 150) &#125;&#125;"
    $('.btnTarget').append(link);
}

function addImageLink(id)
{
    var link = "&#123;&#123; imgLink(" + id + ", 150, 150) &#125;&#125;"
    $('.btnTarget').append(link);
}

function addGallery(id, type)
{
    var link = "&#123;&#123; imgGallery(" + type + ", " + id + ", 150, 150) &#125;&#125;"
    $('.btnTarget').append(link);
}

$(document).ready(function() {

    $('textarea').each(function(){
        if($(this).attr('id').search(/content/i)) {
            $(this).addClass('btnTarget');
        }
    });

    var myDropzone = $(".dropzone").data("dropzone");

    if (myDropzone) {
        myDropzone.on("success", function(file) {
            reloadImageChooser();
        });
    }
});