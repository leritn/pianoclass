@extends('app')


@section('htmlheader_title')
List of all classes
@endsection


@section('contentheader_title')

@endsection


@section('main-content')
<style>
.example-modal .modal {
    position: relative;
    top: auto;
    bottom: auto;
    right: auto;
    left: auto;
    display: block;
    z-index: 1;
}
.example-modal .modal {
    background: transparent!important;
}
</style>
<div class="col-md-12">
	<div class="box ">
	    <div class="box-header">
	        <div class="row">
	            <div class="col-xs-6">
	                <h3 class="box-title">Dashboard</h3>
	            </div>
	            <div class="col-xs-6 text-right">
	                <a href= "{{url('schedule/create')}}" class="btn btn-default" >
	                 <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span>
	             </a>
	                        <!-- <button type="button" class="btn btn-default" >
	                    <span class="glyphicon glyphicon-plus-sign" aria-hidden="true"></span> Add
	                </button> -->
	            </div>
	        </div>
	    </div><!-- /.box-header -->

	    <div class="box-body">
	        <div id="example2_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
	            <div class="row">
	                <!-- <div class="col-xs-12 visible-xs">xs</div>
	                <div class="col-sm-12 visible-sm">sm</div>
	                <div class="col-md-12 visible-md">md</div>
	                <div class="col-lg-12 visible-lg">lg</div> -->
	                <div class="col-sm-12" id="schedule_list_table">

	                    <div class="row hidden-xs" id="table_header">
	                        <div class="col-sm-2">
	                            <strong>Start Time</strong>
	                        </div>
	                        <div class="col-sm-2">
	                            <strong>End Time</strong>
	                        </div>
	                         <div class="col-sm-3">
	                            <strong>Teacher</strong>
	                        </div>
	                        <div class="col-sm-3">
	                            <strong>Student</strong>
	                        </div>
	                         <div class="col-sm-2">
	                            <strong>Option</strong>
	                        </div>
	                    </div>

	                    @foreach ($scheduleList as $schedule)
	                    <div class="row">
	                        <div class="col-xs-2 visible-xs">
	                            Start:
	                        </div>
	                        <div class="col-md-2 col-xs-10">
	                            {{date('j M y G:i', strtotime($schedule->start_time))}}
	                        </div>
	                        <div class="col-xs-2 visible-xs">
	                            End:
	                        </div>
	                        <div class="col-md-2 col-xs-10">
	                            {{date('j M y G:i', strtotime($schedule->end_time))}}
	                        </div>
	                         <div class="col-md-3 col-xs-12">
	                            {{$schedule->teacher_nickname}} <span class='visible-sm-inline visible-md-inline'><br /></span>({{$schedule->teacher_firstname}} {{$schedule->teacher_lastname}})
	                        </div>
	                        <div class="col-md-3 col-xs-12">
	                            {{$schedule->student_nickname}} <span class='visible-sm-inline visible-md-inline'><br /></span>({{$schedule->student_firstname}} {{$schedule->student_lastname}})
	                        </div>

	                        <div class="col-md-2 col-xs-12">
	                            <input type="hidden" id="attr_schedule_{{$schedule->id}}" class_time="{{$schedule->start_time}} - {{$schedule->end_time}}" teacher_nickname="ครู {{$schedule->teacher_nickname}}" student_nickname="{{$schedule->student_nickname}}" />
	                            
	                            <a href= "{{url('schedule/'.$schedule->id.'/edit')}}" class="btn btn-default" >
	                                <span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
	                            </a>
	                            <button class="btn btn-danger" data-toggle="modal" data-target="#deleteModal" schedule_id="{{$schedule->id}}">
	                                <span class="fa fa-trash" aria-hidden="true"> </span>
	                            </button>
	                        </div>
	                    </div>
	                    <div class="row row-splitter">
	                        <div class="col-xs-12 visible-xs" style="height: 10px;">
	                        </div>
	                    </div>
	                    @endforeach


	                    <form action="" method="POST" id="confirm-delete"> 


	                        <div class="modal fade " id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	                            <div class="modal-dialog" role="document">
	                                <div class="modal-content">
	                                    <div class="modal-header">
	                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	                                        <h4 class="modal-title" id="myModalLabel">Delete Teacher</h4>
	                                    </div>
	                                    <div class="modal-body">
	                                        Are you sure you want to delete this class? (id: <span id="delete_id_message"></span>) <br />
	                                        <span id="will_be_deleted_text">
	                                        </span>
	                                        <div class="modal-footer">
	                                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>

	                                            <input type="hidden" name="_method" value="DELETE">
	                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
	                                            <button class="btn btn-danger" >
	                                                <span class="glyphicon glyphicon-remove-sign" aria-hidden="true"> </span> Delete
	                                            </button>
	                                        </div>
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </form>

	                </div>
	            </div>

	        </div>
	    </div>
	</div><!-- /.box-body -->
</div>


<script type="text/javascript">

$('#deleteModal').on('shown.bs.modal',function(e){
    delete_schedule_id = e.relatedTarget.attributes.schedule_id.value;
    delete_schedule_text = "<br />" + $("#attr_schedule_"+delete_schedule_id).attr("class_time") + "<br />" + $("#attr_schedule_"+delete_schedule_id).attr("teacher_nickname") + "<br />" + $("#attr_schedule_"+delete_schedule_id).attr("student_nickname");

    $("#delete_id_message").html(delete_schedule_id);
    $("#will_be_deleted_text").html(delete_schedule_text);
    $("#confirm-delete").attr("action", "{{url('schedule')}}"+"/"+delete_schedule_id);
});





</script>
@endsection