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
              margin: 2,
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
            {  margin: 2, width: 35, height: 35 },
              new go.Binding("source", "path")),
          $(go.TextBlock,
            {
              font: " 9pt Helvetica, Arial, sans-serif",
              stroke: "black",
              margin: 2,
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
            {   margin: 2, width: 35, height: 35 },
              new go.Binding("source", "path")),
          $(go.TextBlock,
            {
              font: " 9pt Helvetica, Arial, sans-serif",
              stroke: "black",
              margin: 2,
              maxSize: new go.Size(160, NaN),
              wrap: go.TextBlock.WrapFit,
              textAlign: "center",
              // editable: true,
               width: 60 //, height: 33
            },
            new go.Binding("text").makeTwoWay())
        ),
        // four named ports, one on each side:
       // makePort("T", go.Spot.Top, true, true),
        //makePort("L", go.Spot.Left, true, true),
        //makePort("R", go.Spot.Right, true, true),
        //makePort("B", go.Spot.Bottom, true, true)
      ));

      myDiagram.nodeTemplateMap.add("Copy",  // the default category
      $(go.Node, "Spot", nodeStyle(),
        // the main object is a Panel that surrounds a TextBlock with a rectangular Shape
        $(go.Shape, "RoundedRectangle",
            { fill: "#E0E8FF", stroke: null, width: 65/*, height: 60*/},
            new go.Binding("figure", "figure")),
        $(go.Panel, "Vertical",
          $(go.Picture, "<?php echo base_url()?>assets/ico/copy.png",
            {  margin: 2, width: 35, height: 35 },
              new go.Binding("source", "path")),
          $(go.TextBlock,
            {
              font: " 9pt Helvetica, Arial, sans-serif",
              stroke: "black",
              margin: 2,
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
        //makePort("R", go.Spot.Right, true, true),
        //makePort("B", go.Spot.Bottom, true, true)
      ));

      myDiagram.nodeTemplateMap.add("Storage",  // the default category
      $(go.Node, "Spot", nodeStyle(),
        // the main object is a Panel that surrounds a TextBlock with a rectangular Shape
        $(go.Shape, "RoundedRectangle",
            { fill: "#E0E8FF", stroke: null, width: 65/*, height: 60*/},
            new go.Binding("figure", "figure")),
        $(go.Panel, "Vertical",
          $(go.Picture, "<?php echo base_url()?>assets/ico/PACS_favicon11.png",
            {  margin: 2, width: 35, height: 35 },
              new go.Binding("source", "path")),
          $(go.TextBlock,
            {
              font: " 9pt Helvetica, Arial, sans-serif",
              stroke: "black",
              margin: 2,
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
        //makePort("R", go.Spot.Right, true, true),
        //makePort("B", go.Spot.Bottom, true, true)
      ));

      myDiagram.nodeTemplateMap.add("Delete",  // the default category
      $(go.Node, "Spot", nodeStyle(),
        // the main object is a Panel that surrounds a TextBlock with a rectangular Shape
        $(go.Shape, "RoundedRectangle",
            { fill: "#E0E8FF", stroke: null, width: 65/*, height: 60*/},
            new go.Binding("figure", "figure")),
        $(go.Panel, "Vertical",
          $(go.Picture, "<?php echo base_url()?>assets/ico/del.png",
            {  margin: 2, width: 35, height: 35 },
              new go.Binding("source", "path")),
          $(go.TextBlock,
            {
              font: " 9pt Helvetica, Arial, sans-serif",
              stroke: "black",
              margin: 2,
              maxSize: new go.Size(160, NaN),
              wrap: go.TextBlock.WrapFit,
              textAlign: "center",
               //editable: true,
               width: 60 //, height: 33
            },
            new go.Binding("text").makeTwoWay())
        ),
        // four named ports, one on each side:
        //makePort("T", go.Spot.Top, false, true),
        //makePort("L", go.Spot.Left, false, true),
        //makePort("R", go.Spot.Right, false, true),
        //makePort("B", go.Spot.Bottom, false, true)
      ));
    //End of custom
    /*
    myDiagram.nodeTemplateMap.add("Start",
      $(go.Node, "Spot", nodeStyle(),
        $(go.Panel, "Auto",
          $(go.Shape, "Circle",
            { minSize: new go.Size(40, 40), fill: "#79C900", stroke: null }),
          $(go.TextBlock, "Start",
            { font: "bold 11pt Helvetica, Arial, sans-serif", stroke: lightText },
            new go.Binding("text"))
        ),
        // three named ports, one on each side except the top, all output only:
        makePort("L", go.Spot.Left, true, false),
        makePort("R", go.Spot.Right, true, false),
        makePort("B", go.Spot.Bottom, true, false)
      ));

    myDiagram.nodeTemplateMap.add("End",
      $(go.Node, "Spot", nodeStyle(),
        $(go.Panel, "Auto",
          $(go.Shape, "Circle",
            { minSize: new go.Size(40, 40), fill: "#DC3C00", stroke: null }),
          $(go.TextBlock, "End",
            { font: "bold 11pt Helvetica, Arial, sans-serif", stroke: lightText },
            new go.Binding("text"))
        ),
        // three named ports, one on each side except the bottom, all input only:
        makePort("T", go.Spot.Top, false, true),
        makePort("L", go.Spot.Left, false, true),
        makePort("R", go.Spot.Right, false, true)
      ));

    myDiagram.nodeTemplateMap.add("Comment",
      $(go.Node, "Auto", nodeStyle(),
        $(go.Shape, "File",
          { fill: "#EFFAB4", stroke: null }),
        $(go.TextBlock,
          {
            margin: 5,
            maxSize: new go.Size(200, NaN),
            wrap: go.TextBlock.WrapFit,
            textAlign: "center",
            editable: true,
            font: " 12pt Helvetica, Arial, sans-serif",
            stroke: '#454545'
          },
          new go.Binding("text").makeTwoWay())
        // no ports, because no links are allowed to connect with a comment
      ));
    */

    // replace the default Link template in the linkTemplateMap
    myDiagram.linkTemplate =
      $(go.Link,  // the whole link panel
        {
          //routing: go.Link.AvoidsNodes,
          //curve: go.Link.JumpGap, //JumpOver,//Bezier ,
          //corner: 5, toShortLength: 4,
          //relinkableFrom: true,
          //relinkableTo: true,
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
            //{ category: "Start", text: "Start" },
            //{ text: "Step", source: "https://d30y9cdsu7xlg0.cloudfront.net/png/11690-200.png" },
            //{ text: "???", figure: "Diamond" },
            //{ category: "End", text: "End" },
            //{ category: "Comment", text: "Comment" }
              { key: "Actor", category: "Actor",text: "Actor",source: "<?php echo base_url()?>assets/ico/user.png" },
              { key: "Document", category: "Document",text: "Document",source: "<?php echo base_url()?>assets/ico/doc.png" },
              { key: "Copy", category: "Copy",text: "Copy",source: "<?php echo base_url()?>assets/ico/copy.png" },
              { key: "Storage", category: "Storage",text: "Chanthel",source: "<?php echo base_url()?>assets/ico/PACS_favicon11.png" },
              { key: "Delete", category: "Delete",text: "Delete",source: "<?php echo base_url()?>assets/ico/del.png" }
          ])
        });
  } // end init

  // Make all ports on a node visible when the mouse is over the node
  /*
  function showPorts(node, show) {
    var diagram = node.diagram;
    if (!diagram || diagram.isReadOnly || !diagram.allowLink) return;
    node.ports.each(function(port) {
        port.stroke = (show ? "white" : null);
      });
  }*/


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
      <div class="create-newitem-container " id="confirmation" style="margin-top:100px;" align="center">
        <div class="create-newitem-content del_wf_content" >

        </div>
        <div class="create-newitem-footer del_wf_footer" align="right">
          <button type="button" class="button-default" onclick="close_delwf()" >Close</button>

        </div>
      </div>
<body onload="init()">
  <div class="row">
    <div class="col-12" style="height:80px;padding-left: 20px;">
      <div class="col-9 " style="padding:25px;">
        <div class="form-group" >
          <h2> </h2>
        </div>
      </div>
      <div class="col-3 " style="padding:25px;">
        <!--<button type="button" class="button-secondary" id="SaveCButton" style="left:0;display:none;">Save Change</button>
        <button type="button" class="button-primary" id="SaveButton" onclick="save()" style="left:0;">Save</button>
        -->
        <button type="button" class="button-danger" onclick="show_togle(<?php echo $wf_id;?>)"> Delete </button>
        <button type="button" class="button-default" id="CloseButton" onclick="close_wf()" style="left:0;">Close</button>
      </div>
    </div>
  </div>
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
<script type="text/javascript">
$('#Workflow').addClass("active");

   function close_wf(){
      window.location = "<?php echo base_url('Workflow');?>";
      //window.history.back();
    }
      document.getElementById('menu-title').style.display ="block";
      document.getElementById('menu-add').style.display ="none";
      document.getElementById('title').innerHTML="<?php echo $wf_name;?>";

  </script>
  <script type="text/javascript">
    function save_data_wf(){
       var wf_name = $('input#wf_name').val();
        var wf_temp = $('textarea#wf_templt').val();

      //console.log(wf_name,wf_temp);
      seted_url = "<?php echo base_url('/Workflow/save_new_wf');?>";
       $.ajax({
        type : 'POST',
        url : seted_url,
        data : {wf_name:wf_name, wf_temp:wf_temp},
        dataType : "JSON",
        success: function(data) {

              if(data['confirm']==0){

              }else {
                id = data['confirm'];
                $("#SaveButton").css('display','none');
                $("#SaveCButton").css('display','inline');
                $("#SaveCButton").attr('onclick', 'save_change('+id+')');
              }
              //console.log(data['confirm'],id);
        }
      });
    }

    function save_cdata_wf(id){
        var wf_name = $('input#wf_name').val();
        var wf_temp = $('textarea#wf_templt').val();

      //console.log(wf_name,wf_temp);
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
              //console.log(data['confirm'],id);
        }
      });
    }

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
  </script>

</body>
