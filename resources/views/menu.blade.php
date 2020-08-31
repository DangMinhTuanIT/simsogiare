@php
    $current = Route::current()->getName();
	if(!$current)
		$current = 'home';

@endphp
<li class="header">DANH MỤC HỆ THỐNG</li>
@if(auth()->user()->type == config('simsogiare.user_type.admin'))
<li class="{{ ($current == 'orders.list') ? 'active' : '' }}">
            <a href="{{ route('orders.list') }}">
                <i class="material-icons">vertical_split</i>
                <span>Quản lý đơn hàng</span>
            </a>
        </li>
        <li class="{{ ($current == 'category_networks.list') ? 'active' : '' }}">
            <a href="{{ route('category_networks.list') }}">
                <i class="material-icons">assignment</i>
                <span>Quản lý nhà mạng</span>
            </a>
        </li>
         
        <li class="{{ ($current == 'genre.list') ? 'active' : '' }}">
            <a href="{{ route('genre.list') }}">
                <i class="material-icons">book_online</i>
                <span>Quản lý Thể Loại SIM</span>
            </a>
        </li>
          <li class="{{ ($current == 'sim.list' || $current == 'sim.add') ? 'active' : '' }}">
            <a  href="javascript:void(0)" class="menu-toggle">
                <i class="material-icons">calendar_view_day</i>
                <span>Quản lý SIM</span>
            </a>
            <ul class="ml-menu">
                     <li class="{{ ($current == 'sim.list') ? 'active' : '' }}">
                        <a href="{{ route('sim.list') }}">
                            <span>Danh sách SIM</span>
                        </a>
                    </li>
                     <li class="{{ ($current == 'sim.add') ? 'active' : '' }}">
                        <a href="{{ route('sim.add') }}">
                            <span>Nhập danh sách SIM</span>
                        </a>
                    </li>
                     <li class="{{ ($current == 'sim.import_sim') ? 'active' : '' }}">
                        <a href="{{ route('sim.import_sim') }}">
                            <span>Nhập danh sách SIM test</span>
                        </a>
                    </li>
                     <li class="">
                        <a href="#">
                            <span>Export SIM</span>
                        </a>
                    </li>
                </ul>
        </li>
        <li class="{{ ($current == 'sim.list' || $current == 'sim.add') ? 'active' : '' }}">
            <a  href="javascript:void(0)" class="menu-toggle">
                <i class="material-icons">calendar_view_day</i>
                <span>Phong thủy</span>
            </a>
            <ul class="ml-menu">
                     <li class="{{ ($current == 'sim_fate.list') ? 'active' : '' }}">
                        <a href="{{ route('sim_fate.list') }}">
                            <span>Sim hợp mệnh</span>
                        </a>
                    </li>
                     <li class="{{ ($current == 'sim_age.add') ? 'active' : '' }}">
                        <a href="{{ route('sim_age.add') }}">
                            <span>Sim hợp tuổi</span>
                        </a>
                    </li>
                     <li class="">
                        <a href="#">
                            <span>Export SIM</span>
                        </a>
                    </li>
                </ul>
        </li>
        <li class="{{ ($current == 'sim_birth.list') ? 'active' : '' }}">
            <a href="{{ route('sim_birth.list') }}">
                <i class="material-icons">receipt</i>
                <span>Sim theo năm sinh SIM</span>
            </a>
        </li>
        <li class="{{ ($current == 'price_range.list') ? 'active' : '' }}">
            <a href="{{ route('price_range.list') }}">
                <i class="material-icons">leaderboard</i>
                <span>Quản lý Giá</span>
            </a>
        </li>
     <li class="{{ ($current == 'customer.list') ? 'active' : '' }}" >
            <a href="javascript:void(0)" class="menu-toggle">
                <i class="material-icons">reorder</i>
                <span>Tin tức</span>
            </a>
            <ul class="ml-menu">
                     <li class="{{ ($current == 'news.list') ? 'active' : '' }}">
                        <a href="{{ route('news.list') }}">
                            <i class="material-icons">receipt</i>
                            <span>Tin tức</span>
                        </a>
                    </li>
                    <li class="{{ ($current == 'category.list') ? 'active' : '' }}">
                        <a href="{{ route('category.list') }}">
                            <i class="material-icons">receipt</i>
                            <span>Category</span>
                        </a>
                    </li>
                    <li class="{{ ($current == 'tags.list') ? 'active' : '' }}">
                        <a href="{{ route('tags.list') }}">
                            <i class="material-icons">receipt</i>
                            <span>Tags</span>
                        </a>
                    </li>
            </ul>
        </li>
        <li class="{{ ($current == 'setting.list') ? 'active' : '' }}">
        <a href="{{ route('setting.list') }}">
            <i class="material-icons">history</i>
            <span>Settings</span>
        </a>
    </li>
    
    @if(auth()->user()->can('Xem log hệ thống') && 1==2)
    <li class="{{ ($current == 'log.list') ? 'active' : '' }}">
        <a href="{{ route('log.list') }}">
            <i class="material-icons">history</i>
            <span>Log hệ thống</span>
        </a>
    </li>
    @endif
    @if(auth()->user()->can('Xem cài đặt') && 1==2)
        <li class="{{ ($current == 'options.list' || $current == 'options.update') ? 'active' : '' }}">
            <a href="{{ route('options.list') }}">
                <i class="material-icons">settings</i>
                <span>Cài đặt</span>
            </a>
        </li>
    @endif
@endif


