<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="{{route('home')}}" style="text-align:center;padding:0;height:56px;background:white">
            <span class="align-middle" style="padding:3px">
                <img src="{{asset('/img/fixner_logo.png')}}" style="height:50px"/>    
            </span>
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
            @can('view-tasks')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('tasks')}}">
                    <i class="align-middle" data-feather="list"></i>
                    <span class="align-middle">{{__('Tasks')}}</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('answers')}}">
                    <i class="align-middle" data-feather="award"></i>
                    <span class="align-middle">{{__('Answers')}}</span>
                </a>
            </li>
            @endcan
            @can('view-work-order')
            <li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="package"></i>
                    <span class="align-middle">{{__('Work Order')}}</span>
                </a>
            </li>
            @endcan

            @if(auth()->user()->can('view-incidences') || auth()->user()->can('view-answers'))
            <li class="sidebar-header">
                {{__('Audit')}}
            </li>
            @endif
            @can('view-incidences')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('incidences')}}">
                    <i class="align-middle" data-feather="alert-triangle"></i>
                    <span class="align-middle">{{__('Incidence')}}</span>
                </a>
            </li>
            @endcan
            @can('view-answers')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('incidences')}}">
                    <i class="align-middle" data-feather="list"></i>
                    <span class="align-middle">{{__('Answers')}}</span>
                </a>
            </li>
            @endcan

            @if(auth()->user()->can('view-clients') || auth()->user()->can('view-stores') || auth()->user()->can('view-agents'))
            <li class="sidebar-header">
                {{__('Contacts')}}
            </li>
            @endif
            @can('view-clients')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('clients')}}">
                    <i class="align-middle" data-feather="users"></i><span class="align-middle">{{__('Clients')}}</span>
                </a>
            </li>
            @endcan
            @can('view-stores')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('stores')}}">
                    <i class="align-middle" data-feather="shopping-bag"></i><span class="align-middle">{{__('Stores')}}</span>
                </a>
            </li>
            @endcan
            @can('view-agents')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('agents')}}">
                    <i class="align-middle" data-feather="user"></i><span class="align-middle">{{__('Agents')}}</span>
                </a>
            </li>
            @endcan
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('team.index')}}">
                    <i class="align-middle" data-feather="users"></i><span class="align-middle">{{__('Teams')}}</span>
                </a>
            </li>

            @if(auth()->user()->can('translates'))
            <li class="sidebar-header">
                {{__('Tools')}}
            </li>
            @endif
            @can('translates')
            <li class="sidebar-item">
                <a class="sidebar-link" href="/translations" target="_blank">
                    <i class="align-middle" data-feather="type"></i>
                    <span class="align-middle">{{__('Translations')}}</span>
                </a>
            </li>
            @endcan
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('audition')}}">
                    <i class="align-middle" data-feather="type"></i>
                    <span class="align-middle">{{__('Audition')}}</span>
                </a>
            </li>

            <!--<li class="sidebar-item">
                <a class="sidebar-link" href="#">
                    <i class="align-middle" data-feather="type"></i>
                    <span class="align-middle">{{__('Log')}}
                </a>
            </li>-->

            @if(auth()->user()->can('view-users') || auth()->user()->can('view-roles'))
            <li class="sidebar-header">
                {{__('Administration')}}
            </li>
            @endif
            @can('view-users')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('users')}}">
                    <i class="align-middle" data-feather="user"></i>
                    <span class="align-middle">{{__('Users')}}</span>
                </a>
            </li>
            @endcan
            @can('view-roles')
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('roles')}}">
                    <i class="align-middle" data-feather="lock"></i>
                    <span class="align-middle">{{__('Roles')}}</span>
                </a>
            </li>
            @endcan
            @can('view-bulks')
            <li class="sidebar-header">
                    {{__('Bulk data upload')}}
            </li>
            <li class="sidebar-item">
                <a class="sidebar-link" href="{{route('uploads')}}">
                    <i class="align-middle" data-feather="upload"></i>
                    <span class="align-middle">{{__('Upload')}}</i>
                </a>
            </li>
            @endcan
            
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