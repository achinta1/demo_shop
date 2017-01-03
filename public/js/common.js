$(document).ready(function(){
	$("body").on("click",'.pop-link', function(){
    $("#Modal-Pop-Content").empty();
		$("#pop-content").html('<div style="text-align: center;text-align: center;font-size: 20px;font-weight: bold;margin-top: 70px;">Loading, Please Wait.</div>');
		var html = $(this).data('href');
		$("#pop-content").load(html, function(){});
	});
    $("body").on('click',"#ModalPopUpID .close",function(){
        $("#Modal-Pop-Content").empty();
    });
    //==========::: ChangeStatus :::=========
    $("body").on("click",'.ChangeStatus', function(){
        $('#notifyMessage').empty();
        var action_link = $(this).data('href');
        var id = $(this).data('id');
        var content_id= $(this).attr('id');
        //console.log(content_id+"=====>>"+id+"======>>"+action_link);
        $('#notifyMessage').empty();
        if(confirm('Are you sure want to change the status?')){
         $.post(action_link,{"_token":$('meta[name="csrf-token"]').attr('content'),"id":id},function(data_arr){
            var return_data=$.parseJSON(data_arr);
            //console.log(return_data);
            var alert_class="alert alert-danger alert-dismissable";
            var msg="Please try again later";
            if(return_data.status!==undefined && return_data.status!==null && return_data.status.trim()==='SUCCESS'){
                alert_class="alert alert-success alert-dismissable";
                msg=return_data.msg;
                if(return_data.change_status!==undefined && return_data.change_status!==null && return_data.change_status.trim()==="ACTIVE"){
                     $("#"+content_id).html('<i style="color:#439f43" title="Click to Inactive" class="fa fa-check-square fa-lg" aria-hidden="true"></i>');
                }
                if(return_data.change_status!==undefined && return_data.change_status!==null && return_data.change_status.trim()==="INACTIVE"){
                     $("#"+content_id).html('<i style="color:#FF0000" title="Click to Active" class="fa fa-check-square fa-lg" aria-hidden="true"></i>');
                }
            }else if(return_data.status!==undefined && return_data.status!==null && return_data.status.trim()==='ERROR'){
                alert_class="alert alert-danger alert-dismissable";
                msg=return_data.msg;
            }
            var append_data='<div class="'+alert_class+'"><button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>'+msg+'</div>';
            $('#notifyMessage').html(append_data);
         });
        }
    });
    //================delete===========
    $("body").on("click",'.deleteDataRow', function(){
        $('#notifyMessage').empty();
        var action_link = $(this).data('href');
        var id = $(this).data('id');
        var content_id='dataRow_'+id;
        //console.log(content_id+"=====>>"+id+"======>>"+action_link);
        $('#notifyMessage').empty();
        if(confirm('Are you sure want to delete?')){
         $.post(action_link,{"_token":$('meta[name="csrf-token"]').attr('content'),"id":id},function(data_arr){
            var return_data=$.parseJSON(data_arr);
            //console.log(return_data);
            var alert_class="alert alert-danger alert-dismissable";
            var msg="Please try again later";
            if(return_data.status!==undefined && return_data.status!==null && return_data.status.trim()==='SUCCESS'){
                alert_class="alert alert-success alert-dismissable";
                msg=return_data.msg;
                $("#"+content_id).remove();
            }else if(return_data.status!==undefined && return_data.status!==null && return_data.status.trim()==='ERROR'){
                alert_class="alert alert-danger alert-dismissable";
                msg=return_data.msg;
            }
            var append_data='<div class="'+alert_class+'"><button aria-hidden="true" data-dismiss="alert" class="close" type="button"><i class="fa fa-times fa-lg" aria-hidden="true"></i></button>'+msg+'</div>';
            $('#notifyMessage').html(append_data);
         });
        }
    });  
});