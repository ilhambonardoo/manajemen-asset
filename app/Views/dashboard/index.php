<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="container-fluid py-4">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="h3 text-dark fw-bold border-start border-5 ps-3" style="border-color: #FFD700 !important;">
            Executive Dashboard
        </h2>
        <div class="text-muted">
            <i class="fas fa-calendar-alt me-1"></i> <?= date('d F Y') ?>
        </div>
    </div>

    <div class="row g-4 mb-5">
        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm h-100 border-0 border-top border-4 border-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">Total Assets</p>
                            <h3 class="fw-bold text-dark mb-0"><?= number_format($total_assets) ?></h3>
                        </div>
                        <div class="icon-circle bg-light text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-boxes fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm h-100 border-0 border-top border-4" style="border-color: #FFD700 !important;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">Depr. Expense (Month)</p>
                            <h3 class="fw-bold text-dark mb-0">Rp <?= number_format(
                            	$depreciation_expense,
                            	0,
                            	',',
                            	'.'
                            ) ?></h3>
                        </div>
                        <div class="icon-circle bg-warning bg-opacity-10 text-warning rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-chart-line fa-lg text-dark"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm h-100 border-0 border-top border-4 border-dark">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">Assets Disposed</p>
                            <h3 class="fw-bold text-dark mb-0"><?= number_format($assets_sold_disposed) ?> units</h3>
                        </div>
                        <div class="icon-circle bg-light text-dark rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-hand-holding-usd fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card shadow-sm h-100 border-0 border-top border-4 <?= $gap_accurate_kingdee != 0
            	? 'border-danger'
            	: 'border-success' ?>">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted mb-1 text-uppercase fw-bold" style="font-size: 0.75rem;">Gap (Accurate vs Kingdee)</p>
                            <h3 class="fw-bold mb-0 <?= $gap_accurate_kingdee != 0 ? 'text-danger' : 'text-success' ?>">
                                Rp <?= number_format($gap_accurate_kingdee, 0, ',', '.') ?>
                            </h3>
                        </div>
                        <div class="icon-circle rounded-circle d-flex align-items-center justify-content-center" style="width: 50px; height: 50px;">
                            <i class="fas fa-balance-scale fa-lg"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 mb-4">
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 mx-4 border-0">
                    <h5 class="mb-0 fw-bold">Asset Acquisition Trend</h5>
                </div>
                <div class="card-body">
                    <canvas id="acquisitionChart" style="max-height: 350px;"></canvas>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow-sm border-0 h-100">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold">Asset Status</h5>
                </div>
                <div class="card-body d-flex flex-column justify-content-center align-items-center">
                    <div style="width: 80%;">
                        <canvas id="statusChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-12">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-white py-3 border-0">
                    <h5 class="mb-0 fw-bold">Depreciation Comparison</h5>
                </div>
                <div class="card-body">
                    <canvas id="comparisonChart" style="max-height: 300px;"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const commonOptions = {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom' }
            }
        };

        const ctxAcq = document.getElementById('acquisitionChart').getContext('2d');
        new Chart(ctxAcq, {
            type: 'line',
            data: {
                labels: <?= $acquisition_labels ?? '[]' ?>,
                datasets: [{
                    label: 'Asset Acquisition (Qty)',
                    data: <?= $acquisition_values ?? '[]' ?>,
                    borderColor: '#000000', 
                    backgroundColor: 'rgba(255, 215, 0, 0.2)', 
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#FFD700'
                }]
            },
            options: commonOptions
        });

        const ctxStatus = document.getElementById('statusChart').getContext('2d');
        new Chart(ctxStatus, {
            type: 'doughnut',
            data: {
                labels: ['Active', 'Non-Active'],
                datasets: [{
                    data: [<?= $active_assets ?? 0 ?>, <?= $inactive_assets ?? 0 ?>],
                    backgroundColor: ['#000000', '#FFD700'],
                    borderWidth: 0
                }]
            },
            options: {
                cutout: '70%',
                plugins: { legend: { display: true, position: 'bottom' } }
            }
        });

        const ctxComp = document.getElementById('comparisonChart').getContext('2d');
        new Chart(ctxComp, {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [
                    {
                        label: 'Accurate System',
                        data: <?= $comp_accurate ?? '[]' ?>,
                        backgroundColor: '#343a40'
                    },
                    {
                        label: 'Kingdee System',
                        data: <?= $comp_kingdee ?? '[]' ?>,
                        backgroundColor: '#FFD700'
                    }
                ]
            },
            options: commonOptions
        });
    });
</script>
<?= $this->endSection() ?>
