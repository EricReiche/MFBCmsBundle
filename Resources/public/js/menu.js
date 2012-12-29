function deleteTreeChild()
{
    loading(true);

    var node = $("#tree").dynatree("getActiveNode");

    $.ajax({
        type: "POST",
        url: treeDeleteUrl,
        dataType: 'json',
        data: "id=" + node.data.id,
        success: function(msg){
            tree = node.tree;
            tree.reload();
            tree.activateKey(msg.key);
        },
        error: function(msg){
            tree = node.tree;
            tree.reload();
        }
    });
}

function addTreeChild()
{
    loading(true);

    var node = $("#tree").dynatree("getActiveNode");

    var childNode = node.addChild({
        title: "New node"
    });

    var prev = childNode.getPrevSibling();
    var parent = childNode.getParent();

    var prevId = null;
    var parentId = null;

    if (prev) {
        prevId = prev.data.id;
    }
    if (parent) {
        parentId = parent.data.id;
    }

    $.ajax({
        type: "POST",
        url: treeAddUrl,
        dataType: 'json',
        data: 'prev=' + prevId +
            '&parent=' + parentId,
        success: function(msg){
            tree = node.tree;
            tree.reload();
            tree.activateKey(msg.key);
        },
        error: function(msg){
            tree = node.tree;
            tree.reload();
        }
    });

}

function loading(start)
{
    if (start) {
        $('#spinner').show();
        $('#controls').hide();
    } else {
        $('#spinner').hide();
        $('#controls').show();
    }
}