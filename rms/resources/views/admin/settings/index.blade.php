@extends('layouts.admin')
@section('title', 'Settings')
@section('page-title', 'Restaurant Settings')

@push('styles')
<style>
    .settings-tab {
        border: none;
        background: transparent;
        padding: 12px 20px;
        font-weight: 600;
        font-size: 13px;
        color: #6c757d;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s;
        display: flex;
        align-items: center;
        gap: 8px;
        width: 100%;
        text-align: left;
        margin-bottom: 4px;
    }
    .settings-tab:hover {
        background: #f8f9fa;
        color: #0d6efd;
    }
    .settings-tab.active {
        background: #e8f0fe;
        color: #0d6efd;
    }
    .settings-panel { display: none; }
    .settings-panel.active { display: block; }
    .setting-group {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .setting-group-title {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 2px;
        text-transform: uppercase;
        color: #0d6efd;
        margin-bottom: 16px;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .form-control, .form-select {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 10px 14px;
        transition: all 0.2s;
    }
    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13,110,253,0.1);
    }
    .toggle-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 14px 0;
        border-bottom: 1px solid #e9ecef;
    }
    .toggle-item:last-child { border-bottom: none; }
    .form-check-input {
        width: 44px !important;
        height: 24px !important;
    }
    .form-check-input:checked {
        background-color: #198754;
        border-color: #198754;
    }
</style>
@endpush

