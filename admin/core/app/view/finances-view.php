<?php
$incomes = IncomeData::getAll();
$expenses = ExpenseData::getAll();

$total_income = 0;
foreach($incomes as $inc) { $total_income += $inc->amount; }

$total_expense = 0;
foreach($expenses as $exp) { $total_expense += $exp->amount; }

$net_income = $total_income - $total_expense;
?>

<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Gestión Financiera</h1>
                <p class="text-muted mb-0">Control de ingresos, egresos y flujo de caja</p>
            </div>
            <div class="ms-auto d-flex">
                <button class="btn btn-success shadow-sm fw-bold me-2" data-coreui-toggle="modal" data-coreui-target="#modalNewIncome">
                    <i class="bi bi-plus-lg me-1"></i> Nuevo Ingreso
                </button>
                <button class="btn btn-danger shadow-sm fw-bold" data-coreui-toggle="modal" data-coreui-target="#modalNewExpense">
                    <i class="bi bi-dash-lg me-1"></i> Nuevo Egreso
                </button>
            </div>
        </div>

        <!-- Summary Cards and Chart -->
        <div class="row g-4 mb-4">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm h-100">
                    <div class="card-header bg-white p-4 border-0 pb-0">
                        <h5 class="fw-bold mb-0">Flujo de Caja Mensual</h5>
                    </div>
                    <div class="card-body p-4">
                        <canvas id="financeChart" style="height: 250px;"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="row g-4 h-100">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4 d-flex align-items-center">
                                <div class="bg-success-subtle p-3 rounded-circle me-3" style="background:#dcfce7">
                                    <i class="bi bi-graph-up-arrow text-success fs-3"></i>
                                </div>
                                <div>
                                    <div class="text-muted small fw-bold">INGRESOS TOTALES</div>
                                    <div class="fs-4 fw-800 text-success">$<?php echo number_format($total_income, 2); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body p-4 d-flex align-items-center">
                                <div class="bg-danger-subtle p-3 rounded-circle me-3" style="background:#fee2e2">
                                    <i class="bi bi-graph-down-arrow text-danger fs-3"></i>
                                </div>
                                <div>
                                    <div class="text-muted small fw-bold">EGRESOS TOTALES</div>
                                    <div class="fs-4 fw-800 text-danger">$<?php echo number_format($total_expense, 2); ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <div class="card border-0 shadow-sm h-100 bg-indigo-900" style="background:#1e1b4b">
                            <div class="card-body p-4 text-white">
                                <div class="small fw-bold opacity-75">BALANCE NETO</div>
                                <div class="fs-2 fw-800">$<?php echo number_format($net_income, 2); ?></div>
                                <div class="mt-2 small opacity-50">Corte al <?php echo date("d/m/Y"); ?></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row g-4">
            <!-- Incomes Table -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white p-4 border-0">
                        <h5 class="fw-bold mb-0">Historial de Ingresos</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 datatable">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Fuente</th>
                                        <th>Fecha</th>
                                        <th class="pe-4 text-end">Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($incomes as $inc): ?>
                                    <tr>
                                        <td class="ps-4"><?php echo $inc->source; ?></td>
                                        <td class="small text-muted"><?php echo $inc->date; ?></td>
                                        <td class="pe-4 text-end fw-bold text-success">$<?php echo number_format($inc->amount, 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Expenses Table -->
            <div class="col-md-6">
                <div class="card border-0 shadow-sm">
                    <div class="card-header bg-white p-4 border-0">
                        <h5 class="fw-bold mb-0">Historial de Egresos</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0 datatable">
                                <thead class="bg-light">
                                    <tr>
                                        <th class="ps-4">Categoría / Descripción</th>
                                        <th>Fecha</th>
                                        <th class="pe-4 text-end">Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($expenses as $exp): ?>
                                    <tr>
                                        <td class="ps-4">
                                            <div class="fw-bold"><?php echo $exp->category; ?></div>
                                            <div class="small text-muted"><?php echo $exp->description; ?></div>
                                        </td>
                                        <td class="small text-muted"><?php echo $exp->date; ?></td>
                                        <td class="pe-4 text-end fw-bold text-danger">$<?php echo number_format($exp->amount, 2); ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nuevo Ingreso -->
<div class="modal fade" id="modalNewIncome" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-success text-white">
        <h5 class="modal-title fw-bold">Registrar Ingreso</h5>
        <button type="button" class="btn-close btn-close-white" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="./?action=finances&opt=add_income">
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label fw-bold">Procedencia / Fuente</label>
            <input type="text" name="source" class="form-control" placeholder="Ej. Donación, Pago extra..." required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Monto ($)</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
          </div>
          <div class="mb-0">
            <label class="form-label fw-bold">Fecha</label>
            <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-success fw-bold">Guardar Ingreso</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Modal Nuevo Egreso -->
<div class="modal fade" id="modalNewExpense" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content border-0 shadow">
      <div class="modal-header bg-danger text-white">
        <h5 class="modal-title fw-bold">Registrar Egreso / Gasto</h5>
        <button type="button" class="btn-close btn-close-white" data-coreui-dismiss="modal" aria-label="Close"></button>
      </div>
      <form method="post" action="./?action=finances&opt=add_expense">
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label fw-bold">Categoría</label>
            <input type="text" name="category" class="form-control" placeholder="Ej. Renta, Insumos, Nómina" required>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Descripción</label>
            <textarea name="description" class="form-control" rows="2" placeholder="Detalle opcional..."></textarea>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Monto ($)</label>
            <input type="number" step="0.01" name="amount" class="form-control" required>
          </div>
          <div class="mb-0">
            <label class="form-label fw-bold">Fecha</label>
            <input type="date" name="date" class="form-control" value="<?php echo date('Y-m-d'); ?>" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-coreui-dismiss="modal">Cancelar</button>
          <button type="submit" class="btn btn-danger fw-bold">Guardar Egreso</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('financeChart');
    if (ctx) {
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ['Mínimo Hist.', 'Promedio', 'Mes Actual'],
                datasets: [
                    {
                        label: 'Ingresos',
                        data: [1200, 1900, <?php echo $total_income; ?>],
                        backgroundColor: 'rgba(25, 135, 84, 0.7)',
                        borderColor: 'rgb(25, 135, 84)',
                        borderWidth: 1
                    },
                    {
                        label: 'Egresos',
                        data: [400, 1000, <?php echo $total_expense; ?>],
                        backgroundColor: 'rgba(220, 53, 69, 0.7)',
                        borderColor: 'rgb(220, 53, 69)',
                        borderWidth: 1
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    }
});
</script>
