@extends('template')
@section('titulo', 'DTE GUARD - Bienvenido')
@section('pagina', 'DTE GUARD - Bienvenido')
@section('contenido')
@verbatim
<style>
    .amarillo {
        color: rgb(172, 163, 2);
        font-size: 12px;
    }

    .rojo {
        color: #f00;
        font-size: 12px;
    }
</style>
<div id="app" v-loading.fullscreen.lock="loading" :element-loading-text="textoCarga" element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
    <h4 class="display-4" style="font-size: 30px;">Reporte General</h4>
    <button class="btn btn-success btn-sm btn-block my-2" @click="exportData(info,'ReporteGeneral')" v-if="info.length>0"><i class="fa fa-file-excel-o"></i> Excel</button>

    <div class="row">
        <div class="col">
            <el-date-picker @change="getData()" format="dd/MM/yyyy" v-model="fechas" type="daterange" range-separator="hasta" start-placeholder="Fecha inicial" end-placeholder="Fecha final">
            </el-date-picker>
        </div>
        <div class="col">
            <el-select v-model="sucursalSeleccionada" @change="infoFiltered(busqueda)" clearable placeholder="Seleccione una empresa">
                <el-option key="A1" label="Todas las empresas" value="">
                </el-option>
                <el-option v-for="item in sucursales" :key="item.id" :label="`${item.codigo} - ${item.nombre}`" :value="item.codigo">
                </el-option>
            </el-select>
        </div>
        <div class="col">
            <el-select v-model="filtroEstado"  @change="infoFiltered(busqueda)" clearable placeholder="Seleccione un estatus">
                <el-option key="B1" label="Todos los estatus" value="">
                </el-option>
                <el-option key="B2" label="Abierto" value="Abierto">
                </el-option>
                <el-option key="B3" label="Cerrado" value="Cerrado">
                </el-option>
                <el-option key="B4" label="Anulados" value="Anulado">
                </el-option>

            </el-select>
        </div>
        <div class="col">
            <el-select v-model="filtroPago"  @change="infoFiltered(busqueda)" clearable placeholder="Seleccione una forma pago">
                
                <el-option key="" label="Todas formas pago" value="">
                </el-option>
                <el-option v-for="item in formasDePago" :key="item" :label="`${item}`" :value="item">
                </el-option>
                
            </el-select>
        </div>
        <div class="col">
            <el-select v-model="filtroDestino"  @change="infoFiltered(busqueda)" clearable placeholder="Seleccione un destino">
                
                <el-option key="" label="Todos destinos" value="">
                </el-option>
                <el-option v-for="item in destinos" :key="item" :label="`${item}`" :value="item">
                </el-option>
                
            </el-select>
        </div>
    </div>


    <hr>
    <div class="row">
        <div class="col-xl-4 col-md-4 ">
            <div class="card border-left-success shadow h-100 ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total MYPOS:</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">$ {{numberFormat(totalGeneral)}}<br>
                                <div v-if="false">
                                    <small style="color:red;font-size:10px;" v-if="((totalGeneral-totalMH)>0)||((totalGeneral-totalSAP)>0)">Diff: (MH $ {{numberFormat(totalGeneral-totalMH)}}) *** (ERP $ {{numberFormat(totalGeneral-totalSAP)}}) </small>

                                </div>
                            </div>
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
                                Total Crédito:</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><span style="color:black;" :class="`${(totalGeneral!=totalMH)?'animate__animated animate__repeat-3 animate__flash':''}`">${{totalCredito}}</span></div>
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
                                Total Contado:</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800"><span style="color:black;" :class="`${(totalGeneral!=totalSAP)?'animate__animated animate__repeat-3 animate__flash':''}`"> ${{totalContado}}</span></div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <small style="color:red;font-size:10px;" class="animate__animated animate__repeat-3 animate__flash" v-if="filtroEstado==''">***Los anulados no son sumados en el total, filtrar por estatus para ver su total ***</small>

    
    <hr>
    <small>
        Se encontraron: {{numberFormat(filteredInfo.length,0)}} registros
    </small>
    <input class="form-control" type="text" placeholder="busqueda..." v-model="busqueda">
    <div class="row">
        <div class="col">
            <i v-if="searchDebounced" class="fa fa-spinner fa-spin"></i>
            <el-table size="small" height="850" :data="filteredInfo" style="width: 100%" :row-class-name="verificaEstilo">
                <el-table-column label="empresa" width="90">
                    <template slot-scope="pp">
                        {{pp.row.empresa}}
                    </template>
                </el-table-column>
                <el-table-column label="fecha_docum" width="130">
                    <template slot-scope="pp">
                        {{dateFormater(pp.row.fecha_docum)}}
                    </template>
                </el-table-column>
                <el-table-column label="hora" width="60">
                    <template slot-scope="pp">
                        {{pp.row.hora}}
                    </template>
                </el-table-column>
                <el-table-column label="caja" width="50">
                    <template slot-scope="pp">
                        {{pp.row.caja}}
                    </template>
                </el-table-column>

                <el-table-column label="documento" width="130">
                    <template slot-scope="pp">
                       <i class="fa fa-file btn" @click="openDetails(pp.row)" ></i> 
                       {{pp.row.documento}}
                    </template>
                </el-table-column>

                <el-table-column label="nombre">
                    <template slot-scope="pp">
                        {{pp.row.nombre}}
                    </template>
                </el-table-column>
                <el-table-column align="right" label="monto" width="60">
                    <template slot-scope="pp">
                        {{pp.row.monto}}
                    </template>
                </el-table-column>

                <el-table-column align="right" label="impuestos" width="90">
                    <template slot-scope="pp">
                        {{pp.row.impuestos}}
                    </template>
                </el-table-column>
                <el-table-column align="right" label="total" width="90">
                    <template slot-scope="pp">
                        {{pp.row.total}}
                    </template>
                </el-table-column>
                <el-table-column label="condicionpago" width="110">
                    <template slot-scope="pp">
                        {{pp.row.condicionpago}}
                    </template>
                </el-table-column>

                <el-table-column label="estatus" width="110">
                    <template slot-scope="pp">
                        {{pp.row.estatus}}
                    </template>
                </el-table-column>

                <el-table-column label="Usuario" width="130">
                    <template slot-scope="pp">
                        {{pp.row.usuario}}
                    </template>
                </el-table-column>

                <el-table-column label="Forma Pago" width="130">
                    <template slot-scope="pp">
                        {{pp.row.formadepago}}
                    </template>
                </el-table-column>

                <el-table-column label="Destino" width="130">
                    <template slot-scope="pp">
                        {{pp.row.destino}}
                    </template>
                </el-table-column>


            </el-table>





        </div>
    </div>

    <div v-loading='loading' class='modal fade' id='detalleModal' tabindex='-1' aria-labelledby='detalleLabel' aria-hidden='true'>
            <div class='modal-dialog modal-xl '>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='detalleLabel'>Detalle de {{detalleDocumento}}</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body' v-loading='loading'>
                        <div class='d-flex flex-wrap'>
   
                            <i class="fa fa-spin fa-spinner" v-if="detalle.length==0"></i>
                            
                            <table v-if="detalle.length>0" class="table">
                                <tr>
                                    <td>Linea</td>
                                    <td>SKU</td>
                                    <td>Descripción</td>
                                    <td>Cantidad</td>
                                    <td>precio+IVA</td>
                                </tr>
                                <tr v-for="(d,k) in detalle">
                                    <td>{{d.linea}}</td>
                                    <td>{{d.sku}}</td>
                                    <td>{{d.descripcion}}</td>
                                    <td>{{d.cantidad}}</td>
                                    <td>{{numberFormat(d.precio)}}</td>
                                </tr>
                                <tr>
                                    <td>Total:</td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td>{{numberFormat( detalle.reduce((acumulador, { precio, cantidad }) => acumulador + ((precio ?? 0) * (cantidad ?? 0)), 0) )}}</td>
                                </tr>
                                


                            </table>
                            
                        </div>
                    </div>
                    <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cerrar</button>
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
            filtroEstado: '',
            filtroPago: '',
            filtroDestino: '',
            textoCarga: 'procesando...',
            fechas: [(localStorage.getItem("f1"))?dayjs(localStorage.getItem("f1")):dayjs(), (localStorage.getItem("f2"))?dayjs(localStorage.getItem("f2")):dayjs()], //.subtract(1, 'days')
            loading: true,
            sucursalSeleccionada: '',
            sucursales: <?= $sucursales ?>,
            info: [],
            detalle: [],
            filteredInfo: [],
            detalleDocumento: "",
            searchDebounced: false,
            searchTimeout: null,
            
        },
        methods: {
            openDetails(detalles){
                
                this.loading = true;
                axios.post('<?= route('getRepoGeneralDetalle') ?>', {
                        documento: detalles.documento,
                    })
                    .then(res => {
                        this.detalle=res.data
                        this.detalleDocumento=detalles.documento
                        this.loading = false;
                        $('#detalleModal').modal();
                        //console.log(res)
                    })
                    .catch(err => {
                        this.loading = false;
                        //console.error(err);
                    });


                

                

            },
            verificaEstilo({
                row,
                rowIndex
            }) {
                if (row.estatus == 'Anulado') {
                    return 'rojo'
                }
                return ''
            },
            tableRowClassName({
                row,
                rowIndex
            }) {

                if (!row.facturasap) {
                    return 'rojo'
                }
                if (!row.sellorecibido) {
                    return 'amarillo'
                }
                return ''
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
                localStorage.setItem("f2",  dayjs(this.fechas[1]));
                this.info = []
                this.loading = true;
                axios.post('<?= route('getRepoGeneral') ?>', {
                        fechas_ini: dayjs(this.fechas[0]).format('YYYY-MM-DD'),
                        fechas_fin: dayjs(this.fechas[1]).format('YYYY-MM-DD'),
                    })
                    .then(res => {
                        app.info = res.data;
                        app.filteredInfo = res.data;
                        this.loading = false;
                        //console.log(res)
                    })
                    .catch(err => {
                        this.loading = false;
                        //console.error(err);
                    });
            },
            tipoRuta(d) {
                switch (d?.substr(0, 1).toUpperCase()) {
                    case '1':
                        return "TIENDA"

                        break;
                    case 'D':
                        return "DETALLE"
                        break;
                    case 'M':
                        return "SAN MIGUEL"
                        break;
                    default:
                        return "DESCONOCIDO"
                        break;
                }

            },
            calcularTotalMH(r) {
                if (r.length > 0) {
                    return r.reduce((c, a) => {
                        return c += (a.sellorecibido) ? parseFloat(a.total) : 0
                    }, 0)
                }
                return 0;
            },
            calcularTotalGeneral(r) {
                if (r.length > 0) {
                    return r.reduce((c, a) => {
                        if(this.filtroEstado=='' && a.estatus=='Anulado'){
                            return 0
                        }
                        return c += parseFloat(a.total)
                    }, 0)
                }
                return 0;
            },
            calcularTotalSAP(r) {
                if (r.length > 0) {
                    return r.reduce((c, a) => {
                        return c += (a.facturasap) ? parseFloat(a.total) : 0
                    }, 0)
                }
                return 0;
            },
            dateFormater(d, f = 'DD/MM/YYYY') {
                return (dayjs(d).format(f) == 'Invalid Date') ? '-' : dayjs(d).format(f)
            },
            timeFormater(d) {
                return dayjs(d).format('HH:mm')
            },
            numberFormat(n,decimales=2) {
                const numberWithTwoDecimals = Number(n).toFixed(decimales);
                let v = numberWithTwoDecimals.toLocaleString('es-MX', {
                    minimumFractionDigits: decimales, // Asegura que siempre haya 2 decimales
                    maximumFractionDigits: decimales, // Asegura que siempre haya 2 decimales
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
                app.message({
                    message: mensaje,
                    type: 'success'
                });
            },
            no(mensaje) {
                app.message({
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
            },

            infoFiltered(newVal) {
                
                this.filteredInfo = []
                    
                    if (this.info.length > 0) {
                    this.filteredInfo = this.jclear(this.info)
                    if (this.filtroEstado != '') {
                        switch (this.filtroEstado) {
                            case "Anulado":
                            this.filteredInfo = this.filteredInfo.filter(r => ((r.estatus.includes('Anulado'))))
                                break;
                            case "Abierto":
                            this.filteredInfo = this.filteredInfo.filter(r => (r.estatus.includes('Abierto')))
                                break;
                            case "Cerrado":
                            this.filteredInfo = this.filteredInfo.filter(r => (r.estatus.includes('Cerrado')))
                                break;
                            default:
                                break;
                        }
                    }

                    if (this.sucursalSeleccionada != '')
                        this.filteredInfo = this.filteredInfo.filter(r => r.empresa == this.sucursalSeleccionada);

                    if (this.filtroPago != '')
                        this.filteredInfo = this.filteredInfo.filter(r => r.formadepago == this.filtroPago);

                    if (this.filtroDestino != '')
                        this.filteredInfo = this.filteredInfo.filter(r => r.destino == this.filtroDestino);

                    if (newVal != '') {
                        this.filteredInfo = this.filteredInfo.filter(b => (
                            (b.empresa.includes(newVal.toUpperCase())) ||
                            (b.fecha_docum.includes(newVal.toUpperCase())) ||
                            (b.hora.includes(newVal.toUpperCase())) ||
                            (b.caja?.toUpperCase().includes(newVal.toUpperCase())) ||
                            (b.documento?.toUpperCase().includes(newVal.toUpperCase())) ||
                            (b.nombre?.toUpperCase().includes(newVal?.toUpperCase())) ||
                            (b.condicionpago?.toUpperCase().includes(newVal?.toUpperCase()))

                        ))
                    }

                }
                this.searchDebounced=false
            },
        },
        computed: {
            sucursalesData() {
                let data = []
                if (this.info.length > 0)
                    data = [...new Set(app.filteredInfo.map(r => r.sucursal))]
                return data
            },
            formasDePago() {
                let data = []
                if (this.info.length > 0)
                    data = [...new Set(app.info.map(item => item.formadepago))]
                return data
            },
            destinos() {
                let data = []
                if (this.info.length > 0)
                    data = [...new Set(app.info.map(item => item.destino))]
                return data
            },
            resumen() {
                let data = []
                if (this.info.length > 0) {
                    this.sucursalesData.forEach(w => {
                        let tmp = this.filteredInfo.filter(r => r.sucursal == w);
                        let indicador_sap = ''
                        let indicador_mh = ''
                        tmp.forEach(q => {
                            q.warning = ''
                            if (tmp.find(r => (r.facturasap == ''))) {
                                q.warning += 'rojo';
                                indicador_sap = 'sap';
                            } else
                            if (tmp.find(r => (r.sellorecibido == ''))) {
                                q.warning += ' amarillo';
                                indicador_mh = 'mh'
                            }
                        });

                        data.push({
                            "sucursal": w,
                            "data": tmp,
                            "indicador_sap": indicador_sap,
                            "indicador_mh": indicador_mh,
                            "tipo_ruta": this.tipoRuta(w),
                            "total": this.calcularTotalGeneral(tmp),
                            "mh": this.calcularTotalMH(tmp),
                            "sap": this.calcularTotalSAP(tmp),
                        });
                    });
                }

                return data
            },
           
            totalMH() {
                return this.calcularTotalMH(this.filteredInfo);
            },
            totalGeneral() {
            
                return (this.filteredInfo.reduce((a,b)=>{
                    if(b.estatus=='Anulado' && this.filtroEstado==''){
                            return a
                        }
                    return  a+parseFloat(b.total)
                },0))
                
            },
            totalCredito() {
                return this.numberFormat(this.filteredInfo.filter(r=>r.condicionpago=='A Crédito').reduce((a,b)=>{
                    if(b.estatus=='Anulado' && this.filtroEstado==''){
                            return a
                        }
                    return  a+parseFloat(b.total)
                },0))
                
                
            },
            totalContado() {
                return this.numberFormat(this.filteredInfo.filter(r=>r.condicionpago=='Contado').reduce((a,b)=>{
                    if(b.estatus=='Anulado' && this.filtroEstado==''){
                            return a
                        }
                    return  a+parseFloat(b.total)
                },0))
                
            },
            totalSAP() {
                return this.calcularTotalSAP(this.filteredInfo)

            },
        },
        watch: {
                busqueda(newVal) {
                clearTimeout(this.searchTimeout);
                this.searchDebounced=true,
                this.searchTimeout = setTimeout(() => {
                    this.infoFiltered(newVal)

                }, 700); // 500 milisegundos de espera después de la última pulsación de tecla
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