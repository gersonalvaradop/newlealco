@extends('template')
@section('titulo', 'DTE GUARD - Reporte Jornada')
@section('pagina', 'DTE GUARD - Reporte Jornada')
@section('contenido')
@verbatim
<style>
    .el-table .warning-row {
        background: oldlace;
    }

    .el-table .success-row {
        background: #f0f9eb;
    }
</style>
<div id="app" v-loading.fullscreen.lock="loading" element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
    <h3>
        Reporte Jornada
    </h3>

    <button class="btn btn-success btn-sm btn-block my-2" @click="exportData(info,'ReporteJornada')" v-if="info.length>0"><i class="fa fa-file-excel-o"></i> Excel</button>

    <el-date-picker @change="getData()" format="dd/MM/yyyy" v-model="fechas" type="daterange" range-separator="al" start-placeholder="Fecha inicial" end-placeholder="Fecha final">
    </el-date-picker>

    <el-select v-model="sucursalSeleccionada"  clearable placeholder="Seleccione una empresa">
                <el-option key="A1" label="Todas las empresas" value="">
                </el-option>
                <el-option v-for="item in sucursales" :key="item.id" :label="`${item.codigo} - ${item.nombre}`" :value="item.codigo">
                </el-option>
            </el-select>
    <br>
    <div class="row my-1" v-if="info.length>0">
        <div class="col">
            <div class="card border-left-success shadow h-100 ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total:</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span v-if="info.length>0" class="float-right"><b>Total: ${{numberFormat( general.reduce((a,b)=>a+parseFloat(b.total),0) )}}</b></span>
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <el-table :data="general" style="width: 100%">
        <el-table-column type="expand">
            <template slot-scope="props">

                <el-table style='padding-left:25px;' row-class-name="success-row" :data="props.row.clases" style="width: 100%">
                    <el-table-column type="expand">
                        <template slot-scope="pclase">



                            <el-table style='padding-left:25px;' row-class-name="warning-row" :data="pclase.row.subclases" style="width: 100%">
                                <el-table-column type="expand">
                                    <template slot-scope="psubclase">


                                        <el-table style='padding-left:25px;' :data="psubclase.row.datos" style="width: 100%">
                                            <el-table-column label="lin." prop="linea" width="50"></el-table-column>
                                            <el-table-column label="f.doc" prop="fecha_docum" width="100">
                                                <template slot-scope="pp">
                                                    <span>
                                                        {{dateFormater(pp.row.fecha_docum)}}
                                                    </span>
                                                </template>
                                            </el-table-column>
                                            <el-table-column label="hora" prop="hora" width="60"></el-table-column>
                                            <el-table-column label="sku" prop="sku" width="120"></el-table-column>
                                            <el-table-column label="desc." prop="descripcion" width="300"></el-table-column>
                                            <el-table-column v-if="false" label="jornada" prop="jornada"></el-table-column>
                                            <el-table-column label="cod." prop="codigo" width="90"></el-table-column>
                                            <el-table-column label="nombre" prop="nombre" width="300"></el-table-column>
                                            <el-table-column label="documento" prop="documento" width="120"></el-table-column>
                                            <el-table-column label="cnt" prop="cantidad" width="70"></el-table-column>
                                            <el-table-column label="pre." prop="precio" width="70"></el-table-column>
                                            <el-table-column label="Tot." width="70">
                                                <template slot-scope="pp">
                                                    <span>
                                                        {{(parseFloat(pp.row.contado)+parseFloat(pp.row.credito))}}
                                                    </span>
                                                </template>
                                            </el-table-column>
                                            <el-table-column v-if="false" label="contado" prop="contado"></el-table-column>
                                            <el-table-column v-if="false" label="credito" prop="credito"></el-table-column>
                                            <el-table-column v-if="false" label="apl.subsidio" prop="aplica_subsidio"></el-table-column>
                                            <el-table-column v-if="false" label="sub.dia" prop="subsidio_dia"></el-table-column>
                                            <el-table-column v-if="false" label="sub.dias" prop="subsidio_dias"></el-table-column>
                                            <el-table-column label=""></el-table-column>

                                        </el-table>



                                    </template>
                                </el-table-column>
                                <el-table-column label="Subclase" prop="nombre_subclase">
                                </el-table-column>
                                <el-table-column label="Total" prop="total">
                                </el-table-column>
                                <el-table-column label="Crédito" prop="credito">
                                </el-table-column>
                                <el-table-column label="Contado" prop="contado">
                                </el-table-column>
                            </el-table>


                        </template>
                    </el-table-column>
                    <el-table-column label="Clase" prop="nombre_clase">
                    </el-table-column>
                    <el-table-column label="Total" prop="total">
                    </el-table-column>
                    <el-table-column label="Crédito" prop="credito">
                    </el-table-column>
                    <el-table-column label="Contado" prop="contado">
                    </el-table-column>
                </el-table>




            </template>
        </el-table-column>
        <el-table-column label="Jornada" prop="jornada">
        </el-table-column>

        <el-table-column label="Total">
            <template slot-scope="pp">
                <span>
                    {{numberFormat(pp.row.total)}}
                </span>
            </template>
        </el-table-column>
        <el-table-column label="Crédito" prop="credito">
        </el-table-column>
        <el-table-column label="Contado" prop="contado">
        </el-table-column>
    </el-table>
