<!-- library d3-->
<script src="<?php echo base_url(); ?>assetsnew/js/d3.v3.min.js"></script>
<script src="<?php echo base_url(); ?>assetsnew/js/d3.layout.cloud.js" charset="utf-8"></script>
<style>
.body svg{
  width: 100% !important;
}
</style>
<!-- row begin -->
<div class="row">
  <!-- col-6 begin -->
  <div class="col-6">
    <p class="title-secondary">Latest Workflow</p>
    <div class="box">
      <div class="box-body">
        <div class="container">
          <ul class="progressbar">
            <li class="actives">Project Leader</li>
            <li class="actives"><button class="button-primary" name="button">Completed</button>HRD</li>
            <li>Manager</li>
            <li>Finance</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- col-6 end -->

  <!-- col-6 begin -->
  <div class="col-6">
    <!-- col-12 begin -->
    <div class="col-12 no-padding">
      <div class="col-5 no-padding">
        <p class="title-secondary"> Workflow Summary</p>
      </div>
      <div class="col-7">
        <ul class="dashboard-filter">
          <li><button class="button-primary">Daily</button></li>
          <li><button class="button-default">Weekly</button></li>
          <li><button class="button-default">Monthly</button></li>
        </ul>
      </div>
    </div>
    <!-- col-6 end -->

    <!-- col-12 begin -->
    <div class="col-12 no-padding">
      <div class="col-4 no-padding">
        <div class="box">
          <div class="box-body" style="">
            <div class="summary-content">
              <div class="image-circle" style="background:#ffa616;">
                <p style="padding-top:15px; font-size:35px">100</p>
              </div>
              <div style="display:inline-flex">
                <p style="margin-right:5px; font-size:12px">Total Workflow</p>
                <div class="circle" style="background:#ffa616;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4 no-padding">
        <div class="box">
          <div class="box-body" style=";">
            <div class="summary-content">
              <div class="image-circle" style="background:#1774f0;">
                <p style="padding-top:15px; font-size:35px">150</p>
              </div>
              <div style="display:inline-flex">
                <p style="margin-right:5px;font-size:12px">Approved </p>
                <div class="circle" style="background:#1774f0;">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-4 no-padding">
        <div class="box">
          <div class="box-body" style="">
            <div class="summary-content">
              <div class="image-circle" style="background:#fe3678" >
                <p style="padding-top:15px; font-size:35px">10</p>
              </div>
              <div style="display:inline-flex">
                <p style="margin-right:5px;font-size:12px">OnProgress</p>
                <div class="circle" style="background:#fe3678;">
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- col-12 end -->
  </div>
  <!-- col-6 end -->
</div>
<!-- row end -->

<!-- row begin-->
<div class="row">
  <!-- col-6 begin -->
  <div class="col-6">
    <div class="col-6 no-padding">
      <p class="title-secondary">Recent Access</p>
      <div class="box">
        <div class="box-header">
          <div class="pull-right">
            <button type="button" class="button-primary" name="button">View All</button>
          </div>
        </div>
        <div class="box-body">
          <ul class="recent-activity">
            <li><img src="<?php echo base_url(); ?>/assets/SVG_dark/pdf.svg" alt="" class="image-user"><span class="file-name">Report RAT.pdf</span><span class="time">09.00</span></li>
            <li><img src="<?php echo base_url(); ?>/assets/SVG_dark/xls.svg" alt="" class="image-user"><span class="file-name">Billing draft.xls </span><span class="time">08.30</span></li>
            <li><img src="<?php echo base_url(); ?>/assets/SVG_dark/archieved.svg" alt="" class="image-user"><span  class="file-name">Report.zip</span><span class="time">08.00</span></li>
            <li><img src="<?php echo base_url(); ?>/assets/SVG_dark/doc.svg" alt="" class="image-user"><span  class="file-name">POC plan.doc</span><span class="time">07.15</span></li>
          </ul>
        </div>
      </div>
    </div>
    <div class="col-6 no-padding">
      <p class="title-secondary">Recent Upload</p>
      <div class="box">
        <div class="box-header">
          <div class="pull-right">
            <button type="button" class="button-primary" name="button">View All</button>
          </div>
        </div>
        <div class="box-body">
          <ul class="recent-activity">
            <li><img src="<?php echo base_url(); ?>/assets/SVG_dark/doc.svg" alt="" class="image-user"><span class="file-name">POC plan.doc</span><span class="time">09.00</span></li>
            <li><img src="<?php echo base_url(); ?>/assets/SVG_dark/xls.svg" alt="" class="image-user"><span class="file-name">Billing draft.xls </span><span class="time">08.30</span></li>
            <li><img src="<?php echo base_url(); ?>/assets/SVG_dark/file-ppt.svg" alt="" class="image-user"><span  class="file-name">POC presentation.ppt</span><span class="time">08.00</span></li>
            <li><img src="<?php echo base_url(); ?>/assets/SVG_dark/pdf.svg" alt="" class="image-user"><span  class="file-name">Report RAT.pdf</span><span class="time">07.15</span></li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- col-6 end -->

  <!-- col-6 begin -->
  <div class="col-6">
    <div class="col-12">
      <p class="title-secondary">Recent Activity</p>
      <div class="box">
        <div class="box-body">
          <div class="important-message">
            <ul class="recent-activity2">
              <li>
                <i class="fa fa-bookmark pull-right"></i>
              </li>
              <li>
                <img src="<?php echo base_url(); ?>/assetsnew/img/user1.jpg" alt="" class="image-user"><span class="user-name">Danang</span><span class="time">08.50</span>
                <p class="user-message">Untuk file presentasi mohon untuk dicek kembali</p>
              </li>
            </ul>
          </div>
          <ul class="recent-activity2">
            <li>
              <img src="<?php echo base_url(); ?>/assetsnew/img/user6.jpg" alt="" class="image-user"><span class="user-name">Fatkhul</span><span class="time">08.45</span>
              <p class="user-message">Report RAT siap untuk di distribusikan</p>
            </li>
            <li>
              <img src="<?php echo base_url(); ?>/assetsnew/img/user8.jpg" alt="" class="image-user"><span class="user-name">Galang</span><span class="time">08.00</span>
              <p class="user-message">Berikut daftar billing untuk bulan Mei</p>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
  <!-- col-6 end -->
