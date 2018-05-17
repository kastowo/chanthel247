<script type="text/javascript" src="<?php echo base_url('assets/gojs/go-debug.js')?>"></script>
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
        locationSpot: go.Spot.Center,
        //isShadowed: true,
        //shadowColor: "#888",
        // handle mouse enter/leave events to show/hide the ports
        //mouseEnter: function (e, obj) { showPorts(obj.part, true); },
        //mouseLeave: function (e, obj) { showPorts(obj.part, false); }
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

  myDiagram.nodeTemplateMap.add("",  // the default category
  $(go.Node, "Spot", nodeStyle(),
  // the main object is a Panel that surrounds a TextBlock with a rectangular Shape
  //$(go.Shape, "RoundedRectangle",
  //    { fill: "#E0E8FF", stroke: "gray", width: 50, height: 50},
  //    new go.Binding("figure", "figure")),
  $(go.Panel, "Vertical",
  $(go.Picture,
    { margin: 2, width: 26, height: 26 },
    new go.Binding("source")),
    $(go.TextBlock,
      {
        font: " 9pt Helvetica, Arial, sans-serif",
        stroke: "gray",
        margin: 5,
        maxSize: new go.Size(160, NaN),
        wrap: go.TextBlock.WrapFit,
        editable: true
        //width: 90, height: 33
      },
      new go.Binding("text").makeTwoWay())
    ),
    // four named ports, one on each side:
    makePort("T", go.Spot.Top, false, true),
    makePort("L", go.Spot.Left, true, true),
    makePort("R", go.Spot.Right, true, true),
    makePort("B", go.Spot.Bottom, true, false)
  ));


  //custom by fly_247
  myDiagram.nodeTemplateMap.add("Actor",  // the default category
  $(go.Node, "Spot", nodeStyle(),
  // the main object is a Panel that surrounds a TextBlock with a rectangular Shape
  $(go.Shape, "RoundedRectangle",
  { fill: "#E0E8FF", stroke: null, width: 65/*, height: 60*/},
  new go.Binding("figure", "figure")),
  $(go.Panel, "Vertical",
  $(go.Picture,  "<?php echo base_url()?>assets/ico/user.png",
  {  margin: 5, width: 20, height: 20 },
  new go.Binding("source", "path")),
  $(go.TextBlock,
    {
      font: " 9pt Helvetica, Arial, sans-serif",
      stroke: "black",
      margin: 5,
      maxSize: new go.Size(160, NaN),
      wrap: go.TextBlock.WrapFit,
      textAlign: "center",
      // editable: true,
      width: 60 //, height: 33
    },
    new go.Binding("text").makeTwoWay())
  ),
  // four named ports, one on each side:
  //makePort("T", go.Spot.Top, true, true),
  //makePort("L", go.Spot.Left, true, true),
  // makePort("R", go.Spot.Right, true, true),
  // makePort("B", go.Spot.Bottom, true, true)
));

myDiagram.nodeTemplateMap.add("Document",  // the default category
$(go.Node, "Spot", nodeStyle(),
// the main object is a Panel that surrounds a TextBlock with a rectangular Shape
$(go.Shape, "RoundedRectangle",
{ fill: "#E0E8FF", stroke: null, width: 65/*, height: 60*/},
new go.Binding("figure", "figure")),
$(go.Panel, "Vertical",
$(go.Picture, "<?php echo base_url()?>assets/ico/doc.png",
{   margin: 5, width: 20, height: 20 },
new go.Binding("source", "path")),
$(go.TextBlock,
  {
    font: " 9pt Helvetica, Arial, sans-serif",
    stroke: "black",
    margin: 5,
    maxSize: new go.Size(160, NaN),
    wrap: go.TextBlock.WrapFit,
    textAlign: "center",
    // editable: true,
    width: 60 //, height: 33
  },
  new go.Binding("text").makeTwoWay())
),

));

