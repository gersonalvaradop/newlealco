@extends('template')
@section('titulo', 'DTE GUARD - SubClases')
@section('pagina', 'DTE GUARD - SubClases')
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
    <h2>SubClases</h2>
    <button class="btn btn-success btn-sm btn-block my-2" @click="exportData(info,'SubClases')" v-if="info.length>0"><i class="fa fa-file-excel-o"></i> Excel</button>
    <button type="button" class="btn btn-outline-primary btn-sm float-right" @click="openCrear()">Crear Subclase</button>
    <br>
    <div v-if="info.length>0">
        <div class="row">
            <div class="col-sm">
                <label for="clase"></label>
                <el-select style="width: 100%;" size="small" v-model="clasesSelected" filterable placeholder="Seleccione una clase">
                    <el-option value="">Seleccione una clase</el-option>
                    <el-option v-for="(d,k) in clasesList" :key="`c${d.id}`" :title="d.nombre" :label="`${d.id} - ${d.nombre}`" :value="d.id">
                        {{d.id}} - {{d.nombre}}
                    </el-option>
                </el-select>

            </div>
        </div>
        <br>
        <input type="text" class="form-control" placeholder="buscar por..." v-model="busqueda">
        <table class="table">
            <thead>
                <tr>
                    <th style="width: 30px;">ID</th>
                    <th>Nombre</th>
                    <th style="width: 30px;">ID Clase</th>
                    <th>Clase padre</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(d,k) in infoFiltered">
                    <td>{{d.id}}</td>
                    <td><span v-if="d.editando"><input type="text" v-model="d.nombre"></span><span v-else>{{d.nombre}} </span></td>
                    <td>{{d.clase_id}}</td>
                    <td><span v-if="d.editando">
                            <el-select v-model="d.clase_id" filterable placeholder="Seleccione una categoria">
                                <el-option v-for="(d,k) in clasesList" :key="d.id" :label="`${d.id} - ${d.nombre}`" :value="d.id">
                                </el-option>
                            </el-select>
                        </span><span v-else>{{getClaseName(d)}}
                        </span></td>
                    <td>
                        <div v-if="!d.editando">
                            <button class="btn btn-xs btn-warning" type="button" @click="editaClase(d)"><i class="fas fa-edit"></i> Editar</button>
                        </div>
                        <div v-else>
                            <button class="btn btn-xs btn-info" type="button" @click="saveClase(d)"><i class="fa-solid fa-floppy-disk"></i>Guardar</button>
                            <button class="btn btn-xs btn-danger" type="button" @click="info.find(r=>r.id==d.id).editando=false;info.find(r=>r.id==d.id).nombre=info.find(r=>r.id==d.id).nombre_original+'';info.find(r=>r.id==d.id).clase_id=parseInt(info.find(r=>r.id==d.id).clase_id_original)+0;"><i class="fa-solid fa-xmark"></i>Cerrar</button>
                        </div>


                    </td>
                </tr>
            </tbody>
        </table>

    </div>
    <div v-else>
        <h4>No se encontraron registros</h4>
    </div>
    <div v-loading='loading' class='modal fade' id='crearSubClaseModal' tabindex='-1' aria-labelledby='crearClaseLabel' aria-hidden='true'>
        <div class='modal-dialog modal-xl '>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='crearClaseLabel'>Crear subClase</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body' v-loading='loading'>
                    <div class=''>
                        <div>
                            Nombre de la subclase: <input type="text" class="form-control" v-model="subclase.nombre">
                        </div>
                        <br>
                        <div>
                            Clase padre:
                            <el-select v-model="subclase.clase_id" filterable placeholder="Seleccione una clase">
                                <el-option v-for="(d,k) in clasesList" :key="d.id" :label="d.nombre" :value="d.id">
                                </el-option>
                            </el-select>
                        </div>

                    </div>
                </div>
                <div class='modal-footer'>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
                    <button type='button' class='btn btn-primary' @click='crearSubClase()'>Crear</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    let app = new Vue({
        el: '#app',
        data: {
            busqueda: '',
            clasesSelected: '',
            subclase: {
                nombre: '',
                clase_id: '',
            },
            clasesList: <?= $clases ?>,
            fechas: [dayjs().subtract(180, 'days'), dayjs()],
            loading: true,
            info: [],
        },
        methods: {
            getClaseName(d) {
                return this.clasesList.find(r => r.id == d.clase_id)?.nombre;

            },
            openCrear() {
                this.subclase.nombre = ''
                this.subclase.clase_id = ''
                $('#crearSubClaseModal').modal();
            },
            crearSubClase() {
                if (this.subclase.nombre == '') {
                    this.no('Ingrese un nombre para la subclase');
                    return;
                }
                if (this.subclase.clase_id == '') {
                    this.no('Ingrese un nombre para la clase');
                    return;
                }
                this.loading = true;
                axios.post('<?= route('crearSubclase') ?>', {
                        datos: app.subclase
                    })
                    .then(res => {
                        app.si("SubClase Creada");
                        this.loading = false;
                        app.getData();
                        $('#crearSubClaseModal').modal('hide');
                        //console.log(res)
                    })
                    .catch(err => {
                        this.loading = false;
                        //console.error(err);
                    });


            },
            editaClase(d) {
                let t = this.info.find(r => r.id == d.id)
                t.editando = true;
            },
            saveClase(d) {
                if (d.nombre == '') {
                    this.no('Ingrese un nombre para la subclase');
                    return;
                }
                if (d.clase_id == '') {
                    this.no('Ingrese un nombre para la clase');
                    return;
                }
                d.editando = false;
                this.loading = true;
                axios.post('<?= route('editSubclase') ?>', {
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

                this.loading = true;
                axios.post('<?= route('getSubclases') ?>', {

                    })
                    .then(res => {

                        res.data.forEach(element => {
                            element.editando = false;
                            element.nombre_original = element.nombre + '';
                            element.clase_id_original = parseInt(element.clase_id) + 0;
                        });
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
            jclear(d) {
                return JSON.parse(JSON.stringify(d));
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
                let data = [];
                data = this.jclear(this.info)
                if (this.info.length > 0) {
                    if (this.busqueda != '') {
                        data = data.filter(b => (
                            (b.nombre?.includes(this.busqueda.toUpperCase())) ||
                            ((this.getClaseName({
                                clase_id: parseInt(b.clase_id)
                            }))?.toUpperCase().includes(this.busqueda?.toUpperCase()))
                        ))
                    }
                    if (this.clasesSelected != '') {
                        data = data.filter(i => i.clase_id == this.clasesSelected)
                    }
                }
                return data
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