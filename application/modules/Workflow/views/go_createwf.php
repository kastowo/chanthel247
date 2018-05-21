<script type="text/javascript" src="<?php echo base_url('assetsnew/plugins/gojs/go-debug.js')?>"></script>
<script id="code">
  function init() {
    if (window.goSamples) goSamples();  // init for these samples -- you don't need to call this
    var $ = go.GraphObject.make;  // for conciseness in defining templates

    myDiagram =
      $(go.Diagram, "myDiagramDiv",  // must name or refer to the DIV HTML element
        {
          initialContentAlignment: go.Spot.Center,
          allowDrop: true,  // must be true to accept drops from the Palette
          "LinkDrawn": showLinkLabel,  // this DiagramEvent listener is defined below
          "LinkRelinked": showLinkLabel,
          scrollsPageOnFocus: false,
          "undoManager.isEnabled": true  // enable undo & redo
        });

        // This is the actual HTML context menu:
        var cxElement = document.getElementById("contextMenu");

        // Since we have only one main element, we don't have to declare a hide method,
        // we can set mainElement and GoJS will hide it automatically
        var myContextMenu = $(go.HTMLInfo, {
          show: showContextMenu,
          mainElement: cxElement
        });

    // when the document is modified, add a "*" to the title and enable the "Save" button
    myDiagram.addDiagramListener("Modified", function(e) {
      var button = document.getElementById("SaveButton");
      if (button) button.disabled = !myDiagram.isModified;
      var idx = document.title.indexOf("*");
      if (myDiagram.isModified) {
        if (idx < 0) document.title += "*";
      } else {
        if (idx >= 0) document.title = document.title.substr(0, idx);
      }
    });

    // helper definitions for node templates

    function nodeStyle() {
      return [
        // The Node.location comes from the "loc" property of the node data,
        // converted by the Point.parse static method.
        // If the Node.location is changed, it updates the "loc" property of the node data,
        // converting back using the Point.stringify static method.
        new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify),
        {
          // the Node.location is at the center of each node
          locationSpot: go.Spot.Left,
          //isShadowed: true,
          //shadowColor: "#888",
          // handle mouse enter/leave events to show/hide the ports
          mouseEnter: function (e, obj) { showPorts(obj.part, true); },
          mouseLeave: function (e, obj) { showPorts(obj.part, false); }
        }
      ];
    }

    // Define a function for creating a "port" that is normally transparent.
    // The "name" is used as the GraphObject.portId, the "spot" is used to control how links connect
    // and where the port is positioned on the node, and the boolean "output" and "input" arguments
    // control whether the user can draw links from or to the port.
    function makePort(name, spot, output, input) {
      // the port is basically just a small circle that has a white stroke when it is made visible
      return $(go.Shape, "Circle",
               {
                  fill: "transparent",
                  stroke: null,  // this is changed to "white" in the showPorts function
                  desiredSize: new go.Size(8, 8),
                  alignment: spot, alignmentFocus: spot,  // align the port on the main Shape
                  portId: name,  // declare this object to be a "port"
                  fromSpot: spot, toSpot: spot,  // declare where links may connect at this port
                  fromLinkable: output, toLinkable: input,  // declare whether the user may draw links to/from here
                  cursor: "pointer"  // show a different cursor to indicate potential link point
               });
    }

    // define the Node templates for regular nodes

    var lightText = 'whitesmoke';

    myDiagram.nodeTemplateMap.add("Start",
      $(go.Node, "Spot", nodeStyle(),
        $(go.Panel, "Auto",
          { contextMenu: myContextMenu },
          $(go.Shape, "Circle",
            { minSize: new go.Size(40, 40),  fill: "#9cea9c", stroke: "#2a9b6a", strokeWidth: 2}),
          $(go.TextBlock, "Start",
            { font: "9pt Helvetica, Arial, sans-serif", stroke: lightText },
            new go.Binding("text"))
        ),
        // three named ports, one on each side except the top, all output only:
        makePort("L", go.Spot.Left, true, false),
        makePort("R", go.Spot.Right, true, false),
        makePort("B", go.Spot.Bottom, true, false)
      ));
    myDiagram.nodeTemplateMap.add("StartScanner",
      $(go.Node, "Spot", nodeStyle(),
        $(go.Panel, "Auto",
          { contextMenu: myContextMenu },
          $(go.Shape, "Circle",
            { minSize: new go.Size(40, 40),  fill: "#9cea9c", stroke: "#2a9b6a", strokeWidth: 2},
            new go.Binding("figure", "figure")),
          $(go.Picture, "<?php echo base_url(); ?>assets/SVG_dark/scanner.png",
            { width: 28, height: 21 },
            new go.Binding("source", "path")),
          $(go.TextBlock, "Start",
            { font: "9pt Helvetica, Arial, sans-serif", stroke: lightText },
            new go.Binding("text"))
        ),
        // three named ports, one on each side except the top, all output only:
        makePort("L", go.Spot.Left, true, false),
        makePort("R", go.Spot.Right, true, false),
        makePort("B", go.Spot.Bottom, true, false)
      ));

    myDiagram.nodeTemplateMap.add("StartDocument",
      $(go.Node, "Spot", nodeStyle(),
        $(go.Panel, "Auto",
          { contextMenu: myContextMenu },
          $(go.Shape, "Circle",
            { minSize: new go.Size(40, 40),  fill: "#9cea9c", stroke: "#2a9b6a", strokeWidth: 2},
            new go.Binding("figure", "figure")),
          $(go.Picture, "<?php echo base_url(); ?>assets/SVG_dark/document-01.png",
            { width: 28, height: 21 },
            new go.Binding("source", "path")),
          $(go.TextBlock, "Start",
            { font: "9pt Helvetica, Arial, sans-serif", stroke: lightText },
            new go.Binding("text"))
      ),
      // three named ports, one on each side except the top, all output only:
      makePort("L", go.Spot.Left, true, false),
      makePort("R", go.Spot.Right, true, false),
      makePort("B", go.Spot.Bottom, true, false)
    ));

    myDiagram.nodeTemplateMap.add("StartEmail",
      $(go.Node, "Spot", nodeStyle(),
        $(go.Panel, "Auto",
          { contextMenu: myContextMenu },
          $(go.Shape, "Circle",
            { minSize: new go.Size(40, 40),  fill: "#9cea9c", stroke: "#2a9b6a", strokeWidth: 2},
            new go.Binding("figure", "figure")),
          $(go.Picture, "<?php echo base_url(); ?>assets/SVG_dark/email-01.png",
            { width: 26, height: 18 },
            new go.Binding("source", "path")),
          $(go.TextBlock, "Start",
            { font: "9pt Helvetica, Arial, sans-serif", stroke: lightText },
            new go.Binding("text"))
      ),
      // three named ports, one on each side except the top, all output only:
      makePort("L", go.Spot.Left, true, false),
      makePort("R", go.Spot.Right, true, false),
      makePort("B", go.Spot.Bottom, true, false)
    ));
    myDiagram.nodeTemplateMap.add("Activity",
      $(go.Node, "Spot", nodeStyle(),
        // the main object is a Panel that surrounds a TextBlock with a rectangular Shape
        $(go.Panel, "Auto",
        { contextMenu: myContextMenu },
          $(go.Shape, "RoundedRectangle",
            { fill: "#FFFFFF", stroke: "#5b5b5c", strokeWidth:2},
            new go.Binding("figure", "figure")),
          $(go.TextBlock,
            {
              font: "9pt Helvetica, Arial, sans-serif",
              stroke: "#5b5b5c",
              margin: 8,
              maxSize: new go.Size(160, NaN),
              wrap: go.TextBlock.WrapFit,
              editable: true
            },
            new go.Binding("text").makeTwoWay())
        ),
        // four named ports, one on each side:
        makePort("T", go.Spot.Top, false, true),
        makePort("L", go.Spot.Left, true, true),
        makePort("R", go.Spot.Right, true, true),
        makePort("B", go.Spot.Bottom, true, false)
    ));

    myDiagram.nodeTemplateMap.add("Decision",
      $(go.Node, "Spot", nodeStyle(),
        // the main object is a Panel that surrounds a TextBlock with a rectangular Shape
        $(go.Panel, "Auto",
        { contextMenu: myContextMenu },
          $(go.Shape, "Diamond",
            { fill: "#FFFFFF", stroke: "#5b5b5c", strokeWidth:2, width:40, height: 40},
            new go.Binding("figure", "figure")),
          $(go.TextBlock,
            {
              font: "9pt Helvetica, Arial, sans-serif",
              stroke: "#5b5b5c",
              margin: 8,
              maxSize: new go.Size(160, NaN),
              wrap: go.TextBlock.WrapFit,
              editable: true
            },
            new go.Binding("text").makeTwoWay())
        ),
        // four named ports, one on each side:
        makePort("T", go.Spot.Top, true, true),
        makePort("L", go.Spot.Left, true, true),
        makePort("R", go.Spot.Right, true, true),
        makePort("B", go.Spot.Bottom, true, true)
    ));

    myDiagram.nodeTemplateMap.add("EmailNotification",
      $(go.Node, "Spot", nodeStyle(),
        $(go.Panel, "Auto",
          { contextMenu: myContextMenu },
          $(go.Shape, "Circle",
            { minSize: new go.Size(40, 40),  fill: "#83bfed", stroke: "#4982ad", strokeWidth: 2},
            new go.Binding("figure", "figure")),
          $(go.Picture, "<?php echo base_url(); ?>assets/SVG_dark/email-01-01.png",
            { width: 26, height: 18 },
            new go.Binding("source", "path")),
          $(go.TextBlock, "Start",
            { font: "9pt Helvetica, Arial, sans-serif", stroke: lightText },
            new go.Binding("text"))
      ),
      // three named ports, one on each side except the top, all output only:
      makePort("L", go.Spot.Left, true, true),
      makePort("R", go.Spot.Right, true, true),
      makePort("B", go.Spot.Bottom, true, true),
      makePort("T", go.Spot.Bottom, true, true)
    ));

    myDiagram.nodeTemplateMap.add("End",
      $(go.Node, "Spot", nodeStyle(),
        $(go.Panel, "Auto",
          { contextMenu: myContextMenu },
          $(go.Shape, "Circle",
            { minSize: new go.Size(40, 40), fill: "#dd6c41", stroke: "#DC3C00", strokeWidth:2 }),
          $(go.TextBlock, "End",
            { font: "9pt Helvetica, Arial, sans-serif", stroke: lightText },
            new go.Binding("text"))
        ),
        // three named ports, one on each side except the bottom, all input only:
        makePort("T", go.Spot.Top, false, true),
        makePort("L", go.Spot.Left, false, true),
        makePort("R", go.Spot.Right, false, true)
      ));

    myDiagram.nodeTemplateMap.add("Comment",
      $(go.Node, "Auto", nodeStyle(),
        { contextMenu: myContextMenu },
        $(go.Shape, "File",
          { minSize: new go.Size(80, 40), fill: "#EFFAB4", stroke: null }),
        $(go.TextBlock,
          {
            margin: 5,
            maxSize: new go.Size(200, NaN),
            wrap: go.TextBlock.WrapFit,
            textAlign: "center",
            editable: true,
            font: "9pt Helvetica, Arial, sans-serif",
            stroke: '#454545'
          },
          new go.Binding("text").makeTwoWay())
        // no ports, because no links are allowed to connect with a comment
      ));


    // replace the default Link template in the linkTemplateMap
    myDiagram.linkTemplate =
      $(go.Link,  // the whole link panel
        {
          routing: go.Link.AvoidsNodes,
          curve: go.Link.JumpOver,
          corner: 5, toShortLength: 4,
          relinkableFrom: true,
          relinkableTo: true,
          reshapable: true,
          resegmentable: true,
          // mouse-overs subtly highlight links:
          mouseEnter: function(e, link) { link.findObject("HIGHLIGHT").stroke = "rgba(30,144,255,0.2)"; },
          mouseLeave: function(e, link) { link.findObject("HIGHLIGHT").stroke = "transparent"; }
        },
        new go.Binding("points").makeTwoWay(),
        $(go.Shape,  // the highlight shape, normally transparent
          { isPanelMain: true, strokeWidth: 8, stroke: "transparent", name: "HIGHLIGHT" }),
        $(go.Shape,  // the link path shape
          { isPanelMain: true, stroke: "gray", strokeWidth: 2 }),
        $(go.Shape,  // the arrowhead
          { toArrow: "standard", stroke: null, fill: "gray"}),
        $(go.Panel, "Auto",  // the link label, normally not visible
          { visible: false, name: "LABEL", segmentIndex: 2, segmentFraction: 0.5},
          new go.Binding("visible", "visible").makeTwoWay(),
          $(go.Shape, "RoundedRectangle",  // the label shape
            { fill: "#F8F8F8", stroke: null }),
          $(go.TextBlock, "Yes",  // the label
            {
              textAlign: "center",
              font: "10pt helvetica, arial, sans-serif",
              stroke: "#333333",
              editable: true
            },
            new go.Binding("text").makeTwoWay())
        )
      );

    // Make link labels visible if coming out of a "conditional" node.
    // This listener is called by the "LinkDrawn" and "LinkRelinked" DiagramEvents.
    function showLinkLabel(e) {
      var label = e.subject.findObject("LABEL");
      if (label !== null) label.visible = (e.subject.fromNode.data.figure === "Diamond");
    }

    // temporary links used by LinkingTool and RelinkingTool are also orthogonal:
    myDiagram.toolManager.linkingTool.temporaryLink.routing = go.Link.Orthogonal;
    myDiagram.toolManager.relinkingTool.temporaryLink.routing = go.Link.Orthogonal;


    // initialize the Palette that is on the left side of the page
    myPalette =
      $(go.Palette, "myPaletteDiv",  // must name or refer to the DIV HTML element
        {
          scrollsPageOnFocus: false,
          nodeTemplateMap: myDiagram.nodeTemplateMap,  // share the templates used by myDiagram
          model: new go.GraphLinksModel([  // specify the contents of the Palette
            { category: "Start", text: "" },
            { category: "StartScanner", text: "" },
            { category: "StartDocument", text: "" },
            { category: "StartEmail", text: "" },
            { category: "Activity", text: "Activity" },
            { category: "Decision", text: ""},
            { category: "EmailNotification", text: ""},
            { category: "End", text: "" },
            { category: "Comment", text: "" }
          ])
        });

        myDiagram.contextMenu = myContextMenu;

        // We don't want the div acting as a context menu to have a (browser) context menu!
        cxElement.addEventListener("contextmenu", function(e) {
          e.preventDefault();
          return false;
        }, false);

        function showContextMenu(obj, diagram, tool) {
          // Show only the relevant buttons given the current state.
          var cmd = diagram.commandHandler;
          document.getElementById("cut").style.display = cmd.canCutSelection() ? "block" : "none";
          document.getElementById("copy").style.display = cmd.canCopySelection() ? "block" : "none";
          document.getElementById("paste").style.display = cmd.canPasteSelection() ? "block" : "none";
          document.getElementById("delete").style.display = cmd.canDeleteSelection() ? "block" : "none";

          // Now show the whole context menu element
          cxElement.style.display = "block";
          // we don't bother overriding positionContextMenu, we just do it here:
          var mousePt = diagram.lastInput.viewPoint;
          cxElement.style.left = mousePt.x + "px";
          cxElement.style.top = mousePt.y + "px";
        }
        // This is the general menu command handler, parameterized by the name of the command.
        function cxcommand(event, val) {
          if (val === undefined) val = event.currentTarget.id;
          var diagram = myDiagram;
          switch (val) {
            case "cut": diagram.commandHandler.cutSelection(); break;
            case "copy": diagram.commandHandler.copySelection(); break;
            case "paste": diagram.commandHandler.pasteSelection(diagram.lastInput.documentPoint); break;
            case "delete": diagram.commandHandler.deleteSelection(); break;
          }
          diagram.currentTool.stopTool();
        }

  } // end init


  // Make all ports on a node visible when the mouse is over the node
  function showPorts(node, show) {
    var diagram = node.diagram;
    if (!diagram || diagram.isReadOnly || !diagram.allowLink) return;
    node.ports.each(function(port) {
        port.stroke = (show ? "white" : null);
      });
  }

