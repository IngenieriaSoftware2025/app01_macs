import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import { validarFormulario } from '../funciones';
import DataTable from "datatables.net-bs5";
import "datatables.net-rowgroup-bs5";
import { lenguaje } from "../lenguaje";

const FormProductos = document.getElementById('FormProductos');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const InputCantidad = document.getElementById('cantidad');
const SelectCategoria = document.getElementById('categoria_id');
const SelectPrioridad = document.getElementById('prioridad_id');
const CheckMostrarComprados = document.getElementById('mostrarComprados');

const ValidarCantidad = () => {
    const cantidad = InputCantidad.value;

    if (cantidad.length < 1) {
        InputCantidad.classList.remove('is-valid', 'is-invalid');
    } else {
        if (cantidad <= 0) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Revise la cantidad",
                text: "La cantidad debe ser mayor a cero",
                showConfirmButton: true,
            });

            InputCantidad.classList.remove('is-valid');
            InputCantidad.classList.add('is-invalid');
        } else {
            InputCantidad.classList.remove('is-invalid');
            InputCantidad.classList.add('is-valid');
        }
    }
}

const GuardarProducto = async (event) => {
    event.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormProductos, ['id'])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe completar todos los campos",
            showConfirmButton: true,
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormProductos);

    const url = '/app01_macs/productos/guardarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Éxito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarFormulario();
            BuscarProductos();
        } else {
            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.log(error);
    }
    BtnGuardar.disabled = false;
}

const BuscarProductos = async () => {
    const url = '/app01_macs/productos/buscarAPI';
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos;

        if (codigo == 1) {
            let productosAplanados = [];
            
            if (data && Array.isArray(data)) {
                data.forEach(item => {
                    const { categoria, productos } = item;
                    
                    if (productos && Array.isArray(productos)) {
                        productos.forEach(producto => {
                            producto.categoria_nombre = categoria.nombre;
                            productosAplanados.push(producto);
                        });
                    }
                });
            }

            const mostrarComprados = CheckMostrarComprados?.checked || false;
            if (!mostrarComprados) {
                productosAplanados = productosAplanados.filter(producto => 
                    producto.comprado === 'f' || 
                    producto.comprado === false || 
                    producto.comprado === 'false'
                );
            }
            
            datatable.clear().draw();
            datatable.rows.add(productosAplanados).draw();
        } else {
            datatable.clear().draw(); 
        }
    } catch (error) {
        console.error("Error al buscar productos:", error);
        datatable.clear().draw(); 
    }
}

const datatable = new DataTable('#TableProductos', {
    dom: `
        <"row mt-3 justify-content-between" 
            <"col" l> 
            <"col" B> 
            <"col-3" f>
        >
        t
        <"row mt-3 justify-content-between" 
            <"col-md-3 d-flex align-items-center" i> 
            <"col-md-8 d-flex justify-content-end" p>
        >
    `,
    language: lenguaje,
    data: [],
    rowGroup: {
        dataSrc: 'categoria_nombre',
        className: 'table-primary'
    },
    order: [[4, 'asc'], [6, 'asc']],
    columns: [
        {
            title: 'No.',
            data: 'id',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { 
            title: 'Producto', 
            data: 'nombre',
            width: '25%'
        },
        { 
            title: 'Cantidad', 
            data: 'cantidad',
            width: '10%'
        },
        { 
            title: 'Prioridad',
            data: 'prioridad',
            width: '15%',
            render: (data, type, row) => {
                const prioridadClass = 
                    row.valor === 1 ? 'bg-danger text-white' : 
                    row.valor === 2 ? 'bg-warning' : 
                    'bg-info text-dark';
                
                return `<span class="badge ${prioridadClass}">${data}</span>`;
            }
        },
        { 
            title: 'Estado',
            data: 'comprado',
            width: '10%',
            render: (data, type, row) => {
                return (data === 't' || data === true || data === 'true') ? 
                    '<span class="badge bg-success">Comprado</span>' : 
                    '<span class="badge bg-secondary">Pendiente</span>';
            }
        },
        { 
            title: 'Categoría', 
            data: 'categoria_nombre',
            visible: false 
        },
        { 
            title: 'Valor prioridad', 
            data: 'valor',
            visible: false 
        },
        {
            title: 'Acciones',
            data: 'id',
            width: '25%',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                if (row.comprado === 't' || row.comprado === true || row.comprado === 'true') {
                    return `
                    <div class='d-flex justify-content-center'>
                        <button class='btn btn-sm btn-primary cambiar-estado mx-1' 
                            data-id="${data}" 
                            data-comprado="false">
                            <i class='bi bi-arrow-return-left me-1'></i> Pendiente
                        </button>
                        <button class='btn btn-sm btn-danger eliminar mx-1' 
                            data-id="${data}">
                            <i class="bi bi-trash3 me-1"></i> Eliminar
                        </button>
                    </div>`;
                } else {
                    return `
                    <div class='d-flex justify-content-center'>
                        <button class='btn btn-sm btn-success cambiar-estado mx-1' 
                            data-id="${data}" 
                            data-comprado="true">
                            <i class='bi bi-check-circle me-1'></i> Comprado
                        </button>
                        <button class='btn btn-sm btn-warning modificar mx-1' 
                            data-id="${data}" 
                            data-nombre="${row.nombre}"  
                            data-cantidad="${row.cantidad}"  
                            data-categoria="${row.categoria_id}"  
                            data-prioridad="${row.prioridad_id}">
                            <i class='bi bi-pencil-square me-1'></i> Editar
                        </button>
                        <button class='btn btn-sm btn-danger eliminar mx-1' 
                            data-id="${data}">
                            <i class="bi bi-trash3 me-1"></i> Eliminar
                        </button>
                    </div>`;
                }
            }
        }
    ]
});

