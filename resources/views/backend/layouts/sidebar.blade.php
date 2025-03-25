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
            
            <li class="nav-item d-none">
                <a href="#" class="nav-link">
                    <i class="fas fa-credit-card nav-icon"></i>
                    <p>
                        রিপোর্ট
                        <i class="fas fa-angle-left right"></i>
                    </p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{route('customers.create')}}"
                            class="nav-link {{ menuActive(['customers.create']) ? 'active' : '' }}">
                            <i class="fas fa-chevron-circle-right nav-icon"></i>
                            <p> বাকি/জমার হিসাব </p>
                        </a>
                    </li>
                </ul>
            </li>
            <li class="nav-item">
                <a href="{{ route('backend.admin.settings.website.general') }}?active-tab=website-info"
                    class="nav-link {{ menuActive('backend.admin.settings.website.general') ? 'active' : '' }}">
                    <i class="nav-icon fas fa-cog"></i>
                    <p>
                        সেটিংস
                    </p>
                </a>
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
