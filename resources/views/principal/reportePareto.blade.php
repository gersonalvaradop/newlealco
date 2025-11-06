@extends('template')
@section('titulo', 'DTE GUARD - Reporte Pareto')
@section('pagina', 'DTE GUARD - Reporte Pareto')
@section('contenido')
@verbatim
<div id="app" v-loading.fullscreen.lock="loading" element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
    <h3>Reporte de producto 80 / 20 (Pareto)</h3>
   <button class="btn btn-success btn-sm btn-block my-2" @click="exportData(info,'ReportePareto')" v-if="info.length>0"><i class="fa fa-file-excel-o"></i> Excel</button>

    <div class="row my-1">
        <div class="col-sm">
            <label for="fecha">Rango de fecha:</label>
            <el-date-picker @change="getData()" format="dd/MM/yyyy" v-model="fechas" type="daterange" range-separator="al" start-placeholder="Fecha inicial" end-placeholder="Fecha final">
            </el-date-picker>
        </div>
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
            <el-select style="width: 100%;" size="small" v-model="subclasesSelected" @change="aplicarFiltro(busqueda)" filterable placeholder="Seleccione una Sub clase">
                <el-option value="">Seleccione una Sub clase</el-option>
                <el-option v-for="(d,k) in subclasesList" :key="`sc${d.id}`" :title="d.nombre" :label="d.nombre" :value="d.id">
                </el-option>
            </el-select>

        </div>
        <div class="col-sm d-none">
            <label for="subclase">Sucursal</label>
            <el-select v-model="sucursalSeleccionada" @change="aplicarFiltro(busqueda)" clearable placeholder="Seleccione una empresa">
                <el-option key="A1" label="Todas las empresas" value="">
                </el-option>
                <el-option v-for="item in sucursales" :key="item.id" :label="`${item.codigo} - ${item.nombre}`" :value="item.id">
                </el-option>
            </el-select>
        </div>

    </div>

    <div class="row my-1">
        <div class="col-sm">
            <label for="bodega">Bodega</label>
            <el-select v-model="bodegaSeleccionada" @change="aplicarFiltro(busqueda)" clearable placeholder="Seleccione una bodega" style="width: 100%;" size="small" filterable>
                <el-option key="B1" label="Todas las bodegas" value="">
                </el-option>
                <el-option v-for="item in bodegas" :key="`b${item}`" :label="item" :value="item">
                </el-option>
            </el-select>
        </div>
    </div>

    <div class="row my-1">
        <div class="col">
            <small>
                Se encontraron: {{numberFormat(filteredInfo.length,0)}} registros
            </small>
            <input class="form-control" type="text" placeholder="busqueda..." v-model="busqueda">
        </div>
    </div>

    <div class="row my-1" v-if="filteredInfo.length>0">
        <div class="col">
            <div class="card border-left-success shadow h-100 ">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Total:</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                <span v-if="filteredInfo.length>0" class="float-right"><b>Total: $ {{numberFormat(filteredInfo.reduce((a,b)=>a+parseFloat(b.total),0))}}</b></span>
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


    <i v-if="searchDebounced" class="fa fa-spinner fa-spin"></i>
    <el-table :data="filteredInfo" style="width: 100%">
        <el-table-column label="id" width="70">
            <template slot-scope="pp">
                {{pp.row.material_id}}
            </template>
        </el-table-column>
        <el-table-column label="Descripcion">
            <template slot-scope="pp">
                {{(pp.row.descripcion)?pp.row.descripcion:'-'}}
            </template>
        </el-table-column>
        <el-table-column label="Cantidad" header-align="right" align="right" width="100">
            <template slot-scope="pp">
                {{numberFormat(pp.row.cantidad)}}
            </template>
        </el-table-column>
        <el-table-column label="Total" header-align="right" align="right" width="100">
            <template slot-scope="pp">
                $ {{numberFormat(pp.row.total)}}
            </template>
        </el-table-column>
        <el-table-column label="Porcentaje" header-align="right" align="right" width="100">
            <template slot-scope="pp">
                {{numberFormat(pp.row.porcentaje)}}
            </template>
        </el-table-column>
        <el-table-column label="% Acum." header-align="right" align="right" width="100">
            <template slot-scope="pp">
                <span :class="`${(pp.row.pareto<=80)?'text-success':''}`"> {{pp.row.pareto}} </span>

            </template>
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
            clasesSelected: '',
            subclasesSelected: '',
            subclasesList: [],
            clases: <?= $clases ?>,
            subclases: <?= $subclases ?>,
            filteredInfo: [],
            searchDebounced: false,
            searchTimeout: null,
            sucursalSeleccionada: '',
            sucursales: <?= $sucursales ?>,
            bodegaSeleccionada: '',
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
                this.aplicarFiltro(this.busqueda)
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
                axios.post('<?= route('getReportePareto') ?>', {
                        fechas_ini: dayjs(this.fechas[0]).format('YYYY-MM-DD'),
                        fechas_fin: dayjs(this.fechas[1]).format('YYYY-MM-DD'),
                    })
                    .then(res => {
                        let valor_total = res.data.reduce((a, b) => (a + parseFloat(b.total)), 0);
                        let incremental = 0;
                        let contador = 1;
                        res.data.forEach(r => {
                            r.porcentaje = parseFloat(this.numberFormat(100 - (((valor_total - r.total) / valor_total) * 100)));
                            incremental = incremental + r.porcentaje;
                            r.pareto = (contador == res.data.length) ? 100 : parseFloat(this.numberFormat(incremental));
                            contador++;

                        });
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

            aplicarFiltro(newVal) {
                this.filteredInfo = []

                if (this.info.length > 0) {
                    this.filteredInfo = this.jclear(this.info)

                    if (this.clasesSelected != '') {
                        this.filteredInfo = this.filteredInfo.filter((i) => {
                            return i.clase == this.clasesSelected
                        });
                    }
                    if (this.subclasesSelected != '') {
                        this.filteredInfo = this.filteredInfo.filter((i) => {
                            return i.subclase == this.subclasesSelected
                        });
                    }
                    if (this.sucursalSeleccionada != '') {
                        this.filteredInfo = this.filteredInfo.filter((i) => {
                            return i.sucursal == this.sucursalSeleccionada
                        });
                    }
                    if (this.bodegaSeleccionada != '') {
                        this.filteredInfo = this.filteredInfo.filter((i) => {
                            return i.consumo == this.bodegaSeleccionada
                        });
                    }
                    



                    if (newVal != '') {
                        this.filteredInfo = this.filteredInfo.filter(b => (
                            (b.descripcion.includes(newVal.toUpperCase())) ||
                            (b.sku.includes(newVal.toUpperCase()))

                        ))
                    }

                }
                this.searchDebounced = false
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
            bodegas() {
                if (this.info.length > 0) {
                    // Extraer todos los valores únicos del campo consumo
                    let consumosUnicos = [...new Set(this.info.map(item => item.consumo))];
                    // Filtrar valores vacíos o null y ordenar alfabéticamente
                    return consumosUnicos.filter(consumo => consumo && consumo.trim() !== '').sort();
                }
                return [];
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
                    if (this.sucursalSeleccionada != '') {
                        data = data.filter((i) => {
                            return parseInt(i.sucursal) == this.sucursalSeleccionada
                        });
                    }
                    if (this.bodegaSeleccionada != '') {
                        data = data.filter((i) => {
                            return i.consumo == this.bodegaSeleccionada
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
        watch: {
            busqueda(newVal) {
                clearTimeout(this.searchTimeout);
                this.searchDebounced = true,
                    this.searchTimeout = setTimeout(() => {
                        this.aplicarFiltro(newVal)

                    }, 700); // 500 milisegundos de espera después de la última pulsación de tecla
            },

        },
    });
</script>


@endverbatim
@endsection
