@extends('template')
@section('titulo', 'DTE GUARD - Reporte venta diaria')
@section('pagina', 'DTE GUARD - Reporte venta diaria')
@section('contenido')
@verbatim
<div id="app" v-loading.fullscreen.lock="loading" element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
    <h3>Reporte venta diaria</h3>

    <div class="row my-1">
        <div class="col-sm">
            <label for="fecha">Rango de fecha:</label>
            <el-date-picker @change="getData()" format="dd/MM/yyyy" v-model="fechas" type="daterange" range-separator="al" start-placeholder="Fecha inicial" end-placeholder="Fecha final">
            </el-date-picker>
        </div>
        <div class="col-sm d-none">
            <label for="dia">Dia</label>
            <el-select style="width: 100%;" size="small" v-model="diaSelected" filterable placeholder="Seleccione un dia">
                <el-option value="">Seleccione un dia</el-option>
                <el-option v-for="(d,k) in diaList" :key="`c${d}`" :title="d" :label="d" :value="d">
                </el-option>
            </el-select>

        </div>
        <div class="col-sm d-none">
            <label for="horario">Horario</label>
            <el-select style="width: 100%;" size="small" v-model="horarioSelected" filterable placeholder="Seleccione un horario">
                <el-option value="">Seleccione un horario</el-option>
                <el-option v-for="(d,k) in horariosList" :key="`sc${d}`" :title="d" :label="d" :value="d">
                </el-option>
            </el-select>
        </div>
        <div class="col-sm">
            <label for="sucursal">Sucursal</label><br>
            <el-select v-model="sucursalSeleccionada" clearable placeholder="Seleccione una empresa">
                <el-option key="A1" label="Todas las empresas" value="">
                </el-option>
                <el-option v-for="item in sucursales" :key="item.id" :label="`${item.codigo} - ${item.nombre}`" :value="item.codigo">
                </el-option>
            </el-select>
        </div>
        <div class="col-sm">
            <label for="sucursal">Cre/Cont.</label><br>
            <el-select v-model="tipoEntrada" clearable placeholder="Seleccione una opción">
                <el-option key="c1" label="Todo" value="">
                </el-option>
                <el-option key="cr" label="Credito" value="credito">
                </el-option>
                <el-option key="co" label="Contado" value="contado">
                </el-option>
            </el-select>
        </div>
    </div>
    <div class="row">
        <div class="col my-3">
            <div class="card border-left-danger shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                Contado:</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{numberFormat( infoFiltered.reduce((a,b)=>a+parseFloat(b.contado),0))}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col my-3">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Crédito:</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{numberFormat( infoFiltered.reduce((a,b)=>a+parseFloat(b.credito),0))}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col my-3">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total:</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{numberFormat( infoFiltered.reduce((a,b)=>a+parseFloat(b.total),0))}}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <table class="table table-bordered table-sm" style="font-size: 12px;">
        <thead>
            <tr>
                <th>Empresa</th>
                <th>Fecha</th>
                <th>Contado</th>
                <th>Crédito</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="item in infoFiltered" :key="item.fecha">
                <td>{{ item.empresa }}</td>
                <td>{{ dateFormater(item.fecha) }}</td>
                <td>{{ numberFormat(item.contado) }}</td>
                <td>{{ numberFormat(item.credito) }}</td>
                <td>{{ numberFormat(item.total) }}</td>
            </tr>
        </tbody>
    </table>



</div>
<script>
    let app = new Vue({
        el: '#app',
        data: {
            busqueda: '',
            fechas: [(localStorage.getItem("f1")) ? dayjs(localStorage.getItem("f1")) : dayjs(), (localStorage.getItem("f2")) ? dayjs(localStorage.getItem("f2")) : dayjs()],
            loading: true,
            info: [],
            clasesSelected: '',
            subclasesSelected: '',
            diaSelected: '',
            horarioSelected: '',
            tipoEntrada: '',
            subclasesList: [],
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
                axios.post('<?= route('getresumenDiario') ?>', {
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
        },
        computed: {
            diaList() {
                return this.info.map(r => r.dia).filter((item, index) => (this.info.map(r => r.dia).indexOf(item) === index))
            },
            horariosList() {
                return this.info.map(r => r.horarios).filter((item, index) => (this.info.map(r => r.horarios).indexOf(item) === index))
            },
            infoFiltered() {
                data = this.jclear(this.info)
                if (this.info.length > 0) {
                    if (this.clasesSelected != '') {
                        data = data.filter((i) => {
                            return i.clase == this.clasesSelected
                        });
                    }
                    if (this.subclasesSelected != '') {
                        data = data.filter((i) => {
                            return i.subclase == this.subclasesSelected
                        });
                    }
                    if (this.diaSelected != '') {
                        data = data.filter((i) => {
                            return i.dia == this.diaSelected
                        });
                    }
                    if (this.sucursalSeleccionada != '') {
                        data = data.filter((i) => {
                            return i.empresa == this.sucursalSeleccionada
                        });
                    }
                    if (this.tipoEntrada != '') {
                        data = data.filter((i) => {
                            if(this.tipoEntrada=='credito'){
                                return parseFloat(i.credito) > 0
                            }else{
                                return parseFloat(i.contado) > 0
                            }                           
                        });
                    }
                    if (this.horarioSelected != '') {
                        data = data.filter((i) => {
                            return i.horarios == this.horarioSelected
                        });
                    }
                }
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