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
            alert('Sorry, something went wrong.');
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
            alert('Sorry, something went wrong.');
        }
    });
}

function selectNode(flag, dtnode)
{
    var nodeId = dtnode.data.id;
    $.ajax({
        type: "POST",
        url: treeSaveUrl,
        dataType: 'json',
        data: 'id=' + nodeId + '&active=' + ((flag) ? 1 : 0),
        success: function(msg){
            loading(false);
        },
        error: function(msg){
            tree = node.tree;
            tree.reload();
            alert('Sorry, something went wrong.');
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



$(document).ready(function() {
    $("#tree").dynatree({
        persist: false,
        checkbox: true,
        minExpandLevel: 3,
        selectMode: 2,
        debugLevel: 0,
        onPostInit: function(isReloading, isError) {
            loading(false)
        },
        postProcess: function(data, dataType) {
            loading(true)
        },
        onSelect: function(flag, dtnode) {
            selectNode(flag, dtnode)
        },
        initAjax: {url: treeListUrl}
    });
});