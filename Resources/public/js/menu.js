var treeNodeId = "#tree";

function deleteTreeChild()
{
    loading(true);

    var node = $(treeNodeId).dynatree("getActiveNode");

    $.ajax({
        type: "POST",
        url: treeDeleteUrl,
        dataType: 'json',
        data: "id=" + node.data.id,
        success: function(msg)
        {
            tree = node.tree;
            tree.reload();
            tree.activateKey(msg.key);
        },
        error: function(msg)
        {
            tree = node.tree;
            tree.reload();
            alert('Sorry, something went wrong.');
        }
    });
    return true;
}

function refreshTree()
{
    $(treeNodeId).dynatree("getTree").reload();
}

function addTreeChild()
{
    loading(true);

    var node = $(treeNodeId).dynatree("getActiveNode");

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
        success: function(msg)
        {
            refreshTree();
            tree.activateKey(msg.key);
        },
        error: function(msg)
        {
            refreshTree();
            alert('Sorry, something went wrong.');
        }
    });
}

function addTreeRoot()
{
    loading(true);

    $.ajax({
        type: "POST",
        url: treeAddUrl,
        dataType: 'json',
        data: 'root=1',
        success: function(msg)
        {
            refreshTree();
            tree.activateKey(msg.key);
        },
        error: function(msg)
        {
            refreshTree();
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
        success: function(msg)
        {
            loading(false);
        },
        error: function(msg)
        {
            refreshTree();
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

function updateLinkFieldEvent()
{
    updateLinkField($(this));
}
function updateLinkField(typeField)
{
    var type = typeField.val();
    var arguments = $('#form_linkArguments').parent();
    var plain = $('#form_linkPlain').parent();
    if (type == 'text') {
        arguments.hide();
        plain.show();
    } else if (type == 'path') {
        arguments.hide();
        plain.hide();
    } else if (type == 'separator') {
        arguments.hide();
        plain.hide();
    } else if (type == 'nolink') {
        arguments.show();
        plain.hide();
    } else {
        arguments.hide();
        plain.hide();
    }
}

function loadEditForm(node)
{
    loading(true);
    var nodeId = node.data.id;
    $('#edit').load(treeFormUrl, 'id=' + nodeId, function()
    {
        loading(false);
        $('#editForm').ajaxForm({
            success: function(responseText, statusText, xhr, $form)
            {
                refreshTree();
                $('#edit').text('');
            },
            target: '#edit'
        });
        var linkTypeField = $('#form_linkType');
        updateLinkField(linkTypeField);
        linkTypeField.change(updateLinkFieldEvent);

    });

}

$(document).ready(function()
{
    $(treeNodeId).dynatree({
        persist: false,
        checkbox: true,
        minExpandLevel: 3,
        selectMode: 2,
        debugLevel: 0,
        onPostInit: function(isReloading, isError)
        {
            loading(false)
        },
        postProcess: function(data, dataType)
        {
            loading(true)
        },
        onSelect: function(flag, dtnode)
        {
            selectNode(flag, dtnode)
        },
        initAjax: {url: treeListUrl},

        onActivate: function(node)
        {
            loadEditForm(node);
        },
        onDeactivate: function(node)
        {
            $('#edit').text('');
        },

        dnd: {
            onDragStart: function(node)
            {
                /** This function MUST be defined to enable dragging for the tree.
                 *  Return false to cancel dragging of node.
                 */
                logMsg("tree.onDragStart(%o)", node);
                return true;
            },
            onDragStop: function(node)
            {
                // This function is optional.
                logMsg("tree.onDragStop(%o)", node);
            },
            autoExpandMS: 1000,
            preventVoidMoves: true, // Prevent dropping nodes 'before self', etc.
            onDragEnter: function(node, sourceNode)
            {
                return true;
            },
            onDragOver: function(node, sourceNode, hitMode)
            {
                if(node.isDescendantOf(sourceNode)){
                    return false;
                }
                if(node.data.lvl == 0){
                    return false;
                }
            },
            onDrop: function(node, sourceNode, hitMode, ui, draggable)
            {
                loading(true);
                var targetNodeId = node.data.id;
                var movedNodeId = sourceNode.data.id;
                $.ajax({
                    type: "POST",
                    url: treeSaveUrl,
                    dataType: 'json',
                    data: 'id=' + movedNodeId + '&target=' + targetNodeId + '&mode=' + hitMode,
                    success: function(msg){
                        sourceNode.move(node, hitMode);
                        loading(false);
                    },
                    error: function(msg){
                        refreshTree();
                        alert('Sorry, something went wrong.');
                    }
                });
            }
        }
    });
});