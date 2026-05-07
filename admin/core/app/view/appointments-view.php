<?php
$opt = isset($_GET["opt"]) ? $_GET["opt"] : "all";
$professionals = ProfessionalData::getAll();
$clients = PersonData::getClients();
$services = ProductData::getServices();
?>
<div class="row">
    <div class="col-md-12">
        <div class="d-flex align-items-center mb-4">
            <div>
                <h1 class="h3 fw-bold mb-0">Agenda de Citas</h1>
                <p class="text-muted mb-0">Gestión de servicios y disponibilidad de staff</p>
            </div>
            <div class="ms-auto d-flex align-items-center">
                <div class="btn-group me-3 shadow-sm">
                    <a href="./?view=appointments&opt=list" class="btn btn-outline-indigo <?php echo ($opt=='list')?'active':''; ?>">
                        <i class="bi bi-list-ul me-1"></i> Lista
                    </a>
                    <a href="./?view=appointments&opt=all" class="btn btn-outline-indigo <?php echo ($opt=='all')?'active':''; ?>">
                        <i class="bi bi-calendar3 me-1"></i> Calendario
                    </a>
                </div>
                <a href="./?view=appointments&opt=new" class="btn btn-indigo shadow-sm fw-bold text-white <?php echo ($opt=='new')?'disabled':''; ?>" style="background:#6366f1">
                    <i class="bi bi-plus-lg me-1"></i> Nueva Cita
                </a>
            </div>
        </div>

        <?php if($opt=="list"): ?>
        <?php $appointments = AppointmentData::getAll(); ?>
        <div class="card border-0 shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 datatable">
                        <thead class="bg-light text-muted small">
                            <tr>
                                <th class="ps-4">ID</th>
                                <th>Cliente</th>
                                <th>Profesional</th>
                                <th>Servicio</th>
                                <th>Fecha / Hora</th>
                                <th>Saldo</th>
                                <th>Estado</th>
                                <th class="pe-4 text-end">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($appointments as $a): 
                                $per = PersonData::getById($a->person_id);
                                $pro = ProfessionalData::getById($a->professional_id);
                                $u_pro = UserData::getById($pro->user_id);
                                $svc = ProductData::getById($a->product_id);
                                $pm = PaymentMethodData::getById($a->payment_method_id);
                                
                                $total_paid = PaymentData::sumByAppointmentId($a->id);
                                $price = $svc ? $svc->price_out : 0;
                                $balance = $price - $total_paid;
                            ?>
                                <tr>
                                    <td class="ps-4 text-muted small">#<?php echo $a->id; ?></td>
                                    <td class="fw-bold"><?php echo $per ? $per->name." ".$per->lastname : "N/A"; ?></td>
                                    <td><?php echo $u_pro->name; ?></td>
                                    <td><span class="badge bg-indigo-100 text-indigo-700"><?php echo $svc ? $svc->name : "N/A"; ?></span></td>
                                    <td>
                                        <div class="fw-bold"><i class="bi bi-calendar-event me-1"></i> <?php echo $a->date; ?></div>
                                        <div class="small text-muted"><i class="bi bi-clock me-1"></i> <?php echo $a->time; ?></div>
                                    </td>
                                    <td>
                                        <div class="fw-bold <?php echo $balance > 0 ? 'text-danger' : 'text-emerald-700'; ?>">
                                            $<?php echo number_format($balance, 2); ?>
                                        </div>
                                        <div class="small text-muted" style="font-size: 10px;">Pagado: $<?php echo number_format($total_paid, 2); ?></div>
                                    </td>
                                    <td>
                                        <?php 
                                        $st_class = "bg-warning text-dark";
                                        $st_text = "Pendiente";
                                        if($a->status == "En Servicio") { $st_class = "bg-info text-white"; $st_text = "En Servicio"; }
                                        if($a->status == "Finalizado") { $st_class = "bg-success text-white"; $st_text = "Finalizado"; }
                                        if($a->status == "cancelled") { $st_class = "bg-danger text-white"; $st_text = "Cancelado"; }
                                        ?>
                                        <span class="badge <?php echo $st_class; ?> rounded-pill"><?php echo $st_text; ?></span>
                                    </td>
                                <td class="pe-4 text-end">
                                    <?php if($a->date == date("Y-m-d") && $a->status=="pending"): ?>
                                        <button class="btn btn-emerald-700 btn-sm fw-bold border-0 text-white" style="background:#10b981" onclick="openCheckin(<?php echo $a->id; ?>)">Check-in</button>
                                    <?php endif; ?>
                                    
                                    <?php if($a->status=="En Servicio"): ?>
                                        <button class="btn btn-indigo btn-sm fw-bold text-white border-0" onclick="finishAppointment(<?php echo $a->id; ?>)"><i class="bi bi-check2-circle"></i> Finalizar</button>
                                    <?php endif; ?>

                                    <button class="btn btn-light btn-sm fw-bold border" onclick="openPayment(<?php echo $a->id; ?>)"><i class="bi bi-wallet2"></i> Pago</button>
                                    <button class="btn btn-light btn-sm ms-1"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm ms-1"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Modal: Add Payment to Appointment -->
        <div class="modal fade" id="paymentModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">Registrar Pago / Abono</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="payment-form">
                        <input type="hidden" name="appointment_id" id="payment_appointment_id">
                        <div class="modal-body p-4">
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Monto del Pago ($) *</label>
                                <input type="number" step="any" name="amount" class="form-control border-2" required placeholder="0.00">
                            </div>
                            <div class="mb-3">
                                <label class="form-label small fw-bold">Método de Pago *</label>
                                <select name="payment_method_id" class="form-select border-2" required>
                                    <?php foreach(PaymentMethodData::getAll() as $m): ?>
                                        <option value="<?php echo $m->id; ?>"><?php echo $m->name; ?></option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Registrar Pago</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal: Check-in Room Assignment -->
        <div class="modal fade" id="checkinModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                    <div class="modal-header border-0 pb-0">
                        <h5 class="modal-title fw-bold">Check-in de Cliente</h5>
                        <button type="button" class="btn-close" data-coreui-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="checkin-form">
                        <input type="hidden" name="appointment_id" id="checkin_appointment_id">
                        <div class="modal-body p-4">
                            <label class="form-label small fw-bold">Asignar Sala / Consultorio *</label>
                            <select name="office_id" class="form-select border-2" required>
                                <option value="">-- Seleccionar Disponible --</option>
                                <?php foreach(OfficeData::getAll() as $o): ?>
                                    <option value="<?php echo $o->id; ?>"><?php echo $o->name; ?></option>
                                <?php endforeach; ?>
                            </select>
                            <p class="small text-muted mt-2">Al realizar el check-in, la cita se marcará como "En Servicio".</p>
                        </div>
                        <div class="modal-footer border-0 pt-0">
                            <button type="button" class="btn btn-light fw-bold" data-coreui-dismiss="modal">Cancelar</button>
                            <button type="submit" class="btn btn-indigo text-white fw-bold px-4">Recibir Cliente</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
        function openCheckin(id) {
            document.getElementById('checkin_appointment_id').value = id;
            const modal = new coreui.Modal(document.getElementById('checkinModal'));
            modal.show();
        }

        function finishAppointment(id){
            Swal.fire({
                title: '¿Confirmar finalización?',
                text: "La cita se marcará como finalizada y el profesional quedará libre.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#6366f1',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, finalizar cita',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('index.php?action=appointments&opt=finish&id=' + id)
                        .then(() => {
                            Swal.fire('¡Cita Finalizada!', '', 'success').then(() => window.location.reload());
                        });
                }
            });
        }

        function openPayment(id) {
            document.getElementById('payment_appointment_id').value = id;
            const modal = new coreui.Modal(document.getElementById('paymentModal'));
            modal.show();
        }

        document.getElementById('payment-form').onsubmit = function(e){
            e.preventDefault();
            fetch('index.php?action=appointments&opt=add_payment', {
                method: 'POST',
                body: new FormData(this)
            }).then(() => {
                Swal.fire('¡Pago Registrado!', '', 'success').then(() => window.location.reload());
            });
        }

        document.getElementById('checkin-form').onsubmit = function(e){
            e.preventDefault();
            fetch('index.php?action=appointments&opt=checkin', {
                method: 'POST',
                body: new FormData(this)
            }).then(() => window.location.reload());
        }
        </script>
        <?php endif; ?>

        <?php if($opt=="all"): ?>
        <div class="row justify-content-center">
            <div class="col-lg-7">
                <div class="card border-0 shadow-sm">
                    <div class="card-body p-4">
                        <div id="calendar-container" style="height: 550px;"></div>
                    </div>
                </div>
            </div>
        </div>

        <script src="vendors/fullcalendar/dist/index.global.min.js"></script>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar-container');
            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },
                locale: 'es',
                events: 'index.php?action=events',
                eventClick: function(info) {
                    Swal.fire({
                        title: 'Detalles de la Cita',
                        html: `
                            <div class="text-start">
                                <p><strong>Cliente:</strong> ${info.event.extendedProps.person}</p>
                                <p><strong>Especialista:</strong> ${info.event.extendedProps.professional}</p>
                                <p><strong>Servicio:</strong> ${info.event.extendedProps.service}</p>
                                <p><strong>Estado:</strong> ${info.event.extendedProps.status}</p>
                            </div>
                        `,
                        icon: 'info'
                    });
                }
            });
            calendar.render();
        });
        </script>
        <?php endif; ?>

        <?php if($opt=="new"): ?>
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="card border-0 shadow-lg" style="border-radius: 25px;">
                    <div class="card-header bg-white border-0 p-4 pb-0 text-center">
                        <h4 class="fw-800 mb-1">ASISTENTE DE RESERVA</h4>
                        <p class="text-muted small">Registra una cita interna de forma dinámica</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <!-- Progress indicators -->
                        <div class="d-flex justify-content-between mb-5 position-relative mx-auto" style="max-width: 600px;">
                            <div class="position-absolute w-100 top-50 start-0 border-top border-2" style="z-index: 1;"></div>
                            <div class="text-center bg-white px-2 position-relative" style="z-index:2"><div class="wizard-step-circle mx-auto active" id="wizard-ind-1">1</div><small class="fw-bold d-none d-md-block mt-2">CLIENTE</small></div>
                            <div class="text-center bg-white px-2 position-relative" style="z-index:2"><div class="wizard-step-circle mx-auto" id="wizard-ind-2">2</div><small class="fw-bold d-none d-md-block mt-2">SERVICIO</small></div>
                            <div class="text-center bg-white px-2 position-relative" style="z-index:2"><div class="wizard-step-circle mx-auto" id="wizard-ind-3">3</div><small class="fw-bold d-none d-md-block mt-2">DISPONIBILIDAD</small></div>
                            <div class="text-center bg-white px-2 position-relative" style="z-index:2"><div class="wizard-step-circle mx-auto" id="wizard-ind-4">4</div><small class="fw-bold d-none d-md-block mt-2">PAGO</small></div>
                        </div>

                        <div id="wizard-content">
                            <!-- Step 1: Client -->
                            <div id="wiz-step-1" class="wizard-view">
                                <h5 class="fw-bold mb-4 text-center">1. ¿Para quién es la cita?</h5>
                                <div class="mb-4">
                                    <label class="form-label small fw-bold">Buscar Cliente</label>
                                    <div class="input-group input-group-lg shadow-sm">
                                        <span class="input-group-text bg-white border-end-0 text-muted"><i class="bi bi-search"></i></span>
                                        <input type="text" class="form-control border-start-0 ps-0" id="client_query" placeholder="Nombre, email o teléfono..." onkeyup="searchClients(this.value)">
                                    </div>
                                    <div id="client-search-results" class="list-group mt-2 shadow-sm d-none"></div>
                                </div>
                                <div class="text-center my-4"><span class="badge bg-light text-muted px-3 fw-normal">O REGISTRAR NUEVO CLIENTE</span></div>
                                <div class="row g-3">
                                    <div class="col-md-6"><input type="text" class="form-control" id="new_client_name" placeholder="Nombre"></div>
                                    <div class="col-md-6"><input type="text" class="form-control" id="new_client_lastname" placeholder="Apellido"></div>
                                    <div class="col-md-6"><input type="email" class="form-control" id="new_client_email" placeholder="Email"></div>
                                    <div class="col-md-6"><input type="tel" class="form-control" id="new_client_phone" placeholder="Teléfono"></div>
                                </div>
                                <div class="mt-5 text-center">
                                    <button class="btn btn-indigo px-5 py-3 fw-bold rounded-3" onclick="validateStep1()">SIGUIENTE PASO <i class="bi bi-arrow-right ms-2"></i></button>
                                </div>
                            </div>



                            <!-- Step 2: Service -->
                            <div id="wiz-step-2" class="wizard-view d-none">
                                <h5 class="fw-bold mb-4 text-center d-flex align-items-center justify-content-center">
                                    <button class="btn btn-light btn-sm rounded-circle me-3" onclick="goToStep(1)"><i class="bi bi-arrow-left"></i></button> 
                                    2. ¿Qué servicio desea?
                                </h5>
                                <div class="row g-3">
                                    <?php foreach($services as $s): ?>
                                    <div class="col-md-6">
                                        <div class="card service-sel overflow-hidden border-2 cursor-pointer h-100 transition-all shadow-sm" onclick="selectService(<?php echo $s->id; ?>, '<?php echo addslashes($s->name); ?>')">
                                            <div style="height: 120px; overflow: hidden; background: #f8fafc;" class="d-flex align-items-center justify-content-center">
                                                <?php if($s->image): ?>
                                                    <img src="storage/products/<?php echo $s->image; ?>" class="w-100 h-100" style="object-fit: cover;">
                                                <?php else: ?>
                                                    <i class="bi bi-scissors fs-1 text-indigo-200"></i>
                                                <?php endif; ?>
                                            </div>
                                            <div class="card-body p-4">
                                            <div class="d-flex justify-content-between align-items-start mb-2">
                                                <h6 class="fw-bold mb-0"><?php echo $s->name; ?></h6>
                                                <div class="text-indigo-600 fw-bold h5 mb-0">$<?php echo number_format($s->price_out, 2); ?></div>
                                            </div>
                                            <p class="small text-muted mb-0"><?php echo $s->description; ?></p>
                                            <div class="mt-3 small text-indigo-500 fw-bold"><i class="bi bi-clock me-1"></i> <?php echo (isset($s->duration)?$s->duration:'30'); ?> min</div>
                                        </div>
                                    </div>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>

                            <!-- Step 3: Combined Availability (Date, Staff Grid, Slots) -->
                            <div id="wiz-step-3" class="wizard-view d-none">
                                <h5 class="fw-bold mb-4 text-center d-flex align-items-center justify-content-center">
                                    <button class="btn btn-light btn-sm rounded-circle me-3" onclick="goToStep(2)"><i class="bi bi-arrow-left"></i></button> 
                                    3. Fecha, Staff y Horario
                                </h5>
                                
                                <div class="row justify-content-center mb-5">
                                    <div class="col-md-6">
                                        <label class="form-label small fw-bold text-center d-block">1. Selecciona el Día</label>
                                        <input type="date" class="form-control form-control-lg border-2 text-center" id="wiz_date" min="<?php echo date("Y-m-d"); ?>" value="<?php echo date("Y-m-d"); ?>" onchange="loadStaffGrid()">
                                    </div>
                                </div>

                                <div id="staff-grid-section" class="mb-5 d-none">
                                    <label class="form-label small fw-bold text-center d-block mb-3">2. Selecciona al Profesional</label>
                                    <div id="staff-grid-container"></div>
                                </div>

                                <div id="slots-section" class="mb-4 d-none">
                                    <label class="form-label small fw-bold text-center d-block mb-3">3. Elige la Hora</label>
                                    <div id="wiz-slots-list" class="d-flex flex-wrap gap-2 justify-content-center"></div>
                                </div>
                            </div>

                            <!-- Step 4: Confirmation & Payment -->
                            <div id="wiz-step-4" class="wizard-view d-none">
                                <h5 class="fw-bold mb-4 text-center d-flex align-items-center justify-content-center">
                                    <button class="btn btn-light btn-sm rounded-circle me-3" onclick="goToStep(3)"><i class="bi bi-arrow-left"></i></button> 
                                    4. Resumen y Pago
                                </h5>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <div class="card h-100 bg-light border-0" style="border-radius: 20px;">
                                            <div class="card-body p-4">
                                                <h6 class="fw-bold mb-4"><i class="bi bi-info-circle me-2"></i>Detalles de Cita</h6>
                                                <div id="wiz-summary" class="small gy-3 d-grid"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="mb-4">
                                            <label class="form-label small fw-bold">Método de Pago</label>
                                            <select id="wiz_payment_method_id" class="form-select border-2 p-3">
                                                <?php foreach(PaymentMethodData::getAll() as $m): ?>
                                                    <option value="<?php echo $m->id; ?>"><?php echo $m->name; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="mb-4">
                                            <label class="form-label small fw-bold">Notas Adicionales</label>
                                            <textarea class="form-control" id="wiz_reason" rows="3" placeholder="Información relevante para la cita..."></textarea>
                                        </div>
                                        <button class="btn btn-indigo w-100 py-3 btn-lg fw-bold rounded-3 shadow" onclick="finishWizard()">
                                            CONFIRMAR RESERVA <i class="bi bi-check2-all ms-2"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <style>
            .wizard-step-circle { width: 44px; height: 44px; border-radius: 50%; background: #f1f5f9; color: #94a3b8; display: flex; align-items: center; justify-content: center; font-weight: 800; border: 2px solid #f1f5f9; transition: 0.3s; }
            .wizard-step-circle.active { background: #6366f1; color: #fff; border-color: #6366f1; box-shadow: 0 0 20px rgba(99, 102, 241, 0.4); }
            .service-sel { border-radius: 20px; transition: all 0.3s; }
            .service-sel:hover { border-color: #6366f1; background: #fdfdff; transform: translateY(-5px); }
            .staff-card { cursor: pointer; border-radius: 20px; border-color: #f1f5f9; }
            .staff-card.active:hover { border-color: #6366f1; transform: scale(1.03); }
            .staff-card.selected { border-color: #6366f1 !important; background-color: #f5f3ff !important; box-shadow: 0 10px 15px -3px rgba(99, 102, 241, 0.1); }
            .slot-btn { border-radius: 12px; border: 2px solid #e2e8f0; font-weight: 700; transition: 0.2s; }
            .slot-btn:hover { background: #6366f1; color: white; border-color: #6366f1; }
            .transition-all { transition: all 0.3s ease; }
            .btn-indigo { background: #6366f1; color: white; }
            .btn-indigo:hover { background: #4f46e5; color: white; }
        </style>

        <script>
            let wizData = { person_id: null, client_name: "", product_id: null, product_name: "", date: null, professional_id: null, professional_name: "", time: null };

            function goToStep(step) {
                document.querySelectorAll('.wizard-view').forEach(el => el.classList.add('d-none'));
                document.getElementById('wiz-step-' + step).classList.remove('d-none');
                
                for(let i=1; i<=4; i++){
                    let ind = document.getElementById('wizard-ind-' + i);
                    if(i <= step) ind.classList.add('active');
                    else ind.classList.remove('active');
                }
            }

            function searchClients(q) {
                if(q.length < 2) { document.getElementById('client-search-results').classList.add('d-none'); return; }
                fetch(`index.php?action=appointments&opt=search_clients&q=${q}`)
                    .then(res => res.json())
                    .then(data => {
                        let html = "";
                        data.forEach(c => {
                            html += `<a href="javascript:void(0)" class="list-group-item list-group-item-action border-0 mb-1 rounded-2 shadow-sm" onclick="selClient(${c.id}, '${c.text}')"><i class="bi bi-person me-2"></i> ${c.text}</a>`;
                        });
                        document.getElementById('client-search-results').innerHTML = html;
                        document.getElementById('client-search-results').classList.remove('d-none');
                    });
            }

            function selClient(id, text) {
                wizData.person_id = id;
                wizData.client_name = text;
                document.getElementById('client_query').value = text;
                document.getElementById('client-search-results').classList.add('d-none');
            }

            function validateStep1() {
                if(!wizData.person_id) {
                    let n = document.getElementById('new_client_name').value;
                    if(n == "") { Swal.fire('Error', 'Debes seleccionar un cliente o registrar uno nuevo.', 'error'); return; }
                    wizData.person_id = "new";
                    wizData.client_name = n + " " + document.getElementById('new_client_lastname').value;
                }
                goToStep(2);
            }

            function selectService(id, name) {
                wizData.product_id = id;
                wizData.product_name = name;
                goToStep(3);
                loadStaffGrid();
            }

            function selectService(id, name) {
                wizData.product_id = id;
                wizData.product_name = name;
                goToStep(3);
                loadStaffGrid();
            }

            function loadStaffGrid() {
                wizData.date = document.getElementById('wiz_date').value;
                document.getElementById('staff-grid-section').classList.remove('d-none');
                document.getElementById('staff-grid-container').innerHTML = '<div class="text-center text-muted py-4"><div class="spinner-border spinner-border-sm me-2"></div> Analizando disponibilidad...</div>';
                document.getElementById('slots-section').classList.add('d-none');
                
                fetch(`index.php?action=appointments&opt=get_staff_grid&date=${wizData.date}&service_id=${wizData.product_id}`)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('staff-grid-container').innerHTML = html;
                    });
            }

            function selectProfessional(id, name) {
                wizData.professional_id = id;
                wizData.professional_name = name;
                
                // Visual toggle
                document.querySelectorAll('.staff-card').forEach(el => el.classList.remove('selected'));
                event.currentTarget.classList.add('selected');
                
                document.getElementById('slots-section').classList.remove('d-none');
                document.getElementById('wiz-slots-list').innerHTML = '<div class="spinner-border spinner-border-sm text-indigo-500"></div>';
                
                fetch(`index.php?action=appointments&opt=get_slots&date=${wizData.date}&professional_id=${id}`)
                    .then(res => res.text())
                    .then(html => {
                        document.getElementById('wiz-slots-list').innerHTML = html;
                    });
            }

            function selectSlot(time) {
                wizData.time = time;
                document.getElementById('wiz-summary').innerHTML = `
                    <div class="border-bottom pb-2 mb-2 d-flex justify-content-between"><span class="text-muted">Cliente</span><span class="fw-bold">${wizData.client_name}</span></div>
                    <div class="border-bottom pb-2 mb-2 d-flex justify-content-between"><span class="text-muted">Servicio</span><span class="fw-bold">${wizData.product_name}</span></div>
                    <div class="border-bottom pb-2 mb-2 d-flex justify-content-between"><span class="text-muted">Staff</span><span class="fw-bold">${wizData.professional_name}</span></div>
                    <div class="d-flex justify-content-between text-indigo-600 h5 mb-0 fw-bold"><span class="text-muted">Fecha y Hora</span><span>${wizData.date} @ ${wizData.time}</span></div>
                `;
                goToStep(4);
            }

            function finishWizard() {
                const fd = new FormData();
                fd.append('person_id', wizData.person_id);
                if(wizData.person_id == "new") {
                    fd.append('client_name', document.getElementById('new_client_name').value);
                    fd.append('client_lastname', document.getElementById('new_client_lastname').value);
                    fd.append('client_email', document.getElementById('new_client_email').value);
                    fd.append('client_phone', document.getElementById('new_client_phone').value);
                }
                fd.append('product_id', wizData.product_id);
                fd.append('date', wizData.date);
                fd.append('professional_id', wizData.professional_id);
                fd.append('time', wizData.time);
                fd.append('payment_method_id', document.getElementById('wiz_payment_method_id').value);
                fd.append('reason', document.getElementById('wiz_reason').value);

                fetch('index.php?action=appointments&opt=add', { method: 'POST', body: fd })
                    .then(res => res.text())
                    .then(res => {
                        if(res.trim() == "success") {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Cita Confirmada!',
                                text: 'La reservación se ha guardado correctamente.',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => window.location.href="./?view=appointments&opt=list");
                        } else {
                            Swal.fire('Error', 'No se pudo agendar la cita: ' + res, 'error');
                        }
                    });
            }
        </script>
        <?php endif; ?>
    </div>
</div>
