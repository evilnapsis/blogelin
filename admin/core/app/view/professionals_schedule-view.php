<?php
$p = ProfessionalData::getById($_GET["id"]);
$u = UserData::getById($p->user_id);
$schedules = ScheduleData::getAllByProfessional($p->id);

$days = ["Lunes", "Martes", "Miércoles", "Jueves", "Viernes", "Sábado", "Domingo"];
?>
<div class="row">
    <div class="col-md-12">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="./?view=professionals&opt=all" class="text-decoration-none text-indigo-600">Profesionales</a></li>
                <li class="breadcrumb-item active">Horario: <?php echo $u->name." ".$u->lastname; ?></li>
            </ol>
        </nav>

        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Gestión de Horario</h1>
                <p class="text-muted mb-0">Define la disponibilidad semanal para <?php echo $u->name; ?></p>
            </div>
            <div class="ms-auto text-end">
                <div class="small text-muted mb-1">Duración Cita</div>
                <span class="badge bg-indigo-100 text-indigo-700 fs-6 px-3"><?php echo $p->appointment_duration; ?> minutos</span>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Form Side -->
    <div class="col-md-4">
        <div class="card border-0 shadow-sm sticky-top" style="top: 100px; border-radius: 20px;">
            <div class="card-body p-4">
                <h5 class="fw-bold mb-4 text-indigo-900"><i class="bi bi-clock-history me-2"></i> Nuevo Bloque</h5>
                <form id="add-schedule-form">
                    <input type="hidden" name="professional_id" value="<?php echo $p->id; ?>">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Día de la Semana</label>
                        <select name="day_of_week" class="form-select border-0 bg-light" required style="border-radius: 10px;">
                            <?php foreach($days as $idx => $day): ?>
                                <option value="<?php echo $idx + 1; ?>"><?php echo $day; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Hora Inicio</label>
                        <input type="time" name="start_time" class="form-control border-0 bg-light" required style="border-radius: 10px;">
                    </div>
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Hora Fin</label>
                        <input type="time" name="end_time" class="form-control border-0 bg-light" required style="border-radius: 10px;">
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-indigo text-white fw-bold py-2 shadow-sm" style="border-radius: 10px;">
                            <i class="bi bi-plus-circle me-1"></i> Agregar Horario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- List Side -->
    <div class="col-md-8">
        <div class="card border-0 shadow-sm" style="border-radius: 20px;">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">Día</th>
                                <th>Horario (Inicio - Fin)</th>
                                <th>Duración Total</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($schedules) > 0): ?>
                                <?php foreach($schedules as $s): ?>
                                <tr>
                                    <td class="ps-4 fw-bold text-dark"><?php echo $days[$s->day_of_week - 1]; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <span class="badge bg-indigo-50 text-indigo-600 px-2 py-1"><?php echo date("h:i A", strtotime($s->start_time)); ?></span>
                                            <i class="bi bi-arrow-right mx-2 text-muted opacity-50"></i>
                                            <span class="badge bg-indigo-50 text-indigo-600 px-2 py-1"><?php echo date("h:i A", strtotime($s->end_time)); ?></span>
                                        </div>
                                    </td>
                                    <td>
                                        <?php 
                                            $t1 = strtotime($s->start_time);
                                            $t2 = strtotime($s->end_time);
                                            $diff = ($t2 - $t1) / 3600;
                                            echo number_format($diff, 1)." hrs";
                                        ?>
                                    </td>
                                    <td class="pe-4 text-end">
                                        <button class="btn btn-outline-danger btn-sm border-0 delete-slot" data-id="<?php echo $s->id; ?>">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center py-5">
                                        <i class="bi bi-calendar-x fs-1 text-muted opacity-25 d-block mb-2"></i>
                                        <p class="text-muted mb-0">No hay horarios definidos aún.</p>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Add Schedule
    const form = document.getElementById('add-schedule-form');
    form.onsubmit = function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        
        fetch('index.php?action=professionals&opt=add_schedule', {
            method: 'POST',
            body: formData
        })
        .then(res => res.text())
        .then(res => {
            if(res.trim() === "success") {
                Swal.fire({
                    icon: 'success',
                    title: 'Horario Agregado',
                    timer: 1500,
                    showConfirmButton: false
                }).then(() => window.location.reload());
            } else {
                Swal.fire({ icon: 'error', title: 'Error', text: res });
            }
        });
    };

    // Delete Schedule
    document.querySelectorAll('.delete-slot').forEach(btn => {
        btn.onclick = function() {
            const id = this.getAttribute('data-id');
            Swal.fire({
                title: '¿Eliminar este bloque?',
                text: "Esta acción no se puede deshacer.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ff4d4d',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Sí, eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`index.php?action=professionals&opt=del_schedule&id=${id}`)
                    .then(res => res.text())
                    .then(res => {
                        if(res.trim() === "success") {
                            window.location.reload();
                        } else {
                            Swal.fire({ icon: 'error', title: 'Error', text: res });
                        }
                    });
                }
            });
        };
    });
});
</script>
