<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>/assetsnew/plugins/css/c3.css">
<!-- library d3 nvd3-->
<script src="<?php echo base_url(); ?>/assetsnew/plugins/vendor/d3.min.js" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>/assetsnew/plugins/vendor/d3.v3.min.js" charset="utf-8"></script>
<!-- library d3 c3-->
<script src="<?php echo base_url(); ?>/assetsnew/plugins/c3/c3.js" charset="utf-8"></script>
<script src="<?php echo base_url(); ?>/assetsnew/plugins/vendor/js/jquery-1.12.0.min.js"></script>
<style>
  ul.recent-activity{
    list-style: none;
    color: inherit;
    font-size: 14px;
    padding: 10px;
  }
  ul.recent-activity li{
    padding: 8px 0;
  }
  ul.recent-activity li span{
    padding-top: 13px;
  }
  .image-user{
    width: 50px;
    height: 50px;
    border-radius: 25px;
    margin-right: 10px;
    vertical-align: middle;
  }


</style>

<script>
    function getData(url)
    {
        var data = {};
         $.ajax({
            type: 'GET',
            url : url,
            async:false,
            dataType: 'json',
            success: function(datum, textStatus, jqXHR)
            {
                data = datum;
            },
            error: function(jqXHR, textStatus, errorThrown)
            {
                alert("This url can't be reach :"+url);
            }
        });

        return data;
    }

    function bytesToSize(bytes)
    {
        var sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
        if (bytes == 0) return '0 Byte';
        var i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
        return Math.round(bytes / Math.pow(1024, i), 2) + ' ' + sizes[i];
    };
</script>
<div class="row">
  <div class="col-7 no-padding">
    <div class="col-5" style="width:274px">
      <div class="box dashboard">
        <div class="box-body" id="graph_pie_1" style="min-height:185px">

        </div>
      </div>
    </div>
    <div class="col-5" style="width:275px">
      <div class="box">
        <div class="box-body" id="graph_pie_4" style="min-height:185px">

        </div>
      </div>
    </div>
    <div class="wrapper">

    </div>
    <div class="col-12">
      <div class="box">
        <div class="box-body" id="graph_pie_5" >

        </div>
      </div>
    </div>
  </div>
  <div class="col-5">
    <div class="box">
      <div class="box-header">
        <p style="font-weight:600;padding:15px 0;">Latest Upload</p>
      </div>
      <div class="box-body">
        <ul class="recent-activity" id="graph_pie_2">
<!--          <li><img src="http://placehold.it/50x50" alt="" class="image-user">Satu<span>time</span></li>
          <li><img src="http://placehold.it/50x50" alt="" class="image-user">Satu<span>time</span></li>
          <li><img src="http://placehold.it/50x50" alt="" class="image-user">Satu<span>time</span></li>
          <li><img src="http://placehold.it/50x50" alt="" class="image-user">Satu<span>time</span></li>
          <li><img src="http://placehold.it/50x50" alt="" class="image-user">Satu<span>time</span></li>
          <li><img src="http://placehold.it/50x50" alt="" class="image-user">Satu<span>time</span></li>
          <li><img src="http://placehold.it/50x50" alt="" class="image-user">Satu<span>time</span></li>-->
        </ul>

      </div>
    </div>
  </div>
