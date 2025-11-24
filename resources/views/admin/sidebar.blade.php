<!-- BEGIN: Sidebar-->
<div class="page-sidebar custom-scroll" id="sidebar">
    <div class="sidebar-header"><a class="sidebar-brand" href="{{ URL::to('dashboard') }}">ASIFHOSSAIN</a><a
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


        {{-- <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">ব্রাঞ্চসমূহ</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ route('branch.create') }}">ব্রাঞ্চ এড করুন</a></li>
                <li><a href="{{ route('branch.index') }}">ব্রাঞ্চের তালিকা</a></li>
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


        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">সদস্য</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ route('member.create') }}">নতুন সদস্য যুক্ত করুন</a></li>
                <li><a href="{{ route('member.index') }}">সকল সদস্যদের তালিকা</a></li>
                <li><a href="{{ route('member.ledger.index') }}">মেম্বার লেজার </a></li>
            </ul>
        </li>

        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">লোনসমূহ</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ route('loan.create') }}">লোন প্রদান করুন</a></li>
                <li><a href="{{ route('loan.index') }}">সকল লোনের তথ্য</a></li>
                <li><a href="{{ route('collection.index') }}">লোন কালেকশন</a></li>
                <li><a href="{{ route('loan.ledger') }}">লোন লেজার</a></li>
            </ul>
        </li>

        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">লোন
                    কালেকশন</span><i class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ route('collection.index') }}">লোন কালেকশন করুন </a></li>
                <li><a href="{{ route('collection.all') }}">সকল কালেকশন তালিকা</a></li>
                <li><a href="{{ route('loan.ledger') }}">লোন লেজার</a></li>
            </ul>
        </li>
        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">সেভিংস</span><i
                    class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ route('savings.collect.form') }}">সেভিংস কালেকশন করুন</a></li>
                <li><a href="{{ route('savings.index') }}">সকল সেভিংস তথ্য</a></li>
            </ul>
        </li>


        <!-- FD -->
        <li>
            <a href="javascript:;">
                <i class="sidebar-item-icon ft-anchor"></i>
                <span class="nav-label">FDR (ফিক্সড ডিপোজিট)</span>
                <i class="arrow la la-angle-right"></i>
            </a>
            <ul class="nav-2-level">
                <li><a href="{{ route('fd.create') }}">নতুন FD তৈরি</a></li>
                <li><a href="{{ route('fd.index') }}">FD তালিকা</a></li>
                {{-- <li><a href="{{ route('fd.rate.index') }}">FD রেট ম্যানেজমেন্ট</a></li> --}}
            </ul>
        </li>


        <li>
            <a href="javascript:;">
                <i class="sidebar-item-icon ft-layers"></i>
                <span class="nav-label">DPS সিস্টেম</span>
                <i class="arrow la la-angle-right"></i>
            </a>
            <ul class="nav-2-level">

                <li><a href="{{ route('dps.plan.index') }}">DPS প্লানসমূহ</a></li>

                <li><a href="{{ route('dps.account.create') }}">নতুন DPS খুলুন</a></li>

                <li><a href="{{ route('dps.account.index') }}">DPS অ্যাকাউন্টসমূহ</a></li>

            </ul>
        </li>

        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">ফি
                    কালেকশন</span><i class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ route('loan.create') }}">লোন প্রদান করুন</a></li>
                <li><a href="{{ route('loan.index') }}">সকল লোনের তথ্য</a></li>
            </ul>
        </li>
    </ul>
</div><!-- END: Sidebar-->
