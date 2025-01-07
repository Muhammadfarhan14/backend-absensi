 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
     <div class="app-brand demo">
         <a href="{{ route('dashboard') }}" class="app-brand-link">
             <img src="{{ asset('assets/img/logo.png') }}" alt="" height="150px">
         </a>

         <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
             <i class="bx bx-chevron-left bx-sm align-middle"></i>
         </a>
     </div>

     <div class="menu-inner-shadow"></div>

     <ul class="menu-inner py-1 justify-content-center">
         <li class="menu-header small text-uppercase">
             <span class="menu-header-text">Dashboard</span>
         </li>
         <li class="menu-item {{ $title == 'Dashboard' ? 'active' : '' }}">
             <a href="{{ route('dashboard') }}" class="menu-link">
                 <i class="menu-icon tf-icons bx bx-home-circle"></i>
                 <div data-i18n="Analytics">Dashboard</div>
             </a>
         </li>

         <li class="menu-header small text-uppercase">
             <span class="menu-header-text">User</span>
         </li>
         <li class="menu-item {{ $title == 'Mahasiswa' ? 'active' : '' }}">
             <a href="{{ route('mahasiswa.index') }}" class="menu-link">
                 <i class='menu-icon bx bx-group'></i>
                 <div data-i18n="Analytics">Data Mahasiswa</div>
             </a>
         </li>
         <!-- <li class="menu-item {{ $title == 'Pembimbing Lapangan' ? 'active' : '' }}">
             <a href="{{ route('pembimbing-lapangan.index') }}" class="menu-link">
                 <i class='menu-icon bx bx-group'></i>
                 <div data-i18n="Analytics">Pemb Lapangan</div>
             </a>
         </li> -->
         <li class="menu-item {{ $title == 'Dosen Pembimbing' ? 'active' : '' }}">
             <a href="{{ route('dosen-pembimbing.index') }}" class="menu-link">
                 <i class='menu-icon bx bx-group'></i>
                 <div data-i18n="Analytics">Dosen Pembimbing</div>
             </a>
         </li>

         <li class="menu-item {{ $title == 'Authentication' ? 'active' : '' }}">
             <a href="{{ route('authentication.index') }}" class="menu-link">
                <i class='menu-icon bx bx-log-in'></i>
                 <div data-i18n="Analytics">Authentication</div>
             </a>
         </li>
         <li class="menu-header small text-uppercase">
             <span class="menu-header-text">Lokasi PPL</span>
         </li>
         <li class="menu-item {{ $title == 'Tempat PPL' ? 'active' : '' }}">
             <a href="{{route('lokasi.index')}}" class="menu-link">
                <i class='bx bx-current-location'></i>
                 <div data-i18n="Analytics">Tempat PPL</div>
             </a>
         </li>
     </ul>
 </aside>