</script>
<body onload="init()">
  <div class="row">
    <div class="col-12 no-padding">
      <div id="sample" style="position:relative">
        <div id="myPaletteDiv" style="width: 100%; height:60px; background-color: #f8f8f8; border: solid 0px black "></div>
        <div class="row margin-y">
          <div class="col-9 no-padding">
            <div style="width: 100%; display: flex;">
              <div id="myDiagramDiv" style="flex-grow: 1; min-height: 470px; border: solid 0.5px silver"></div>
              <div id="contextMenu">
                <ul>
                  <li id="cut" onclick="cxcommand(event)"><a href="#" target="_self">Cut</a></li>
                  <li id="copy" onclick="cxcommand(event)"><a href="#" target="_self">Copy</a></li>
                  <li id="paste" onclick="cxcommand(event)"><a href="#" target="_self">Paste</a></li>
                  <li id="delete" onclick="cxcommand(event)"><a href="#" target="_self">Delete</a></li>
                </ul>
              </div>
            </div>
          </div>
          <div class="col-3 no-padding" style="min-height:450px">
            <div class="box" style="border:0.5px solid silver !important">
              <div class="box-header" style="background: #428bca;">
                <p class="box-title" style="color:white; padding-left:10px">Properties</p>
              </div>
              <div class="box-body">
                <ul class="properties">
                  <li>Variable<span><i class="fa fa-plus-circle"></i></span></li>
                  <li><a href="<?php echo base_url('Workflow/createDynamicForm')?>">Dyanamic Form<span><i class="fa fa-plus-circle"></i></span></a></li>
                  <li>Input Document<span><i class="fa fa-plus-circle"></i></span></li>
                </ul>
              </div>
            </div>
            <div class="properties-button">
              <button type="button" name="button" class="button-default" style="margin-right:20px">Reset</button>
              <button type="button" name="button" class="button-primary">Save</button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