</div>

<script>
    let app = new Vue({
        el: '#app',
        data: {
            busqueda: '',
            fechas: [(localStorage.getItem("f1")) ? dayjs(localStorage.getItem("f1")) : dayjs(), (localStorage.getItem("f2")) ? dayjs(localStorage.getItem("f2")) : dayjs()],
            loading: true,
            info: [],
            sucursalSeleccionada: '',
            sucursales: <?= $sucursales ?>,

        },
        methods: {
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
                axios.post('<?= route('getReporteJornada') ?>', {
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
            dateFormater(d, f = 'DD/MM/YYYY') {
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
            general() {
                let data = [];
                if (this.info.length > 0) {
                    let tmp, tmpClases, tmpSubclases;
                    let filterInfo = this.info;
                    if (this.sucursalSeleccionada != '') {
                        filterInfo = filterInfo.filter((i) => {
                            return i.empresa == this.sucursalSeleccionada
                        });
                    }


                    filterInfo.forEach(d => {
                        tmp = data.find(r => r.jornada == d.jornada);
                        if (!tmp) {
                            data.push({
                                jornada: d.jornada,
                                datos: [],
                                clases: [],
                                total: 0,
                                credito: 0,
                                contado: 0,
                            });
                            tmp = data.find(r => r.jornada == d.jornada);
                        }
                        tmp.total += parseFloat(d.credito) + parseFloat(d.contado);
                        tmp.credito += parseFloat(d.credito);
                        tmp.contado += parseFloat(d.contado);
                        tmp.datos.push(d);

                        //para definir las clases array
                        d.nombre_clase = (d.nombre_clase == null) ? '-' : d.nombre_clase;
                        tmpClases = tmp.clases.find(r => r.nombre_clase == d.nombre_clase);
                        if (!tmpClases) {
                            tmp.clases.push({
                                nombre_clase: d.nombre_clase,
                                subclases: [],
                                datos: [],
                                total: 0,
                                credito: 0,
                                contado: 0,
                            });
                        }
                        tmpClases = tmp.clases.find(r => r.nombre_clase == d.nombre_clase);
                        tmpClases.total += parseFloat(d.credito) + parseFloat(d.contado);
                        tmpClases.credito += parseFloat(d.credito);
                        tmpClases.contado += parseFloat(d.contado);
                        tmpClases.datos.push(d);

                        //para definir las subclases array
                        d.nombre_subclase = (d.nombre_subclase == null) ? '-' : d.nombre_subclase;
                        tmpSubclases = tmpClases.subclases.find(r => r.nombre_subclase == d.nombre_subclase);
                        if (!tmpSubclases) {
                            tmpClases.subclases.push({
                                nombre_subclase: d.nombre_subclase,
                                datos: [],
                                total: 0,
                                credito: 0,
                                contado: 0,
                            });
                        }
                        tmpSubclases = tmpClases.subclases.find(r => r.nombre_subclase == d.nombre_subclase);
                        tmpSubclases.total += parseFloat(d.credito) + parseFloat(d.contado);
                        tmpSubclases.credito += parseFloat(d.credito);
                        tmpSubclases.contado += parseFloat(d.contado);
                        tmpSubclases.datos.push(d);


                    });
                }
                data.forEach(t => {
                    t.clases.forEach(c => {
                        c.total = this.numberFormat(c.total)
                        c.credito = this.numberFormat(c.credito)
                        c.contado = this.numberFormat(c.contado)
                        c.subclases.forEach(s => {
                            s.total = this.numberFormat(s.total)
                            s.credito = this.numberFormat(s.credito)
                            s.contado = this.numberFormat(s.contado)
                        });
                    });
                    t.total = (t.total)
                    t.credito = this.numberFormat(t.credito)
                    t.contado = this.numberFormat(t.contado)
                });

                

                

                return data;

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