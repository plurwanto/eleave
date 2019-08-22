@extends('layout.main')

@section('title','Portal')

@section('content')

<div class="application-list">
    <div class="row margin-bottom-40 application-list-header" data-auto-height="true">
        <div class="col-md-12 margin-bottom-20">
            <h1>People &amp; Performance Portal</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="portlet light portlet-fit bordered">
                <div class="portlet-body" style="padding: 20px;">
                    <div class="mt-element-card mt-element-overlay">
                        <div class="row">
                            <div class="col-lg-12 container-application">

                                @if(session('is_recruiter') > 0)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12"
                                    style="float:none; display: inline-block;">
                                    <div id="recruitment-app">
                                        <input type="hidden" id="token" value="{{session('token')}}">
                                        <input type="hidden" id="id_eleave" value="{{session('id_eleave')}}">
                                        <input type="hidden" id="id_hris" value="{{session('id_hris')}}">
                                        <input type="hidden" id="email" value="{{session('email')}}">
                                        <input type="hidden" id="name" value="{{session('name')}}">
                                        <input type="hidden" id="is_recruiter" value="{{session('is_recruiter')}}">
                                        <div class="mt-card-item">
                                            <div class="mt-card-avatar mt-overlay-4">
                                                <div class="application-name recruitment">
                                                    <span>Recruitment</span>
                                                </div>
                                                <a href="javascript:;" @click="goToInternal">
                                                    <div class="mt-overlay">
                                                        <h2>Recruitment</h2>
                                                    </div>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if(session('id_hris') > 0)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12"
                                    style="float:none; display: inline-block;">
                                    <div class="mt-card-item">
                                        <div class="mt-card-avatar mt-overlay-4">
                                            <div class="application-name hris">
                                                <span>HRIS</span>
                                            </div>
                                            <a href="{{ URL::to('hris/dashboard') }}">
                                                <div class="mt-overlay">
                                                    <h2>HRIS</h2>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                @if(session('id_eleave') > 0)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12"
                                    style="float:none; display: inline-block;">
                                    <div class="mt-card-item">
                                        <div class="mt-card-avatar mt-overlay-4">
                                            <div class="application-name eleave">
                                                <span>E-Leave</span>
                                            </div>
                                            <a href="{{ URL::to('eleave') }}">
                                                <div class="mt-overlay">
                                                    <h2>E-Leave</h2>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif

                                <!-- begin egemes -->
                                @if(session('id_egemes') > 0)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12"
                                    style="float:none; display: inline-block;">
                                    <div class="mt-card-item">
                                        <div class="mt-card-avatar mt-overlay-4">
                                            <div class="application-name egemes">
                                                <span>E-Gemes</span>
                                            </div>
                                            <a onclick="goEgemes();">
                                                <div class="mt-overlay">
                                                    <h2>E-Gemes</h2>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <!-- end egemes -->

                                <!-- begin CCM Dashboard -->
                                @if(session('id_dashboard') > 0)
                                <div class="col-lg-2 col-md-3 col-sm-4 col-xs-12"
                                    style="float:none; display: inline-block;">
                                    <div class="mt-card-item">
                                        <div class="mt-card-avatar mt-overlay-4">
                                            <div class="application-name dashboard">
                                                <span>Dashboard</span>
                                            </div>
                                            <a onclick="location.href = `${recruitmentUrl}/ccm/client-contract`">
                                                <div class="mt-overlay">
                                                    <h2>Dashboard</h2>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                @endif
                                <!-- end CCM Dashboard -->

                            </div>
                            @php /* @endphp
                            <div class="col-lg-2 col-xs-12">
                                <div class="mt-card-item">
                                    <div class="mt-card-avatar mt-overlay-4">
                                        <div class="application-name wms">
                                            <span>WMS</span>
                                        </div>
                                        <a href="https://elabramdev.com/wms" target="_blank">
                                            <div class="mt-overlay">
                                                <h2>WMS</h2>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-xs-12">
                                <div class="mt-card-item">
                                    <div class="mt-card-avatar mt-overlay-4">
                                        <div class="application-name rms">
                                            <span>RMS</span>
                                        </div>
                                        <a href="https://elabramdev.com/rms" target="_blank">
                                            <div class="mt-overlay">
                                                <h2>RMS</h2>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-2 col-xs-12">
                                <div class="mt-card-item">
                                    <div class="mt-card-avatar mt-overlay-4">
                                        <div class="application-name dcs">
                                            <span>DCS</span>
                                        </div>
                                        <a href="https://elabramdev.com/document-control-system" target="_blank">
                                            <div class="mt-overlay">
                                                <h2>DCS</h2>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            @php */ @endphp
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
<script src="{{ URL::asset(env('PUBLIC_PATH').'js/app/recruitment.js') }}"></script>
<script type="text/javascript">
function goEgemes() {
    var token = $('#token').val();
    localStorage.setItem('userToken', token);

    window.location.href = "https://elabramdev.com/egemes/#/dashboard-queue";
}
</script>
@endsection