const llenarFormulario = (event) => {
    const datos = event.currentTarget.dataset;
    
    document.getElementById('id').value = datos.id;
    document.getElementById('nombre').value = datos.nombre;
    document.getElementById('cantidad').value = datos.cantidad;
    document.getElementById('categoria_id').value = datos.categoria;
    document.getElementById('prioridad_id').value = datos.prioridad;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');
}

const limpiarFormulario = () => {
    FormProductos.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

const ModificarProducto = async (event) => {
    event.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormProductos, [''])) {
        Swal.fire({
            position: "center",
            icon: "info",
            title: "FORMULARIO INCOMPLETO",
            text: "Debe completar todos los campos",
            showConfirmButton: true,
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormProductos);

    const url = '/app01_macs/productos/modificarAPI';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Éxito",
                text: mensaje,
                showConfirmButton: true,
            });

            limpiarFormulario();
            BuscarProductos();
        } else {
            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.log(error);
    }
    BtnModificar.disabled = false;
}

const confirmarEliminar = (event) => {
    const id = event.currentTarget.dataset.id;
    
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Realmente deseas eliminar este producto?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            EliminarProducto(id);
        }
    });
}

const EliminarProducto = async (id) => {
    const url = '/app01_macs/productos/eliminarAPI';
    const formData = new FormData();
    formData.append('id', id);

    const config = {
        method: 'POST',
        body: formData
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Éxito",
                text: mensaje,
                showConfirmButton: true,
            });

            BuscarProductos();
        } else {
            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.log(error);
    }
}

const cambiarEstadoProducto = async (event) => {
    const id = event.currentTarget.dataset.id;
    const comprado = event.currentTarget.dataset.comprado;

    const url = '/app01_macs/productos/cambiarEstadoAPI';
    const formData = new FormData();
    formData.append('id', id);
    formData.append('comprado', comprado);

    const config = {
        method: 'POST',
        body: formData
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;

        if (codigo == 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "Éxito",
                text: mensaje,
                showConfirmButton: true,
            });

            BuscarProductos();
        } else {
            await Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: true,
            });
        }
    } catch (error) {
        console.log(error);
    }
}

const CargarSelecciones = async () => {
    const url = '/app01_macs/productos/obtenerSeleccionesAPI';
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, categorias, prioridades } = datos;

        if (codigo == 1) {
            categorias.forEach(categoria => {
                const option = document.createElement('option');
                option.value = categoria.id;
                option.textContent = categoria.nombre;
                SelectCategoria.appendChild(option);
            });

            prioridades.forEach(prioridad => {
                const option = document.createElement('option');
                option.value = prioridad.id;
                option.textContent = prioridad.nombre;
                SelectPrioridad.appendChild(option);
            });
        }
    } catch (error) {
        console.log(error);
    }
}

const toggleMostrarComprados = () => {
    BuscarProductos(); 
}

CargarSelecciones();
BuscarProductos();
FormProductos.addEventListener('submit', GuardarProducto);
InputCantidad.addEventListener('change', ValidarCantidad);
BtnLimpiar.addEventListener('click', limpiarFormulario);
BtnModificar.addEventListener('click', ModificarProducto);
CheckMostrarComprados.addEventListener('change', toggleMostrarComprados);
datatable.on('click', '.modificar', llenarFormulario);
datatable.on('click', '.eliminar', confirmarEliminar);
datatable.on('click', '.cambiar-estado', cambiarEstadoProducto);