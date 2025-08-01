@extends('template')
@section('titulo', 'DTE GUARD - Reporte venta Mensual')
@section('pagina', 'DTE GUARD - Reporte venta Mensual')
@section('contenido')
@verbatim
<div id="app" v-loading.fullscreen.lock="loading" element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
    <h3>Reporte venta Mensual</h3>

    <div class="row my-1">
        <div class="col-sm d-none">
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
        <div class="col-sm d-none">
            <label for="sucursal">Cre/Cont.</label><br>
            <el-select v-model="tipoEntrada" clearable placeholder="Seleccione una opción">
                <el-option key="c1" label="Todo" value="">
                </el-option>
                <el-option key="c2" label="Crédito" value="credito">
                </el-option>
                <el-option key="c3" label="Contado" value="contado">
                </el-option>
            </el-select>
        </div>
        <div class="col-sm">
            <label for="año">Año</label><br>
            <el-select v-model="añoSeleccionado" clearable placeholder="Seleccione un año" @change="getData()">
                <el-option v-for="year in years" :key="year" :label="year" :value="year">
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


    <div class="row">
        <div class="col">
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>Empresa</th>
                        <th>Año</th>
                        <th>Mes</th>
                        <th>Contado</th>
                        <th>Crédito</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="item in infoFiltered" :key="item.mes">
                        <td>{{ item.empresa }}</td>
                        <td>{{ item.anio }}</td>
                        <td>{{ item.mes }}</td>
                        <td>{{ numberFormat(item.contado) }}</td>
                        <td>{{ numberFormat(item.credito) }}</td>
                        <td>{{ numberFormat(item.total) }}</td>
                    </tr>
                </tbody>
            </table>
            <canvas id="myChart" width="400" height="100"></canvas>

        </div>
    </div>



</div>
<script>
    let app = new Vue({
        el: '#app',
        data: {
            busqueda: '',
            years: [...Array(6).keys()].map(i => dayjs().year() - i),
            fechas: [(localStorage.getItem("f1")) ? dayjs(localStorage.getItem("f1")) : dayjs(), (localStorage.getItem("f2")) ? dayjs(localStorage.getItem("f2")) : dayjs()],
            loading: true,
            info: [],
            clasesSelected: '',
            subclasesSelected: '',
            diaSelected: '',
            horarioSelected: '',
            tipoEntrada: '',
            añoSeleccionado: dayjs().year(),
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
                /*if (!this.fechas) {
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
                localStorage.setItem("f2", dayjs(this.fechas[1]));*/
                this.loading = true;
                axios.post('<?= route('getresumenMensual') ?>', {
                        año: this.añoSeleccionado,
                    })
                    .then(res => {

                        app.info = res.data;
                        app.renderChart();
                        this.loading = false;
                        //console.log(res)
                    })
                    .catch(err => {
                        this.loading = false;
                        //console.error(err);
                    });
            },
            renderChart() {
            const ctx = document.getElementById('myChart').getContext('2d');
            
            // Destruir la gráfica existente si ya existe
            if (this.chart) {
                this.chart.destroy();
            }

            const labels = this.infoFiltered.map(item => `Mes ${item.mes}`);
            const dataContado = this.infoFiltered.map(item => item.contado);
            const dataCredito = this.infoFiltered.map(item => item.credito);
            const dataTotal = this.infoFiltered.map(item => item.total);

            this.chart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Contado',
                            data: dataContado,
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            fill: false
                        },
                        {
                            label: 'Crédito',
                            data: dataCredito,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            fill: false
                        },
                        {
                            label: 'Total',
                            data: dataTotal,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        x: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Mes'
                            }
                        },
                        y: {
                            display: true,
                            title: {
                                display: true,
                                text: 'Monto'
                            }
                        }
                    }
                }
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
                            if (this.tipoEntrada == 'credito') {
                                return parseFloat(i.credito) > 0
                            } else {
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