myDiagram.nodeTemplateMap.add("Copy",  // the default category
$(go.Node, "Spot", nodeStyle(),
// the main object is a Panel that surrounds a TextBlock with a rectangular Shape
$(go.Shape, "RoundedRectangle",
{ fill: "#E0E8FF", stroke: null, width: 65/*, height: 60*/},
new go.Binding("figure", "figure")),
$(go.Panel, "Vertical",
$(go.Picture, "<?php echo base_url()?>assets/ico/copy.png",
{  margin: 5, width: 25, height: 25 },
new go.Binding("source", "path")),
$(go.TextBlock,
  {
    font: " 9pt Helvetica, Arial, sans-serif",
    stroke: "black",
    margin: 5,
    maxSize: new go.Size(160, NaN),
    wrap: go.TextBlock.WrapFit,
    textAlign: "center",
    // editable: true,
    width: 60 //, height: 33
  },
  new go.Binding("text").makeTwoWay())
),

));

myDiagram.nodeTemplateMap.add("Storage",  // the default category
$(go.Node, "Spot", nodeStyle(),
// the main object is a Panel that surrounds a TextBlock with a rectangular Shape
$(go.Shape, "RoundedRectangle",
{ fill: "#E0E8FF", stroke: null, width: 65/*, height: 60*/},
new go.Binding("figure", "figure")),
$(go.Panel, "Vertical",
$(go.Picture, "<?php echo base_url()?>assets/ico/PACS_favicon11.png",
{  margin: 5, width: 20, height: 20 },
new go.Binding("source", "path")),
$(go.TextBlock,
  {
    font: " 9pt Helvetica, Arial, sans-serif",
    stroke: "black",
    margin: 5,
    maxSize: new go.Size(160, NaN),
    wrap: go.TextBlock.WrapFit,
    textAlign: "center",
    // editable: true,
    width: 60 //, height: 33
  },
  new go.Binding("text").makeTwoWay())
),

));

myDiagram.nodeTemplateMap.add("Delete",  // the default category
$(go.Node, "Spot", nodeStyle(),
// the main object is a Panel that surrounds a TextBlock with a rectangular Shape
$(go.Shape, "RoundedRectangle",
{ fill: "#E0E8FF", stroke: null, width: 65/*, height: 60*/},
new go.Binding("figure", "figure")),
$(go.Panel, "Vertical",
$(go.Picture, "<?php echo base_url()?>assets/ico/del.png",
{  margin: 5, width: 20, height: 20 },
new go.Binding("source", "path")),
$(go.TextBlock,
  {
    font: " 9pt Helvetica, Arial, sans-serif",
    stroke: "black",
    margin: 5,
    maxSize: new go.Size(160, NaN),
    wrap: go.TextBlock.WrapFit,
    textAlign: "center",
    //editable: true,
    width: 60 //, height: 33
  },
  new go.Binding("text").makeTwoWay())
),

));
//End of custom





myDiagram.addDiagramListener("ObjectDoubleClicked",
function(e) {
  var part = e.subject.part;
  it_key = part.data.key
  //console.log(it_key);
  show_ac(it_key);
  //if (!(part instanceof go.Link)) showMessage("Clicked on " + part.data.key);
});




