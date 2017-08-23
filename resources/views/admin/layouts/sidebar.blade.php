<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu">
      <li class="header">MAIN NAVIGATION</li>
      <li @yield('dashboard')><a href="{{ url('admin/dashboard') }}"><i class="fa fa-circle-thin"></i><span> Dashboard</span></a></li>
      <li @yield('customers')><a href="{{ url('admin/customer') }}"><i class="fa fa-circle-thin"></i><span> Customers</span></a></li>
      <li @yield('shops')><a href="{{ url('admin/shop') }}"><i class="fa fa-circle-thin"></i><span> Shops</span></a></li>
      <li @yield('members')><a href="{{ url('admin/member') }}"><i class="fa fa-circle-thin"></i><span> Members</span></a></li>
      <li @yield('products')><a href="{{ url('admin/product') }}"><i class="fa fa-circle-thin"></i><span> Products</span></a></li>
      <li @yield('rewards')><a href="{{ url('admin/reward') }}"><i class="fa fa-circle-thin"></i><span> Rewards</span></a></li>
    </ul>
  </section>
</aside>
