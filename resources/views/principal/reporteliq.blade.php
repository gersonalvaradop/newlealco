@extends('template')
@section('titulo', 'DTE GUARD - Bienvenido')
@section('pagina', 'DTE GUARD - Bienvenido')
@section('contenido')
@verbatim
<script src="<?= url('/') ?>/varr.js?<?= rand(1, 50) ?>"></script>
<style>
    .amarillo {
        color: rgb(172, 163, 2);
        font-size: 14px;
    }

    .rojo {
        color: #f00;
        font-size: 14px;
    }
</style>
<div id="app" v-loading.fullscreen.lock="loading" :element-loading-text="textoCarga" element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
    <h4 class="display-4" style="font-size: 30px;">Liquidaciones <button type="button" @click="sincronizar()" class="btn btn-sm btn-info d-none"><i class="el-icon-refresh"></i></button></h4>
    <button class="btn btn-success btn-sm btn-block my-2" @click="exportData(info,'ReporteLiquidaciones')" v-if="info.length>0"><i class="fa fa-file-excel-o"></i> Excel</button>
    <div class="row">
        <div class="col py-2">
            <el-date-picker @change="getData()" format="dd/MM/yyyy" v-model="fechas" type="daterange" range-separator="al" start-placeholder="Fecha inicial" end-placeholder="Fecha final">
            </el-date-picker>
        </div>
        <div class="col py-2">
            <el-select style="width:300px;" v-model="sucursalSeleccionada" clearable placeholder="Seleccione una empresa">
                <el-option key="A1" label="Todas las empresas" value="">
                </el-option>
                <el-option v-for="item in sucursales" :key="item.id" :label="`${item.codigo} - ${item.nombre}`" :value="item.codigo">
                </el-option>
            </el-select>
        </div>
        <div class="col py-2">
            <el-select style="width:300px;" v-model="filtroEstado" clearable placeholder="Seleccione un estado">
                <el-option key="B1" label="Todos los estados" value="">
                </el-option>
                <el-option v-for="item in ['Rechazado','Procesado']" :key="item" :label="item" :value="item">
                </el-option>
            </el-select>
        </div>
        <div class="col py-2">
            <el-select style="width:300px;" v-model="estadoSaldo" clearable placeholder="Seleccione saldo">
                <el-option key="G1" label="Todos los registros" value="">
                </el-option>
                <el-option v-for="item in ['Con Saldo','Cancelados']" :key="item" :label="item" :value="item">
                </el-option>
            </el-select>
        </div>
    </div>


    <hr>
    <div class="row">
        <div class="col">

            <div class="row">
                <div class="col text-center">
                    <span style="color:black;font-size:20px;">Total MYPOS:</span><br>
                    <span style="color:black;font-size:15px;">$ {{numberFormat(totalGeneral)}}</span>
                    <br><small style="color:red;font-size:10px;" v-if="((totalGeneral-totalMH)>0)||((totalGeneral-totalSAP)>0)">Diff: (MH $ {{numberFormat(totalGeneral-totalMH)}}) *** (ERP $ {{numberFormat(totalGeneral-totalSAP)}}) </small>
                </div>
                <div class="col text-center">
                    <span style="color:black;font-size:20px;">Total MH:</span><br>
                    <span style="color:black;font-size:15px;" :class="`${(totalGeneral!=totalMH)?'animate__animated animate__repeat-3 animate__flash':''}`">${{numberFormat(totalMH)}}</span>
                </div>
                <div class="col text-center">
                    <span style="color:black;font-size:20px;">Total ERP:</span><br>
                    <span style="color:black;font-size:15px;" :class="`${(totalGeneral!=totalSAP)?'animate__animated animate__repeat-3 animate__flash':''}`"> ${{numberFormat(totalSAP)}}</span>
                </div>
                <div class="col text-center">
                    <span style="color:black;font-size:20px;">Total Saldo:</span><br>
                    <span style="color:black;font-size:15px;" :class="`${(totalSaldo>0)?'animate__animated animate__repeat-3 animate__flash':''}`"> ${{numberFormat(totalSaldo)}}</span>
                </div>
            </div>


        </div>
    </div>
    <hr>
    <button :disabled="info.length==0" class="btn btn-warning btn-sm" type="button" @click="printReporte()"><i class="fa fa-print" aria-hidden="true"></i> Imprimir</button>
    <button :disabled="seleccionados.length==0" class="btn btn-success btn-sm" type="button" @click="openLiquidar([])"><i class="fa fa-sort" aria-hidden="true"></i><span v-if="seleccionados.length>0">({{seleccionados.length}}) </span> Liquidar</button>

    <hr>

    <input class="form-control" type="text" placeholder="busqueda..." v-model="busqueda">
    <div class="row">
        <div class="col">

            <el-table size="small" height="850" :data="infoFiltered" style="width: 100%">
                <el-table-column label="" width="40" align="center">
                    <template slot="header">
                        <el-button type="primary" size="mini" @click="doToggle"><i class="el-icon-finished"></i></el-button>
                    </template>

                    <template slot-scope="ppr">
                        <span v-if="parseFloat(ppr.row.saldo)>0"><input v-model="ppr.row.seleccionado" type="checkbox">

                    </template>
                </el-table-column>
                <el-table-column label="Cod." v-if="false">
                    <template slot-scope="ppr">
                        {{(ppr.row.codigo)}}
                    </template>
                </el-table-column>
                <el-table-column label="Empresa">
                    <template slot-scope="ppr">
                        {{(ppr.row.empresa)}}
                    </template>
                </el-table-column>
                <el-table-column label="Fecha">
                    <template slot-scope="ppr">
                        {{(ppr.row.fecha_docum)}}
                    </template>
                </el-table-column>
                <el-table-column label="Hora">
                    <template slot-scope="ppr">
                        {{(ppr.row.hora)}}
                    </template>
                </el-table-column>
                <el-table-column label="Caja">
                    <template slot-scope="ppr">
                        {{(ppr.row.caja)}}
                    </template>
                </el-table-column>
                <el-table-column label="Tipo Documento" v-if="false">
                    <template slot-scope="ppr">
                        {{(ppr.row.tipodoc)}}
                    </template>
                </el-table-column>
                <el-table-column label="Documento">
                    <template slot-scope="ppr">
                        {{(ppr.row.documento)}}
                    </template>
                </el-table-column>
                <el-table-column label="Nombre" width="300">
                    <template slot-scope="ppr">
                        {{(ppr.row.nombre)}}
                    </template>
                </el-table-column>
                <el-table-column label="Total">
                    <template slot-scope="ppr">
                        {{(ppr.row.total)}}
                    </template>
                </el-table-column>
                <el-table-column label="Subsidio" v-if="false">
                    <template slot-scope="ppr">
                        {{(ppr.row.subsidio)}}
                    </template>
                </el-table-column>
                <el-table-column label="Saldo">
                    <template slot-scope="ppr">
                        {{(ppr.row.saldo)}}
                    </template>
                </el-table-column>
                <el-table-column label="Liquidado">
                    <template slot-scope="ppr">
                        {{(ppr.row.liquidado)}}
                    </template>
                </el-table-column>
                <el-table-column label="Cond. pago">
                    <template slot-scope="ppr">
                        {{(ppr.row.condicionpago)}}
                    </template>
                </el-table-column>
                <el-table-column label="Vendedor" v-if="false">
                    <template slot-scope="ppr">
                        {{(ppr.row.nombrevendedor)}}
                    </template>
                </el-table-column>


                <el-table-column label="-">
                    <template slot-scope="ppr">

                    </template>
                </el-table-column>

            </el-table>

        </div>
    </div>

    <div v-loading='loading' class='modal fade' id='liquidarModal' tabindex='-1' aria-labelledby='liquidarLabel' aria-hidden='true'>
        <div class='modal-dialog modal-xl '>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h5 class='modal-title' id='liquidarLabel'>Liquidación</h5>
                    <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                        <span aria-hidden='true'>&times;</span>
                    </button>
                </div>
                <div class='modal-body' v-loading='loading'>
                    <div class=''>
                        <h4>¿Desea liquidar?</h4>
                        <br>
                        <h6># de documentos: {{seleccionados.length}} </h6>
                        TOTAL: $ <b>{{seleccionados.reduce((c, a) => {
                        return c+parseFloat(a.total)
                    }, 0)}}</b>

                        <el-table height='380' :data="seleccionados" style="width: 100%">
                            <el-table-column prop="codigo" label="COD." width="80">
                            </el-table-column>
                            <el-table-column prop="nombre" label="Nombre">
                            </el-table-column>
                            <el-table-column prop="nombrevendedor" label="Nombre Vendedor">
                            </el-table-column>
                            <el-table-column prop="total" label="total">
                            </el-table-column>

                        </el-table>
                        <br>
                        <button type="button" class="btn btn-sm btn-danger" @click="procederLiquidar()">Proceder a liquidar</button>

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
            paraToggle: false,
            estadoSaldo: '',
            filtroEstado: '',
            textoCarga: 'procesando...',
            fechas: [dayjs(), dayjs()], //.subtract(9, 'days'),
            loading: true,
            sucursalSeleccionada: '',
            actualLiquidar: '',
            sucursales: <?= $sucursales ?>,
            info: [],
        },
        methods: {
            doToggle() {
                this.info.forEach(d => {
                    d.seleccionado = !this.paraToggle;
                });
                this.paraToggle = !this.paraToggle;
            },

            sincronizar() {
                this.loading = true;
                axios.post('<?= route('updaterRPT') ?>', {
                        fecha: dayjs(app.fecha).format('DD.MM.YYYY'),
                        sucursal: app.sucursalSeleccionada,
                    })
                    .then(res => {
                        app.loading = false;
                        app.getData();

                    })
                    .catch(err => {
                        console.error(err);
                        app.loading = false;
                    });
            },
            procederLiquidar() {
                this.$confirm('Desea proceder a la liquidación?', 'Liquidación', {
                    confirmButtonText: 'OK',
                    cancelButtonText: 'Cancel',
                    type: 'warning'
                }).then(() => {
                    app.loading = true;
                    axios.post('<?= route('generarLiquidacion') ?>', {
                            datos: app.seleccionados.map(r => r.idunico),
                        })
                        .then(res => {
                            app.loading = false;
                            if (res.data.exito == 1) {
                                app.si(res.data.mensaje);
                                $('#liquidarModal').modal('hide');
                                app.getData()
                            } else {
                                app.no(res.data.mensaje);
                            }


                        })
                        .catch(err => {
                            console.error(err);
                            app.loading = false;
                            app.si(err);
                        });
                }).catch(() => {

                });
            },
            openLiquidar(d) {
                this.actualLiquidar = d;
                $('#liquidarModal').modal();

            },
            tablaReporte(d, total, saldo) {

                let tabla = []
                let c = 1;
                d.forEach(r => {
                    tabla.push(
                        [{
                                text: this.dateFormater(r.fecha_docum) + ' ' + r.hora,
                                fontSize: 7,
                                border: [0, 0, 0, 0],
                            }, {
                                text: r.idunico,
                                fontSize: 7,
                                border: [0, 0, 0, 0],
                            },

                            {
                                text: r.tipodoc,
                                fontSize: 7,
                                border: [0, 0, 0, 0],
                            },
                            {
                                text: r.documento,
                                fontSize: 7,
                                border: [0, 0, 0, 0],
                            },
                            {
                                text: r.nombre,
                                fontSize: 7,
                                border: [0, 0, 0, 0],
                            },
                            {
                                text: this.numberFormat(r.total),
                                fontSize: 7,
                                border: [0, 0, 0, 0],
                                alignment: 'right',
                            },
                            {
                                text: this.numberFormat(r.saldo),
                                fontSize: 7,
                                border: [0, 0, 0, 0],
                                alignment: 'right',
                            },

                        ]
                    )
                    c++;
                });
                if (d.length > 0) {
                    tabla.push(
                        [{
                                text: '# de items: ',
                                fontSize: 7,
                                border: [0, 10, 0, 0],
                            },
                            {
                                text: d.length,
                                fontSize: 7,
                                border: [0, 10, 0, 0],
                            },
                            {
                                text: '',
                                fontSize: 7,
                                border: [0, 10, 0, 0],
                            },
                            {
                                text: '',
                                fontSize: 7,
                                border: [0, 10, 0, 0],
                            },
                            {
                                text: 'Total',
                                fontSize: 7,
                                border: [0, 10, 0, 0],
                                alignment: 'right',
                            },
                            {
                                text: '$ ' + total,
                                fontSize: 7,
                                border: [0, 10, 0, 0],
                                alignment: 'right',
                            },
                            {
                                text: '$ ' + saldo,
                                fontSize: 7,
                                border: [0, 10, 0, 0],
                            },

                        ]
                    )
                }
                return tabla
            },
            printReporte() {

                let dd = {
                    pageSize: 'letter',
                    background: [{
                        image: logo_trasparente,
                        fit: [595.28, 841.89],
                        margin: [0, 240, 0, 0]
                    }, ],
                    header: function(currentPage, pageCount) {
                        return {
                            stack: [{
                                    text: "LEALCO S.A DE CV",
                                    alignment: 'center',
                                    fontSize: 12,
                                    style: 'customMargin',
                                    bold: true,
                                },
                                {
                                    text: "REPORTE DE LIQUIDACION DE VENTA DIRECTA",
                                    alignment: 'center',
                                    fontSize: 10,
                                    bold: true,
                                },
                                {
                                    text: "DEL: " + dayjs(app.fechas[0]).format('DD/MM/YYYY') + ' al ' + dayjs(app.fechas[1]).format('DD/MM/YYYY'),
                                    alignment: 'center',
                                    fontSize: 9,
                                    bold: true,
                                },


                            ],
                            border: [false, false, false, false]
                        };
                    },
                    footer: function(currentPage, pageCount) {
                        return {
                            text: `Página ${currentPage} de ${pageCount} - Hora y fecha de impresión ${dayjs(this.fecha).format('DD/MM/YYYY hh:mm a')}`,
                            fontSize: 7,
                            alignment: 'center', // Alinea el texto al centro
                        };
                    },

                    pageMargins: [30, 59, 20, 45],
                    styles: {
                        customMargin: {
                            margin: [0, 12, 0, 0], // [izquierda, derecha] márgenes horizontalmente
                        },
                        imagenConMargen: {
                            margin: [0, 0, 0, 0], // [margen izquierdo, margen superior]
                        },
                    },
                    content: [{
                            table: {
                                layout: 'noBorders',
                                widths: [140, '*', 60, 70],
                                body: [
                                    [{
                                            text: '',
                                            border: [false, false, false, false]
                                        },



                                    ]

                                ]
                            }
                        },
                        linea(),
                        {
                            table: {
                                layout: 'noBorders',
                                widths: [60, 20, 35, 50, 170, 40, 40],
                                headerRows: 1,
                                body: [

                                    [{
                                        text: 'FECHA Y HORA',
                                        bold: true,
                                        color: 'black',
                                        fontSize: 7,
                                        border: [0, 0, 0, 0],

                                    }, {
                                        text: 'ID',
                                        bold: true,
                                        color: 'black',
                                        fontSize: 7,
                                        border: [0, 0, 0, 0],

                                    }, {
                                        text: 'TIPO DOC',
                                        bold: true,
                                        color: 'black',
                                        fontSize: 7,
                                        border: [0, 0, 0, 0],

                                    }, {
                                        text: 'DOCUMENTO',
                                        bold: true,
                                        color: 'black',
                                        fontSize: 7,
                                        border: [0, 0, 0, 0],

                                    }, {
                                        text: 'NOMBRE',
                                        bold: true,
                                        color: 'black',
                                        fontSize: 7,
                                        border: [0, 0, 0, 0],

                                    }, {
                                        text: 'TOTAL',
                                        bold: true,
                                        color: 'black',
                                        fontSize: 7,
                                        border: [0, 0, 0, 0],
                                        alignment: 'right',

                                    }, {
                                        text: 'Saldo',
                                        bold: true,
                                        color: 'black',
                                        fontSize: 7,
                                        border: [0, 0, 0, 0],
                                        alignment: 'right',

                                    }, ],
                                    ...this.tablaReporte(this.infoFiltered, this.numberFormat(this.info.reduce((a, b) => a + parseFloat(b.total), 0)), this.numberFormat(this.info.reduce((a, b) => a + parseFloat(b.saldo), 0))),
                                ]
                            }
                        },
                        {
                            text: '\n\n\n\n\n\n\n\n\n\n'
                        },
                        {
                            table: {
                                layout: 'noBorders',
                                widths: ['*', 170, '*', 170, '*'],
                                body: [
                                    [{
                                            text: '',
                                            border: [false, false, false, false]
                                        },
                                        {
                                            text: 'Firma Liquidador',
                                            alignment: 'center',
                                            fontSize: 7,
                                            border: [false, 1, false, false]
                                        },
                                        {
                                            text: '',
                                            border: [false, false, false, false]
                                        },
                                        {
                                            text: 'Firma Vendedor',
                                            alignment: 'center',
                                            fontSize: 7,
                                            border: [false, 5, false, false]
                                        },
                                        {
                                            text: '',
                                            border: [false, false, false, false]
                                        }
                                    ]
                                ]
                            }
                        }

                    ],
                }

                let q = pdfMake.createPdf(dd)
                q.open()
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

                this.info = []
                this.loading = true;
                axios.post('<?= route('getRepoLiqudacion') ?>', {
                        fechas_ini: dayjs(this.fechas[0]).format('YYYY-MM-DD'),
                        fechas_fin: dayjs(this.fechas[1]).format('YYYY-MM-DD'),
                    })
                    .then(res => {
                        res.data.forEach(d => {
                            d.seleccionado = false;
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
            sucursalesData() {
                let data = []
                if (this.info.length > 0)
                    data = [...new Set(app.infoFiltered.map(r => r.sucursal))]
                return data
            },
            resumen() {
                let data = []
                if (this.info.length > 0) {

                    this.sucursalesData.forEach(w => {

                        let tmp = this.infoFiltered.filter(r => r.sucursal == w);
                        let indicador_sap = ''
                        let indicador_mh = ''
                        let liquidado = false
                        tmp.forEach(q => {
                            q.warning = ''
                            if (q.liquidado == 1) {
                                liquidado = true
                            }
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
                            "liquidado": liquidado,
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
            infoFiltered() {
                let data = [];
                if (this.info.length > 0) {
                    data = this.info
                    if (this.filtroEstado != '') {
                        switch (this.filtroEstado) {
                            case "Rechazado":
                                data = data.filter(r => ((r.mensajemh.includes('RECHAZADO') || r.mensajemh == '')))
                                break;
                            case "Procesado":
                                data = data.filter(r => (r.mensajemh.includes('PROCESADO')))
                                break;
                            default:
                                break;
                        }
                    }

                    if (this.sucursalSeleccionada != '')
                        data = data.filter(r => r.empresa == this.sucursalSeleccionada);

                    if (this.estadoSaldo != '') {
                        switch (this.estadoSaldo) {
                            case 'Con Saldo':
                                data = data.filter(e => parseFloat(e.saldo) > 0)
                                break;
                            case 'Cancelados':
                                data = data.filter(e => parseFloat(e.saldo) == 0)
                                break;
                            default:
                                break;
                        }



                    }

                    if (this.busqueda != '') {
                        data = data.filter(b => (
                            (b.codigo.includes(this.busqueda.toUpperCase())) ||
                            (b.condicionpago.includes(this.busqueda.toUpperCase())) ||
                            (b.documento.includes(this.busqueda.toUpperCase())) ||
                            (this.dateFormater(b.fecha_docum)?.toUpperCase().includes(this.busqueda.toUpperCase())) ||
                            (b.hora?.toUpperCase().includes(this.busqueda.toUpperCase())) ||
                            (b.nombre?.toUpperCase().includes(this.busqueda?.toUpperCase())) ||
                            (b.tipodoc?.toUpperCase().includes(this.busqueda?.toUpperCase())) ||
                            (b.nombrevendedor?.toUpperCase().includes(this.busqueda?.toUpperCase()))
                        ))
                    }

                }
                return data;
            },
            totalMH() {
                return this.calcularTotalMH(this.infoFiltered);
            },
            totalGeneral() {
                return this.calcularTotalGeneral(this.infoFiltered)
            },
            totalSAP() {
                return this.calcularTotalSAP(this.infoFiltered)
            },
            totalSaldo() {
                if (this.infoFiltered.length > 0) {
                    return this.infoFiltered.reduce(function(a, b) {
                        return a + Number(b.saldo);
                    }, 0);

                }
                return 0;

            },
            seleccionados() {
                return this.info.filter(r => r.seleccionado);
            },
        },
        watch: {},
        mounted() {
            this.loading = true;
            this.getData()


        },
    });

    function linea() {
        return {
            canvas: [{
                type: 'line',
                x1: 0,
                y1: 0, // Coordenadas de inicio
                x2: 538,
                y2: 0, // Coordenadas de finalización
                lineWidth: 1, // Ancho de la línea
                lineColor: 'gray' // Color de la línea (puedes ajustar el color)
            }]
        };
    }
</script>




@endverbatim
@endsection