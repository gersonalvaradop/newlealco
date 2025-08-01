@extends('template')
@section('titulo', 'DTE GUARD - Reporte E/S')
@section('pagina', 'DTE GUARD - Reporte E/S')
@section('contenido')
@verbatim

<div id="app" v-loading.fullscreen.lock="loading" element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">

    <h3>Reporte de E/S</h3>
    <div class="container">
        <button class="btn btn-success btn-sm btn-block my-2" @click="exportData(info,'Stocks')" v-if="info.length>0"><i class="fa fa-file-excel-o"></i> Excel</button>
        Periodo de tiempo: <br>
        <el-date-picker @change="getData()" format="dd/MM/yyyy" v-model="fechas" type="daterange" range-separator="hasta" start-placeholder="Fecha inicial" end-placeholder="Fecha final">
        </el-date-picker>
        <div class="row my-3">
            <div class="col-sm">
                <label for="clase">Clase</label>
                <el-select style="width: 100%;" size="small" @change="setSubclase()" v-model="clasesSelected" filterable placeholder="Seleccione una clase">
                    <el-option value="">Seleccione una clase</el-option>
                    <el-option v-for="(d,k) in clases" :key="`c${d.id}`" :title="d.nombre" :label="d.nombre" :value="d.id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-sm">
                <label for="subclase">Subclase</label>
                <el-select style="width: 100%;" size="small" v-model="subclasesSelected" filterable placeholder="Seleccione una Sub clase">
                    <el-option value="">Seleccione una Sub clase</el-option>
                    <el-option v-for="(d,k) in subclasesList" :key="`sc${d.id}`" :title="d.nombre" :label="d.nombre" :value="d.id">
                    </el-option>
                </el-select>
            </div>
            <div class="col-sm">
                <label for="materiales">Materiales</label>
                <el-select v-model="materialesSelected" placeholder="Select" style="width: 100%;" size="small" filterable>
                    <el-option value="">Seleccione un material</el-option>
                    <el-option v-for="(d,k) in materiales" :key="d.id" :label="`${d.sku} - ${d.descripcion}`" :value="d.id">
                        {{d.sku}} - {{d.descripcion}}
                    </el-option>
                </el-select>
            </div>
            <div class="col-sm">
                <label for="sucursales">Sucursales</label>
                <el-select v-model="sucursalSeleccionada" clearable placeholder="Seleccione una empresa">
                    <el-option key="A1" label="Todas las empresas" value="">
                    </el-option>
                    <el-option v-for="item in sucursales" :key="item.id" :label="`${item.codigo} - ${item.nombre}`" :value="item.codigo">
                    </el-option>
                </el-select>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <el-table :data="infoFilter" style="width: 100%">
                    <el-table-column type="expand">
                        <template slot-scope="props">
                            <div v-if="props.row.materiales.length>0">

                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>FECHA</th>
                                            <th>SKU</th>
                                            <th>DESCRIPCION</th>
                                            <th>CONCEPTO</th>
                                            <th>CANITDAD</th>
                                            <th>TIPO</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(d,k) in props.row.materiales">
                                            <td><span>{{ dateFormater(d.fecha, 'DD/MM/YYYY')}} </span></td>
                                            <td><span>{{d.material.sku}} </span></td>
                                            <td><span>{{(d.material.descripcion_corta=='' || d.material.descripcion_corta==null)?d.material.descripcion:d.material.descripcion_corta}} </span></td>
                                            <td><span>{{d.concepto}} </span></td>
                                            <td><span>{{d.cantidad}} </span></td>
                                            <td><span> <i v-if="d.tipo_operacion=='entrada'" class="el-icon-caret-top text-success"></i> <i v-if="d.tipo_operacion=='salida'" class="el-icon-caret-bottom text-danger"></i> {{d.tipo_operacion}} </span></td>
                                        </tr>
                                    </tbody>
                                </table>

                            </div>
                            <div v-else>
                                <h4>No se encontraron registros</h4>
                            </div>

                        </template>
                    </el-table-column>
                    <el-table-column label="Nombre">
                        <template slot-scope="pp">
                            {{pp.row.nombre}}
                        </template>
                    </el-table-column>
                    <el-table-column label="Stock actual">
                        <template slot-scope="pp">
                            {{pp.row.stock}}
                        </template>
                    </el-table-column>
                </el-table>
            </div>
        </div>
    </div>