<script type="text/javascript">
$('#Workflow').addClass("active");

function close_wf(){
  window.location = "<?php echo base_url('Workflow');?>";
  //window.history.back();
}
document.getElementById('menu-title').style.display ="block";
document.getElementById('menu-add').style.display ="none";
document.getElementById('title').innerHTML="Create New Workflow";

</script>
<script type="text/javascript">
function save_data_wf(){
  var wf_name = $('input#wf_name').val();
  var wf_temp = $('textarea#wf_templt').val();
  seted_url = "<?php echo base_url('/Workflow/save_new_wf');?>";
  $.ajax({
    type : 'POST',
    url : seted_url,
    data : {wf_name:wf_name, wf_temp:wf_temp},
    dataType : "JSON",
    success: function(data) {

      if(data['confirm']==0){

      }else {
        window.location = "<?php echo base_url('Workflow');?>"
      }
    }
  });
}

function save_cdata_wf(id){
  var wf_name = $('input#wf_name').val();
  var wf_temp = $('textarea#wf_templt').val();

  //console.log(wf_name,wf_temp);
  if(wf_name!=''){
    seted_url = "<?php echo base_url('/Workflow/save_change_wf');?>";
    $.ajax({
      type : 'POST',
      url : seted_url,
      data : {id:id, wf_name:wf_name, wf_temp:wf_temp},
      dataType : "JSON",
      success: function(data) {

        if(data['confirm']==0){

        }else {

        }
      }
    });
  }

}
</script>
