<div class="sidebar">
    <!-- Sidebar user panel (optional) -->

    <!-- Sidebar Menu -->
    <nav class="mt-1">
        <ul class="nav nav-pills nav-sidebar flex-column nav-child-indent" data-widget="treeview" role="menu" data-accordion="false">
            
            <li class="nav-item">
                <a href="{{ route('backend.admin.dashboard') }}"
                    class="nav-link {{ menuActive('backend.admin.dashboard') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>
                        ড্যাসবোর্ড
                    </p>
                </a>
            </li>

            @if(auth()->user()->type== 'Admin')
            <li class="nav-item">
                <a href="{{ route('customers.index') }}"
                    class="nav-link {{ menuActive('customers.index') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        গ্রাহক লিস্ট
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('customers.create') }}"
                    class="nav-link {{ menuActive('customers.create') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-user-plus"></i>
                    <p>
                       নতুন গ্রাহক তৈরি
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.admin.users') }}"
                    class="nav-link {{ menuActive('backend.admin.users') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-users"></i>
                    <p>
                        Members
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('manage-notice.index') }}"
                    class="nav-link {{ menuActive('manage-notice.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-bell"></i>
                    <p>
                        Notice
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('projects.index') }}"
                    class="nav-link {{ menuActive('projects.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-folder"></i>
                    <p>
                        Projects
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('amount-deposited.index') }}"
                    class="nav-link {{ menuActive('amount-deposited.*') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-dollar-sign"></i>
                    <p>
                        Deposit/Loan
                    </p>
                </a>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-credit-card nav-icon"></i>
                    <p>
                        Reports
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('reports.due')}}"
                            class="nav-link {{ menuActive(['reports.due']) ? 'active' : '' }}">
                            <i class="fas fa-chevron-circle-right nav-icon"></i>
                            <p>Monthly Due</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('reports.projects')}}"
                            class="nav-link {{ menuActive(['reports.projects']) ? 'active' : '' }}">
                            <i class="fas fa-chevron-circle-right nav-icon"></i>
                            <p>Project Reports</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('reports.monthly-collection')}}"
                            class="nav-link {{ menuActive(['reports.monthly-collection']) ? 'active' : '' }}">
                            <i class="fas fa-chevron-circle-right nav-icon"></i>
                            <p>Monthly Collection</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{route('reports.income-expense')}}"
                            class="nav-link {{ menuActive(['reports.income-expense']) ? 'active' : '' }}">
                            <i class="fas fa-chevron-circle-right nav-icon"></i>
                            <p>Yearly Reports</p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog nav-icon"></i>
                    <p>
                        Website Settings
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('text-slider.index') }}"
                            class="nav-link {{ menuActive('text-slider.*') ? 'active' : '' }}">
                            <i class="fas fa-folder nav-icon"></i>
                            <p>Text Slider</p>
                        </a>
                    </li>
                     <li class="nav-item">
                        <a href="{{ route('menus.index') }}"
                            class="nav-link {{ menuActive('menus.*') ? 'active' : '' }}">
                            <i class="fas fa-folder nav-icon"></i>
                            <p>Menu Settings</p>
                        </a>
                    </li>
                     <li class="nav-item">
                        <a href="{{ route('backend.admin.settings.website.general') }}?active-tab=website-info"
                            class="nav-link {{ menuActive('backend.admin.settings.website.general') ? 'active' : '' }}">
                            <i class="fas fa-circle nav-icon"></i>
                            <p>General Settings</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>

<script>
    // Get all elements with the nav-treeview class
    const treeviewElements = document.querySelectorAll('.nav-treeview');

    // Iterate over each treeview element
    treeviewElements.forEach(treeviewElement => {
        // Check if it has the nav-link and active classes
        const navLinkElements = treeviewElement.querySelectorAll('.nav-link.active');

        // If there are nav-link elements with the active class, log the treeview element
        if (navLinkElements.length > 0) {
            // Add the menu-open class to the parent nav-item
            const parentNavItem = treeviewElement.closest('.nav-item');
            if (parentNavItem) {
                parentNavItem.classList.add('menu-open');
            }

            // Add the active class to the immediate child nav-link
            const childNavLink = parentNavItem.querySelector('.nav-link');
            if (childNavLink) {
                childNavLink.classList.add('active');
            }
        }
    });
</script>
