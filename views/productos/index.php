<div class="container py-5">
    <div class="row mb-5 justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0 rounded-4">
                <div class="card-body bg-gradient" style="background: linear-gradient(90deg, #f8fafc 60%, #e3f2fd 100%);">
                    <div class="mb-4 text-center">
                        <h5 class="fw-bold text-secondary mb-2">¡Bienvenido a la Aplicación para la gestión de compras de forma organizada!</h5>
                        <h3 class="fw-bold text-primary mb-0">LISTA DE COMPRAS</h3>
                    </div>
                    <form id="FormProductos" class="p-4 bg-white rounded-3 shadow-sm border">
                        <input type="hidden" id="id" name="id">
                        <div class="row g-4 mb-3">
                            <div class="col-md-8">
                                <label for="nombre" class="form-label">Nombre del Producto</label>
                                <input type="text" class="form-control form-control-lg" id="nombre" name="nombre" placeholder="Ej: Papel higiénico" required>
                            </div>
                            <div class="col-md-4">
                                <label for="cantidad" class="form-label">Cantidad</label>
                                <input type="number" class="form-control form-control-lg" id="cantidad" name="cantidad" placeholder="Ej: 3" min="1" required>
                            </div>
                        </div>
                        <div class="row g-4 mb-4">
                            <div class="col-md-6">
                                <label for="categoria_id" class="form-label">Categoría</label>
                                <select name="categoria_id" class="form-select form-select-lg" id="categoria_id" required>
                                    <option value="">-- Seleccione categoría --</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label for="prioridad_id" class="form-label">Prioridad</label>
                                <select name="prioridad_id" class="form-select form-select-lg" id="prioridad_id" required>
                                    <option value="">-- Seleccione prioridad --</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-center gap-3">
                            <button class="btn btn-success btn-lg px-4 shadow" type="submit" id="BtnGuardar">
                                <i class="bi bi-save me-2"></i>Guardar
                            </button>
                            <button class="btn btn-warning btn-lg px-4 shadow d-none" type="button" id="BtnModificar">
                                <i class="bi bi-pencil-square me-2"></i>Modificar
                            </button>
                            <button class="btn btn-secondary btn-lg px-4 shadow" type="reset" id="BtnLimpiar">
                                <i class="bi bi-eraser me-2"></i>Limpiar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row justify-content-center mt-5">
        <div class="col-lg-11">
            <div class="card shadow-lg border-primary rounded-4">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-primary">Lista de Compras</h3>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="mostrarComprados">
                            <label class="form-check-label" for="mostrarComprados">Mostrar productos comprados</label>
                        </div>
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-bordered align-middle rounded-3 overflow-hidden" id="TableProductos">
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalConfirmacion" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmar eliminación</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>¿Estás seguro de que deseas eliminar este producto?</p>
                <input type="hidden" id="eliminarProductoId">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-danger" id="BtnConfirmarEliminar">Eliminar</button>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
<script src="<?= asset('build/js/productos/index.js') ?>"></script>