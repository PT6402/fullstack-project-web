<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="index3.html" class="brand-link">
    <img src="images/catalogy-3.jpg" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">SG12s</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="images/catalogy-3.jpg" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">Admin</a>
      </div>
    </div>

    <!-- SidebarSearch Form -->
    <div class="form-inline">
      <div class="input-group" data-widget="sidebar-search">
        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-sidebar">
            <i class="fas fa-search fa-fw"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
             with font-awesome or any other icon font library -->
          {{-- Product --}}
          <li class="nav-item">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Product
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('product/create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Create Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('product/index')}}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>List Product</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('image/index')}}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product Image</p>
                </a>
              </li>
              {{-- <li class="nav-item">
                <a href="{{URL::to('/index')}}" class="nav-link active">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Product List</p>
                </a>
              </li> --}}
            </ul>
          </li>
        {{-- Category --}}
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Category
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('category/create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Category</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('category/index')}}" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>List Category</p>
              </a>
            </li>
          </ul>
        </li>
        

        {{-- Subcategory --}}
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-stroopwafel"></i>
            <p>
              Subcategory
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('subcategory/create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Subcategory</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('subcategory/index')}}" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>List Subcategory</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Color
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('color/create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Color</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('color/index')}}" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>List Color</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- Size --}}
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-tachometer-alt"></i>
            <p>
              Size
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('size/create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Size</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('size/index')}}" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>List Size</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-stroopwafel"></i>
            <p>
              Coupon
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('coupon/create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Coupon</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('coupon/index')}}" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>List Coupon</p>
              </a>
            </li>
          </ul>
        </li>
        {{-- Order --}}
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-stroopwafel"></i>
            <p>
              Order
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{url('order/create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Order</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{url('order/index')}}" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>List Order</p>
              </a>
            </li>
          </ul>
        </li>

        {{-- Inventory --}}
        <li class="nav-item">
          <a href="#" class="nav-link active">
            <i class="nav-icon fas fa-stroopwafel"></i>
            <p>
              Inventory Management
              <i class="right fas fa-angle-left"></i>
            </p>
          </a>
          <ul class="nav nav-treeview">
            {{-- <li class="nav-item">
              <a href="{{url('order/create')}}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Create Order</p>
              </a>
            </li> --}}
            <li class="nav-item">
              <a href="{{url('inventory/index')}}" class="nav-link active">
                <i class="far fa-circle nav-icon"></i>
                <p>List Inventory</p>
              </a>
            </li>
          </ul>
        </li>
      </ul>

      
      
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>