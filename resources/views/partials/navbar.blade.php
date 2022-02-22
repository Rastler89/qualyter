<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">{{ config('app.name', 'Laravel') }}</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                {{__('Reports')}}
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('home')}}">
                    <i class="align-middle" data-feather="sliders"></i> <span class="align-middle">{{__('Dashboard')}}</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="list"></i>
                    <span class="align-middle">{{__('Tasks')}}</span>
                </a>
            </li>

            <li class="sidebar-header">
                {{__('Tools')}}
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="/translations" target="_blank">
                    <i class="align-middle" data-feather="type"></i>
                    <span class="align-middle">{{__('Translations')}}</span>
                </a>
            </li>

            <li class="sidebar-header">
                {{__('Administration')}}
            </li>

            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('users')}}">
                    <i class="align-middle" data-feather="user"></i>
                    <span class="align-middle">{{__('Users')}}</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="lock"></i>
                    <span class="align-middle">{{__('Roles')}}</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="upload"></i>
                    <span class="align-middle">{{__('Upload')}}</i>
                </a>
            </li>
            
        </ul>

        <!--<div class="sidebar-cta">
            <div class="sidebar-cta-content">
                <strong class="d-inline-block mb-2">Upgrade to Pro</strong>
                <div class="mb-3 text-sm">
                    Are you looking for more components? Check out our premium version.
                </div>
                <div class="d-grid">
                    <a href="upgrade-to-pro.html" class="btn btn-primary">Upgrade to Pro</a>
                </div>
            </div>
        </div>-->
    </div>
</nav>