</div>

<script>
    let app = new Vue({
        el: '#app',
        data: {
            materialesSelected: '',
            clasesSelected: '',
            subclasesSelected: '',
            busqueda: '',
            fechas: [(localStorage.getItem("f1")) ? dayjs(localStorage.getItem("f1")) : dayjs(), (localStorage.getItem("f2")) ? dayjs(localStorage.getItem("f2")) : dayjs()],
            loading: true,
            info: [],
            subclasesList: [],
            materiales: <?= $materiales ?>,
            clases: <?= $clases ?>,
            subclases: <?= $subclases ?>,
            sucursalSeleccionada: '',
            sucursales: <?= $sucursales ?>,
        },
        methods: {
            setSubclase() {
                this.subclasesSelected = ''
                if (this.clasesSelected == "") {
                    this.subclasesList = [];
                } else {
                    this.subclasesList = [];
                    let clase = JSON.parse(JSON.stringify(this.clases.find(r => r.id == this.clasesSelected)))
                    this.subclasesList = clase.subclases;
                }
            },
            getData() {
                if (!this.fechas) {
                    this.$message({
                        message: 'Seleccione un rago de fecha valido',
                        type: 'warning'
                    });
                    return;
                }
                if (this.fechas.length != 2) {
                    this.$message({
                        message: 'Seleccione un rago de fecha valido',
                        type: 'warning'
                    });
                    return;
                }
                localStorage.setItem("f1", dayjs(this.fechas[0]));
                localStorage.setItem("f2", dayjs(this.fechas[1]));
                this.loading = true;
                axios.post('<?= route("getKardexDate") ?>', {
                        fechas_ini: dayjs(this.fechas[0]).format('YYYY-MM-DD'),
                        fechas_fin: dayjs(this.fechas[1]).format('YYYY-MM-DD'),
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
            infoFilter() {
                let data = [];
                if (this.info.length > 0) {
                    //data = this.jclear(this.info)   
                    this.info.forEach(v => {
                        let tmp = data.find(r => r.material_id == v.material_id);
                        console.log(tmp);
                        if (!tmp) {
                            data.push({
                                material_id: v.material_id,
                                materiales: [],
                                nombre: v.material.descripcion,
                                clase: v.material.clase,
                                subclase: v.material.subclase,
                                stock: v.material.stock,
                            });
                            tmp = data.find(r => r.material_id == v.material_id);
                        }
                        tmp.materiales.push(v);
                    });

                    if (this.clasesSelected != '') {
                        data = data.filter((i) => {
                            return i.clase == this.clasesSelected
                        });
                    }
                    if (this.materialesSelected != '') {
                        data = data.filter((i) => {
                            return i.material_id == this.materialesSelected
                        });
                    }
                    if (this.subclasesSelected != '') {
                        data = data.filter((i) => {
                            return i.subclase == this.subclasesSelected
                        });
                    }
                    if (this.sucursalSeleccionada != '') {
                        data = data.filter((i) => {
                            return i.empresa == this.sucursalSeleccionada
                        });
                    }



                    if (this.busqueda != '') {
                        data = data.filter(b => (
                            (b.dui.includes(this.busqueda.toUpperCase())) ||
                            (b.numero.includes(this.busqueda.toUpperCase())) ||
                            (b.movil.includes(this.busqueda.toUpperCase())) ||
                            (b.email?.toUpperCase().includes(this.busqueda.toUpperCase())) ||
                            (b.tipodoc?.toUpperCase().includes(this.busqueda.toUpperCase())) ||
                            (b.nombre?.toUpperCase().includes(this.busqueda?.toUpperCase())) ||
                            (b.nrc?.toUpperCase().includes(this.busqueda?.toUpperCase())) ||
                            (b.nombrevendedor?.toUpperCase().includes(this.busqueda?.toUpperCase())) ||
                            (b.direccion?.toUpperCase().includes(this.busqueda?.toUpperCase())) ||
                            (b.documento?.toUpperCase().includes(this.busqueda?.toUpperCase())) ||
                            ((this.dateFormater(b.fecha_docum, 'DD/MM/YYYY')).includes(this.busqueda))

                        ))
                    }
                }

                return data;

            },

        },
        mounted() {
            this.loading = true;
            this.getData()
        },
    });
</script>


@endverbatim
@endsection