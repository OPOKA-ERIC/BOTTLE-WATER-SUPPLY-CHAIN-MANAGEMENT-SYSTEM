@extends('layouts.app', ['activePage' => 'reports', 'title' => 'Manufacturer Reports'])

@section('content')
<div class="content" style="margin-top: 40px !important;">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="content-card">
                    <div class="card-header report-header-blue">
                        <div class="header-content">
                            <h4 class="card-title">Manufacturer Reports</h4>
                            <p class="card-subtitle">Access your production and inventory reports below.</p>
                        </div>
                        <div class="header-icon">
                            <i class="nc-icon nc-chart-bar-32"></i>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Production Report Card -->
                            <div class="col-md-6 mb-4">
                                <div class="stats-card">
                                    <div class="stats-icon">
                                        <i class="nc-icon nc-settings-gear-65"></i>
                                    </div>
                                    <div class="stats-content">
                                        <div class="stats-number">{{ $productionBatches->count() }}</div>
                                        <div class="stats-label">Production Batches</div>
                                    </div>
                                </div>
                            </div>
                            <!-- Inventory Report Card -->
                            <div class="col-md-6 mb-4">
                                <div class="stats-card">
                                    <div class="stats-icon">
                                        <i class="nc-icon nc-box-2"></i>
                                    </div>
                                    <div class="stats-content">
                                        <div class="stats-number">{{ $inventory->count() }}</div>
                                        <div class="stats-label">Inventory Items</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Download Buttons -->
                        <div class="d-flex justify-content-end mt-4 gap-2">
                            <a href="{{ route('manufacturer.production.report.pdf') }}" class="btn btn-primary" target="_blank" rel="noopener">
                                <i class="nc-icon nc-single-copy-04"></i> Download Production PDF
                            </a>
                            <a href="{{ route('manufacturer.inventory.report') }}?pdf=1" class="btn btn-secondary" target="_blank" rel="noopener">
                                <i class="nc-icon nc-single-copy-04"></i> Download Inventory PDF
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
body, .vendor-bg {
    background: #f4f6fa !important;
}
.stats-card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(44, 62, 80, 0.07);
    padding: 1.5rem 1.2rem;
    display: flex;
    align-items: center;
    margin-bottom: 1rem;
    min-height: 120px;
}
.stats-icon {
    width: 48px;
    height: 48px;
    background: #e3e6f3;
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    margin-right: 1rem;
    font-size: 1.5rem;
    color: #1a237e;
}
.stats-content {
    flex: 1;
}
.stats-number {
    font-size: 2rem;
    font-weight: 700;
    color: #1a237e;
    margin-bottom: 0.2rem;
}
.stats-label {
    font-size: 1rem;
    color: #6c757d;
    margin-bottom: 0;
}
.report-header-blue {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%) !important;
    color: #fff !important;
    border-top-left-radius: 20px;
    border-top-right-radius: 20px;
    padding: 2rem 2.5rem 1.5rem 2.5rem;
    display: flex;
    align-items: center;
    justify-content: space-between;
}
.report-header-blue .card-title,
.report-header-blue .card-subtitle,
.report-header-blue .header-icon i {
    color: #fff !important;
}
</style>
@endsection 