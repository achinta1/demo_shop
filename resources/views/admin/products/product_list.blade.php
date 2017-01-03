@extends('../layouts.app')
@section('content')
<div id="wrapper">
    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header page_title">
								{{isset($data['heading']) ? trim($data['heading']).' List' :""}}
                    <div class="header-btn">
                        <a href="javascript:void(0)" alt="Add" title="Add" data-toggle="modal" data-target="#ModalPopUpID" class="Modal-Pop-Link-Apr" data-href="{{ url('/admin/product-add') }}"><button class="btn btn-success btn-bg-change">Add <?php echo isset($data['heading']) ? trim($data['heading']) :""; ?></button></a>
                    </div>
                </h1>
            </div>
            <div class="col-lg-12">
								@include('layouts.flash-message')
                <div class="panel panel-default">
                <div class="panel-body table-responsive">
                <div class="dataTable_wrapper">
                    <table class="table table-bordered" id="dataTablesApnd">
                        <thead>
                            <tr>
                                <th>SL</th>        
                                <th>Image</th>
                                <th>Name</th>
                                <th class="actions">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        if(isset($data['products']) && !empty($data['products'])){
                          $counter=1;
                          foreach ($data['products'] as $product){
                        ?>
                        <tr id="dataRow_<?php echo $product->id;?>">
                         <td align="center"><?php echo $counter;?></td>
                         <td align="center">
													<img src="{{URL::to('public/uploads/images/thumb/'.$product->default_image) }}"  style="margin-top:-9px" width="30%" height="50%" alt="">
												</td>
												<td align="center">{{$product->name }}</td>
                        <td align="center" class="actions">
													<a href="javascript:void(0)" alt="Add" title="Add" data-toggle="modal" data-target="#ModalPopUpID" class="Modal-Pop-Link-Apr" data-href="{{url('/admin/product-edit/'.$product->id)}}"><i class="fa fa-pencil-square-o fa-lg"></i></a>
                         	<a href="javascript:void(0)" data-href="{{url('/admin/product-delete/'.$product->id)}}" data-id="{{$product->id}}", class="deleteDataRow" ><i style="color:#FF0000" title="Click to Delete" class="fa fa-times-circle fa-lg" aria-hidden="true"></i></a>
                          <a href="javascript:void(0)" data-href="{{url('/admin/product-change-status/'.$product->id)}}" data-id="{{$product->id}}", class="ChangeStatus" id="ChangeStatus_<?php echo $product->id;?>" data-status="<?php echo $product->status;?>">
                          <?php if(trim($product->status)=='ACTIVE'){?>
                          <i style="color:#439f43" title="Click to Inactive" class="fa fa-check-square fa-lg" aria-hidden="true"></i>
                          <?php } else { ?>
                          <i style="color:#FF0000" title="Click to Active" class="fa fa-check-square fa-lg" aria-hidden="true"></i>
                          <?php } ?>
													</a>
													<a href="javascript:void(0)" alt="vew & Edit" title="View & Upload Multiple Image" data-toggle="modal" data-target="#ModalPopUpID" class="Modal-Pop-Link-Apr" data-href="{{url('/admin/product-image-upload/'.$product->id)}}"><i class="fa fa-picture-o fa-lg"></i></a>
												</td>
                      </tr>
                    <?php
													$counter++;
												}
											}
                    ?>
                    </tbody>
                    </table>
                </div>
								<!-- ./Pagination-->
								<div class="row">
									<div class="col-sm-6"></div>
									<div class="col-sm-6">
										<div class="dataTables_paginate paging_simple_numbers" id="dataTablesApnd_paginate">
											{{ $data['products']->links() }}
										</div>
									</div>
								</div>
								<!-- ./Pagination-->
                </div>
                </div>
            </div>
        <!-- /.Icon Table -->
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Icon Info
                    </div>
                    <!-- /.panel-heading -->
                    <div class="panel-body">
                        <a><i class="fa fa-pencil-square-o fa-lg"></i></a>&nbsp;View & Edit&nbsp;&nbsp;|&nbsp;
                        <a><i class="fa fa-times-circle fa-lg" style="color:#FF0000"></i></a>&nbsp;Delete&nbsp;&nbsp;|&nbsp;
                        <a><i class="fa fa-check-square fa-lg" style="color:#439f43"></i></a>&nbsp;Active&nbsp;&nbsp;|&nbsp;
                        <a><i class="fa fa-check-square fa-lg" style="color:#FF0000"></i></a>&nbsp;Inactive
                      <!-- /.table-responsive -->
                    </div>
                    <!-- /.panel-body -->
                </div>
                <!-- /.panel -->
            </div>
        <!-- /.Icon Table -->
    </div>
</div>
<!-- Data Tables -->
<script>
/*
$(document).ready(function() {
    $('#dataTablesApnd').DataTable({
            responsive: true,
            "ordering": false,
            "info":     false,
            "oLanguage":{
            "sEmptyTable":"No Records found.",
            "emptyTable": "No Records found.",
            },
            "language": {
                "emptyTable": "No Records found.",
            },
            "aoColumnDefs" : [ { "bSortable" : false, "aTargets" : [ "sorting_disabled" ] } ],
            "iDisplayLength": '10', //Pagination limit
    });
});*/
</script>
@endsection
