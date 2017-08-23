<aside class="main-sidebar">
  <section class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <!-- <div class="user-panel text-center">
      <div class="image">
        <img src="{{ asset("/bower_components/AdminLTE/dist/img/user2-160x160.jpg") }}" class="img-circle" alt="User Image" />
      </div>
      <div class="row">OWNER NAME</div>
    </div> -->
    <!-- Sidebar Menu -->
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li @yield('sale')><a href="{{ url('sale') }}"><i class="fa fa-circle-thin"></i><span> Point of Sale</span></a></li>
      <li @yield('redeem')><a href="{{ url('redeem') }}"><i class="fa fa-circle-thin"></i><span> Redeem Reward</span></a></li>
      <li @yield('member_menu', 'class="treeview"')>
        <a href="#"><i class="fa fa-circle-thin"></i><span> Members</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li @yield('member_list')><a href="{{ url('member') }}"> Members List</a></li>
          <li @yield('member_add')><a href="{{ url('member/request')}}"> Accept New Member</a></li>
        </ul>
      </li>
      <li @yield('product_menu', 'class="treeview"')>
        <a href="#"><i class="fa fa-circle-thin"></i><span> Products</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li @yield('product_list')><a href="{{ url('product') }}"> Products List</a></li>
          @if(!App\CheckBranch::isBranch())
          <li @yield('product_add')><a href="{{ url('product/add') }}"> Add New Product</a></li>
          @endif
        </ul>
      </li>
      <li @yield('reward_menu', 'class="treeview"')>
        <a href="#"><i class="fa fa-circle-thin"></i><span> Rewards</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li @yield('reward_list')><a href="{{ url('reward') }}"> Rewards List</a></li>
          @if(!App\CheckBranch::isBranch())
          <li @yield('reward_add')><a href="{{ url('reward/add') }}"> Add New Reward</a></li>
          @endif
          <li @yield('reward_history')><a href="{{ url('reward/redeem/history') }}"> Redeem Reward History</a></li>
        </ul>
      </li>
      @if(!App\CheckBranch::isBranch())
      <li @yield('branch_menu', 'class="treeview"')>
        <a href="#"><i class="fa fa-circle-thin"></i><span> Branches</span> <i class="fa fa-angle-left pull-right"></i></a>
        <ul class="treeview-menu">
          <li @yield('branch_list')><a href="{{ url('branch') }}"> Branches List</a></li>
          <li @yield('branch_add')><a href="{{ url('branch/add') }}"> Create Branch</a></li>
        </ul>
      </li>
      @endif
      @if(!App\CheckBranch::isBranch())
      <li @yield('shop_edit')><a href="{{ url('edit') }}"><i class="fa fa-circle-thin"></i><span> Edit Shop Info</span></a></li>
      @else
      <li @yield('shop_edit')><a href="{{ url('edit') }}"><i class="fa fa-circle-thin"></i><span> Edit Branch Info</span></a></li>
      @endif

    </ul>
  </section>
</aside>
