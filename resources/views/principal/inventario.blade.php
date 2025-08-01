@extends('template')
@section('titulo', 'DTE GUARD - Registro de E/S')
@section('pagina', 'DTE GUARD - Registro de E/S')
@section('contenido')
@verbatim
<style>
    body,
    .el-input__inner,
    .el-select-dropdown__item {
        font-family: "Inter", sans-serif;
        letter-spacing: 0.16px;
        font-size: 12px;
    }

    .header {
        font-size: 16px;
    }

    input[type="text"],
    .el-input__inner {
        border: 1px solid #cbd5e1;
        border-radius: 5px;
        padding: 10px;
        width: 100%;
    }

    .el-select {
        display: block !important;
    }
</style>

<div id="app" v-loading.fullscreen.lock="loading" element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
    <h2>Registro de entradas y salidas de inventario</h2>
    <button class="btn btn-success btn-sm btn-block my-2" @click="exportData(info,'EntradasSalidas')" v-if="info.length>0"><i class="fa fa-file-excel-o"></i> Excel</button>
    <button type="button" class="btn btn-outline-primary btn-sm float-right d-none" @click="openCrear()">Agregar Movimientos</button>


    <div class="row">
        <div class="col">
            <label for="" class="header">Usuario:</label>
            <span><?= Auth::user()->name ?></span>
        </div>
        <div class="col">
            <div class="row">
                <div class="col">
                    <table>
                        <tr>
                            <td><label for="">Tipo: </label></td>
                            <td>
                                <el-select v-model="registro.tipo_operacion" size="mini" placeholder="Seleccione E/S" filterable>
                                    <el-option key="es1" value="entrada">
                                        Entrada
                                    </el-option>
                                    <el-option key="es2" value="salida">
                                        Salida
                                    </el-option>
                                </el-select>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col">
            <div class="row">
                <div class="col">
                    <table>
                        <tr>
                            <td>Fecha:</td>
                            <td><el-date-picker @change="getData()" format="dd/MM/yyyy" size="mini" type="date" v-model="registro.fecha" placeholder="Seleccione una fecha">
                                </el-date-picker></td>
                        </tr>
                    </table>


                </div>
            </div>
        </div>
    </div>

    <br>

    <div class="row">
        <div class="col">Concepto:<input v-model="registro.concepto" type="text"></div>
    </div>
    <br>
    <div class="row">
        <div class="col">
            Producto:
            <el-select v-model="registro.material_id" width="100" placeholder="Select" filterable>
                <el-option v-for="(d,k) in material.filter(r=>(r.lleva_inventario=='1' && r.activo=='1'))" :key="d.id" :label="`${d.sku} - ${d.descripcion}`" :value="d.id">
                    {{d.sku}} - {{d.descripcion}}
                </el-option>
            </el-select>
            <br>

        </div>
    </div>
    <div class="row">

        <div class="col">Cantidad: <input v-model='registro.cantidad' type="number" min="0"></div>
        <div class="col">Costo: <input v-model='registro.costo' type="number" min="0"></div>
        <div class="col"><button type="button" class="btn btn-xs btn-info" @click="grabar()">Agregar Movimiento</button></div>
    </div>

    <div v-if="info.length>0">

        <table class="table">
            <thead>
                <tr>
                    <th>FECHA</th>
                    <th>SKU</th>
                    <th>DESCRIPCION</th>
                    <th>CONCEPTO</th>
                    <th>CANITDAD</th>
                    <th>COSTO</th>
                    <th>TIPO</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(d,k) in info">
                    <td><span>{{ dateFormater(d.fecha, 'DD/MM/YYYY')}} </span></td>
                    <td><span>{{getMaterial(d.material_id)?.sku}} </span></td>
                    <td><span>{{(getMaterial(d.material_id)?.descripcion_corta=='' || getMaterial(d.material_id)?.descripcion_corta==null)?getMaterial(d.material_id)?.descripcion:getMaterial(d.material_id)?.descripcion_corta}} </span></td>
                    <td><span>{{d.concepto}} </span></td>
                    <td><span>{{d.cantidad}} </span></td>
                    <td><span>{{d.costo}} </span></td>
                    <td><span> <i v-if="d.tipo_operacion=='entrada'" class="el-icon-caret-top text-success"></i> <i v-if="d.tipo_operacion=='salida'" class="el-icon-caret-bottom text-danger"></i> {{d.tipo_operacion}} </span></td>
                </tr>
            </tbody>
        </table>

    </div>
    <div v-else>
        <h4 class="my-5">No se encontraron registros</h4>
    </div>
    <div v-loading='loading' class='modal fade' id='crearClaseModal' tabindex='-1' aria-labelledby='crearClaseLabel' aria-hidden='true'>
        <div class='modal-dialog modal-xl '>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='crearClaseLabel'>Crear Clase</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body' v-loading='loading'>
                    <div class='d-flex flex-wrap'>
                        Nombre de la clase: <input type="text" class="form-control" v-model="clase.nombre">
                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                    <button type='button' class='btn btn-primary' @click='crearClase()'>Crear</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let app = new Vue({
        el: '#app',
        data: {
            registro: {
                material_id: '',
                concepto: '',
                cantidad: 0,
                costo: 0,
                user_id: '<?= Auth::user()->name ?>',
                tipo_operacion: '',
                fecha: dayjs(),
            },
            busqueda: '',
            clase: {
                nombre: ''
            },
            fechas: [dayjs().subtract(180, 'days'), dayjs()],
            loading: true,
            info: [],
            material: <?= $materiales ?>,
        },
        methods: {
            getMaterial(d) {
                let datos = app.material.find(r => r.id == d)
                if(!datos){
                    datos = {
                        sku:'No encontrado',
                        descripcion_corta:'No encontrado',
                        descripcion:'No encontrado'
                    }
                }
                return datos;
            },
            validar() {
                if (this.registro.cantidad == '' || this.registro.cantidad == 0) {
                    this.no('Ingrese una cantidad valida');
                    return;
                }
                if (this.registro.concepto == '') {
                    this.no('Ingrese un concepto valido');
                    return;
                }
                if (this.registro.fecha == null) {
                    this.no('Ingrese una fecha valida');
                    return;
                }
                if (this.registro.material_id == "") {
                    this.no('Seleccione el producto');
                    return;
                }
                if (this.registro.tipo_operacion == "") {
                    this.no('Seleccione el tipo de operación');
                    return;
                }

                return true;

            },
            grabar() {
                if (!this.validar()) {
                    return
                }

                this.loading = true;
                let info = {
                    ...this.registro
                }
                info.fecha = dayjs(info.fecha).format('YYYY-MM-DD');
                axios.post('<?= route('crearInventario') ?>', {
                        datos: info,
                    })
                    .then(res => {
                        app.loading = false;
                        app.registro.cantidad = 0;
                        app.registro.costo = 0;
                        app.si('Agregado con exito');
                        app.getData();
                        $('#crearClaseModal').modal('hide');
                    })
                    .catch(err => {
                        console.error(err);
                        app.loading = false;
                    });
            },
            openCrear() {
                this.clase.nombre = ''
                $('#crearClaseModal').modal();
            },
            crearClase() {
                if (this.clase.nombre == '') {
                    this.no('Ingrese un nombre para la clase');
                    return;
                }
                this.loading = true;
                axios.post('<?= route('crearClase') ?>', {
                        datos: app.clase
                    })
                    .then(res => {
                        app.si("Clase Creada");
                        this.loading = false;
                        app.getData();
                        $('#crearClaseModal').modal('hide');
                        //console.log(res)
                    })
                    .catch(err => {
                        this.loading = false;
                        this.no(err);
                    });


            },
            editaClase(d) {
                d.editando = true;
            },
            saveClase(d) {
                if (d.nombre == '') {
                    this.no('Ingrese un nombre para la clase');
                    return;
                }
                d.editando = false;
                this.loading = true;
                axios.post('<?= route('editClase') ?>', {
                        datos: d
                    })
                    .then(res => {
                        app.si("Registro Modificado");
                        this.loading = false;
                        app.getData();
                        //console.log(res)
                    })
                    .catch(err => {
                        this.loading = false;
                        //console.error(err);
                    });


            },
            getData() {
                if (!this.registro.fecha) {
                    this.no('Ingrese una fecha valida');
                    return;
                }
                this.loading = true;
                axios.post('<?= route('getInventario') ?>', {
                        fecha: dayjs(this.registro.fecha).format('YYYY-MM-DD'),
                    })
                    .then(res => {

                        app.info = res.data;
                        this.loading = false;
                        //console.log(res)
                    })
                    .catch(err => {
                        this.loading = false;
                        //console.error(err);
                    });
            },
            dateFormater(d, f = 'DD/MM/YYYY HH:mm') {
                return (dayjs(d).format(f) == 'Invalid Date') ? '-' : dayjs(d).format(f)
            },
            timeFormater(d) {
                return dayjs(d).format('HH:mm')
            },
            numberFormat(n) {
                const numberWithTwoDecimals = Number(n).toFixed(2);
                let v = numberWithTwoDecimals.toLocaleString('es-MX', {
                    minimumFractionDigits: 2, // Asegura que siempre haya 2 decimales
                    maximumFractionDigits: 2, // Asegura que siempre haya 2 decimales
                });

                const numberAsString = v.toString();

                // Divide la cadena en parte entera y parte decimal (si la tiene)
                const parts = numberAsString.split('.');
                const integerPart = parts[0];
                const decimalPart = parts.length > 1 ? '.' + parts[1] : '';

                // Aplica la expresión regular para insertar comas como separadores de miles en la parte entera
                const integerWithCommas = integerPart.replace(/\B(?=(\d{3})+(?!\d))/g, ',');

                // Combina la parte entera y la parte decimal nuevamente
                const formattedNumber = integerWithCommas + decimalPart;

                return formattedNumber;
            },
            si(mensaje) {
                app.$message({
                    message: mensaje,
                    type: 'success'
                });
            },
            no(mensaje) {
                app.$message({
                    message: mensaje,
                    type: 'warning'
                });
            },
            exportData(json, nombre) {
                filename = nombre + dayjs().format('DDMMYYYYHHmm') + '.xlsx';
                data = json
                var ws = XLSX.utils.json_to_sheet(data);
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "reporte");
                XLSX.writeFile(wb, filename);
            }
        },
        computed: {
            infoFiltered() {
                return this.info;
            }
        },
        mounted() {
            this.loading = true;
            this.getData()
        },
    });
</script>

@endverbatim
@endsection