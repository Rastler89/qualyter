<div class="col-12">
    <div class="mb-3">
        @if ($message = Session::get('primary'))
        <div class="alert d-flex alert-primary alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon">
                <i class="far fa-fw fa-bell"></i>
            </div>
            <div class="alert-message">
                <strong>{{ __('Primary') }}</strong> {{$message}}
            </div>
        </div>
        @endif
        @if ($message = Session::get('secondary'))
        <div class="alert d-flex alert-secondary alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon">
                <i class="far fa-fw fa-bell"></i>
            </div>
            <div class="alert-message">
                <strong>{{ __('Secondary')}}</strong> {{$message}}
            </div>
        </div>
        @endif
        @if ($message = Session::get('success'))
        <div class="alert d-flex alert-success alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon">
                <i class="far fa-fw fa-bell"></i>
            </div>
            <div class="alert-message">
                <strong>{{ __('Successfully!') }}</strong> {{$message}}
            </div>
        </div>
        @endif
        @if ($message = Session::get('alert'))
        <div class="alert d-flex alert-danger alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon">
                <i class="far fa-fw fa-bell"></i>
            </div>
            <div class="alert-message">
                <strong>{{__('Alert!')}}</strong> {{$message}}
            </div>
        </div>
        @endif
        @if ($message = Session::get('warning'))
        <div class="alert d-flex alert-warning alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon">
                <i class="far fa-fw fa-bell"></i>
            </div>
            <div class="alert-message">
                <strong>{{__('Caution:')}}</strong> {{$message}}
            </div>
        </div>
        @endif
        @if ($message = Session::get('info'))
        <div class="alert d-flex alert-info alert-dismissible" role="alert">
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            <div class="alert-icon">
                <i class="far fa-fw fa-bell"></i>
            </div>
            <div class="alert-message">
                <strong>{{__('Info:')}}</strong> {{$message}}
            </div>
        </div>
        @endif
    </div>
</div>