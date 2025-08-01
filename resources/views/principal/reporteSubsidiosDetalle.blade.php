@extends('template')
@section('titulo', 'DTE GUARD - SubClases')
@section('pagina', 'DTE GUARD - SubClases')
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
    <h3>Reporte de subsidios y excedentes Detallado</h3>
    <div class="row my-1">
        <div class="col-sm">
            <label for="fecha">Rango de fecha:</label>
            <el-date-picker @change="getData()" format="dd/MM/yyyy" v-model="fechas" type="daterange" range-separator="al" start-placeholder="Fecha inicial" end-placeholder="Fecha final">
            </el-date-picker>
        </div>

    </div>
    <button type="button" @click="doPDF()" class="btn btn-sm btn-danger">PDF</button>
    <button class="btn btn-success btn-sm btn-block my-2" @click="exportData(info,'SubsidioExcedentes')" v-if="info.length>0"><i class="fa fa-file-excel-o"></i> Excel</button>
    <input type="text" class="form-control my-2" placeholder="Buscar..." v-model="busqueda" />

    <div v-if="this.info.length>0">
        <div class="row">
            <div class="col text-center">
                Totales:
            </div>
        </div>
        <div class="row">
            <div class="col-xl-2 col-md-2 ">
                <div class="card border-left-success shadow h-100 ">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total:</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${{numberFormat(detalle.reduce((a,b)=>a+parseFloat(b.total),0))}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2 ">
                <div class="card border-left-danger shadow h-100 ">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Excedente</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${{numberFormat(detalle.reduce((a,b)=>a+parseFloat(b.excedente),0))}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-2 col-md-2 ">
                <div class="card border-left-warning shadow h-100 ">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Subsidio:</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${{numberFormat(detalle.reduce((a,b)=>a+parseFloat(b.subsidio),0))}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-2 ">
                <div class="card border-left-success shadow h-100 ">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Fee</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${{numberFormat(detalle.reduce((a,b)=>a+parseFloat(b.fee),0))}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-2 col-md-2 ">
                <div class="card border-left-danger shadow h-100 ">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Total Subsidio</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">${{numberFormat(detalle.reduce((a,b)=>a+( parseFloat(b.subsidio)+parseFloat(b.fee) ),0))}}</div>

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
    <select class="form-control" v-model="tipo_entrada">
        <option value="">Todos</option>
        <option value="Contado">Contado</option>
        <option value="Credito">Credito</option>
    </select>
    <br>
    <button class="btn btn-warning btn-sm" @click="expandAllRows">{{(expandidas)?'Contraer':'Expandir'}} Todas las filas</button>
    <div class="row">
        <div class="col">

            <el-table :default-expand-all="expandidas" :data="detalle" ref="table" style="width: 100%">
                <el-table-column type="expand">
                    <template slot-scope="props">
                        <div>
                            <el-table :default-expand-all="expandidas" row-class-name="success-row" :data="props.row.porFecha" style="width: 100%">

                                <el-table-column type="expand">
                                    <template slot-scope="pf">

                                        <el-table :default-expand-all="expandidas" row-class-name="warning-row" :data="pf.row.detalles" style="width: 100%">
                                            <el-table-column label="Sku">
                                                <template slot-scope="pq">
                                                    {{pq.row.sku}}
                                                </template>
                                            </el-table-column>
                                            <el-table-column label="Hora">
                                                <template slot-scope="pq">
                                                    {{pq.row.hora}}
                                                </template>
                                            </el-table-column>
                                            <el-table-column label="Linea">
                                                <template slot-scope="pq">
                                                    {{pq.row.linea}}
                                                </template>
                                            </el-table-column>
                                            <el-table-column label="Descripcion">
                                                <template slot-scope="pq">
                                                    {{pq.row.descripcion}}
                                                </template>
                                            </el-table-column>
                                            <el-table-column label="Cantidad">
                                                <template slot-scope="pq">
                                                    {{pq.row.cantidad}}
                                                </template>
                                            </el-table-column>
                                            <el-table-column label="Precio">
                                                <template slot-scope="pq">
                                                    {{pq.row.precio}}
                                                </template>
                                            </el-table-column>
                                            <el-table-column label="Contado">
                                                <template slot-scope="pq">
                                                    {{pq.row.contado}}
                                                </template>
                                            </el-table-column>
                                            <el-table-column label="Credito">
                                                <template slot-scope="pq">
                                                    {{pq.row.total_credito}}
                                                </template>
                                            </el-table-column>

                                            <el-table-column v-if="false" label="fee">
                                                <template slot-scope="pq">
                                                    {{pq.row.fee}}
                                                </template>
                                            </el-table-column>
                                            <el-table-column v-if="false" label="subsidio_dia">
                                                <template slot-scope="pq">
                                                    {{pq.row.subsidio_dia}}
                                                </template>
                                            </el-table-column>
                                            <el-table-column v-if="false" label="aplica_subsidio">
                                                <template slot-scope="pq">
                                                    {{pq.row.aplica_subsidio}}
                                                </template>
                                            </el-table-column>


                                        </el-table>
                                    </template>
                                </el-table-column>



                                <el-table-column label="Fecha" width="150">
                                    <template slot-scope="pr">
                                        {{dateFormater(pr.row.fecha)}}
                                    </template>
                                </el-table-column>
                                <el-table-column label="Dia">
                                    <template slot-scope="pr">
                                        {{nombreDia(pr.row.fecha)}}
                                    </template>
                                </el-table-column>
                                <el-table-column v-if="false" label="DOCUMENTO">
                                    <template slot-scope="pr">
                                        {{pr.row.documento}}
                                    </template>
                                </el-table-column>
                                <el-table-column align="right" width="150" label="Total">
                                    <template slot-scope="pr">
                                        {{numberFormat(pr.row.total)}}
                                    </template>
                                </el-table-column>
                                <el-table-column align="right" width="150" label="Subsidio">
                                    <template slot-scope="pr">
                                        {{numberFormat(pr.row.subsidio)}}
                                    </template>
                                </el-table-column>
                                <el-table-column align="right" width="150" label="Excedente">
                                    <template slot-scope="pr">
                                        {{numberFormat(pr.row.excedente)}}
                                    </template>
                                </el-table-column>



                            </el-table>
                        </div>
                    </template>
                </el-table-column>
                <el-table-column label="CODIGO" width="120">
                    <template slot-scope="pp">
                        {{pp.row.codigo}}
                    </template>
                </el-table-column>
                <el-table-column label="Nombre">
                    <template slot-scope="pp">
                        {{pp.row.nombre}}
                    </template>
                </el-table-column>
                <el-table-column width="150" align='right' label="Total Venta">
                    <template slot-scope="pp">
                        {{numberFormat(pp.row.total)}}
                    </template>
                </el-table-column>
                <el-table-column width="150" align='right' label="V.Excedente">
                    <template slot-scope="pp">
                        {{numberFormat(pp.row.excedente)}}
                    </template>
                </el-table-column>
                <el-table-column width="150" align='right' label="V.Subsidio">
                    <template slot-scope="pp">
                        {{numberFormat(pp.row.subsidio)}}
                    </template>
                </el-table-column>
                <el-table-column width="160" align='right' label="V.Fee.administrativo">
                    <template slot-scope="pp">
                        {{numberFormat(pp.row.fee)}}
                    </template>
                </el-table-column>
                <el-table-column width="150" align='right' label="Total Subsidio">
                    <template slot-scope="pp">
                        {{numberFormat(parseFloat(pp.row.subsidio)+parseFloat(pp.row.fee))}}
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
            expandidas: (localStorage.getItem("expandido")) ? ((localStorage.getItem("expandido") == 'true') ? true : false) : false,
            busqueda: '',
            tipo_entrada: 'Credito',
            fechas: [(localStorage.getItem("f1")) ? dayjs(localStorage.getItem("f1")) : dayjs(), (localStorage.getItem("f2")) ? dayjs(localStorage.getItem("f2")) : dayjs()],
            loading: true,
            info: [],
        },
        methods: {
            expandAllRows() {
                if (localStorage.getItem("expandido") != null || localStorage.getItem("expandido") != undefined) {
                    localStorage.setItem("expandido", !((localStorage.getItem("expandido") == 'true') ? true : false));
                } else {
                    localStorage.setItem("expandido", true);
                }
                window.location.reload();
            },
            nombreDia(fecha) {
                days = ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
                let nombre = ''
                d = dayjs(fecha)
                nombre = days[d.day()];
                return nombre
            },
            doPDF() {
                columnas = [];
                this.detalle.forEach(de => {
                    
                    columnas.push(
                        [{
                            text: de.codigo,
                            fillColor: '#eeeeee'
                        }, {
                            text: de.nombre,
                            fillColor: '#eeeeee'
                        }, {
                            text: "$ " + this.numberFormat(de.total),
                            alignment: 'right',
                            fillColor: '#eeeeee'
                        }, {
                            text: "$ " + this.numberFormat(de.excedente),
                            alignment: 'right',
                            fillColor: '#eeeeee'
                        }, {
                            text: "$ " + this.numberFormat(de.subsidio),
                            alignment: 'right',
                            fillColor: '#eeeeee'
                        }],
                    );
                    colFecha = []
                    de.porFecha.forEach(f => {
                        //detalle de porFecha para linea primera
                        columnas.push(
                            ['', this.dateFormater(f.fecha), {
                                text: this.numberFormat(f.total),
                                alignment: 'right'
                            }, {
                                text: this.numberFormat(f.excedente),
                                alignment: 'right'
                            }, {
                                text: this.numberFormat(f.subsidio),
                                alignment: 'right'
                            }],
                        );

                        /*f.detalles.forEach(c => {
                            //colFecha.push([c.descripcion, c.cantidad, this.numberFormat(parseFloat(c.cantidad) * parseFloat(c.precio))])
                            colFecha = [[c.descripcion, c.cantidad, this.numberFormat(parseFloat(c.cantidad) * parseFloat(c.precio))]]
                        });*/
                        colFecha = [
                            ...f.detalles.map(r=>[r.descripcion, r.cantidad, this.numberFormat(parseFloat(r.cantidad) * parseFloat(r.precio))])
                                ]
                    
                        columnas.push(
                            [{}, {
                                    colSpan: 4,
                                    fontSize: 8,
                                    layout: 'headerLineOnly',
                                    dontBreakRows: true,
                                    table: {
                                        headerRows: 1,
                                        widths: ['*', 'auto', 'auto'],
                                        body: [
                                            ['Descripción', 'Cnt', 'Total'],
                                            ...colFecha,
                                        ]
                                    }
                                },
                                {}, {}, {}
                            ]
                        );

                    });


                });

                var dd = {
                    pageSize: 'letter',
                    footer: function(currentPage, pageCount) {
                        return {
                            text: `Página ${currentPage} de ${pageCount} - Hora y fecha de impresión ${dayjs(this.fecha).format('DD/MM/YYYY hh:mm a')}`,
                            fontSize: 7,
                            alignment: 'center', // Alinea el texto al centro
                        };
                    },
                    pageMargins: [30, 20, 20, 45],
                    content: [{
                            alignment: 'right',
                            text: '<?= $empresaNombre ?>',
                            fontSize: 15,
                        },
                        {
                            alignment: 'right',
                            text: 'Subsidios y Excedentes Detallados',
                            fontSize: 12,
                        },
                        {
                            alignment: 'right',
                            text: 'Del: ' + dayjs(this.fechas[0]).format('DD/MM/YYYY') + ' al: ' + dayjs(this.fechas[1]).format('DD/MM/YYYY'),
                            fontSize: 8,
                        },
                        {
                            alignment: 'right',
                            text: 'Condición: ' + ((app.tipo_entrada == '') ? 'Todo' : app.tipo_entrada),
                            fontSize: 8,
                        },
                        {
                            alignment: 'right',
                            text: (app.busqueda != '') ? 'Filtrando: ' + app.busqueda : '',
                            fontSize: 8,
                        },
                        {
                            fontSize: 8,
                            table: {
                                widths: [30, '*', 'auto', 'auto', 'auto'],
                                headerRows: 1,
                                body: [
                                    [{
                                        fontSize: 9,
                                        text: 'Cod.',
                                        bold: true
                                    }, {
                                        fontSize: 9,
                                        text: 'Nombre',
                                        bold: true,
                                    }, {
                                        fontSize: 9,
                                        text: 'TOTAL VENTA',
                                        bold: true
                                    }, {
                                        fontSize: 9,
                                        text: 'V.EXCEDENTE',
                                        bold: true
                                    }, {
                                        fontSize: 9,
                                        text: 'V.SUBSIDIO',
                                        bold: true
                                    }],
                                    ...columnas,

                                ]
                            }
                        },
                    ]

                }
                
                pdfMake.createPdf(dd).open()
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
                axios.post('<?= route('getSubsidiosDetalle') ?>', {
                        fechas_ini: dayjs(this.fechas[0]).format('YYYY-MM-DD'),
                        fechas_fin: dayjs(this.fechas[1]).format('YYYY-MM-DD'),
                    })
                    .then(res => {
                        res.data.forEach(r => {
                            if(r.codigo.startsWith('LE0')){r.fee=0; }                            
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
            detalle() {
                let data = []
                if (this.infoFiltered.length > 0) {

                    this.infoFiltered.forEach(t => {
                        let tmp = data.find(r => r.codigo == t.codigo);
                        if (!tmp) {
                            data.push({
                                codigo: t.codigo,
                                nombre: t.nombre,
                                porFecha: [],
                                total: 0,
                                excedente: 0,
                                fee: 0,
                                subsidio: 0
                            })
                            tmp = data.find(r => r.codigo == t.codigo);
                        }
                        //agregando a total de cliente
                        tmp.total += parseFloat(parseFloat(t.cantidad) * parseFloat(t.precio)) //parseFloat(t.total_credito)
                        //tmp.datos.push(t);    

                        //creando por fecha registros
                        let tmpFechas = tmp.porFecha.find(q => q.fecha == t.fecha_docum);
                        if (!tmpFechas) {
                            tmp.porFecha.push({
                                fecha: t.fecha_docum,
                                detalles: [],
                                subsidio: 0,
                                subsidio_dia: 0,
                                subsidio_valido: 0,
                                excedente: 0,
                                fee: 0,
                                total: 0
                            })
                            tmpFechas = tmp.porFecha.find(q => q.fecha == t.fecha_docum);
                        }
                        tmpFechas.detalles.push(t);
                    });

                    //ya recorrido, se calcularan los datos
                    data.forEach(g => {
                        //se calculara a cada por fecha los valores correspondientes a sus totales
                        g.porFecha.forEach(f => {
                            f.detalles.forEach(d => {
                                f.total += parseFloat(d.total_credito);
                                if (d.aplica_subsidio == 1) {
                                    f.subsidio_dia = parseFloat(d.subsidio_dia);
                                    f.fee = parseFloat(d.fee);
                                    //sumando subsidio
                                    f.subsidio += parseFloat(d.total_credito)
                                    f.subsidio = (parseFloat(f.subsidio) > parseFloat(f.subsidio_dia)) ? parseFloat(f.subsidio_dia) : parseFloat(f.subsidio);
                                }


                            });
                            f.excedente = parseFloat(this.numberFormat(f.total - f.subsidio))

                            g.fee += parseFloat(f.fee)
                            g.subsidio += parseFloat(f.subsidio)
                            g.excedente += parseFloat(f.excedente)


                        });


                    });

                }

                return data;

            },
            nuevoResumen() {
                let data = []
                if (this.infoFiltered.length > 0) {

                    this.infoFiltered.forEach(t => {
                        let tmp = data.find(r => r.codigo == t.codigo);
                        if (!tmp) {
                            data.push({
                                codigo: t.codigo,
                                nombre: t.nombre,
                                facturas: [],
                                porFecha: [],
                                total: 0,
                                excedente: 0,
                                fee: 0,
                                subsidio_valido: 0
                            })
                            tmp = data.find(r => r.codigo == t.codigo);
                        }
                        //agregando a total de cliente
                        tmp.total += parseFloat(parseFloat(t.cantidad) * parseFloat(t.precio)) //parseFloat(t.total_credito)
                        //tmp.datos.push(t);         
                        //para meter facturas               
                        let tmpFacturas = tmp.facturas.find(f => f.documento == t.documento);
                        if (!tmpFacturas) {
                            tmp.facturas.push({
                                documento: t.documento,
                                fecha_docum: t.fecha_docum,
                                detalles: [],
                                subsidio: 0,
                                subsidio_dia: 0
                            })
                            tmpFacturas = tmp.facturas.find(f => f.documento == t.documento);
                        }
                        //evalua si el subsidio aplica
                        if (t.aplica_subsidio == 1) {
                            tmpFacturas.subsidio_dia = parseFloat(t.subsidio_dia)
                        }
                        tmpFacturas.subsidio += parseFloat(t.total_credito)
                        tmpFacturas.detalles.push(t);

                        //creando por fecha registros
                        let tmpFechas = tmp.porFecha.find(q => q.fecha == t.fecha_docum);
                        if (!tmpFechas) {
                            tmp.porFecha.push({
                                fecha: t.fecha_docum,
                                detalles: [],
                                subsidio: 0,
                                subsidio_dia: 0,
                                subsidio_valido: 0,
                                excedente: 0,
                                fee: 0
                            })
                            tmpFechas = tmp.porFecha.find(q => q.fecha == t.fecha_docum);
                        }
                        //evalua si el subsidio aplica
                        if (t.aplica_subsidio == 1) {
                            tmpFechas.subsidio_dia = parseFloat(t.subsidio_dia)
                            //este tmp se hace para validar si ya excedio los 2.50 o el subsidio otorgado
                            tmpFechas.subsidio_valido += tmpFechas.subsidio_valido
                            tmpFechas.subsidio_valido = (parseFloat(tmpFechas.subsidio_valido) > 2.50) ? 2.50 : parseFloat(t.total_credito)

                        }
                        tmpFechas.subsidio += parseFloat(this.numberFormat(parseFloat(t.total_credito)))
                        tmpFechas.fee = (tmpFechas.fee <= parseFloat(t.fee)) ? parseFloat(t.fee) : tmpFechas.fee
                        tmpFechas.detalles.push(t);

                        //suma el fee al raiz de la data 
                        //tmp.fee+=parseFloat(t.fee)


                    });
                    data.forEach(r => {
                        r.facturas.forEach(f => {
                            if (f.subsidio < f.subsidio_dia) {
                                f.subsidio_dia = parseFloat(f.subsidio)
                            }
                            f.excedente = ((f.subsidio - f.subsidio_dia) > 0) ? parseFloat(this.numberFormat(f.subsidio - f.subsidio_dia)) : 0;
                            //r.excedente+=f.excedente;
                        });
                        r.porFecha.forEach(f => {

                            if (f.subsidio < f.subsidio_dia) {
                                f.subsidio_dia = parseFloat(f.subsidio)
                            }
                            //f.excedente = ((f.subsidio - f.subsidio_dia)>0)?parseFloat(this.numberFormat(f.subsidio - f.subsidio_dia)) : 0;
                            //r.excedente+=f.excedente; 
                            f.excedente = f.subsidio - f.subsidio_valido;

                            //suma al excedente raiz
                            r.excedente += f.excedente;
                            r.fee += f.fee;

                            //a
                            r.subsidio_valido += f.subsidio_valido
                        });
                    });
                }

                return data;
            },

            infoFiltered() {
                let data = [];
                data = this.jclear(this.info)
                if (this.info.length > 0) {
                    if (this.tipo_entrada != '') {
                        switch (this.tipo_entrada) {
                            case 'Contado':
                                data = data.filter(r => parseFloat(r.contado) > 0)
                                break;
                            case 'Credito':
                                data = data.filter(r => parseFloat(r.total_credito) > 0)
                                break;
                            default:
                                break;
                        }
                    }
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