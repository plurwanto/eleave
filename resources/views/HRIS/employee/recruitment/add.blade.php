<div id="getData">
    <div class="modal-header" style="padding: 10px; background-color: #333942; color: #fff; border-bottom: unset;">
        <button class="close" style="filter: brightness(0) invert(1); opacity: 1;" data-dismiss="modal"></button>
        <h4 class="modal-title">Add Employee</h4>
    </div>
    <div class="modal-body" style="padding-bottom: 0;">
        <div class="portlet box" style="background-color: #444d58; margin-bottom: 0px">
            <div class="portlet-body" style="padding:15px;">
                <div class="row">
                    <div style="text-align: center; font-size: 18px;">
                        Please insert ID or Passport Number
                    </div>
                    <div class="input-group" style="border: 1px solid #03A9F4; margin: 20px 100px 10px 100px;">
                        <input type="text" class="form-control" name="id_number" id="id_number" placeholder="Enter ID Number">

                        <span class="input-group-btn">
                            <a title="Search"  onclick="get_data()" class="btn blue" style="background-color: #03A9F4 !important">
                                <i class="fa fa-search"></i>
                            </a>
                        </span>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <input type="hidden" name="id" id="id" value="{{$id}}">
</div>


<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'select2/js/select2.full.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'components-select2.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'jquery-validation/js/additional-methods.min.js') }}" type="text/javascript"></script>
<script src="{{ URL::asset(env('GLOBAL_PLUGIN_PATH').'bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->

<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="{{ URL::asset(env('PAGES_SCRIPT_PATH').'form-validation.min.js') }}" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->

<script type="text/javascript">


    function get_data() {
        var id = $("#id").val();
        var id_number = $("#id_number").val();
        $("#getData").html(`<div style="text-align: center"><h2><i class="fa fa-chevron-right-o-notch fa-spin fa-1x fa-fw"></i>
                <span>Loading...</span></h2>
            </div>`);
        if (id_number != '') {
            $.get("{{ URL::asset(env('APP_URL').'/hris/employee/recruitment/get-data') }}",
                    {
                        id: id,
                        id_number: id_number

                    },
                    function (data) {
                        $("#getData").html(data);
                    });
        } else {
            $("#getData").html('');
        }
    }
</script>
