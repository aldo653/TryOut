  <aside
      class="sidenav bg-white navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-4 "
      id="sidenav-main">
      <div class="sidenav-header">
          <i class="fas fa-times p-3 cursor-pointer text-secondary opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
              aria-hidden="true" id="iconSidenav"></i>
          <a class="navbar-brand m-0" href="{{ route('dashboard') }}" target="_blank">
              <img src="{{ asset('assets/img/Logo UIN.png') }}" width="26px" height="26px"
                  class="navbar-brand-img h-100" alt="main_logo">
              <span class="ms-1 font-weight-bold">SIMAD Ma`had</span>
          </a>
      </div>
      <hr class="horizontal dark mt-0">
      <div class="w-auto " id="sidenav-collapse-main">
          <ul class="navbar-nav">
              @can('dashboard')
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                          href="{{ route('dashboard') }}">
                          <div
                              class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                              <i class="ti ti-dashboard text-dark text-sm opacity-10"></i>
                          </div>
                          <span class="nav-link-text ms-1">Dashboard</span>
                      </a>
                  </li>
              @endcan

              @canany(['assessment', 'assignment'])
                  <li class="nav-item mt-3">
                      <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Assessment</h6>
                  </li>
              @endcanany

              @can('assessment')
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('assessment.index') || request()->routeIs('assessment.detail') ? 'active' : '' }}"
                          href="{{ route('assessment.index') }}">
                          <div
                              class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                              <i class="ti ti-checkup-list text-dark text-sm opacity-10"></i>
                          </div>
                          <span class="nav-link-text ms-1">Assessment</span>
                      </a>
                  </li>

                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('assessment.holistic') || request()->routeIs('assessment.holistic.detail') ? 'active' : '' }}"
                          href="{{ route('assessment.holistic') }}">
                          <div
                              class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                              <i class="ti ti-alert-triangle text-dark text-sm opacity-10"></i>
                          </div>
                          <span class="nav-link-text ms-1">Holistic Assess</span>
                      </a>
                  </li>
              @endcan
              @can('assignment')
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('assignment.index') ? 'active' : '' }}"
                          href="{{ route('assignment.index') }}">
                          <div
                              class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                              <i class="ti ti-notes text-dark text-sm opacity-10"></i>
                          </div>
                          <span class="nav-link-text ms-1">Assignment</span>
                      </a>
                  </li>
              @endcan

              @canany(['master_jadwal', 'master_kegiatan'])
                  <li class="nav-item mt-3">
                      <h6 class="ps-4 ms-2 text-uppercase text-xs font-weight-bolder opacity-6">Master</h6>
                  </li>
              @endcanany

              @can('master_kegiatan')
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('kegiatan.index') ? 'active' : '' }}"
                          href="{{ route('kegiatan.index') }}">
                          <div
                              class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                              <i class="ti ti-calendar text-dark text-sm opacity-10"></i>
                          </div>
                          <span class="nav-link-text ms-1">Kegiatan</span>
                      </a>
                  </li>
              @endcan
              @can('master_jadwal')
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('jadwal.index') ? 'active' : '' }}"
                          href="{{ route('jadwal.index') }}">
                          <div
                              class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                              <i class="ti ti-clock text-dark text-sm opacity-10"></i>
                          </div>
                          <span class="nav-link-text ms-1">Jadwal</span>
                      </a>
                  </li>
              @endcan
              @can('master_pelanggaran')
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('pelanggaran.index') ? 'active' : '' }}"
                          href="{{ route('pelanggaran.index') }}">
                          <div
                              class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                              <i class="ti ti-ban text-dark text-sm opacity-10"></i>
                          </div>
                          <span class="nav-link-text ms-1">Pelanggaran</span>
                      </a>
                  </li>
              @endcan
              @can('user_management')
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}"
                          href="{{ route('user.index') }}">
                          <div
                              class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                              <i class="ti ti-user-cog text-dark text-sm opacity-10"></i>
                          </div>
                          <span class="nav-link-text ms-1">User</span>
                      </a>
                  </li>
              @endcan
              @can('role_management')
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('role.index') ? 'active' : '' }}"
                          href="{{ route('role.index') }}">
                          <div
                              class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                              <i class="ti ti-shield-lock text-dark text-sm opacity-10"></i>
                          </div>
                          <span class="nav-link-text ms-1">Role</span>
                      </a>
                  </li>
              @endcan
              @can('permission_management')
                  <li class="nav-item">
                      <a class="nav-link {{ request()->routeIs('permission.index') ? 'active' : '' }}"
                          href="{{ route('permission.index') }}">
                          <div
                              class="icon icon-shape icon-sm border-radius-md text-center me-2 d-flex align-items-center justify-content-center">
                              <i class="ti ti-key text-dark text-sm opacity-10"></i>
                          </div>
                          <span class="nav-link-text ms-1">Permission</span>
                      </a>
                  </li>
              @endcan
          </ul>
      </div>
  </aside>