// replace the default Link template in the linkTemplateMap
myDiagram.linkTemplate =
$(go.Link,  // the whole link panel
  {

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
    myDiagram.toolManager.linkingTool.temporaryLink.routing = go.Link.Normal;// Orthogonal ; //Orthogonal
    myDiagram.toolManager.relinkingTool.temporaryLink.routing = go.Link.Normal;//Orthogonal; ; //Orthogonal

    load();  // load an initial diagram from some JSON text

    // initialize the Palette that is on the left side of the page
    myPalette =
    $(go.Palette, "myPaletteDiv",  // must name or refer to the DIV HTML element
    {
      scrollsPageOnFocus: false,
      nodeTemplateMap: myDiagram.nodeTemplateMap,  // share the templates used by myDiagram
      model: new go.GraphLinksModel([  // specify the contents of the Palette

        { key: "Actor", category: "Actor",text: "Actor",source: "<?php echo base_url()?>assets/ico/user.png" },
        { key: "Document", category: "Document",text: "Document",source: "<?php echo base_url()?>assets/ico/doc.png" },
        { key: "Copy", category: "Copy",text: "Copy",source: "<?php echo base_url()?>assets/ico/copy.png" },
        { key: "Storage", category: "Storage",text: "Chanthel",source: "<?php echo base_url()?>assets/ico/PACS_favicon11.png" },
        { key: "Delete", category: "Delete",text: "Delete",source: "<?php echo base_url()?>assets/ico/del.png" }
      ])
    });


  } // end init

  // Make all ports on a node visible when the mouse is over the node


  // Show the diagram's model in JSON format that the user may edit
  function save() {
    document.getElementById("wf_templt").value = myDiagram.model.toJson();
    myDiagram.isModified = false;
    save_data_wf();
  }
  //costom by fly
  function save_change(id){
    document.getElementById("wf_templt").value = myDiagram.model.toJson();
    myDiagram.isModified = false;
    save_cdata_wf(id);
  }

  function load() {
    myDiagram.model = go.Model.fromJson(document.getElementById("wf_templt").value);
  }

  // add an SVG rendering of the diagram at the end of this page
  function makeSVG() {
    var svg = myDiagram.makeSvg({
      scale: 0.5
    });
    svg.style.border = "1px solid black";
    obj = document.getElementById("SVGArea");
    obj.appendChild(svg);
    if (obj.children.length > 0) {
      obj.replaceChild(svg, obj.children[0]);
    }
  }
</script>

<body onload="init()">
  <div class="row">
    <div class="col-12 text-right" style="margin-bottom:20px">
      <button type="button" class="button-default" id="CloseButton" onclick="close_wf()" style="left:0;">Close</button>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      <div id="sample">
        <div style="width: 100%; display: flex; justify-content: space-between">
          <div id="myPaletteDiv" style="display:none;width: 100px; margin-right: 2px; background-color: white; border: solid 0px black"></div>
          <div id="myDiagramDiv" style="flex-grow: 1; height: 720px; border: solid 1px silver"></div>
        </div>

        <!--Diagram Model saved in JSON format: -->
        <textarea id="wf_templt" style="width:100%;height:300px;display:none;">
          <?php echo $wf_templ;?>
        </textarea>
      </div>
    </div>
  </div>

  <div class="create-newitem-container " id="confirmation" style="margin-top:100px;" align="center">
    <div class="create-newitem-content del_wf_content" >

    </div>
    <div class="create-newitem-footer del_wf_footer" align="right">
      <button type="button" class="button-default" onclick="close_delwf()" >Close</button>

    </div>
  </div>

  <!--Togel of node-->
  <style type="text/css">
  .node_s{
    /*width:700px;
    min-height:480px;
    margin-top:25px;
    margin-left: 48px;
    border:solid 2px #428bca;
    padding: 10px;*/
  }
  .node_s_title{
    font-weight: 10px;
  }
  .file_bar{
    overflow-y: auto;
    height:200px;
  }
  .node_s_content{
    height:250px;
    padding:20px;


  }
  .ctn-txt{
    min-width: 60%;
    min-height: 100px;
    padding-left:50px;
  }
  .get_dir{
    margin-top:10px;
  }
  </style>
  <!--Fathul-->
  <div class="create-newitem-container node_s" id="Actor2">
    <div class="create-newitem-heade node_s_title Actor_title">
      <p>Fathul Reviews</p>
    </div>
    <div class="get_dir">
      <div class="col-9">
        <div class="form-group">

          <input type="text" id="dir_pth_Actor2" class="form-control" name="dir_pth" placeholder="Full Path Directory">

        </div>
      </div>
      <div div class="col-2">
        <button type="button"  class="button-default" onclick="load_file_node2('Actor2')">Load</button>
      </div>
    </div>
    <form id="Actor2_form">
      <div class="create-newitem-content file_bar node_s_content Actor2_content" >
        <p>No Exist File</p>
      </div>
    </form>
    <div class="create-newitem-footer del_wf_footer" align="right">
      <button type="button" class="button-primary app-Actor2" onclick="actor2_approve('Interest')" style="display:inline;">Approve</button>
      <button type="button" class="button-danger app-Actor2" onclick="actor2_reject('Not')" style="display:inline;">Reject</button>
      <button type="button" class="button-default" onclick="close_nodes()" >Close</button>

    </div>
  </div>

  <!--Galang-->
  <div class="create-newitem-container node_s" id="Actor3" style="margin-top:100px;" align="center">
    <div class="create-newitem-title node_s_title Actor_title">
      <b>Galang Review</b>
    </div>
    <div class="get_dir">
      <div class="col-9">
        <div class="form-group">
          <input type="text" id="dir_pth_Actor3" class="form-control" name="dir_pth" placeholder="Full Path Directory">
        </div>
      </div>
      <div div class="col-2">
        <button type="button"  class="button-default" onclick="load_file_node2('Actor3')">Load</button>
      </div>
    </div>
    <form id="Actor3_form">
      <div class="create-newitem-content file_bar node_s_content Actor3_content" >
        <p>Non Exist File</p>
      </div>
      <!--
      <div class="col-11" align="left" style="border-top:2px solid #428bca; ">
      <div class="form-group Actor3_chc_g" align="left"  style="display:inline;">
      <input type="radio" name="Actor_chc" class="Actor3_chc" value="Interest" ><label for="Interest">Interest</label><br/>
      <input type="radio" name="Actor_chc" class="Actor3_chc" value="Not" ><label for="Not">Not Interest</label>
    </div>
  </div>
-->
</form>
<div class="create-newitem-footer del_wf_footer" align="right">
  <button type="button" class="button-primary app-Actor3" onclick="actor3_approve('Interest')" style="display:inline;">Approve</button>
  <button type="button" class="button-danger app-Actor3" onclick="actor3_reject('Not')" style="display:inline;">Reject</button>
  <button type="button" class="button-default" onclick="close_nodes()" >Close</button>

</div>
</div>

<!--Danang-->
<div class="create-newitem-container node_s" id="Actor4" style="margin-top:100px;" align="center">
  <div class="create-newitem-title node_s_title Actor_title">
    <b>Danang Review</b>
  </div>
  <div class="get_dir">
    <div class="col-9">
      <div class="form-group">
        <input type="text" id="dir_pth_Actor4" class="form-control" name="dir_pth" placeholder="Full Path Directory">
      </div>
    </div>
    <div div class="col-2">
      <button type="button"  class="button-default" onclick="load_file_node2('Actor4')">Load</button>
    </div>
  </div>
  <form id="Actor4_form">
    <div class="create-newitem-content file_bar node_s_content Actor4_content" >
      <p>Non Exist File</p>
    </div>
    <!--
    <div class="col-11" align="left" style="border-top:2px solid #428bca; ">
    <div class="form-group Actor4_chc_g" style="display:inline;">
    <input type="radio" name="Actor_chc" class="Actor4_chc" value="Interest" ><label for="Interest">Interest</label><br/>
    <input type="radio" name="Actor_chc" class="Actor4_chc" value="Not" ><label for="Not">Not Interest</label>
  </div>
</div>-->
</form>
<div class="create-newitem-footer del_wf_footer" align="right">
  <button type="button" class="button-primary app-Actor4" onclick="actor4_approve('Interest')" style="display:inline;">Approve</button>
  <button type="button" class="button-danger app-Actor4" onclick="actor4_reject('Not')" style="display:inline;">Reject</button>
  <button type="button" class="button-default" onclick="close_nodes()" >Close</button>

</div>
</div>
<!--Guntur 2-->
<div class="create-newitem-container node_s" id="Actor5" style="margin-top:100px;" align="center">
  <div class="create-newitem-title node_s_title Actor_title">
    <b>Guntur Process to Hire</b>
  </div>
  <form id="Actor5_form">
    <div class="create-newitem-content file_bar node_s_content Actor5_content" >
      <p>Non Exist File</p>
    </div>
    <div class="actor5_from_info" align="left">
    </div>
  </form>
  <div class="create-newitem-footer del_wf_footer" align="right">
    <button type="button" class="button-default" onclick="close_nodes()" >Close</button>

  </div>
</div>
<!--HR-->
<div class="create-newitem-container node_s" id="Actor6" style="margin-top:100px;" align="center">
  <div class="create-newitem-title node_s_title Actor_title">
    <b>HR</b>
  </div>
  <form id="Actor6_form">
    <div class="create-newitem-content file_bar node_s_content Actor6_content" >
      <p>Non Exist File</p>
    </div>
    <div class="actor6_from_info" align="left" style="margin-top:-25px;height:100px;overflow-y: auto;">
    </div>
  </form>
  <div class="create-newitem-footer del_wf_footer" align="right">
    <button type="button" class="button-danger app-Actor6" onclick="actor6_approve()" style="display:inline;">Delete</button>
    <button type="button" class="button-default" onclick="close_nodes()" >Close</button>

  </div>
</div>

<!--Storage-->
<div class="create-newitem-container node_s" id="Storage" style="margin-top:100px;" align="center">
  <div class="create-newitem-title node_s_title Storage_title">
    <b>Store Resume Marketing Candidate</b>
  </div>
  <div class="create-newitem-content node_s_content Storage_content" style="overflow-y: auto;">
    <p>Non Exist File</p>
  </div>

  <div class="Storage_from_info" align="left" style="margin-top:-25px;height:100px;overflow-y: auto;">
  </div>
  <div class="create-newitem-footer del_wf_footer" align="right">
    <button type="button" class="button-default" onclick="close_nodes()" >Close</button>

  </div>
</div>

<!--Storage2-->
<div class="create-newitem-container node_s" id="Storage2" style="margin-top:100px;" align="center">
  <div class="create-newitem-title node_s_title Storage2_title">
    <b>Store Resume Accounting Candidate</b>
  </div>
  <div class="create-newitem-content node_s_content Storage2_content" style="overflow-y: auto;">
    <p>Non Exist File</p>
  </div>

  <div class="Storage2_from_info" align="left" style="margin-top:-25px;height:100px;overflow-y: auto;">
  </div>
  <div class="create-newitem-footer del_wf_footer" align="right">
    <button type="button" class="button-default" onclick="close_nodes()" >Close</button>

  </div>
</div>

<!--Storage3-->
<div class="create-newitem-container node_s" id="Storage3" style="margin-top:100px;" align="center">
  <div class="create-newitem-title node_s_title Storage3_title">
    <b>Store Resume IT Candidate</b>
  </div>
  <div class="create-newitem-content node_s_content Storage3_content" style="overflow-y: auto;">
    <p>Non Exist File</p>
  </div>

  <div class="Storage3_from_info" align="left" style="margin-top:-25px;height:100px;overflow-y: auto;">
  </div>
  <div class="create-newitem-footer del_wf_footer" align="right">
    <button type="button" class="button-default" onclick="close_nodes()" >Close</button>

  </div>
</div>

<!--Delete-->
<div class="create-newitem-container node_s" id="Delete" style="margin-top:100px;" align="center">
  <div class="create-newitem-title node_s_title Delete_title">
    <b>Delete Resume if No Hire</b>
  </div>
  <div class="create-newitem-content node_s_content Delete_content" >
    <p>Non Exist File</p>
  </div>

  <div class="Delete_from_info" align="left" style="margin-top:-25px;height:100px;overflow-y: auto;">
  </div>
  <div class="create-newitem-footer del_wf_footer" align="right">
    <button type="button" class="button-default" onclick="close_nodes()" >Close</button>

  </div>
</div>


<script type="text/javascript">
$( document ).ready(function() {
  $('#dir_pth_Actor2').val('/var/www/html/chanthel/scanner/');
  $('#dir_pth_Actor3').val('/var/www/html/chanthel/scanner/');
  $('#dir_pth_Actor4').val('/var/www/html/chanthel/scanner/');
  load_file_node2('Actor2');
  load_file_node2('Actor3');
  load_file_node2('Actor4');
});

function preview_f(obj){
  var text = $(obj).text();
  var cls = $(obj).attr("class");
  var dir_url=$('#dir_pth_'+String(cls)).val();

  console.log(text,cls,dir_url);
  seted_url = "<?php echo base_url('/Workflow/set_preview');?>";
  $.ajax({
    type : 'POST',
    url : seted_url,
    data : {file:text,dir_url:dir_url},
    dataType : "JSON",
    success: function(data) {
      console.log(data['feed']);
      $('.preview-container').addClass("shown");
      $('#reader-content').html('<iframe src="<?php echo base_url();?>Workflow/frame" width="100%" height="600px"></iframe>');
    }
  });

}
</script>
<script type="text/javascript">


</script>
<script type="text/javascript">
$('#Workflow').addClass("active");

function close_wf(){
  window.location = "<?php echo base_url('Workflow');?>";
  //window.history.back();
}
document.getElementById('menu-title').style.display ="block";
document.getElementById('menu-add').style.display ="none";
document.getElementById('title').innerHTML="<?php echo $wf_name;?>";

function show_togle(id){
  commant = $('.wf_name').text();
  $('#confirmation').addClass('shown');
  $('.del_wf_content').html('<h3>Are you sure to delete Workflow '+commant+' ?</h3>');
  $('.del_wf_footer').prepend('<button type="button" class="button-danger ok_del" onclick="delete_workflow('+id+')" >Ok</button>');
}

function delete_workflow(id){
  close_delwf();
  commant = $('.wf_name').text();
  seted_url = "<?php echo base_url('/Workflow/delete_wf');?>";
  $.ajax({
    type : 'POST',
    url : seted_url,
    data : {id:id},
    //dataType : "JSON",
    success: function(data) {
      window.location = "<?php echo base_url('Workflow');?>";
    }
  });
}

function close_delwf() {
  $("#confirmation").removeClass("shown");
  $('.ok_del').remove();
}

function show_ac(it_key){
  $("#"+String(it_key)).addClass("shown");
  $("#cover").css("display", "block");

  if(it_key=="Actor"){
    load_files();
  }
  else {
    load_file_node(it_key); //Actor2_content
  }
}

function close_nodes(){
  $('.node_s').removeClass("shown");
  $("#cover").css("display", "none");
}
var show_file = '';



function load_files(){
  dir_url=$('#dir_pth').val();
  seted_url="<?php echo base_url('/Workflow/set_file_list');?>";
  //console.log(dir_url);
  $.ajax({
    type : 'POST',
    url : seted_url,
    data : {dir_url:dir_url},
    dataType : "JSON",
    success: function(data) {
      $('.file_bar_actor').html(data['file']);
    }
  });
}


function load_file_node(it_key){
  seted_url = "<?php echo base_url('/Workflow/set_file_node');?>";
  //console.log(dir_url);
  $.ajax({
    type : 'POST',
    url : seted_url,
    data : {it_key:it_key},
    dataType : "JSON",
    success: function(data) {
      $('.'+String(it_key)+'_content').html(data['file']);
    }
  });
}

function load_file_node2(it_key){
  dir_url=$('#dir_pth_'+String(it_key)).val();
  seted_url = "<?php echo base_url('/Workflow/set_file_node2');?>";
  //console.log(dir_url);
  $.ajax({
    type : 'POST',
    url : seted_url,
    data : {it_key:it_key,dir_url:dir_url},
    dataType : "JSON",
    success: function(data) {
      $('.'+String(it_key)+'_content').html(data['file']);
    },
    error: function (data) {
      $('.'+String(it_key)+'_content').html('<p>No File Exists</p>');
    },
  });
}

function actor2_approve(choice){
  dir_pth=$('#dir_pth_Actor2').val();
  it_key='Actor2';
  seted_data = $('#Actor2_form').serialize()+'&it_key='+it_key+'&choice='+choice+'&dir_pth='+dir_pth;
  go_move_approve(seted_data,it_key);
}
function actor2_reject(choice){
  dir_pth=$('#dir_pth_Actor2').val();
  it_key='Actor2';
  seted_data = $('#Actor2_form').serialize()+'&it_key='+it_key+'&choice='+choice+'&dir_pth='+dir_pth;
  go_move_reject(seted_data,it_key);
}

function actor3_approve(choice){
  dir_pth=$('#dir_pth_Actor3').val();
  it_key='Actor3';
  seted_data = $('#Actor3_form').serialize()+'&it_key='+it_key+'&choice='+choice+'&dir_pth='+dir_pth;
  go_move_approve(seted_data,it_key);

  setTimeout( function() {
    // create the notification
    var notification = new NotificationFx({
      message : '<p>Approved</p>',
      layout : 'growl',
      effect : 'slide',
      type : 'notice', // notice, warning or error
    });

    // show the notification
    notification.show();

  }, 1200 );
}
function actor3_reject(choice){
  dir_pth=$('#dir_pth_Actor3').val();
  it_key='Actor3';
  seted_data = $('#Actor3_form').serialize()+'&it_key='+it_key+'&choice='+choice+'&dir_pth='+dir_pth;
  go_move_reject(seted_data,it_key);
}

function actor4_approve(choice){
  dir_pth=$('#dir_pth_Actor4').val();
  it_key='Actor4';
  seted_data = $('#Actor4_form').serialize()+'&it_key='+it_key+'&choice='+choice+'&dir_pth='+dir_pth;
  go_move_approve(seted_data,it_key);
}
function actor4_reject(choice){
  dir_pth=$('#dir_pth_Actor4').val();
  it_key='Actor4';
  seted_data = $('#Actor4_form').serialize()+'&it_key='+it_key+'&choice='+choice+'&dir_pth='+dir_pth;
  go_move_reject(seted_data,it_key);
}
//Function approve for move to arsip and hire directory
function go_move_approve(seted_data,it_key){
  seted_url = "<?php echo base_url('/Workflow/go_move_approve');?>";
  console.log(seted_data);
  $.ajax({
    type : 'POST',
    url : seted_url,
    data : seted_data,
    dataType : "JSON",
    success: function(data) {
      console.log(data['n']);
      if(data['n']!='0'){
        load_file_node2(it_key);
      }
    }
  });
}
//Function reject for move to not interested
function go_move_reject(seted_data,it_key){
  seted_url = "<?php echo base_url('/Workflow/go_move_reject');?>";
  console.log(seted_data);
  $.ajax({
    type : 'POST',
    url : seted_url,
    data : seted_data,
    dataType : "JSON",
    success: function(data) {
      console.log(data['n']);
      if(data['n']!='0'){
        load_file_node2(it_key);
      }
    }
  });
}

function actor6_approve(){
  it_key='Actor6';
  seted_data = $('#Actor6_form').serialize()+'&it_key='+it_key;
  seted_url = "<?php echo base_url('/Workflow/approve_actor3');?>";
  console.log(seted_data);
  $.ajax({
    type : 'POST',
    url : seted_url,
    data : seted_data,
    dataType : "JSON",
    success: function(data) {
      console.log(data['n']);
      //if(data['n']!='0'){

      //}
    }
  });
  load_file_node(it_key);

}
</script>

</body>
