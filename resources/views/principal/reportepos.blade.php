@extends('template')
@section('titulo', 'DTE GUARD - Bienvenido')
@section('pagina', 'DTE GUARD - Bienvenido')
@section('contenido')
@verbatim
<div id="app" v-loading.fullscreen.lock="loading" :element-loading-text="textoCarga" element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
<h4 class="display-4" style="font-size: 30px;">Consulta de ventas por rango por fecha</h4>

    <el-select style="width:300px;" v-model="sucursalSeleccionada" clearable placeholder="Seleccione una sucursal">
        <el-option v-for="item in sucursales" :key="item.id" :label="item.nombre" :value="item.codigo">
        </el-option>
    </el-select>


    <el-date-picker @change="getData()" format="dd/MM/yyyy" v-model="fechas" type="daterange" range-separator="hasta" start-placeholder="Fecha inicial" end-placeholder="Fecha final">
    </el-date-picker>

    <button type="button" class="btn btn-sm btn-success" @click="openCuadre()">Cuadre Diario</button>



    <div class="row">
        <div class="col">
            
            <div class="my-2">
                <input class="form-control" type="text" placeholder="busqueda..." v-model="busqueda">
                <el-tag style="font-size: 20px;" class="my-2"> Total de registros: {{infoFiltered.length}}</el-tag>
                <el-tag style="font-size: 20px;" class="float-right my-2"> Total: $ {{numberFormat(infoFiltered.reduce((a,b)=>a+b.total,0))}} USD</el-tag>

            </div>

           
            <el-table size="small" height="850" :data="infoFiltered" style="width: 100%">
                <el-table-column type="expand">
                    <template slot-scope="props">
                        
                        <table class="table table-striped table-bordered table-hover table-sm">
                            <tr>
                                <th>sku</th>
                                <th>codigo_barras</th>
                                <th>descripcion</th>
                                <th>cantidad</th>                                
                                <th></th>                                
                            </tr>
                            <tr v-for="(d,k) in props.row.detalle">
                                <td>{{d.sku}}</td>
                                <td>{{d.codigo_barras}}</td>
                                <td>{{d.descripcion}}</td>
                                <td>{{d.cantidad}}</td> 
                                <td style="width: 600px;"></td>                               
                            </tr>

                        </table>
                    </template>
                </el-table-column>
                <el-table-column label="id" width="70">
                    <template slot-scope="pp">
                        {{pp.row.id}}
                    </template>
                </el-table-column>
                <el-table-column label="Fecha">
                    <template slot-scope="pp">
                        {{dateFormater(pp.row.fecha_docum)}}
                    </template>
                </el-table-column>
                <el-table-column label="Hora" width="70">
                    <template slot-scope="pp">
                        {{pp.row.hora.substring(0,5)}}
                    </template>
                </el-table-column>
                <el-table-column label="Tipo_Doc">
                    <template slot-scope="pp">
                        {{pp.row.tipo_doc}}
                    </template>
                </el-table-column>
                <el-table-column width="340" label="Nombre">
                    <template slot-scope="pp">
                        {{pp.row.nombre}}
                    </template>
                </el-table-column>
                <el-table-column label="Monto">
                    <template slot-scope="pp">
                        {{pp.row.monto}}
                    </template>
                </el-table-column>
                <el-table-column label="Impuestos">
                    <template slot-scope="pp">
                        {{pp.row.impuestos}}
                    </template>
                </el-table-column>
                <el-table-column label="Percepción">
                    <template slot-scope="pp">
                        {{pp.row.percepcion}}
                    </template>
                </el-table-column>
                <el-table-column label="Dtos">
                    <template slot-scope="pp">
                        {{pp.row.descuentos}}
                    </template>
                </el-table-column>
                <el-table-column label="Total">
                    <template slot-scope="pp">
                        {{pp.row.total}}
                    </template>
                </el-table-column>
                <el-table-column label="Estatus">
                    <template slot-scope="pp">
                        {{pp.row.estatus}}
                    </template>
                </el-table-column>
                <el-table-column label="Condición">
                    <template slot-scope="pp">
                        {{pp.row.condicionpago}}
                    </template>
                </el-table-column>
                <el-table-column label="Forma_pago">
                    <template slot-scope="pp">
                        {{pp.row.formadepago}}
                    </template>
                </el-table-column>
                <el-table-column label="Vendedor">
                    <template slot-scope="pp">
                        {{pp.row.nombrevendedor}}
                    </template>
                </el-table-column>
                <el-table-column label="DUI">
                    <template slot-scope="pp">
                        {{pp.row.dui}}
                    </template>
                </el-table-column>
            </el-table>
        </div>
    </div>

    <div v-loading='loading' class='modal fade' id='cuadreModal' tabindex='-1' aria-labelledby='cuadreLabel' aria-hidden='true'>
            <div class='modal-dialog modal-xl '>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h5 class='modal-title' id='cuadreLabel'>Cuadre Diario</h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                            <span aria-hidden='true'>&times;</span>
                        </button>
                    </div>
                    <div class='modal-body' v-loading='loading'>
                        <div class='d-flex flex-wrap'>
                            El    
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
            sucursalSeleccionada: '',
            sucursales: <?= $sucursales ?>,
            textoCarga: 'procesando...',
            fechas: [dayjs().subtract(15, 'days'), dayjs()],
            loading: true,
            info: [],
        },
        methods: {
            openCuadre(){
                $('#cuadreModal').modal()

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
                this.info = []
                this.loading = true;
                axios.post('<?= route('getFacturas') ?>', {
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
                return Number(n).toLocaleString('es-MX');
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
            }
        },
        computed: {
            infoFiltered() {
                let data = [];
                if (this.info.length > 0) {
                    data = this.info.filter(r => r.sucursal == this.sucursalSeleccionada);
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
            }
        },
        watch: {},
        mounted() {
            this.loading = true;
            this.getData()
            if (this.sucursales.length > 0) {
                this.sucursalSeleccionada = this.sucursales[0].codigo;
            }
        },
    });
</script>




@endverbatim
@endsection