</div>
<script type="text/javascript">
  document.getElementById('menu-title').style.display ="block";
  document.getElementById('menu-add').style.display ="none";
  document.getElementById('title').innerHTML="Dashboard"

        //alert("base="+"<?php //echo base_url(); ?>");// http://192.168.1.228/dhiar/chantel-civ2/

        var url_1 = "<?php echo base_url(); ?>"+"index.php/Dashboard/data_1";
        var url_2 = "<?php echo base_url(); ?>"+"index.php/Dashboard/data_2";
        var url_3 = "<?php echo base_url(); ?>"+"index.php/Dashboard/data_3";
        var url_4 = "<?php echo base_url(); ?>"+"index.php/Dashboard/data_4";
        var url_5 = "<?php echo base_url(); ?>"+"index.php/Dashboard/data_5";

        var msg_1 = "";
        var msg_4 = "";

        var arr_data_5 = [];
        var data_5 = getData(url_5);

        // {"error_code":0,"message":"Success get data for grafik 5","data":{"mp4":1,"webm":1,"doc":19}}
        if(data_5.error_code == "0")
        {
            var data = data_5.data;
            for(var i in data)
            {
                if(i != "")
                {
                    var o = {};
                    if(data.hasOwnProperty(i))
                    {
                        arr_data_5.push([i,data[i]]);
                    }
                }
            }
        }

        // -------------------------------------------------------
//alert('url_1='+url_1);
        var data_1 = getData(url_1);
        //alert('data_1='+JSON.stringify(data_1)); // data_1={"error_code":0,"message":"Success get data for grafik 1","data":{"oid:1 AND template_id:6":298}}
        if(data_1.error_code == "0")
        {
            var data = data_1.data;
            for(var i in data)
            {
                var o = {};
                if(data.hasOwnProperty(i))
                {
                    msg_1 = data[i];
                }
            }
        }
        // -------------------------------------------------------

        var data_2 = getData(url_2);
        var list_data_2 = "";
        if(data_2.error_code == "0")
        {
            var data = data_2.data;
            if(data.length > 0)
            {
                for (var i = 0, len = data.length; i < len; i++)
                {
                  if(i <= 7 )
                  {
                    var base_url = "<?php echo base_url(); ?>"+"/assets/SVG_dark/file-txt.svg";
                    list_data_2 += "<li><img style='width:35px; height:35px; margin-right:20px' src="+base_url+"><span style='white-space: nowrap; width: 100px; overflow: hidden;text-overflow: ellipsis;display:inline-block;'>"+data[i].name+"</span><span style='float:right;'>"+bytesToSize(data[i].size)+"</span></li>";
                  }
                }
            }
        }
        // -------------------------------------------------------

        var data_4 = getData(url_4);
        if(data_4.error_code == "0")
        {
            var data = data_4.data;
            for(var i in data)
            {
                var o = {};
                if(data.hasOwnProperty(i))
                {
                    msg_4 = data[i];
                }
            }
        }

        var sort = true;

        $("#graph_pie_1").html("<br><p>Total documents </p>"+"<br><div style='font-size:50px; text-align:center; font-weight:600'>"+msg_1+"</div>");
        $("#graph_pie_2").html(list_data_2);
        $("#graph_pie_4").html("<br><p>Document on this week </p>"+"<br><div style='font-size:50px; text-align:center; font-weight:600'>"+msg_4+"</div>");

        c3.generate({
        bindto: '#graph_pie_5',
        data: {
            columns: arr_data_5,
            type: 'donut',
        },
        axis: {
            x: {
                label: 'Sepal.Width'
            },
            y: {
                label: 'Petal.Width'
            }
        },
        pie: {
            sort: sort,
            onmouseover: function(d, i) {
                console.log(d, i);
            },
            onmouseout: function(d, i) {
                console.log(d, i);
            },
            onclick: function(d, i) {
                console.log(d, i);
            },
        },
        donut:
        {
            title: "File Summary"
        },
        tooltip:
        {
            format:
            {
                title: function()
                {
                    return "File Extension"
                },
                value: function(value, ratio, id)
                {
                    var format = id === 'data' ? d3.format(',') : d3.format('');
                    return format(value);
                }
            }
        },
        color: {

            pattern: ['#C4DFE6', '#DE7A22', '#20948B', '#6AB187', '#336B87', '#07575B'] // warna coklat. Surf & Turf
        },
        legend: {
            position: 'bottom'
        },
        size: {
            height: 300
        }
    });
</script>
