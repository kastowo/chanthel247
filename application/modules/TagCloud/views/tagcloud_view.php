<!-- library d3 nvd3-->
<script src="http://d3js.org/d3.v3.min.js"></script>
<script src="<?php echo base_url(); ?>/assetsnew/js/d3.layout.cloud.js" charset="utf-8"></script>

       
        <div class="row">
          <div class="col-12">
            <p class="title-secondary">File Overview</p>
            <div class="col-12 no-padding">
              <div class="box">
                <div class="box-body">
                  <div class="body">

                  </div>
                  <div style="width: 100%;">
                    <div class="legend">
                      Commonly used extension in this mechine.
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

<script>
  document.getElementById('menu-title').style.display ="block";
  document.getElementById('menu-add').style.display ="none";
  document.getElementById('title').innerHTML="Tag Cloud";

  $('#TagCloud').addClass("active");


var frequency_list = [{"text":"pdf","size":40},{"text":"docx","size":15},{"text":"doc","size":10},{"text":"xls","size":15},{"text":"xlsx","size":10},{"text":"ppt","size":5},{"text":"pptx","size":10},{"text":"mp3","size":5},{"text":"mp4","size":5},{"text":"flex","size":85},{"text":"mov","size":5},{"text":"txt","size":5},{"text":"laws","size":15},{"text":"speed","size":45},{"text":"velocity","size":30},{"text":"define","size":5},{"text":"constraints","size":5},{"text":"universe","size":10},{"text":"docx","size":120},{"text":"describing","size":5},{"text":"pacs","size":90},{"text":"physics-the","size":5},{"text":"world","size":10},{"text":"works","size":10},{"text":"zip","size":70},{"text":"interactions","size":30},{"text":"studies","size":5},{"text":"pdf","size":45},{"text":"nature","size":40},{"text":"branch","size":30},{"text":"concerned","size":25},{"text":"source","size":40},{"text":"google","size":10},{"text":"defintions","size":5},{"text":"two","size":15},{"text":"grouped","size":15},{"text":"traditional","size":15},{"text":"fields","size":15},{"text":"acoustics","size":15},{"text":"optics","size":15},{"text":"mechanics","size":20},{"text":"thermodynamics","size":15},{"text":"electromagnetism","size":15},{"text":"modern","size":15},{"text":"extensions","size":15},{"text":"thefreedictionary","size":15},{"text":"interaction","size":15},{"text":"org","size":25},{"text":"answers","size":5},{"text":"natural","size":15},{"text":"objects","size":5},{"text":"treats","size":10},{"text":"acting","size":5},{"text":"department","size":5},{"text":"gravitation","size":5},{"text":"heat","size":10},{"text":"light","size":10},{"text":"magnetism","size":10},{"text":"modify","size":5},{"text":"general","size":10},{"text":"bodies","size":5},{"text":"philosophy","size":5},{"text":"brainyquote","size":5},{"text":"words","size":5},{"text":"ph","size":5},{"text":"html","size":5},{"text":"lrl","size":5},{"text":"zgzmeylfwuy","size":5},{"text":"subject","size":5},{"text":"distinguished","size":5},{"text":"chemistry","size":5},{"text":"biology","size":5},{"text":"includes","size":5},{"text":"radiation","size":5},{"text":"sound","size":5},{"text":"structure","size":5},{"text":"atoms","size":5},{"text":"including","size":10},{"text":"atomic","size":10},{"text":"nuclear","size":10},{"text":"cryogenics","size":10},{"text":"solid-state","size":10},{"text":"particle","size":10},{"text":"plasma","size":10},{"text":"deals","size":5},{"text":"merriam-webster","size":5},{"text":"dictionary","size":10},{"text":"analysis","size":5},{"text":"conducted","size":5},{"text":"order","size":5},{"text":"understand","size":5},{"text":"behaves","size":5},{"text":"en","size":5},{"text":"wikipedia","size":5},{"text":"wiki","size":5},{"text":"physics-","size":5},{"text":"physical","size":5},{"text":"behaviour","size":5},{"text":"collinsdictionary","size":5},{"text":"english","size":5},{"text":"time","size":35}];


  var color = d3.scale.linear()
          .domain([0,1,2,3,4,5,6,10,15,20,100])
          .range(["#1774f0", "#ccc", "#ffa616", "#bbb", "#55b776", "#fe3678", "#ffe800", "#5b5b5c", "#02459e", "#444",  "#222", "#69a2f2",]);
  d3.layout.cloud().size([800, 300])
          .words(frequency_list)
          .rotate(0)
          .fontSize(function(d) { return d.size; })
          .on("end", draw)
          .start();

  function draw(words) {
      d3.select(".body").append("svg")
              .attr("width", 850)
              .attr("height", 350)
              .attr("class", "wordcloud")
              .append("g")
              // without the transform, words words would get cutoff to the left and top, they would
              // appear outside of the SVG area
              .attr("transform", "translate(320,200)")
              .selectAll("text")
              .data(words)
              .enter().append("text")
              .style("font-size", function(d) { return d.size + "px"; })
              .style("fill", function(d, i) { return color(i); })
              .attr("transform", function(d) {
                  return "translate(" + [d.x, d.y] + ")rotate(" + d.rotate + ")";
              })
              .text(function(d) { return d.text; });
  }

  
</script>