@section('content')

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf

    <div class="row g-4">

        <!-- Left: Tab Navigation -->
        <div class="col-lg-3">
            <div class="card border-0 shadow-sm sticky-top"
                 style="top:80px;">
                <div class="card-body p-3">
                    <h6 class="fw-bold mb-3 text-muted small
                                text-uppercase ls-1">
                        Settings Menu
                    </h6>

                    <button type="button" class="settings-tab active"
                            onclick="showPanel('general')">
                        <i class="ti ti-building-store"></i>
                        General Info
                    </button>

                    <button type="button" class="settings-tab"
                            onclick="showPanel('contact')">
                        <i class="ti ti-phone"></i>
                        Contact Info
                    </button>

                    <button type="button" class="settings-tab"
                            onclick="showPanel('business')">
                        <i class="ti ti-cash"></i>
                        Business Rules
                    </button>

                    <button type="button" class="settings-tab"
                            onclick="showPanel('social')">
                        <i class="ti ti-share"></i>
                        Social Media
                    </button>

                    <button type="button" class="settings-tab"
                            onclick="showPanel('system')">
                        <i class="ti ti-settings"></i>
                        System
                    </button>

                    <hr>

                    <button type="submit"
                            class="btn btn-primary w-100">
                        <i class="ti ti-device-floppy me-2"></i>
                        Save All Settings
                    </button>
                </div>
            </div>
        </div>

        <!-- Right: Settings Panels -->
        <div class="col-lg-9">

            @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show
                        border-0 rounded-3 mb-4">
                <i class="ti ti-circle-check me-2"></i>
                {{ session('success') }}
                <button type="button" class="btn-close"
                        data-bs-dismiss="alert"></button>
            </div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger border-0 rounded-3 mb-4">
                @foreach($errors->all() as $e)
                <div><i class="ti ti-x me-1"></i>{{ $e }}</div>
                @endforeach
            </div>
            @endif

            <!-- General Panel -->
            <div class="settings-panel active" id="panel-general">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom">
                        <h6 class="mb-0 fw-bold">
                            <i class="ti ti-building-store me-2
                                       text-primary"></i>
                            General Information
                        </h6>
                    </div>
                    <div class="card-body">

                        <div class="setting-group">
                            <div class="setting-group-title">
                                <i class="ti ti-info-circle"></i>
                                Restaurant Details
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Restaurant Name *
                                </label>
                                <input type="text"
                                       name="restaurant_name"
                                       class="form-control"
                                       value="{{ $settings['restaurant_name'] }}"
                                       required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    About / Description
                                </label>
                                <textarea name="about_text"
                                          class="form-control"
                                          rows="4"
                                          placeholder="Short description...">{{ $settings['about_text'] }}</textarea>
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    Business Hours
                                </label>
                                <input type="text"
                                       name="restaurant_hours"
                                       class="form-control"
                                       value="{{ $settings['restaurant_hours'] }}"
                                       placeholder="e.g. Daily: 12:00 PM - 11:00 PM">
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- Contact Panel -->
            <div class="settings-panel" id="panel-contact">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom">
                        <h6 class="mb-0 fw-bold">
                            <i class="ti ti-phone me-2 text-info"></i>
                            Contact Information
                        </h6>
                    </div>
                    <div class="card-body">

                        <div class="setting-group">
                            <div class="setting-group-title">
                                <i class="ti ti-map-pin"></i>
                                Location & Contact
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        Email *
                                    </label>
                                    <input type="email"
                                           name="restaurant_email"
                                           class="form-control"
                                           value="{{ $settings['restaurant_email'] }}"
                                           required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        Phone *
                                    </label>
                                    <input type="text"
                                           name="restaurant_phone"
                                           class="form-control"
                                           value="{{ $settings['restaurant_phone'] }}"
                                           required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">
                                        Address *
                                    </label>
                                    <textarea name="restaurant_address"
                                              class="form-control"
                                              rows="2"
                                              required>{{ $settings['restaurant_address'] }}</textarea>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        WhatsApp Number
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="ti ti-brand-whatsapp
                                                       text-success"></i>
                                        </span>
                                        <input type="text"
                                               name="whatsapp_number"
                                               class="form-control"
                                               value="{{ $settings['whatsapp_number'] }}"
                                               placeholder="+92 300 1234567">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Business Panel -->
            <div class="settings-panel" id="panel-business">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom">
                        <h6 class="mb-0 fw-bold">
                            <i class="ti ti-cash me-2 text-success"></i>
                            Business Rules
                        </h6>
                    </div>
                    <div class="card-body">

                        <div class="setting-group">
                            <div class="setting-group-title">
                                <i class="ti ti-receipt"></i>
                                Pricing & Charges
                            </div>

                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">
                                        Currency Symbol
                                    </label>
                                    <input type="text"
                                           name="currency"
                                           class="form-control"
                                           value="{{ $settings['currency'] }}"
                                           maxlength="5" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">
                                        Tax (%)
                                    </label>
                                    <div class="input-group">
                                        <input type="number"
                                               name="tax_percentage"
                                               class="form-control"
                                               value="{{ $settings['tax_percentage'] }}"
                                               min="0" max="100" step="0.1">
                                        <span class="input-group-text">%</span>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">
                                        Delivery Charges
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rs.</span>
                                        <input type="number"
                                               name="delivery_charges"
                                               class="form-control"
                                               value="{{ $settings['delivery_charges'] }}"
                                               min="0">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">
                                        Minimum Order Amount
                                    </label>
                                    <div class="input-group">
                                        <span class="input-group-text">Rs.</span>
                                        <input type="number"
                                               name="min_order_amount"
                                               class="form-control"
                                               value="{{ $settings['min_order_amount'] }}"
                                               min="0">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Social Panel -->
            <div class="settings-panel" id="panel-social">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom">
                        <h6 class="mb-0 fw-bold">
                            <i class="ti ti-share me-2 text-warning"></i>
                            Social Media Links
                        </h6>
                    </div>
                    <div class="card-body">

                        <div class="setting-group">
                            <div class="setting-group-title">
                                <i class="ti ti-world"></i>
                                Social Profiles
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="ti ti-brand-facebook
                                               text-primary me-1"></i>
                                    Facebook URL
                                </label>
                                <input type="url"
                                       name="facebook_url"
                                       class="form-control"
                                       value="{{ $settings['facebook_url'] }}"
                                       placeholder="https://facebook.com/...">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="ti ti-brand-instagram
                                               text-danger me-1"></i>
                                    Instagram URL
                                </label>
                                <input type="url"
                                       name="instagram_url"
                                       class="form-control"
                                       value="{{ $settings['instagram_url'] }}"
                                       placeholder="https://instagram.com/...">
                            </div>

                            <div class="mb-3">
                                <label class="form-label fw-semibold">
                                    <i class="ti ti-brand-twitter
                                               text-info me-1"></i>
                                    Twitter URL
                                </label>
                                <input type="url"
                                       name="twitter_url"
                                       class="form-control"
                                       value="{{ $settings['twitter_url'] }}"
                                       placeholder="https://twitter.com/...">
                            </div>

                        </div>

                    </div>
                </div>
            </div>

            <!-- System Panel -->
            <div class="settings-panel" id="panel-system">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-transparent border-bottom">
                        <h6 class="mb-0 fw-bold">
                            <i class="ti ti-settings me-2 text-danger"></i>
                            System Settings
                        </h6>
                    </div>
                    <div class="card-body">

                        <div class="setting-group">
                            <div class="setting-group-title">
                                <i class="ti ti-toggle-right"></i>
                                Feature Toggles
                            </div>

                            <div class="toggle-item">
                                <div>
                                    <div class="fw-semibold">
                                        Allow Online Orders
                                    </div>
                                    <small class="text-muted">
                                        Customers can place orders online
                                    </small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="allow_orders"
                                           id="allow_orders"
                                           {{ $settings['allow_orders'] === '1'
                                               ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="toggle-item">
                                <div>
                                    <div class="fw-semibold">
                                        Allow Reservations
                                    </div>
                                    <small class="text-muted">
                                        Customers can make table reservations
                                    </small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="allow_reservations"
                                           id="allow_reservations"
                                           {{ $settings['allow_reservations'] === '1'
                                               ? 'checked' : '' }}>
                                </div>
                            </div>

                            <div class="toggle-item">
                                <div>
                                    <div class="fw-semibold text-danger">
                                        Maintenance Mode
                                    </div>
                                    <small class="text-muted">
                                        Show maintenance page to visitors
                                    </small>
                                </div>
                                <div class="form-check form-switch mb-0">
                                    <input class="form-check-input"
                                           type="checkbox"
                                           name="maintenance_mode"
                                           id="maintenance_mode"
                                           {{ $settings['maintenance_mode'] === '1'
                                               ? 'checked' : '' }}>
                                </div>
                            </div>

                        </div>

                        <!-- Danger Zone -->
                        <div class="setting-group"
                             style="background:#fff5f5;
                                    border:1px solid #ffcccc;">
                            <div class="setting-group-title"
                                 style="color:#dc3545;">
                                <i class="ti ti-alert-triangle"></i>
                                Danger Zone
                            </div>

                            <div class="d-flex justify-content-between
                                        align-items-center">
                                <div>
                                    <div class="fw-semibold text-danger">
                                        Clear All Cache
                                    </div>
                                    <small class="text-muted">
                                        Clear application cache
                                    </small>
                                </div>
                                <a href="{{ route('admin.settings.cache.clear') }}"
                                   class="btn btn-outline-danger btn-sm"
                                   onclick="return confirm('Clear cache?')">
                                    <i class="ti ti-trash me-1"></i>
                                    Clear Cache
                                </a>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
function showPanel(name) {
    document.querySelectorAll('.settings-panel').forEach(p => {
        p.classList.remove('active');
    });
    document.querySelectorAll('.settings-tab').forEach(t => {
        t.classList.remove('active');
    });
    document.getElementById('panel-'+name).classList.add('active');
    event.currentTarget.classList.add('active');
}
</script>
@endpush