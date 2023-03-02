 <aside id="layout-menu" class="layout-menu menu-vertical menu bg-menu-theme">
     <div class="app-brand demo">
         <a href="" class="app-brand-link">
             <img src="{{ asset('assets/img/logo.png') }}" alt="" height="54px">
         </a>

         <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto d-block d-xl-none">
             <i class="bx bx-chevron-left bx-sm align-middle"></i>
         </a>
     </div>

     <div class="menu-inner-shadow"></div>

     <ul class="menu-inner py-1">
         <li class="menu-header small text-uppercase">
             <span class="menu-header-text">Dashboard</span>
         </li>
         <li class="menu-item {{ $title == 'Dashboard Admin' ? 'active' : '' }}">
             <a href="#" class="menu-link">
                 <i class="menu-icon tf-icons bx bx-home-circle"></i>
                 <div data-i18n="Analytics">Dashboard</div>
             </a>
         </li>

         <li class="menu-header small text-uppercase">
             <span class="menu-header-text">User</span>
         </li>
         <li class="menu-item {{ $title == 'Data Masyarakat' ? 'active' : '' }}">
             <a href="#" class="menu-link">
                 <i class='menu-icon bx bx-group'></i>
                 <div data-i18n="Analytics">Data Mahasiswa</div>
             </a>
         </li>
         <li class="menu-item {{ $title == 'Data Masyarakat' ? 'active' : '' }}">
             <a href="#" class="menu-link">
                 <i class='menu-icon bx bx-group'></i>
                 <div data-i18n="Analytics">Pemb Lapangan</div>
             </a>
         </li>
     </ul>
 </aside>