</div>
<!-- row end -->

<!-- row begin -->
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
<!-- row end -->

<script>
  // manipulate top header menu
  document.getElementById('menu-title').style.display ="block";
  document.getElementById('menu-add').style.display ="none";
  document.getElementById('title').innerHTML="Dashboard";

  // manipulate menu by adding active class
  $('#Dashboard').addClass("active");

  // initialize word cloud chart data size
  var frequency_list = [{"text":"pdf","size":40},{"text":"docx","size":15},{"text":"doc","size":10},{"text":"xls","size":15},{"text":"xlsx","size":10},{"text":"ppt","size":5},{"text":"pptx","size":10},{"text":"mp3","size":5},{"text":"mp4","size":5},{"text":"flex","size":85},{"text":"mov","size":5},{"text":"txt","size":5},{"text":"laws","size":15},{"text":"speed","size":45},{"text":"velocity","size":30},{"text":"define","size":5},{"text":"constraints","size":5},{"text":"universe","size":10},{"text":"docx","size":120},{"text":"describing","size":5},{"text":"pacs","size":90},{"text":"physics-the","size":5},{"text":"world","size":10},{"text":"works","size":10},{"text":"zip","size":70},{"text":"interactions","size":30},{"text":"studies","size":5},{"text":"pdf","size":45},{"text":"nature","size":40},{"text":"branch","size":30},{"text":"concerned","size":25},{"text":"source","size":40},{"text":"google","size":10},{"text":"defintions","size":5},{"text":"two","size":15},{"text":"grouped","size":15},{"text":"traditional","size":15},{"text":"fields","size":15},{"text":"acoustics","size":15},{"text":"optics","size":15},{"text":"mechanics","size":20},{"text":"thermodynamics","size":15},{"text":"electromagnetism","size":15},{"text":"modern","size":15},{"text":"extensions","size":15},{"text":"thefreedictionary","size":15},{"text":"interaction","size":15},{"text":"org","size":25},{"text":"answers","size":5},{"text":"natural","size":15},{"text":"objects","size":5},{"text":"treats","size":10},{"text":"acting","size":5},{"text":"department","size":5},{"text":"gravitation","size":5},{"text":"heat","size":10},{"text":"light","size":10},{"text":"magnetism","size":10},{"text":"modify","size":5},{"text":"general","size":10},{"text":"bodies","size":5},{"text":"philosophy","size":5},{"text":"brainyquote","size":5},{"text":"words","size":5},{"text":"ph","size":5},{"text":"html","size":5},{"text":"lrl","size":5},{"text":"zgzmeylfwuy","size":5},{"text":"subject","size":5},{"text":"distinguished","size":5},{"text":"chemistry","size":5},{"text":"biology","size":5},{"text":"includes","size":5},{"text":"radiation","size":5},{"text":"sound","size":5},{"text":"structure","size":5},{"text":"atoms","size":5},{"text":"including","size":10},{"text":"atomic","size":10},{"text":"nuclear","size":10},{"text":"cryogenics","size":10},{"text":"solid-state","size":10},{"text":"particle","size":10},{"text":"plasma","size":10},{"text":"deals","size":5},{"text":"merriam-webster","size":5},{"text":"dictionary","size":10},{"text":"analysis","size":5},{"text":"conducted","size":5},{"text":"order","size":5},{"text":"understand","size":5},{"text":"behaves","size":5},{"text":"en","size":5},{"text":"wikipedia","size":5},{"text":"wiki","size":5},{"text":"physics-","size":5},{"text":"physical","size":5},{"text":"behaviour","size":5},{"text":"collinsdictionary","size":5},{"text":"english","size":5},{"text":"time","size":35}];

  // styling word cloud chart color
  var color = d3.scale.linear()
  .domain([0,1,2,3,4,5,6,10,15,20,100])
  .range(["#1774f0", "#ccc", "#ffa616", "#bbb", "#55b776", "#fe3678", "#ffe800", "#5b5b5c", "#02459e", "#444",  "#222", "#69a2f2",]);
  d3.layout.cloud().size([800, 300])
  .words(frequency_list)
  .rotate(0)
  .fontSize(function(d) { return d.size; })
  .on("end", draw)
  .start();

  // initialize word cloud chart
  function draw(words) {
    d3.select(".body").append("svg")
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
