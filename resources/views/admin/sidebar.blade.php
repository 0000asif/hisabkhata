<!-- BEGIN: Sidebar-->
<div class="page-sidebar custom-scroll" id="sidebar">
    <div class="sidebar-header"><a class="sidebar-brand" href="{{ URL::to('dashboard') }}">ADMIN</a><a
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
                <li><a href="{{ route('fdr.calculator') }}">FDR Calculator</a></li>
                <li><a href="{{ route('fd.create') }}">নতুন FD তৈরি</a></li>
                <li><a href="{{ route('fd.index') }}">FD তালিকা</a></li>
            </ul>
        </li>


        <li>
            <a href="javascript:;">
                <i class="sidebar-item-icon ft-layers"></i>
                <span class="nav-label">DPS সিস্টেম</span>
                <i class="arrow la la-angle-right"></i>
            </a>
            <ul class="nav-2-level">

                <li><a href="{{ route('dps.calculator.index') }}">DPS ক্যালকুলেটর</a></li>
                <li><a href="{{ route('dps.plan.index') }}">DPS প্লানসমূহ</a></li>

                <li><a href="{{ route('dps.account.create') }}">নতুন DPS খুলুন</a></li>

                <li><a href="{{ route('dps.account.index') }}">DPS অ্যাকাউন্টসমূহ</a></li>

            </ul>
        </li>

        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label"></span><i class="arrow la la-angle-right"></i>ইনকাম ও খরচের ক্যাটাগরি</a>
            <ul class="nav-2-level">
                <li><a href="{{ route('category.create') }}">ক্যাটাগরি তৈরি করুন</a></li>
                <li><a href="{{ route('category.index') }}">সকল ক্যাটাগরির তথ্য</a></li>
            </ul>
        </li>


        <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label"></span><i class="arrow la la-angle-right"></i>ইনকাম ও খরচ</a>
            <ul class="nav-2-level">
                <li><a href="{{ route('income-expense.create') }}">ইনকাম ও খরচ করুন</a></li>
                <li><a href="{{ route('income-expense.index') }}">ইনকাম ও খরচের তালিকা</a></li>
            </ul>
        </li>
        
        
        <li>
            <a href="javascript:;">
                <i class="sidebar-item-icon ft-anchor"></i>
                <span class="nav-label">ব্যাংক সিস্টেম</span>
                <i class="arrow la la-angle-right"></i>
            </a>

            <ul class="nav-2-level">

                {{-- Bank Account --}}
                <li>
                    <a href="{{ route('bank.create') }}">ব্যাংক এড করুন</a>
                </li>

                <li>
                    <a href="{{ route('bank.index') }}">ব্যাংকের তালিকা</a>
                </li>

                {{-- Bank Transaction --}}
                <li>
                    <a href="{{ route('bank-transaction.create') }}">ব্যাংক লেনদেন (জমা/উত্তোলন)</a>
                </li>

                <li>
                    <a href="{{ route('bank-transaction.index') }}">লেনদেনের তালিকা</a>
                </li>

                {{-- Bank Transfer --}}
                <li>
                    <a href="{{ route('bank-transfer.form') }}">ব্যাংক ট্রান্সফার</a>
                </li>

            </ul>
        </li>


        {{-- <li><a href="javascript:;"><i class="sidebar-item-icon ft-anchor"></i><span class="nav-label">ফি
                    কালেকশন</span><i class="arrow la la-angle-right"></i></a>
            <ul class="nav-2-level">
                <li><a href="{{ route('loan.create') }}">লোন প্রদান করুন</a></li>
                <li><a href="{{ route('loan.index') }}">সকল লোনের তথ্য</a></li>
            </ul>
        </li> --}}

        <li>
            <a href="javascript:;">
                <i class="sidebar-item-icon ft-bar-chart"></i>
                <span class="nav-label">রিপোর্ট</span>
                <i class="arrow la la-angle-right"></i>
            </a>

            <ul class="nav-2-level">

                <li><a href="{{ route('report.loans') }}">লোন সামারি রিপোর্ট</a></li>
                <li><a href="{{ route('report.installments') }}">কিস্তি রিপোর্ট</a></li>
                <li><a href="{{ route('report.collection.daily') }}">ডেইলি কালেকশন রিপোর্ট</a></li>
                <li><a href="{{ route('report.member') }}">মেম্বার অনুযায়ী রিপোর্ট</a></li>
                <li><a href="{{ route('report.area') }}">এরিয়া অনুযায়ী রিপোর্ট</a></li>

                <li><a href="{{ route('report.latefee') }}">লেট ফি রিপোর্ট</a></li>
                <li><a href="{{ route('report.latefee.collection') }}">লেট ফি কালেকশন হিস্ট্রি</a></li>
                <li><a href="{{ route('savings.report.form') }}">সেভিংস রিপোর্ট</a></li>
                <li><a href="{{ route('fd.report.form') }}">ফিক্সড ডিপোজিট রিপোর্ট</a></li>
                <li><a href="{{ route('dps.report.form') }}">DPS রিপোর্ট</a></li>
                <li><a href="{{ route('income-expense.report') }}">Income Expense রিপোর্ট</a></li>

                        {{-- Bank Report --}}
                        <li>
                            <a href="{{ route('bank.report') }}">ব্যাংক রিপোর্ট</a>
                        </li>

            </ul>
        </li>



    </ul>
</div><!-- END: Sidebar-->
