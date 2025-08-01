@extends('template')
@section('titulo', 'DTE GUARD - SubClases')
@section('pagina', 'DTE GUARD - SubClases')
@section('contenido')
@verbatim

<div id="app" v-loading.fullscreen.lock="loading" element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
    <h3>Reporte de subsidios y excedentes</h3>
    <div class="row my-1">
        <div class="col-sm">
            <label for="fecha">Rango de fecha:</label>
            <el-date-picker @change="getData()" format="dd/MM/yyyy" v-model="fechas" type="daterange" range-separator="al" start-placeholder="Fecha inicial" end-placeholder="Fecha final">
            </el-date-picker>
        </div>

    </div>
    <button class="btn btn-success btn-sm btn-block my-2" @click="exportData(info,'SubsidioExcedentes')" v-if="info.length>0"><i class="fa fa-file-excel-o"></i> Excel</button>
    <input type="text" class="form-control my-2" placeholder="Buscar..." v-model="busqueda" />

    <div v-if="this.info.length>0">
        <div class="row">
            <div class="col text-center" >
                Totales:
            </div>
        </div>
        <div class="row">
            <div class="col-xl-4 col-md-4 ">
                <div class="card border-left-success shadow h-100 ">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total:</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${{numberFormat(info.reduce((a,b)=>a+parseFloat(b.credito),0))}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-4 ">
                <div class="card border-left-danger shadow h-100 ">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Excedente</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${{numberFormat(info.reduce((a,b)=>a+parseFloat(b.dto_planilla),0))}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4 ">
                <div class="card border-left-warning shadow h-100 ">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Subsidio:</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${{numberFormat(info.reduce((a,b)=>a+parseFloat(b.subsidio_dia),0))}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
        </div>

    </div>
    <br>
    <div class="row">
        <div class="col">
            <el-table :data="infoFiltered" style="width: 100%">
                <el-table-column label="CODIGO" width="120">
                    <template slot-scope="pp">
                        {{pp.row.codigo}}
                    </template>
                </el-table-column>
                <el-table-column label="NOMBRE">
                    <template slot-scope="pp">
                        {{pp.row.nombre}}
                    </template>
                </el-table-column>
                <el-table-column label="FECHA" width="120">
                    <template slot-scope="pp">
                        {{dateFormater(pp.row.fecha_docum)}}
                    </template>
                </el-table-column>
                <el-table-column label="Total" width="120" header-align="right" align="right">
                    <template slot-scope="pp">
                        {{pp.row.credito}}
                    </template>
                </el-table-column>
                <el-table-column label="EXCEDENTE" width="120" header-align="right" align="right">
                    <template slot-scope="pp">
                        {{pp.row.dto_planilla}}
                    </template>
                </el-table-column>
                <el-table-column label="SUBSIDIO" width="160" header-align="right" align="right">
                    <template slot-scope="pp">
                        {{pp.row.subsidio_dia}}
                    </template>
                </el-table-column>                
            </el-table>
        </div>
    </div>


</div>

<script>
    let app = new Vue({
        el: '#app',
        data: {
            busqueda: '',
            fechas: [(localStorage.getItem("f1"))?dayjs(localStorage.getItem("f1")):dayjs(), (localStorage.getItem("f2"))?dayjs(localStorage.getItem("f2")):dayjs()],
            loading: true,
            info: [],
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
                localStorage.setItem("f2",  dayjs(this.fechas[1]));
                this.loading = true;
                axios.post('<?= route('getSubsidios') ?>', {
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
                data = json.map(item=>{
                    return {
                        CODIGO:item.codigo,
                        NOMBRE:item.nombre,
                        FECHA:item.fecha_docum,
                        TOTAL:item.credito,
                        EXCEDENTE:item.dto_planilla,
                        SUBSIDIO:item.subsidio_dia,
                        };
                })
                var ws = XLSX.utils.json_to_sheet(data);
                var wb = XLSX.utils.book_new();
                XLSX.utils.book_append_sheet(wb, ws, "reporte");
                XLSX.writeFile(wb, filename);
            }
        },
        computed: {
            nuevoResumen(){
                let data = []
                if(this.infoFiltered.length>0){
                    this.infoFiltered.forEach(t => {
                        let tmp = data.find(r=>r.codigo==t.codigo);
                        if(!tmp){
                            data.push({codigo:t.codigo, nombre:t.nombre, facturas:[]})
                            tmp = data.find(r=>r.codigo==t.codigo);
                        }
                        //tmp.datos.push(t);         
                        //para meter facturas               
                        let tmpFacturas = tmp.facturas.find(f=>f.documento==t.documento);
                        if(!tmpFacturas){
                            tmp.facturas.push({documento: t.documento, detalles:[] })
                            tmpFacturas = tmp.facturas.find(f=>f.documento==t.documento);
                        }
                        tmpFacturas.detalles.push(t);     
                    });
                }
                
                return data;
            },

            infoFiltered() {
                let data = [];
                data = this.jclear(this.info)
                if (this.info.length > 0) {
                    if (this.busqueda != '') {
                        data = data.filter(b => (
                            (b.codigo?.includes(this.busqueda.toUpperCase())) ||
                            (b.nombre?.includes(this.busqueda.toUpperCase())) ||
                            (this.dateFormater(b.fecha)?.includes(this.busqueda.toUpperCase()))
                        ))
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