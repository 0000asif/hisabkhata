<!-- BEGIN: Sidebar-->
<div class="page-sidebar custom-scroll" id="sidebar">
    <div class="sidebar-header"><a class="sidebar-brand" href="{{ URL::to('dashboard')}}">ASIFHOSSAIN</a><a
            class="sidebar-brand-mini" href="index.html">AH</a><span class="sidebar-points"><span
                class="badge badge-success badge-point mr-2"></span><span
                class="badge badge-danger badge-point mr-2"></span><span
                class="badge badge-warning badge-point"></span></span></div>
    <ul class="sidebar-menu metismenu">
        <li class="heading"><span>DASHBOARDS</span></li>
        <li class="mm-active"><a href="{{ URL::to('/dashboard') }}">
                <i class="sidebar-item-icon ft-home"></i><span class="nav-label">Dashboards</span></a>
        </li>

        {{-- <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">Form</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ URL::to('newform') }}">New Form</a></li>
                <li><a href="{{ URL::to('datatables') }}">Datatable</a></li>
            </ul>
        </li> --}}

        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">এলাকাসমূহ</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ route('area.create') }}">এলাকা এড করুণ</a></li>
                <li><a href="{{ route('area.index') }}">এলাকার তালিকা</a></li>
            </ul>
        </li>

        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">পদবিসমূহ</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ route('position.create') }}">পদবি এড করুন</a></li>
                <li><a href="{{ route('position.index') }}">পদবির তালিকা</a></li>
            </ul>
        </li>

        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">স্টাফসমূহ</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ route('staff.create') }}">স্টাফ এড করুন</a></li>
                <li><a href="{{ route('staff.index') }}">স্টাফদের তালিকা</a></li>
            </ul>
        </li>

        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">লোনসমূহ</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ route('loan.create') }}">লোন প্রদান করুন</a></li>
                <li><a href="{{ route('loan.index') }}">সকল লোনের তথ্য</a></li>
            </ul>
        </li>
        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">FDR</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ route('loan.create') }}">লোন প্রদান করুন</a></li>
                <li><a href="{{ route('loan.index') }}">সকল লোনের তথ্য</a></li>
            </ul>
        </li>
        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">DPS</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ route('loan.create') }}">লোন প্রদান করুন</a></li>
                <li><a href="{{ route('loan.index') }}">সকল লোনের তথ্য</a></li>
            </ul>
        </li>
        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">ফি কালেকশন</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ route('loan.create') }}">লোন প্রদান করুন</a></li>
                <li><a href="{{ route('loan.index') }}">সকল লোনের তথ্য</a></li>
            </ul>
        </li>
    </ul>
</div><!-- END: Sidebar-->