

function add_file(){
  var e = document.getElementById("select_file");
  var filename = e.options[e.selectedIndex].value;
  //filename = $(this).val();
  if(filename!='none'){
    $('.flow-fiew').html('<a href="#"><img src="http://localhost/chantel-ci//assets/SVG_dark/pdf.svg" width="40px" /><br/> '+filename+' <input type="hidden" name="wf_name" value="'+filename+'" ><br/></a>');
  }else if(filename=='none'){
    $('.flow-fiew').empty();
  }
}

function add_approvement(section_indx){
  approve_sit = $('#sit_approve').val();
  //approve_by = $('#val'+String(section_indx)).val();

  if(approve_sit!=""){
    //incremt();
    var y = Math.floor(j + 1);
    j = y;
    left= '<div class="input-group left"> <label for="" style="display:block"><b>'+approve_sit+'</b></label> <input type="hidden" name="approve_sit['+y+']" value="'+approve_sit+'" > </div> ';
    right= '<div class="input-group right"> <label for="" style="display:block"></label> <input type="text" name="approve_indx['+y+']" value="'+y+'" placeholder="index / urutan approve" ><span class="add" style="font-size:8px;" onclick="">delete</span></div>';
    //$('.out-item').append('<div class="accordion" onclick="acordi()">'+secment_name+' </div>');
    $('.flow-fiew').after('<div style="padding:5px">'+left+' '+right+'</div>');
  }

}


function success_aprove(idx,nxt_idx,date,wf_id,filename,file_namefull){
  //var element = document.getElementById("myDIV");
  //    element.classList.add("mystyle");
  //$('.btn-aprove'+String(idx)).css('display','none');
  $('#give').css('display','none');
  $('.li'+String(idx)).addClass( "active" );
  $('.lib'+String(idx)).addClass( "active" );
  $('#box'+String(idx)).empty();
  $('#box'+String(idx)).html('Approved <br/><span style="opacity:0.5;font-size:12px;">'+date+'</span>');
  $('#box'+String(nxt_idx)).html('<img src="http://localhost/chantel-ci/assets/SVG_dark/pdf.svg" width="40px" /><br/><text >File position</text>');
  //$('.btn-aprove'+String(nxt_idx)).css('display','inline');

}

function setupnode(id_node,file_name,wf_id,file_namefull){
  $('#box'+String(id_node)).html('<img src="http://localhost/chantel-ci/assets/SVG_dark/pdf.svg" width="40px" /><br/><text >File position</text>');
  $('.btn-aprove'+String(id_node)).css('display','inline');
}

//reimburse
function open_form(id_form){
  $('#form_'+String(id_form)).toggleClass('shown');
  if ($('#form_'+String(id_form)).hasClass('shown')) {
      $("#cover").css("display","block");
    document.getElementById('add-wf').focus();
    $('#form_'+String(id_form)).removeClass("shown");
  }
  else {
    $("#cover").css("display","none");
  }
}

function closeNewFolder(id_form){
  $('#'+String(id_form)).removeClass("shown");
  $("#cover").css("display","none");
};
