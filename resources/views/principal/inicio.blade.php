@extends('template')
@section('titulo', 'DTE GUARD - Bienvenido')
@section('pagina', 'DTE GUARD - Bienvenido')
@section('contenido')
@verbatim
<script src="<?= url('/') ?>/varr.js?<?= rand(1, 50) ?>"></script>
<div id="app" v-loading.fullscreen.lock="loading" :element-loading-text="textoCarga" element-loading-spinner="el-icon-loading" element-loading-background="rgba(0, 0, 0, 0.8)">
  <h1 class="h3 mb-0 text-gray-800">Facturas</h1>
  <div class="">
    <div class="card border-left-primary shadow h-100">
      <div class="card-body">
        <div class="d-flex justify-content-between">
          <div>
            Consultar: <el-date-picker @change="getRegistros()" format="dd/MM/yyyy" v-model="fecha">
          </div>
          <div>
            Filtrar por:
            <input class="" type="text" @input="supermercadosFiltro=''; resetSeleccion()" v-model="gestion" placeholder="filtro por gestión">
            <input class="" type="text" v-model="busqueda">
          </div>

        </div>
      </div>
    </div>
  </div>
  <div class="row">

    <div class="col-md-6">
      <table>
        <tr>
          <td> </td>
          <td>

          </td>
        </tr>
      </table>

      </el-date-picker>
    </div>
    <div class="col-md-3">
      <button type="button" class="btn btn-primary btn-sm d-none">Consultar api cliente</button>
    </div>
  </div>
  <div class="d-flex flex-wrap">

    <div class="px-3"><i class="fa fa-envelope text-danger"></i> Sin enviar</div>
    <div class="px-3"><i class="fa fa-envelope text-success"></i> Correo enviado</div>
    <div class="px-3">
      <el-popover placement="top-start" width="400" trigger="hover">
        <table>
          Impresiones por defecto:
          <tr>
            <td>CALLEJA</td>
            <td> 1 copias, doble cara </td>
          </tr>
          <tr>
            <td>OPERADORA</td>
            <td>3 copias, una cara</td>
          </tr>
          <tr>
            <td>Documento Crédito</td>
            <td>2 copias</td>
          </tr>
          <tr>
            <td>Documento Contado</td>
            <td>1 copia</td>
          </tr>
        </table>
        <i style="color:blue;" class="el-icon-info animate__animated animate__flash animate__delay-5s animate__repeat-3" slot="reference"></i>

      </el-popover>
      Cantidad de copias:
      <el-input-number v-model="cantidadImpresion" size="mini" controls-position="right" :min="1" :max="1"></el-input-number>
    </div>
    <div class="px-5">

      Filtrar: <el-select size="small" v-model="correoFiltro">
        <el-option key="" value="" label="Todos - Correos enviados"></el-option>
        <el-option key="0" value="0" label="Sin enviar"></el-option>
        <el-option key="1" value="1" label="Enviados"></el-option>
      </el-select>


      <el-select size="small" v-model="tipoDocumentoFiltro" @change="resetSeleccion()">
        <el-option key="" value="" label="Todos los documentos"></el-option>
        <el-option key="01" value="01" label="FACTURA"></el-option> <el-option key="03" value="03" label="CRÉDITO FISCAL"></el-option>
        <el-option key="05" value="05" label="NOTA DE CRÉDITO"></el-option>
        <el-option key="11" value="11" label="FACTURA DE EXPORTACIÓN "></el-option>
      </el-select>




      <el-select size="small" v-model="supermercadosFiltro" filterable @change="resetSeleccion(); gestion=''">
        <el-option key="" label="Todos los registros" value="">
        </el-option>
        <el-option v-for="(d) in listadoSupermercadoDistinct" :key="d" :value="d">
        </el-option>
      </el-select>

    </div>
  </div>
  <div class="row mt-3">

    <div class="col-md-3 d-none">
      <div style="display: inline-block;">Archivo:
        <input type="text">

      </div>

      <small>(Códigos de generación)</small>

    </div>
    <div class="col-md-3">
      <button type="button" class="btn btn-primary btn-sm " @click="openCvs()">Subir CSV</button>
    </div>
    <div class="col-md-2">
      <div class="d-none">
        <el-radio-group v-model="tipoModelo">
          <el-radio label="hacienda">Hacienda</el-radio>
          <el-radio label="contingencia">Contingencia</el-radio>
        </el-radio-group>

      </div>

      <button type="button" class="btn btn-primary btn-sm d-none">Extraer versión gráfica</button>
    </div>
    <div class="col-md-2 d-none">
      <button type="button" class="btn btn-primary btn-sm  d-none">Imprimir</button>
    </div>
    <div class="col-md-2">
    </div>
    <div class="col-4 text-right">
      <button :disabled="registros.filter(r=>r.seleccionado).length==0" type="button" @click="modalEnviarCorreo()" class="btn btn-warning btn-sm float-end d-none">Enviar correos</button>
      <button :disabled="registros.filter(r=>r.seleccionado).length==0" type="button" @click="imprimirAccion()" class="btn btn-danger btn-sm float-end ">Imprimir seleccionados{{(seleccionados.length==0)?'':seleccionados.length}}</button>
      <button :disabled="paraSincronizar.length==0||(dayjs(fecha)?.format('DD/MM/YYYY')=='Invalid Date'||supemercados.length==0)" type="button" @click="sincronizacion()" class="btn btn-danger btn-sm float-end ">Sincronizar fecha: {{(dayjs(fecha)?.format('DD/MM/YYYY')=='Invalid Date'?'':dayjs(fecha)?.format('DD/MM/YYYY'))}} {{`(${(paraSincronizar.length==0)?'':paraSincronizar.length})`}} </button>
      <button disabled type="button" @click="modalEnviarCorreo()" class="btn btn-warning btn-sm float-end ">Enviar correos</button>
    </div>
  </div>
  <div class="alert alert-primary" role="alert" v-if="listadoRegionesAFiltrar.length>0">
    rango seleccionado ({{listadoRegionesAFiltrar.length}}): {{listadoRegionesAFiltrar.join(', ')}}
  </div>


  <div class="row">
    <div class="col">
      <div class="table-responsive">
        <table class="table table-bordered table-striped table-sm">
          <thead>
            <tr>
              <th colspan="3">Registros: {{registrosFiltrado.length}}</th>
              <th colspan="6">CAMPOS OPCIONABLES CONFIGURABLES</th>
            </tr>
            <tr>
              <th><button type="button" class="btn btn-info btn-sm" @click="seleccionarTodo()">
                  <i class="fa fa-flag" aria-hidden="true"></i>
                </button></th>
              <th>ITEM</th>
              <th>FECHA</th>
              <th><span v-if="mostrarCodigo">COD.GEN.DTE</span> <span v-else>N.Control</span>
                <el-tooltip class="item" effect="dark" content="presionar para intercambiar entre codigo DTE y N.Control" placement="top-start">
                  <button class="btn btn-outline-info btn-xs" @click="mostrarCodigo=!mostrarCodigo"><i class="fa fa-exchange" aria-hidden="true"></i></button>
                </el-tooltip>
              </th>
              <th>NOMBRE</th>
              <th>COMERCIAL</th>
              <th>VALOR</th>
              <th>CORREO</th>
              <th>WHATSAPP</th>
              <th>VISOR</th>
            </tr>
          </thead>
          <tbody>
            <tr v-for="(d,k) in registrosFiltrado">
              <td><span v-if="d.correo!=null||true"><input v-if="d.correo_enviado==0" v-model="d.seleccionado" type="checkbox"></span></td>
              <td>{{k+1}}</td>
              <td>{{dateFormater(d.fecha,'DD/MM/YYYY')}}</td>
              <td>
                <span v-if="mostrarCodigo">
                  {{d.cod_gen_dte}}
                </span>
                <span v-else>
                  {{getNumControl(d.json_data)}}
                </span>

              </td>
              <td>{{d.nombre}}</td>
              <td>{{getNombreComercial(d)}}</td>
              <td>{{numberFormat(d.valor)}}</td>
              <td>
                <span>
                  <i :class="`fa fa-envelope ${(d.correo_enviado==0)?'text-danger':'text-success'}`"></i>
                </span>
                <i></i>
                <span v-if="d.correo!=null||true">
                  {{d.correo}}
                </span>
                <span v-else>
                  <input type="text" v-model="d.correo_nuevo" placeholder="No Asignado">
                  <button type="button" @click="guardarCorreo(d)" class="btn btn-sm btn-warning"><i class="fa fa-save"></i>
                  </button>
                </span>
                <button type="button" class="btn btn-warning btn-sm d-none" @click="modalCorreo(d.cod_gen_dte)">Enviar por correo</button>
              </td>
              <td>WHATSAPP</td>
              <td>
                <button class="btn btn-sm btn-success d-none" @click="mostrarPDF(d.cod_gen_dte)">Visor</button>
                <button class="btn btn-sm btn-success" @click="openPDF(d)">Visor</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    <div class="col-6" v-if="showPDF">
      <button class="btn btn-info btn-xs" @click="showPDF=false">x</button>

      <div>
        <iframe :src="pdfUrl" width="100%" height="450px"></iframe>
      </div>
    </div>
  </div>

  <div class="modal fade" v-loading="loading" id="modalEmail" tabindex="-1" role="dialog" aria-labelledby="modalEmailLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="modalEmailLabel">Enviar por correo</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            x
          </button>
        </div>
        <div class="modal-body">
          <div class="col-xl-12 invoice-address-company">
            <div class="invoice-address-company-fields">

              <div class="form-group row">
                <label for="company-name" class="col-sm-3 col-form-label col-form-label-sm">Para:</label>
                <div class="col-sm-7">
                  <input v-model.trim="para" type="text" class="form-control form-control-sm" placeholder="Para">
                </div>
                <div class="col-sm-2">
                  <button class="btn btn-info" @click="addPara()">Agregar</button>
                </div>
              </div>



              <div class="form-group row">
                <label for="company-name" class="col-sm-3 col-form-label col-form-label-sm">CC:</label>
                <div class="col-sm-7">
                  <input v-model.trim="cc" type="text" class="form-control form-control-sm" placeholder="CC">
                </div>
                <div class="col-sm-2">
                  <button class="btn btn-info" @click="addCC()">Agregar</button>
                </div>
              </div>


              <div class="form-group row">
                <label for="company-name" class="col-sm-3 col-form-label col-form-label-sm">BCC:</label>
                <div class="col-sm-7">
                  <input v-model.trim="bcc" type="text" class="form-control form-control-sm" placeholder="BCC">
                </div>
                <div class="col-sm-2">
                  <button class="btn btn-info" @click="addBCC()">Agregar</button>
                </div>
              </div>



            </div>

          </div>

          <div class="tags-input-wrapper">

            <b>Para:</b> <span v-for="(d,i) in correos.para" class="tag" :key="i">{{ d }}<a class="bg-danger mx-3 px-2 text-white" @click="correos.para.splice(i,1);">x</a></span><br><br>
            <b>CC:</b> <span v-for="(d,i) in correos.cc" class="tag" :key="'a'+i">{{ d }}<a class="bg-danger mx-3 px-2 text-white" @click="correos.cc.splice(i,1);">x</a></span><br><br>
            <b>BCC:</b> <span v-for="(d,i) in correos.bcc" class="tag" :key="'b'+i">{{ d }} <a class="bg-danger mx-3 px-2 text-white" @click="correos.bcc.splice(i,1);">x</a></span><br><br>
          </div>

        </div>
        <div class="modal-footer">
          <button class="btn" data-dismiss="modal"><i class="flaticon-cancel-12"></i>
            Cancelar</button>
          <button type="button" class="btn btn-primary" @click="doSentEmail()">Enviar</button>

        </div>
      </div>
    </div>
  </div>

  <div v-loading='loading' class='modal fade' id='enviarCorreoModal' tabindex='-1' aria-labelledby='enviarCorreoLabel' aria-hidden='true'>
    <div class='modal-dialog modal-xl '>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title' id='enviarCorreoLabel'>Por enviar</h5>
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>
        <div class='modal-body' v-loading='loading'>
          <div class=''>
            Se enviaran las facturas correspondientes a sus correos:
            <br>
            <br>
            <br>
            <ul>
              <li v-for="(d,k) in registros.filter(r=>r.seleccionado)">{{d.correo}}</li>
            </ul>
            <br>
            <br>
            <br>
            <button class="btn btn-success">Enviar</button>


          </div>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
        </div>
      </div>
    </div>
  </div>

  <div v-loading='loading' class='modal fade' id='cvsModal' tabindex='-1' aria-labelledby='cvsLabel' aria-hidden='true'>
    <div class='modal-dialog modal-xl '>
      <div class='modal-content'>
        <div class='modal-header'>
          <h5 class='modal-title' id='cvsLabel'>Subir desde excel</h5>
          <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
            <span aria-hidden='true'>&times;</span>
          </button>
        </div>
        <div class='modal-body' v-loading='loading'>
          <a href="archivo_dte.xlsx" class="btn btn-success py-2 px-2">Plantilla</a>
          <div class=''>
            <h4>Selccione el archivo a cargar:</h4>
            <br>
            <div>
              <input class="" type="file" id="file_upload" onchange="upload()" />

            </div>
            <br>

            <div v-if="cvs.length>0">
              <h5>¿Desea subir la siguiente información?</h5>
              <table>
                <thead>
                  <tr>
                    <th>Cod. DTE</th>
                    <th>-</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="(d,k) in cvs">
                    <td>{{d.codigo_dte}}</td>
                    <td>-</td>
                  </tr>
                </tbody>
              </table>
              <button type="button" class="btn btn-success btn-xs" @click="cargarDatos()">Subir registros</button>
            </div>


            <textarea id="json-result" style="display:none;height:500px;width:350px;"></textarea>
          </div>
        </div>
        <div class='modal-footer'>
          <button type='button' class='btn btn-secondary' data-dismiss='modal'>Cancelar</button>
        </div>
      </div>
    </div>
  </div>

</div>


<script>
  let app = new Vue({
    el: '#app',
    data: {
      dayjs: dayjs,
      para: '',
      cc: '',
      bcc: '',
      correos: {
        para: [],
        cc: [],
        bcc: []
      },
      busqueda: '',
      mostrarCodigo: true,
      custom_desc: custom_description,
      listadoRegionesAFiltrar: [],
      cantidadImpresion: 1,
      impresorSelecionada: "<?= $impresor ?>",
      gestion: '',
      tipoModelo: 'contingencia',
      supermercadosFiltro: '',
      toggle: true,
      pdfUrl: '',
      textoCarga: 'Procesando...',
      correoFiltro: '',
      tipoDocumentoFiltro: '',
      currentPorCorreo: '',
      fecha: dayjs(), //dayjs().subtract(6, 'day'),
      loading: true,
      showPDF: false,
      factura: {},
      cvs: [],
      registros: [],
      supemercados: [],
      codigoBarra: [],
      departamentos: [],
      municipios: [],
      base64List: [],
      ccliente: [{
        "MATNR": 140423,
        "KDMAT": "38684"
      }, {
        "MATNR": 140424,
        "KDMAT": "38680"
      }, {
        "MATNR": 140425,
        "KDMAT": "38681"
      }, {
        "MATNR": 140426,
        "KDMAT": "38682"
      }, {
        "MATNR": 140428,
        "KDMAT": "39216"
      }, {
        "MATNR": 140429,
        "KDMAT": "39214"
      }, {
        "MATNR": 140430,
        "KDMAT": "39219"
      }, {
        "MATNR": 140432,
        "KDMAT": "39218"
      }, {
        "MATNR": 140444,
        "KDMAT": "5030´"
      }, {
        "MATNR": 140445,
        "KDMAT": "5381´"
      }, {
        "MATNR": 140446,
        "KDMAT": "5054´"
      }, {
        "MATNR": 140447,
        "KDMAT": "30050´"
      }, {
        "MATNR": 140448,
        "KDMAT": "5030'"
      }, {
        "MATNR": 140449,
        "KDMAT": "5381'"
      }, {
        "MATNR": 140450,
        "KDMAT": "5054'"
      }, {
        "MATNR": 140451,
        "KDMAT": "30050'"
      }, {
        "MATNR": 140452,
        "KDMAT": "34098"
      }, {
        "MATNR": 150031,
        "KDMAT": "59002"
      }, {
        "MATNR": 140315,
        "KDMAT": "2191*"
      }, {
        "MATNR": 140327,
        "KDMAT": "2191"
      }, {
        "MATNR": 140804,
        "KDMAT": "59935."
      }, {
        "MATNR": 140763,
        "KDMAT": "5055."
      }, {
        "MATNR": 140873,
        "KDMAT": "65679"
      }, {
        "MATNR": 140872,
        "KDMAT": "65680"
      }, {
        "MATNR": 140768,
        "KDMAT": "23423"
      }, {
        "MATNR": 140375,
        "KDMAT": "23423_"
      }, {
        "MATNR": 140292,
        "KDMAT": "51874"
      }, {
        "MATNR": 140862,
        "KDMAT": "20302"
      }, {
        "MATNR": 140767,
        "KDMAT": "3204"
      }, {
        "MATNR": 140769,
        "KDMAT": "2949"
      }, {
        "MATNR": 140320,
        "KDMAT": "2191^"
      }, {
        "MATNR": 140330,
        "KDMAT": "2191°"
      }, {
        "MATNR": 140341,
        "KDMAT": "2282"
      }, {
        "MATNR": 140266,
        "KDMAT": "9452"
      }, {
        "MATNR": 140294,
        "KDMAT": "51874`"
      }, {
        "MATNR": 140296,
        "KDMAT": "2190:"
      }, {
        "MATNR": 140374,
        "KDMAT": "23423"
      }, {
        "MATNR": 140585,
        "KDMAT": "48281"
      }, {
        "MATNR": 140587,
        "KDMAT": "48281."
      }, {
        "MATNR": 140324,
        "KDMAT": "47066."
      }, {
        "MATNR": 140722,
        "KDMAT": "47066*"
      }, {
        "MATNR": 140704,
        "KDMAT": "54843"
      }, {
        "MATNR": 140702,
        "KDMAT": "55002"
      }, {
        "MATNR": 140232,
        "KDMAT": "5030."
      }, {
        "MATNR": 140664,
        "KDMAT": "53524"
      }, {
        "MATNR": 140673,
        "KDMAT": "54241."
      }, {
        "MATNR": 140662,
        "KDMAT": "20302*"
      }, {
        "MATNR": 140668,
        "KDMAT": "53446"
      }, {
        "MATNR": 140665,
        "KDMAT": "53447"
      }, {
        "MATNR": 140666,
        "KDMAT": "53445"
      }, {
        "MATNR": 140348,
        "KDMAT": "34098."
      }, {
        "MATNR": 140211,
        "KDMAT": "28365"
      }, {
        "MATNR": 140373,
        "KDMAT": "23423."
      }, {
        "MATNR": 140512,
        "KDMAT": "51874"
      }, {
        "MATNR": 140575,
        "KDMAT": "51874."
      }, {
        "MATNR": 140303,
        "KDMAT": "2190."
      }, {
        "MATNR": 140574,
        "KDMAT": "31820."
      }, {
        "MATNR": 140588,
        "KDMAT": "41163"
      }, {
        "MATNR": 140474,
        "KDMAT": "41713"
      }, {
        "MATNR": 140071,
        "KDMAT": "9452."
      }, {
        "MATNR": 140589,
        "KDMAT": "17413."
      }, {
        "MATNR": 140417,
        "KDMAT": "7598.."
      }, {
        "MATNR": 140325,
        "KDMAT": "47066"
      }, {
        "MATNR": 140793,
        "KDMAT": "59969"
      }, {
        "MATNR": 140792,
        "KDMAT": "59970"
      }, {
        "MATNR": 140794,
        "KDMAT": "59557"
      }, {
        "MATNR": 140823,
        "KDMAT": "39216."
      }, {
        "MATNR": 140837,
        "KDMAT": "62315"
      }, {
        "MATNR": 140836,
        "KDMAT": "61341"
      }, {
        "MATNR": 140783,
        "KDMAT": "59435"
      }, {
        "MATNR": 140782,
        "KDMAT": "59434"
      }, {
        "MATNR": 140667,
        "KDMAT": "53446."
      }, {
        "MATNR": 140786,
        "KDMAT": "59239"
      }, {
        "MATNR": 140733,
        "KDMAT": "57475"
      }, {
        "MATNR": 140732,
        "KDMAT": "56456"
      }, {
        "MATNR": 140803,
        "KDMAT": "59611"
      }, {
        "MATNR": 140723,
        "KDMAT": "47066,"
      }, {
        "MATNR": 140349,
        "KDMAT": "3204.,"
      }, {
        "MATNR": 140835,
        "KDMAT": "29239."
      }, {
        "MATNR": 140220,
        "KDMAT": "20302"
      }, {
        "MATNR": 140221,
        "KDMAT": "20301"
      }, {
        "MATNR": 140222,
        "KDMAT": "20303"
      }, {
        "MATNR": 140223,
        "KDMAT": "20302."
      }, {
        "MATNR": 140224,
        "KDMAT": "30050"
      }, {
        "MATNR": 140225,
        "KDMAT": "5030"
      }, {
        "MATNR": 140226,
        "KDMAT": "5381"
      }, {
        "MATNR": 140227,
        "KDMAT": "5380"
      }, {
        "MATNR": 140228,
        "KDMAT": "5053"
      }, {
        "MATNR": 140229,
        "KDMAT": "5054"
      }, {
        "MATNR": 140230,
        "KDMAT": "5055"
      }, {
        "MATNR": 140231,
        "KDMAT": "17413"
      }, {
        "MATNR": 140233,
        "KDMAT": "5626"
      }, {
        "MATNR": 140234,
        "KDMAT": "9747."
      }, {
        "MATNR": 140235,
        "KDMAT": "5625"
      }, {
        "MATNR": 140236,
        "KDMAT": "5030,"
      }, {
        "MATNR": 140237,
        "KDMAT": "5381,"
      }, {
        "MATNR": 140238,
        "KDMAT": "5380."
      }, {
        "MATNR": 140239,
        "KDMAT": "5053,"
      }, {
        "MATNR": 140240,
        "KDMAT": "5626.."
      }, {
        "MATNR": 140241,
        "KDMAT": "9747.."
      }, {
        "MATNR": 140250,
        "KDMAT": "59455"
      }, {
        "MATNR": 140251,
        "KDMAT": "28903"
      }, {
        "MATNR": 140252,
        "KDMAT": "28905"
      }, {
        "MATNR": 140253,
        "KDMAT": "31907"
      }, {
        "MATNR": 140254,
        "KDMAT": "91908"
      }, {
        "MATNR": 140255,
        "KDMAT": "2944"
      }, {
        "MATNR": 140256,
        "KDMAT": "3207,"
      }, {
        "MATNR": 140257,
        "KDMAT": "10736"
      }, {
        "MATNR": 140259,
        "KDMAT": "27704"
      }, {
        "MATNR": 140261,
        "KDMAT": "13725"
      }, {
        "MATNR": 140262,
        "KDMAT": "9605."
      }, {
        "MATNR": 140263,
        "KDMAT": "17879"
      }, {
        "MATNR": 140264,
        "KDMAT": "2198"
      }, {
        "MATNR": 140265,
        "KDMAT": "8729."
      }, {
        "MATNR": 140267,
        "KDMAT": "9608:"
      }, {
        "MATNR": 140268,
        "KDMAT": "9606"
      }, {
        "MATNR": 140269,
        "KDMAT": "17878"
      }, {
        "MATNR": 140270,
        "KDMAT": "9608'"
      }, {
        "MATNR": 140271,
        "KDMAT": "13724"
      }, {
        "MATNR": 140272,
        "KDMAT": "31624"
      }, {
        "MATNR": 140273,
        "KDMAT": "2188'"
      }, {
        "MATNR": 140274,
        "KDMAT": "2942"
      }, {
        "MATNR": 140275,
        "KDMAT": "2197"
      }, {
        "MATNR": 140276,
        "KDMAT": "2943"
      }, {
        "MATNR": 140277,
        "KDMAT": "30622"
      }, {
        "MATNR": 140278,
        "KDMAT": "13725,"
      }, {
        "MATNR": 140279,
        "KDMAT": "39220"
      }, {
        "MATNR": 140280,
        "KDMAT": "2198."
      }, {
        "MATNR": 140281,
        "KDMAT": "5381."
      }, {
        "MATNR": 140282,
        "KDMAT": "9608´"
      }, {
        "MATNR": 140283,
        "KDMAT": "9606,"
      }, {
        "MATNR": 140310,
        "KDMAT": "7596"
      }, {
        "MATNR": 140312,
        "KDMAT": "2191"
      }, {
        "MATNR": 140344,
        "KDMAT": "3204"
      }, {
        "MATNR": 140345,
        "KDMAT": "3204."
      }, {
        "MATNR": 140362,
        "KDMAT": "15344"
      }, {
        "MATNR": 140363,
        "KDMAT": "15446"
      }, {
        "MATNR": 140364,
        "KDMAT": "15343"
      }, {
        "MATNR": 140365,
        "KDMAT": "15445"
      }, {
        "MATNR": 140366,
        "KDMAT": "28289"
      }, {
        "MATNR": 140367,
        "KDMAT": "28906"
      }, {
        "MATNR": 140368,
        "KDMAT": "28185"
      }, {
        "MATNR": 140355,
        "KDMAT": "2949"
      }, {
        "MATNR": 140357,
        "KDMAT": "2949."
      }, {
        "MATNR": 140358,
        "KDMAT": "2949,"
      }, {
        "MATNR": 140413,
        "KDMAT": "51874,"
      }, {
        "MATNR": 140300,
        "KDMAT": "51874.."
      }, {
        "MATNR": 140301,
        "KDMAT": "2190.."
      }, {
        "MATNR": 140309,
        "KDMAT": "31820"
      }, {
        "MATNR": 140302,
        "KDMAT": "2190´"
      }, {
        "MATNR": 140314,
        "KDMAT": "2191:"
      }, {
        "MATNR": 140316,
        "KDMAT": "2191,"
      }, {
        "MATNR": 140317,
        "KDMAT": "2191."
      }, {
        "MATNR": 140318,
        "KDMAT": "2191.."
      }, {
        "MATNR": 140328,
        "KDMAT": "47526"
      }, {
        "MATNR": 140329,
        "KDMAT": "2191´"
      }, {
        "MATNR": 140331,
        "KDMAT": "47526"
      }, {
        "MATNR": 140332,
        "KDMAT": "7598"
      }, {
        "MATNR": 140260,
        "KDMAT": "2944."
      }, {
        "MATNR": 140336,
        "KDMAT": "7598."
      }, {
        "MATNR": 140918,
        "KDMAT": "71610"
      }, {
        "MATNR": 140921,
        "KDMAT": "71610"
      }, {
        "MATNR": 140906,
        "KDMAT": "71744"
      }, {
        "MATNR": 140907,
        "KDMAT": "71747"
      }, {
        "MATNR": 140903,
        "KDMAT": "71753"
      }, {
        "MATNR": 140905,
        "KDMAT": "71610"
      }, {
        "MATNR": 140904,
        "KDMAT": "71748"
      }, {
        "MATNR": 140891,
        "KDMAT": "47526"
      }, {
        "MATNR": 140328,
        "KDMAT": "47526"
      }, {
        "MATNR": 140458,
        "KDMAT": "20302"
      }, {
        "MATNR": 140908,
        "KDMAT": "59557"
      }, {
        "MATNR": 140864,
        "KDMAT": "59557"
      }, {
        "MATNR": 140889,
        "KDMAT": "2191"
      }, {
        "MATNR": 140887,
        "KDMAT": "2191"
      }, {
        "MATNR": 140324,
        "KDMAT": "47066"
      }, {
        "MATNR": 140899,
        "KDMAT": "2191"
      }, {
        "MATNR": 140902,
        "KDMAT": "47066"
      }, {
        "MATNR": 140901,
        "KDMAT": "47066"
      }, {
        "MATNR": 140572,
        "KDMAT": "31820"
      }],
      unidadesList: [{
          "und": "KG",
          "id": "34"
        },
        {
          "und": "LB",
          "id": "36"
        },
        {
          "und": "Otra",
          "id": "99"
        },
        {
          "und": "UN",
          "id": "59"
        },
      ],
      tipoDocumentoList: [{
          "id": "01",
          "nombre": "Factura"
        },
        {
          "id": "03",
          "nombre": "Comprobante de crédito fiscal"
        },
        {
          "id": "04",
          "nombre": "Nota de remisión"
        },
        {
          "id": "05",
          "nombre": "Nota de crédito"
        },
        {
          "id": "06",
          "nombre": "Nota de débito"
        },
        {
          "id": "07",
          "nombre": "Comprobante de retención"
        },
        {
          "id": "08",
          "nombre": "Comprobante de liquidación"
        },
        {
          "id": "09",
          "nombre": "Documento contable de liquidación"
        },
        {
          "id": "11",
          "nombre": "Facturas de exportación"
        },
        {
          "id": "14",
          "nombre": "Factura de sujeto excluido"
        },
        {
          "id": "15",
          "nombre": "Comprobante de donación"
        },
      ],
      tipoEstablecimientoList: [{
          "id": "01",
          "nombre": "Sucursal / Agencia"
        },
        {
          "id": "02",
          "nombre": "Casa matriz"
        },
        {
          "id": "04",
          "nombre": "Bodega"
        },
        {
          "id": "07",
          "nombre": "Predio y/o patio"
        },
        {
          "id": "20",
          "nombre": "Otro"
        },
      ],
    },
    methods: {
      getNumControl(j) {
        let v = JSON.parse(j)
        return (v.body.documento.identificacion.numeroControl) ? v.body.documento.identificacion.numeroControl : '-'
      },
      mensaje(mensaje, titulo) {
        this.$alert(mensaje, titulo, {
          dangerouslyUseHTMLString: true,
          center: true
        });
      },
      openPDF(d) {
        this.loading = true;
        info = JSON.parse(d.json_data);
        if (!info.body.documento) {
          this.no('no se encontro el JSON de la factura');
          return;
        }
        let r = [];
        r = info.body.documento;
        r.selloRecibido = info.body.selloRecibido
        switch (info.body.tipoDte) {
          case "01":
            this.getPDFConsumidor(r);
            break;
          case "03":
            this.getPDF(r);
            break;
          case "05":
            this.getNotaCredito(r);
            break;
          case "11":
            this.getPDFExporta(r);
            break;

          default:
            this.no('Tipo de documento no valido, comunicar al administrador: documento ' + info.body.tipoDte);
            this.loading = false;
            return;
            break;
        }

      },
      async generarBulk() {

        for (let f of this.seleccionados) {
          let info = JSON.parse(f.json_data);

          if (!info.body.documento) {
            this.no('No se encontró el JSON de la factura');
            return;
          }

          let r = info.body.documento;
          r.selloRecibido = info.body.selloRecibido;
          this.loading = true;
          // Espera a que se complete la función recorrer
          await this.getPDF(r, 'crear');
        }

        // Cuando todas las llamadas a recorrer se hayan completado
        this.loading = false;

      },
      imprimirAccion() {
        this.$confirm('Desea imprimir ' + this.seleccionados.length + ' documentos?', 'Impresiones', {
          confirmButtonText: 'Si',
          cancelButtonText: 'Cancelar',
          type: 'warning'
        }).then(() => {
          this.imprimirListado();
        }).catch(() => {

        });
      },
      async imprimirListado() {
        this.base64List = []
        for (let f of this.seleccionados) {
          let info = JSON.parse(f.json_data);

          if (!info.body.documento) {
            this.no('No se encontró el JSON de la factura');
            return;
          }

          let r = info.body.documento;
          r.selloRecibido = info.body.selloRecibido;
          this.loading = true;


          switch (info.body.tipoDte) {
            case "01":
              await this.getPDFConsumidor(r, 'b64');
              break;
            case "03":
              await this.getPDF(r, 'b64');
              break;
            case "05":
              await this.getNotaCredito(r, 'b64');
              break;
            case "11":
              await this.getPDFExporta(r, 'b64');
              break;
            default:
              this.no(info.body.codigoGeneracion + ' - Documento "' + info.body.tipoDte + '" no impreso, No se tiene formato');

              break;
          }



          // Espera a que se complete la función recorrer

        }

        if (this.base64List.length == 0) {
          setTimeout(() => {
            this.no('Sin registros por imprimir');
            this.loading = false;
          }, 500);
          return;
        }

        //console.log('termino de meterlas');


        try {
          //agrego printer

          let enviar = {
            "printer_name": this.impresorSelecionada,
            "documents": this.base64List
          }
          // Realiza la petición Axios para guardar el PDF
          //const response = await axios.post('https://sv.lacnetcorp.com/print_pdf/printpdf_base64_list', app.base64List);
          //const response = await axios.post('http://192.168.101.92:8000/printpdf_base64_list', app.base64List);
          //const response = await axios.post('http://192.168.101.92:8000/printpdf_base64_list', enviar);
          const response = await axios.post('https://sv.lacnetcorp.com/print_pdf/printpdf_base64_list', enviar);
          if (response.data.status == 'error') {
            app.no('No se pudo imprimir: ' + response.data.message)
          } else {
            app.si('Impresion enviada')
          }
        } catch (error) {
          app.no('No se pudo imprimir: ' + error.message)
          app.loading = false;
        }
        // Cuando todas las llamadas a recorrer se hayan completado
        this.loading = false;

      },
      resetSeleccion() {
        this.registros.forEach(d => {
          d.seleccionado = false;
        });
        this.toggle = !this.toggle
      },
      seleccionarTodo() {
        this.registros.forEach(d => {
          d.seleccionado = false;
        });

        this.registrosFiltrado.forEach(r => {
          let current = this.registros.find(f => f.cod_gen_dte == r.cod_gen_dte)
          current.seleccionado = this.toggle;
        });

        /*this.registros.forEach(d => {
          if (d.correo != null) {
            d.seleccionado = this.toggle;
          }
          //if (d.correo_enviado == 1) {
          //  d.seleccionado = false;
          //}
        });*/
        this.toggle = !this.toggle
      },
      guardarCorreo(d) {
        if (!this.correoCheck(d.correo_nuevo)) {
          return this.no("Correo invalido");
        }
        this.loading = true;
        axios.post('<?= route('correo.save') ?>', {
            id: d.id,
            correo: d.correo_nuevo,
          })
          .then(res => {
            app.loading = false;
            app.si(res.data.mensaje);
            app.getRegistros();

          })
          .catch(err => {
            console.error(err);
            app.loading = false;
          });

      },
      correoCheck(correo) {
        // Expresión regular para validar una dirección de correo electrónico
        const expresionRegular = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;

        // Usa test() para verificar si la cadena coincide con la expresión regular
        return expresionRegular.test(correo);
      },
      doSentEmail() {
        this.loading = true;
        axios.post('<?= route('enviar') ?>', {
            id: this.currentPorCorreo,
            para: this.correos.para,
            cc: this.correos.cc,
            bcc: this.correos.bcc,
          })
          .then(res => {
            app.loading = false;
            app.si('Enviado con exito');
          })
          .catch(err => {
            console.error(err);
            app.loading = false;
          });
      },
      modalCorreo(c) {
        this.currentPorCorreo = c;
        $('#modalEmail').modal();
      },
      modalEnviarCorreo(c) {

        $('#enviarCorreoModal').modal();
      },
      addPara() {
        if (this.para == '') {
          this.no("Ingrese el correo a agregar");
          return;
        }
        if (!this.para.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
          this.no("Ingrese correo valido");
          return;
        }
        this.correos.para.push(this.para.toLowerCase());
        this.para = '';
      },
      addCC() {
        if (this.cc == '') {
          this.no("Ingrese el correo a agregar");
          return;
        }
        if (!this.cc.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
          this.no("Ingrese correo valido");
          return;
        }
        this.correos.cc.push(this.cc.toLowerCase());
        this.cc = '';
      },
      addBCC() {
        if (this.bcc == '') {
          this.no("Ingrese el correo a agregar");
          return;
        }
        if (!this.bcc.match(/^[^\s@]+@[^\s@]+\.[^\s@]+$/)) {
          this.no("Ingrese correo valido");
          return;
        }
        this.correos.bcc.push(this.bcc.toLowerCase());
        this.bcc = '';
      },
      sincronizacion() {
        this.cvs = []
        if (this.paraSincronizar.length == 0) {
          this.no("No hay registros por sincronizar");
          return;
        }
        this.cvs = this.paraSincronizar.map(r => {
          return {
            "codigo_dte": r.CAMPO1
          }
        })
        this.cargarDatos()
      },
      cargarDatos() {
        if (this.cvs.length == 0) {
          this.no("No hay registros para subir")
          return;
        }



        const batchSize = 10; // Tamaño del lote
        const totalRecords = app.cvs.length;
        let batchesProcessed = 0;

        for (let i = 0; i < totalRecords; i += batchSize) {
          const batch = app.cvs.slice(i, i + batchSize);
          this.loading = true;

          axios.post('<?= route('subir.cvs') ?>', {
              datos: batch,
              modelo: this.tipoModelo,
              fecha: dayjs(this.fecha).format('YYYY-MM-DD'),
            })
            .then(res => {
              app.si("Cargados " + i + " de " + totalRecords);
              this.textoCarga = "Cargados " + i + " de " + totalRecords;

              if (res.data.length > 0) {
                app.mensaje('<h4>Los documentos no procesados son los siguientes:</h4><br><ul>' + (res.data.map(r => ('<li>' + r + '</li>')).join('')) + '</ul><br><h5>Verificar si son documentos validos</h5>', res.data.length + ' documentos no fueron procesados')
              }
              batchesProcessed++;
              if (batchesProcessed === Math.ceil(totalRecords / batchSize)) {
                // Este es el último lote
                this.getRegistros();
                $('#cvsModal').modal('hide')
                this.si('Cargados todos con exito');
                this.textoCarga = 'Procesando...';
                //this.loading = false;
                // Puedes realizar acciones adicionales aquí
              }
            })
            .catch(err => {
              console.error(err);
              this.loading = false;
              app.no(err)
              return;
            });
        }

        /*axios.post('<?= route('subir.cvs') ?>', {
            datos: app.cvs,
            fecha: dayjs(this.fecha).format('YYYY-MM-DD'),
          })
          .then(res => {
            //app.loading = false;
            app.getRegistros();
            $('#cvsModal').modal('hide')
            app.si('Cargados con exito');
            if (res.data.length > 0) {
              app.mensaje('<h4>Los documentos no procesados son los siguientes:</h4><br><ul>' + (res.data.map(r => ('<li>' + r + '</li>')).join('')) + '</ul><br><h5>Verificar si son documentos validos</h5>', res.data.length + ' documentos no fueron procesados')
            }

          })
          .catch(err => {
            console.error(err);
            app.loading = false;
          });*/

      },
      openCvs() {
        this.cvs = []
        $('#cvsModal').modal()
      },
      obtenerCcliente(c, p) {
        let v = ''
        if (c == '2000000057') {
          //let existe = this.ccliente.find(r=>r.MATNR==p)
          let existe = this.custom_desc.find(r => r.codigo_sap == p)
          if (existe) {
            v = existe.registro
          }
        }
        return v
      },

      async getRegistros() {
        if (!this.fecha) {
          this.no('Seleccione una fecha valida');
          return;
        }

        this.loading = true;
        await this.getSupermercados()
        this.loading = true;

        axios.post('<?= route('get.registros') ?>', {
            fecha: dayjs(this.fecha).format('YYYY-MM-DD'),
            //fechas_fin: dayjs(this.fechas[1]).format('YYYY-MM-DD'),
          })
          .then(res => {
            res.data.forEach(r => {
              r.correo_nuevo = '';
              r.seleccionado = false;
              try {
                r.gestion = (app.getSupermercado(r.cod_gen_dte).BZIRK) ? this.getSupermercado(r.cod_gen_dte).BZIRK : '';
              } catch (error) {
                console.log(error);
              }
            });
            app.registros = res.data;
            this.loading = false;
            //console.log(res)
          })
          .catch(err => {
            this.loading = false;
            app.no(err)
            //console.error(err);
          });
      },



      conversorLineaPDF(d) {
        let data = d.cuerpoDocumento;
        // Agrupar por el campo 'codigo' y realizar las sumas
        let groupedData = data.reduce((result, current) => {
          let existingItem = result.find(item => item.codigo === current.codigo);

          if (existingItem) {
            // Si ya existe el código, sumar los valores
            existingItem.cantidad += current.cantidad;
            existingItem.ventaNoSuj += current.ventaNoSuj;
            existingItem.ventaExenta += current.ventaExenta;
            existingItem.ventaGravada += current.ventaGravada;
          } else {
            // Si no existe, agregar el elemento al resultado
            result.push({
              'codigo': current.codigo,
              'cantidad': current.cantidad,
              'uniMedida': current.uniMedida,
              'descripcion': current.descripcion,
              'precioUni': current.precioUni,
              'montoDescu': current.montoDescu,
              'psv': current.psv,
              'ventaNoSuj': current.ventaNoSuj,
              'ventaExenta': current.ventaExenta,
              'ventaGravada': current.ventaGravada
            });
          }

          return result;
        }, []);

        // Recalcular el campo 'numItem'
        let numItemCounter = 1;
        groupedData.forEach(item => {
          item.numItem = numItemCounter++;
        });
        data = groupedData;


        let enviar = [];
        let ejecutado = false;


        data.forEach((r, k) => {

          if (data.length > 21 && data.length <= 38) {
            if ((data.length - 1) == k)
              enviar.push([{
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '****CONTINUA EN LA SIGUIENTE PÁGINA****',
                fontSize: 6,
                bold: true,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                pageBreak: 'before',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, ]);
          }
          if (data.length > 79) {
            if ((data.length - 1) == k)
              enviar.push([{
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '****CONTINUA EN LA SIGUIENTE PÁGINA****',
                fontSize: 6,
                bold: true,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                pageBreak: 'before',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, ]);
          }

          enviar.push([{
              text: r.numItem,
              fontSize: 7,
              border: [0, 0, 0, 0],
            },
            {
              text: r.cantidad,
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
            {
              text: this.getUnidad(r.uniMedida),
              fontSize: 7,
              border: [0, 0, 0, 0],
            },
            {
              text: r.codigo,
              fontSize: 6,
              border: [0, 0, 0, 0],
            },
            {
              text: this.getCodigoBarra(r.codigo),
              fontSize: 6,
              border: [0, 0, 0, 0],
            },
            {
              text: r.descripcion,
              fontSize: 6,
              border: [0, 0, 0, 0],
            },
            {
              text: this.numberFormat(r.precioUni),
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
            {
              text: this.numberFormat(r.montoDescu),
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
            {
              text: this.numberFormat(r.psv),
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
            {
              text: this.numberFormat(r.ventaNoSuj),
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
            {
              text: this.numberFormat(r.ventaExenta),
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
            {
              text: this.numberFormat(r.ventaGravada),
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
          ])
        });
        return enviar;



      },
      conversorLineaExportaPDF(d) {
        let data = d.cuerpoDocumento;
        // Agrupar por el campo 'codigo' y realizar las sumas
        let groupedData = data.reduce((result, current) => {
          let existingItem = result.find(item => item.codigo === current.codigo);

          if (existingItem) {
            // Si ya existe el código, sumar los valores
            existingItem.cantidad += current.cantidad;
            existingItem.ventaNoSuj += current.ventaNoSuj;
            existingItem.ventaExenta += current.ventaExenta;
            existingItem.ventaGravada += current.ventaGravada;
          } else {
            // Si no existe, agregar el elemento al resultado
            result.push({
              'codigo': current.codigo,
              'cantidad': current.cantidad,
              'uniMedida': current.uniMedida,
              'descripcion': current.descripcion,
              'precioUni': current.precioUni,
              'montoDescu': current.montoDescu,
              'psv': current.psv,
              'ventaNoSuj': current.ventaNoSuj,
              'ventaExenta': current.ventaExenta,
              'ventaGravada': current.ventaGravada
            });
          }

          return result;
        }, []);

        // Recalcular el campo 'numItem'
        let numItemCounter = 1;
        groupedData.forEach(item => {
          item.numItem = numItemCounter++;
        });
        data = groupedData;
        let enviar = [];
        let ejecutado = false;

        data.forEach((r, k) => {

          if (data.length > 16 && data.length <= 41) {
            if ((data.length - 1) == k)
              enviar.push([{
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '****CONTINUA EN LA SIGUIENTE PÁGINA****',
                fontSize: 6,
                bold: true,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                pageBreak: 'before',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, ]);
          }
          if (data.length > 75) {
            if ((data.length - 1) == k)
              enviar.push([{
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '****CONTINUA EN LA SIGUIENTE PÁGINA****',
                fontSize: 6,
                bold: true,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                pageBreak: 'before',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, ]);
          }

          enviar.push([{
              text: r.numItem,
              fontSize: 7,
              border: [0, 0, 0, 0],
            },
            {
              text: r.cantidad,
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
            {
              text: this.getUnidad(r.uniMedida),
              fontSize: 7,
              border: [0, 0, 0, 0],
            },
            {
              text: r.codigo,
              fontSize: 6,
              border: [0, 0, 0, 0],
            },
            {
              text: this.getCodigoBarra(r.codigo) + '   ' + this.obtenerCcliente(this.getSupermercado(d.identificacion.codigoGeneracion).KUNNR, r.codigo),
              fontSize: 6,
              border: [0, 0, 0, 0],
            },
            {
              text: (this.custom_desc.find(q => q.codigo_sap == r.codigo) && (d.receptor.nombrePais == 'NICARAGUA')) ? this.custom_desc.find(q => q.codigo_sap == r.codigo).descripcion : r.descripcion,
              fontSize: 6,
              border: [0, 0, 0, 0],
            },
            {
              text: this.numberFormat(r.precioUni, 4),
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
            {
              text: this.numberFormat(r.montoDescu),
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },

            {
              text: this.numberFormat(r.ventaGravada),
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
          ])
        });
        return enviar;



      },
      conversorLineaNotaCredito(d) {
        let data = d.cuerpoDocumento;
        // Agrupar por el campo 'codigo' y realizar las sumas
        let groupedData = data.reduce((result, current) => {
          let existingItem = result.find(item => item.codigo === current.codigo);

          if (existingItem) {
            // Si ya existe el código, sumar los valores
            existingItem.cantidad += current.cantidad;
            existingItem.ventaNoSuj += current.ventaNoSuj;
            existingItem.ventaExenta += current.ventaExenta;
            existingItem.ventaGravada += current.ventaGravada;
          } else {
            // Si no existe, agregar el elemento al resultado
            result.push({
              'codigo': current.codigo,
              'cantidad': current.cantidad,
              'uniMedida': current.uniMedida,
              'descripcion': current.descripcion,
              'precioUni': current.precioUni,
              'montoDescu': current.montoDescu,
              'ventaNoSuj': current.ventaNoSuj,
              'ventaExenta': current.ventaExenta,
              'ventaGravada': current.ventaGravada
            });
          }

          return result;
        }, []);

        // Recalcular el campo 'numItem'
        let numItemCounter = 1;
        groupedData.forEach(item => {
          item.numItem = numItemCounter++;
        });
        data = groupedData;
        let enviar = [];
        let ejecutado = false;

        data.forEach((r, k) => {

          if (data.length > 16 && data.length <= 41) {
            if ((data.length - 1) == k)
              enviar.push([{
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '****CONTINUA EN LA SIGUIENTE PÁGINA****',
                fontSize: 6,
                bold: true,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                pageBreak: 'before',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, ]);
          }
          if (data.length > 75) {
            if ((data.length - 1) == k)
              enviar.push([{
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '****CONTINUA EN LA SIGUIENTE PÁGINA****',
                fontSize: 6,
                bold: true,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, {
                text: '',
                pageBreak: 'before',
                fontSize: 5,
                border: [0, 0, 0, 0],
              }, ]);
          }

          enviar.push([{
              text: r.numItem,
              fontSize: 7,
              border: [0, 0, 0, 0],
            },
            {
              text: r.cantidad,
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
            {
              text: this.getUnidad(r.uniMedida),
              fontSize: 7,
              border: [0, 0, 0, 0],
            },
            {
              text: r.codigo,
              fontSize: 6,
              border: [0, 0, 0, 0],
            },
            {
              text: this.getCodigoBarra(r.codigo),
              fontSize: 6,
              border: [0, 0, 0, 0],
            },
            {
              text: r.descripcion,
              fontSize: 6,
              border: [0, 0, 0, 0],
            },
            {
              text: this.numberFormat(r.precioUni),
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
            {
              text: this.numberFormat(r.montoDescu),
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
            {
              text: this.numberFormat(r.ventaNoSuj),
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
            {
              text: this.numberFormat(r.ventaExenta),
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
            {
              text: this.numberFormat(r.ventaGravada),
              fontSize: 7,
              border: [0, 0, 0, 0],
              alignment: 'right',
            },
          ])
        });
        return enviar;



      },


      async getPDF(elemento, acion = '') {

        //const qr = await this.getCodigoQR(elemento.identificacion.codigoGeneracion, elemento.identificacion.fecEmi);

        let urlQr = 'https://admin.factura.gob.sv/consultaPublica?ambiente=01&codGen=' + elemento.identificacion.codigoGeneracion + '&fechaEmi=' + elemento.identificacion.fecEmi
        const qr = generarQR(urlQr)

        let mensajeEspecial = ''
        mensajeEspecial = '***formato particular, para ver el oficial consulte el QR***';
        let old = false
        if (dayjs(elemento.identificacion.fecEmi).isBefore(dayjs('2023-10-14'))) {
          old = true
        }

        const customColors = {
          customOrange: '#ff4b00',
          //customOrange: '#ff9a00',
          customRed: '#FF0000',
          customRed: '#FFFFFF',
        };

        let tabla_head = {
          table: {
            layout: 'noBorders',
            widths: [140, '*', 60, 70],
            body: [
              [{
                  image: logo,
                  width: 200,
                  alignment: 'center',
                  border: [false, false, false, false],
                  style: 'imagenConMargen',
                },
                {
                  stack: [{
                      text: "DOCUMENTO TRIBUTARIO ELECTRÓNICO",
                      alignment: 'center',
                      fontSize: 10,
                      style: 'customMargin',
                    },
                    {
                      text: "COMPROBANTE DE CRÉDITO FISCAL",
                      alignment: 'center',
                      fontSize: 10
                    },
                  ],
                  border: [false, false, false, false]
                },
                {
                  image: qr,
                  width: 55,
                  alignment: 'center',
                  border: [false, false, false, false]
                },
                {
                  stack: [{
                      alignment: 'right',
                      border: [false, false, false, false],
                      text: '\n' + app.getSupermercado(elemento.identificacion.codigoGeneracion).BZIRK,
                      fontSize: 12
                    },
                    {
                      alignment: 'right',
                      border: [false, false, false, false],
                      text: app.ocValidacion(elemento),
                      fontSize: 6
                    },

                  ],
                  border: [false, false, false, false]
                },

              ]
            ],

          }, //fin tabla
        }; //fin bracket tabla

        let losDetalles = {
          table: {
            layout: 'noBorders',

            widths: [250, '*'],
            body: [
              [{
                  stack: [{
                      text: [{
                          text: 'Código de Generación: ',
                          bold: true,
                          fontSize: 6
                        },

                        {
                          text: elemento.identificacion.codigoGeneracion,
                          fontSize: 6
                        },

                      ],
                    },

                    {
                      text: [{
                          text: 'Número de Control : ',
                          bold: true,
                          fontSize: 6
                        },

                        {
                          text: elemento.identificacion.numeroControl,
                          fontSize: 6
                        },

                      ],
                    },

                    {
                      text: [{
                          text: 'Sello de Recepción: ',
                          bold: true,
                          fontSize: 6
                        },

                        {
                          text: app.getSupermercado(elemento.identificacion.codigoGeneracion).CAMPO2,
                          fontSize: 6
                        },

                      ],
                    },


                  ],
                  border: [false, false, false, false]
                },
                {
                  stack: [{
                      text: [{
                          text: 'Modelo de Facturación: ',
                          bold: true,
                          fontSize: 6,
                          alignment: 'right',
                        },

                        {
                          text: elemento.identificacion.tipoModelo,
                          fontSize: 6,
                          alignment: 'right',

                        },

                      ],
                    },

                    {
                      text: [{
                          text: 'Tipo de Transmisión:',
                          bold: true,
                          fontSize: 6,
                          alignment: 'right',
                        },

                        {
                          text: elemento.identificacion.tipoOperacion,
                          fontSize: 6,
                          alignment: 'right',
                        },

                      ],
                    },

                    {
                      text: [{
                          text: 'Fecha y Hora de Generación: ',
                          bold: true,
                          fontSize: 6,
                          alignment: 'right',
                        },

                        {
                          text: elemento.identificacion.fecEmi + ' ' + elemento.identificacion.horEmi,
                          fontSize: 6,
                          alignment: 'right',
                        },

                      ],
                    },


                  ],
                  border: [false, false, false, false]
                },

              ]
            ],

          }
        };



        var dd = {
          pageSize: 'letter',
          /*background: [{
            image: logo_trasparente,
            fit: [595.28, 841.89],
            margin: [0, 240, 0, 0]
          }, ],*/
          header: function(currentPage, pageCount, pageSize) {
            // you can apply any logic and return any valid pdfmake element

            let texto = {
              text: ''
            };
            if (currentPage === 1) {
              return {
                stack: [texto]
              }
            } else {
              return {
                stack: [
                  losDetalles,
                ],
                margin: [30, 10, 20, 30],
              }
            }

          },
          footer: function(currentPage, pageCount) {
            return {
              text: `Página ${currentPage} de ${pageCount} - ${elemento.identificacion.numeroControl}`,
              fontSize: 7,
              alignment: 'center', // Alinea el texto al centro
            };
          },
          pageMargins: [30, 40, 20, 45],
          styles: {
            customMargin: {
              margin: [0, 12, 0, 0], // [izquierda, derecha] márgenes horizontalmente
            },
            imagenConMargen: {
              margin: [0, 0, 0, 0], // [margen izquierdo, margen superior]
            },
          },
          content: [
            {text:'',margin: [0, -32, 0, 0]},
            tabla_head,
            linea(),
            losDetalles,
            {
              text: mensajeEspecial,
              fontSize: 4,
            },
            {
              table: {
                widths: ['49%', '2%', '49%'], // Definimos dos columnas con igual ancho
                body: [
                  [{
                      stack: [{
                          text: 'Emisor',
                          alignment: 'center',
                          bold: true,
                        },
                        {
                          text: [{
                            text: 'Nombre o Razón social: ',
                            bold: true
                          }, elemento.emisor.nombre]
                        },
                        {
                          text: [{
                            text: 'NIT: ',
                            bold: true
                          }, elemento.emisor.nit]
                        },
                        {
                          text: [{
                            text: 'NRC: ',
                            bold: true
                          }, elemento.emisor.nrc]
                        },
                        {
                          text: [{
                            text: 'Actividad Economica: ',
                            bold: true
                          }, elemento.emisor.descActividad]
                        },
                        {
                          text: [{
                            text: 'Direccion:  ',
                            bold: true
                          }, elemento.emisor.direccion.complemento]
                        },
                        {


                          text: this.getDepartamento(elemento.emisor.direccion.departamento).toUpperCase() + ' - ' + this.getMunicipio(elemento.emisor.direccion.departamento, elemento.emisor.direccion.municipio).toUpperCase()
                        },
                        {
                          text: [{
                            text: 'Numero de teléfono: ',
                            bold: true
                          }, elemento.emisor.telefono]
                        },
                        {
                          text: [{
                            text: 'Correo electrónico: ',
                            bold: true
                          }, elemento.emisor.correo]
                        },
                        {
                          text: [{
                            text: 'Nombre Comercial: ',
                            bold: true
                          }, elemento.emisor.nombreComercial]
                        },
                        {
                          text: [{
                            text: 'Tipo Establecimiento: ',
                            bold: true
                          }, this.getTipoEstablecimiento(elemento.emisor.tipoEstablecimiento)]
                        },

                      ],
                      fontSize: 6,
                      border: [true, true, true, true], // Borde en los cuatro lados
                      margin: [5, 5], // Márgenes para separación y espacio interno
                    },
                    {
                      text: '',
                      border: [0, 0, 0, 0],
                    },
                    {
                      stack: [{
                          text: 'Receptor',
                          alignment: 'center',
                          bold: true,
                        },
                        {
                          text: [{
                            text: 'Nombre o razón social: ',
                            bold: true
                          }, elemento.receptor.nombre + ' ( ' + this.getSupermercado(elemento.identificacion.codigoGeneracion).KUNNR + ' )']
                        },
                        {
                          text: [{
                            text: 'Nombre comercial: ',
                            bold: true
                          }, this.getSupermercado(elemento.identificacion.codigoGeneracion).NAME2]
                        },
                        {
                          text: [{
                            text: 'NIT: ',
                            bold: true
                          }, elemento.receptor.nit]
                        },
                        {
                          text: [{
                            text: 'NRC: ',
                            bold: true
                          }, elemento.receptor.nrc]
                        },
                        {
                          text: [{
                            text: 'Actividad económica: ',
                            bold: true
                          }, elemento.receptor.descActividad]
                        },
                        {
                          text: [{
                            text: 'Dirección: ',
                            bold: true
                          }, elemento.receptor.direccion.complemento]
                        },
                        {
                          text: this.getDepartamento(elemento.receptor.direccion.departamento) + ' ' + this.getMunicipio(elemento.receptor.direccion.municipio)
                        },
                        {
                          text: [{
                            text: 'Correo electrónico: ',
                            bold: true
                          }, elemento.receptor.correo]
                        },
                        {
                          text: [{
                            text: 'Teléfono: ',
                            bold: true
                          }, elemento.receptor.telefono]
                        },

                      ],
                      fontSize: 6,
                      border: [true, true, true, true], // Borde en los cuatro lados
                      margin: [5, 5], // Márgenes para separación y espacio interno
                    },
                  ],
                ],
              },
            },

            {
              text: '\n'
            },


            {
              table: {
                headerRows: 1,
                widths: ['2%', '4%', '4%', '5%', '11%', '38%', '7%', '4%', '7%', '6%', '6%', '7%'],
                body: [
                  [{
                      text: 'N°',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Cnt.',
                      bold: true,
                      alignment: 'right',
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Und.',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Cod.p',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Cod.b',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Descripción',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Precio Unitario',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Dtos',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Montos no afectados',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 6,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Vtas no sujetas',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Vtas Exentas',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Vtas Gravadas',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                  ],
                  ...this.conversorLineaPDF(elemento),


                ]
              }
            }, //fin tabla detalle

            {
              table: {
                widths: ['50%', '35%', '16%'],
                body: [
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Suma de Ventas:',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.subTotalVentas),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 1, 1, 0],
                    },

                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Suma Total de Operaciones:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.totalGravada),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },

                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Monto global Desc., Rebajas y otros a ventas no sujetas:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.totalNoSuj),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Monto global Desc., Rebajas y otros a ventas Exentas:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.totalExenta),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Monto global Desc., Rebajas y otros a ventas gravadas:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.totalNoGravado),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Impuesto al Valor Agregado 13%:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      //text: (elemento.resumen.tributos.find(r => r.codigo == '20')) ? elemento.resumen.tributos.find(r => r.codigo == '20').valor : 0,
                      text: (old) ? this.numberFormat(parseFloat(elemento.resumen.subTotal) * 0.13) : ((elemento.resumen.tributos.find(r => r.codigo == '20')) ? elemento.resumen.tributos.find(r => r.codigo == '20').valor : 0),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Sub-Total:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.subTotal),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'IVA Percibido:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.ivaPerci1),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'IVA Retenido:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.ivaRete1),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Retención Renta:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.reteRenta),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Monto Total de la Operación:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      //text: this.numberFormat(elemento.resumen.montoTotalOperacion),
                      text: (old) ? this.numberFormat(parseFloat(elemento.resumen.subTotal) * 1.13) : this.numberFormat(elemento.resumen.montoTotalOperacion),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Total Otros montos no afectos:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(0),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Total a Pagar:',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },

                    {
                      //text: '$ ' + this.numberFormat(elemento.resumen.totalPagar),
                      text: (old) ? this.numberFormat(parseFloat(elemento.resumen.subTotal) * 1.13) : '$ ' + this.numberFormat(elemento.resumen.totalPagar),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 1],
                    },
                  ],
                ]
              } //fin tabla resumen abajo
            },
            {
              text: "\n"
            },
            {
              table: {
                widths: ['15%', '35%', '25%', '26%'],
                body: [
                  [{
                      text: 'Valor en letras: ',
                      fontSize: 7,
                      border: [1, 1, 0, 0],
                    }, {
                      text: (old) ? this.numeroALetras(parseFloat(elemento.resumen.subTotal) * 1.13) : elemento.resumen.totalLetras,
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: 'Condición de la Operación: ',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: (elemento.resumen.condicionOperacion == 2) ? 'Crédito' : 'Contado',
                      fontSize: 7,
                      border: [0, 1, 1, 0],
                    }
                  ],
                  [{
                      text: 'Observaciones: ',
                      fontSize: 7,
                      border: [1, 0, 0, 1],
                    }, {
                      text: '',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: 'Documento ERP: ',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: this.getSupermercado(elemento.identificacion.codigoGeneracion).VBELN,
                      fontSize: 7,
                      border: [0, 0, 1, 1],
                    }
                  ],
                ]
              }
            },
            /*{
              text: '\n'
            },
            {
              table: {
                widths: ['15%', '35%', '25%', '26%'],
                body: [
                  [{
                      text: 'Responsable por: ',
                      fontSize: 7,
                      border: [1, 1, 0, 0],
                    }, {
                      text: '',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: 'Nro. de Documento: ',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: '',
                      fontSize: 7,
                      border: [0, 1, 1, 0],
                    }
                  ],
                  [{
                      text: 'Responsable por: ',
                      fontSize: 7,
                      border: [1, 0, 0, 1],
                    }, {
                      text: '',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: 'Nro. de Documento: ',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: '',
                      fontSize: 7,
                      border: [0, 0, 1, 1],
                    }
                  ],
                ]
              }
            },*/



          ],
        };


        let q = pdfMake.createPdf(dd);
        if (acion == 'b64') {

          const data = await new Promise((resolve, reject) => {
            q.getBase64((pdfData) => {

              let cantidadAImprimir = 1;
              if (this.cantidadImpresion == 1) {
                if (elemento.receptor.nombre.toUpperCase().includes("CALLEJA")) {
                  //cantidadAImprimir = 2;
                  cantidadAImprimir = 1;
                } else if (elemento.receptor.nombre.toUpperCase().includes("OPERADORA")) {
                  cantidadAImprimir = 3;
                } else {
                  cantidadAImprimir = (elemento.resumen.condicionOperacion == 2) ? 2 : 1
                }
              } else {
                cantidadAImprimir = this.cantidadImpresion;
              }
              app.base64List.push({
                "document": pdfData,
                "printing_type": (elemento.receptor.nombre.toUpperCase().includes("CALLEJA")) ? 'double' : 'single',
                "copies": cantidadAImprimir,
                "cod": elemento.identificacion.codigoGeneracion,
              });
              resolve(pdfData);
            }, (error) => {
              reject(error);
            });


          });
        } else if (acion == 'crear') {
          //lo manda a php para hacer el fisico en el server

          const data = await new Promise((resolve, reject) => {
            q.getBase64((pdfData) => {
              resolve(pdfData);
            }, (error) => {
              reject(error);
            });
          });

          try {
            // Realiza la petición Axios para guardar el PDF
            const response = await axios.post('<?= route('conversor') ?>', {
              elpdf: data,
              id: 'cc-' + elemento.identificacion.codigoGeneracion
            });
            console.log(response);
          } catch (error) {
            console.error(error);
            app.loading = false;
          }

        } else {
          this.loading = false;
          //abre el pdf
          q.open();
        }



      },

      async getPDFConsumidor(elemento, acion = '') {

        //const qr = await this.getCodigoQR(elemento.identificacion.codigoGeneracion, elemento.identificacion.fecEmi);

        let urlQr = 'https://admin.factura.gob.sv/consultaPublica?ambiente=01&codGen=' + elemento.identificacion.codigoGeneracion + '&fechaEmi=' + elemento.identificacion.fecEmi
        const qr = generarQR(urlQr)

        let mensajeEspecial = ''
        mensajeEspecial = '***formato particular, para ver el oficial consulte el QR***';
        let old = false
        if (dayjs(elemento.identificacion.fecEmi).isBefore(dayjs('2023-10-14'))) {
          old = true
        }

        let documentosRel = [{
          text: ''
        }]
        if (elemento.documentoRelacionado) {
          documentosRel = [{
              text: 'Documentos Relacionados',
              alignment: 'center',
              fontSize: 7,
            },
            {
              table: {
                headerRows: 1,
                widths: ['33%', '33%', '35%'],
                body: [
                  [{
                      text: 'Tipo de Documento',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'N° de Documento',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Fecha de Documento',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                  ],

                  ...elemento.documentoRelacionado.map(r => {
                    return [{
                        text: this.getTipoDocumento(r.tipoDocumento),
                        fontSize: 7,
                        border: [0, 0, 0, 0],
                      },
                      {
                        text: r.numeroDocumento,
                        fontSize: 7,
                        border: [0, 0, 0, 0],
                      },
                      {
                        text: r.fechaEmision,
                        fontSize: 7,
                        border: [0, 0, 0, 0],
                      },
                    ]
                  })


                ],
              }
            },
          ]
        }



        const customColors = {
          customOrange: '#ff4b00',
          //customOrange: '#ff9a00',
          customRed: '#FF0000',
          customRed: '#FFFFFF',
        };


        var dd = {
          pageSize: 'letter',
          /*background: [{
            image: logo_trasparente,
            fit: [595.28, 841.89],
            margin: [0, 240, 0, 0]
          }, ],*/
          footer: function(currentPage, pageCount) {
            return {
              text: `Página ${currentPage} de ${pageCount} - ${elemento.identificacion.numeroControl}`,
              fontSize: 7,
              alignment: 'center', // Alinea el texto al centro
            };
          },
          pageMargins: [30, 9, 20, 45],
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
                widths: [150, '*', 70, 50],
                body: [
                  [{
                      image: logo,
                      width: 220,
                      alignment: 'center',
                      border: [false, false, false, false],
                      style: 'imagenConMargen',
                    },
                    {
                      stack: [{
                          text: "DOCUMENTO TRIBUTARIO ELECTRÓNICO",
                          alignment: 'center',
                          fontSize: 10,
                          style: 'customMargin',
                        },
                        {
                          text: "FACTURA",
                          alignment: 'center',
                          fontSize: 10
                        },
                      ],
                      border: [false, false, false, false]
                    },
                    {
                      image: qr,
                      width: 55,
                      alignment: 'center',
                      border: [false, false, false, false]
                    },
                    {
                      alignment: 'right',
                      border: [false, false, false, false],
                      text: '\n' + this.getSupermercado(elemento.identificacion.codigoGeneracion).BZIRK,
                      fontSize: 12
                    },

                  ]
                ]

              }, //fin tabla
            }, //fin bracket tabla
            linea(),

            {
              table: {
                layout: 'noBorders',

                widths: [250, '*'],
                body: [
                  [{
                      stack: [{
                          text: [{
                              text: 'Código de Generación: ',
                              bold: true,
                              fontSize: 6
                            },

                            {
                              text: elemento.identificacion.codigoGeneracion,
                              fontSize: 6
                            },

                          ],
                        },

                        {
                          text: [{
                              text: 'Número de Control : ',
                              bold: true,
                              fontSize: 6
                            },

                            {
                              text: elemento.identificacion.numeroControl,
                              fontSize: 6
                            },

                          ],
                        },

                        {
                          text: [{
                              text: 'Sello de Recepción: ',
                              bold: true,
                              fontSize: 6
                            },

                            {
                              text: this.getSupermercado(elemento.identificacion.codigoGeneracion).CAMPO2,
                              fontSize: 6
                            },

                          ],
                        },


                      ],
                      border: [false, false, false, false]
                    },
                    {
                      stack: [{
                          text: [{
                              text: 'Modelo de Facturación: ',
                              bold: true,
                              fontSize: 6,
                              alignment: 'right',
                            },

                            {
                              text: elemento.identificacion.tipoModelo,
                              fontSize: 6,
                              alignment: 'right',

                            },

                          ],
                        },

                        {
                          text: [{
                              text: 'Tipo de Transmisión:',
                              bold: true,
                              fontSize: 6,
                              alignment: 'right',
                            },

                            {
                              text: elemento.identificacion.tipoOperacion,
                              fontSize: 6,
                              alignment: 'right',
                            },

                          ],
                        },

                        {
                          text: [{
                              text: 'Fecha y Hora de Generación: ',
                              bold: true,
                              fontSize: 6,
                              alignment: 'right',
                            },

                            {
                              text: elemento.identificacion.fecEmi + ' ' + elemento.identificacion.horEmi,
                              fontSize: 6,
                              alignment: 'right',
                            },

                          ],
                        },


                      ],
                      border: [false, false, false, false]
                    },

                  ]
                ],

              }
            },
            {
              text: mensajeEspecial,
              fontSize: 4
            },
            {
              table: {
                widths: ['49%', '2%', '49%'], // Definimos dos columnas con igual ancho
                body: [
                  [{
                      stack: [{
                          text: 'Emisor',
                          alignment: 'center',
                          bold: true,
                        },
                        {
                          text: [{
                            text: 'Nombre o Razón social: ',
                            bold: true
                          }, elemento.emisor.nombre]
                        },
                        {
                          text: [{
                            text: 'NIT: ',
                            bold: true
                          }, elemento.emisor.nit]
                        },
                        {
                          text: [{
                            text: 'NRC: ',
                            bold: true
                          }, elemento.emisor.nrc]
                        },
                        {
                          text: [{
                            text: 'Actividad Economica: ',
                            bold: true
                          }, elemento.emisor.descActividad]
                        },
                        {
                          text: [{
                            text: 'Direccion:  ',
                            bold: true
                          }, elemento.emisor.direccion.complemento]
                        },
                        {


                          text: this.getDepartamento(elemento.emisor.direccion.departamento).toUpperCase() + ' - ' + this.getMunicipio(elemento.emisor.direccion.departamento, elemento.emisor.direccion.municipio).toUpperCase()
                        },
                        {
                          text: [{
                            text: 'Numero de teléfono: ',
                            bold: true
                          }, elemento.emisor.telefono]
                        },
                        {
                          text: [{
                            text: 'Correo electrónico: ',
                            bold: true
                          }, elemento.emisor.correo]
                        },
                        {
                          text: [{
                            text: 'Nombre Comercial: ',
                            bold: true
                          }, elemento.emisor.nombreComercial]
                        },
                        {
                          text: [{
                            text: 'Tipo Establecimiento: ',
                            bold: true
                          }, this.getTipoEstablecimiento(elemento.emisor.tipoEstablecimiento)]
                        },

                      ],
                      fontSize: 6,
                      border: [true, true, true, true], // Borde en los cuatro lados
                      margin: [5, 5], // Márgenes para separación y espacio interno
                    },
                    {
                      text: '',
                      border: [0, 0, 0, 0],
                    },
                    {
                      stack: [{
                          text: 'Receptor',
                          alignment: 'center',
                          bold: true,
                        },
                        {
                          text: [{
                            text: 'Nombre o razón social: ',
                            bold: true
                          }, elemento.receptor.nombre + ' ( ' + this.getSupermercado(elemento.identificacion.codigoGeneracion).KUNNR + ' )']
                        },
                        {
                          text: [{
                            text: 'Nombre comercial: ',
                            bold: true
                          }, this.getSupermercado(elemento.identificacion.codigoGeneracion).NAME2]
                        },

                        {
                          text: [{
                            text: 'Otro: ',
                            bold: true
                          }, elemento.receptor.numDocumento]
                        },
                        {
                          text: [{
                            text: 'Correo electrónico: ',
                            bold: true
                          }, elemento.receptor.correo]
                        },
                        {
                          text: [{
                            text: 'Dirección: ',
                            bold: true
                          }, elemento.receptor.direccion.complemento]
                        },
                        {
                          text: this.getDepartamento(elemento.receptor.direccion.departamento) + ' ' + this.getMunicipio(elemento.receptor.direccion.municipio)
                        },
                        {
                          text: [{
                            text: 'Teléfono: ',
                            bold: true
                          }, elemento.receptor.telefono]
                        },

                      ],
                      fontSize: 6,
                      border: [true, true, true, true], // Borde en los cuatro lados
                      margin: [5, 5], // Márgenes para separación y espacio interno
                    },
                  ],
                ],
              },
            },

            {
              text: '\n'
            },

            ...documentosRel,
            {
              table: {
                headerRows: 1,
                widths: ['2%', '4%', '4%', '5%', '11%', '38%', '7%', '4%', '7%', '6%', '6%', '7%'],
                body: [
                  [{
                      text: 'N°',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Cnt.',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Und.',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Cod.p',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Cod.b',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Descripción',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Precio Unitario',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Dtos',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Montos no afectados',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 6,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Vtas no sujetas',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Vtas Exentas',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Vtas Gravadas',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                  ],
                  ...this.conversorLineaPDF(elemento),


                ]
              }
            }, //fin tabla detalle

            {
              table: {
                widths: ['50%', '35%', '16%'],
                body: [
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Suma de Ventas:',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.subTotalVentas),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 1, 1, 0],
                    },

                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Sumatoria de ventas:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.totalGravada),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },

                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Monto global Desc., Rebajas y otros a ventas no sujetas:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.totalNoSuj),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Monto global Desc., Rebajas y otros a ventas Exentas:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.totalExenta),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Monto global Desc., Rebajas y otros a ventas gravadas:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.descuGravada),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Sub-Total:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.subTotal),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'IVA Retenido: ',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      //text: (elemento.resumen.tributos.find(r => r.codigo == '20')) ? elemento.resumen.tributos.find(r => r.codigo == '20').valor : 0,
                      text: this.numberFormat(elemento.resumen.ivaRete1),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Retención Renta:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.reteRenta),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],

                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Monto Total de la Operación:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      //text: this.numberFormat(elemento.resumen.montoTotalOperacion),
                      text: (old) ? this.numberFormat(parseFloat(elemento.resumen.subTotal) * 1.13) : this.numberFormat(elemento.resumen.montoTotalOperacion),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Total Otros montos no afectos:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(0),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Total a Pagar:',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },

                    {
                      //text: '$ ' + this.numberFormat(elemento.resumen.totalPagar),
                      text: (old) ? this.numberFormat(parseFloat(elemento.resumen.subTotal) * 1.13) : '$ ' + this.numberFormat(elemento.resumen.totalPagar),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 1],
                    },
                  ],
                ]
              } //fin tabla resumen abajo
            },
            {
              text: "\n"
            },
            {
              table: {
                widths: ['15%', '35%', '25%', '26%'],
                body: [
                  [{
                      text: 'Valor en letras: ',
                      fontSize: 7,
                      border: [1, 1, 0, 0],
                    }, {
                      text: (old) ? this.numeroALetras(parseFloat(elemento.resumen.subTotal) * 1.13) : elemento.resumen.totalLetras,
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: 'Condición de la Operación: ',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: (elemento.resumen.condicionOperacion == 2) ? 'Crédito' : 'Contado',
                      fontSize: 7,
                      border: [0, 1, 1, 0],
                    }
                  ],
                  [{
                      text: 'Observaciones: ',
                      fontSize: 7,
                      border: [1, 0, 0, 1],
                    }, {
                      text: '',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: 'Documento ERP: ',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: this.getSupermercado(elemento.identificacion.codigoGeneracion).VBELN,
                      fontSize: 7,
                      border: [0, 0, 1, 1],
                    }
                  ],
                ]
              }
            },
            {
              text: '\n'
            },
            {
              table: {
                widths: ['15%', '35%', '25%', '26%'],
                body: [
                  [{
                      text: 'Responsable por: ',
                      fontSize: 7,
                      border: [1, 1, 0, 0],
                    }, {
                      text: '',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: 'Nro. de Documento: ',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: '',
                      fontSize: 7,
                      border: [0, 1, 1, 0],
                    }
                  ],
                  [{
                      text: 'Responsable por: ',
                      fontSize: 7,
                      border: [1, 0, 0, 1],
                    }, {
                      text: '',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: 'Nro. de Documento: ',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: '',
                      fontSize: 7,
                      border: [0, 0, 1, 1],
                    }
                  ],
                ]
              }
            },



          ],
        };


        let q = pdfMake.createPdf(dd);
        if (acion == 'b64') {

          const data = await new Promise((resolve, reject) => {
            q.getBase64((pdfData) => {

              let cantidadAImprimir = 1;
              if (this.cantidadImpresion == 1) {
                if (elemento.receptor.nombre.toUpperCase().includes("CALLEJA")) {
                  //cantidadAImprimir = 2;
                  cantidadAImprimir = 1;
                } else if (elemento.receptor.nombre.toUpperCase().includes("OPERADORA")) {
                  cantidadAImprimir = 3;
                } else {
                  cantidadAImprimir = (elemento.resumen.condicionOperacion == 2) ? 2 : 1
                }
              } else {
                cantidadAImprimir = this.cantidadImpresion;
              }
              app.base64List.push({
                "document": pdfData,
                "printing_type": (elemento.receptor.nombre.toUpperCase().includes("CALLEJA")) ? 'double' : 'single',
                "copies": cantidadAImprimir,
                "cod": elemento.identificacion.codigoGeneracion,
              });
              resolve(pdfData);
            }, (error) => {
              reject(error);
            });


          });
        } else if (acion == 'crear') {
          //lo manda a php para hacer el fisico en el server

          const data = await new Promise((resolve, reject) => {
            q.getBase64((pdfData) => {
              resolve(pdfData);
            }, (error) => {
              reject(error);
            });
          });

          try {
            // Realiza la petición Axios para guardar el PDF
            const response = await axios.post('<?= route('conversor') ?>', {
              elpdf: data,
              id: 'cc-' + elemento.identificacion.codigoGeneracion
            });
            console.log(response);
          } catch (error) {
            console.error(error);
            app.loading = false;
          }

        } else {
          this.loading = false;
          //abre el pdf
          q.open();
        }



      },
      async getPDFExporta(elemento, acion = '') {

        //const qr = await this.getCodigoQR(elemento.identificacion.codigoGeneracion, elemento.identificacion.fecEmi);

        let urlQr = 'https://admin.factura.gob.sv/consultaPublica?ambiente=01&codGen=' + elemento.identificacion.codigoGeneracion + '&fechaEmi=' + elemento.identificacion.fecEmi
        const qr = generarQR(urlQr)

        let mensajeEspecial = ''
        mensajeEspecial = '***formato particular, para ver el oficial consulte el QR***';
        let old = false
        if (dayjs(elemento.identificacion.fecEmi).isBefore(dayjs('2023-10-14'))) {
          old = true
        }

        let documentosRel = [{
          text: ''
        }]
        if (elemento.documentoRelacionado) {
          documentosRel = [{
              text: 'Documentos Relacionados',
              alignment: 'center',
              fontSize: 7,
            },
            {
              table: {
                headerRows: 1,
                widths: ['33%', '33%', '35%'],
                body: [
                  [{
                      text: 'Tipo de Documento',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'N° de Documento',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Fecha de Documento',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                  ],

                  ...elemento.documentoRelacionado.map(r => {
                    return [{
                        text: this.getTipoDocumento(r.tipoDocumento),
                        fontSize: 7,
                        border: [0, 0, 0, 0],
                      },
                      {
                        text: r.numeroDocumento,
                        fontSize: 7,
                        border: [0, 0, 0, 0],
                      },
                      {
                        text: r.fechaEmision,
                        fontSize: 7,
                        border: [0, 0, 0, 0],
                      },
                    ]
                  })


                ],
              }
            },
          ]
        }



        const customColors = {
          customOrange: '#ff4b00',
          //customOrange: '#ff9a00',
          customRed: '#FF0000',
          customRed: '#FFFFFF',
        };


        var dd = {
          pageSize: 'letter',
          /*background: [{
            image: logo_trasparente,
            fit: [595.28, 841.89],
            margin: [0, 240, 0, 0]
          }, ],*/
          footer: function(currentPage, pageCount) {
            return {
              text: `Página ${currentPage} de ${pageCount} - ${elemento.identificacion.numeroControl}`,
              fontSize: 7,
              alignment: 'center', // Alinea el texto al centro
            };
          },
          pageMargins: [30, 9, 20, 45],
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
                widths: [150, '*', 70, 50],
                body: [
                  [{
                      image: logo,
                      width: 220,
                      alignment: 'center',
                      border: [false, false, false, false],
                      style: 'imagenConMargen',
                    },
                    {
                      stack: [{
                          text: "DOCUMENTO TRIBUTARIO ELECTRÓNICO",
                          alignment: 'center',
                          fontSize: 10,
                          style: 'customMargin',
                        },
                        {
                          text: "FACTURA DE EXPORTACIÓN",
                          alignment: 'center',
                          fontSize: 10
                        },
                      ],
                      border: [false, false, false, false]
                    },
                    {
                      image: qr,
                      width: 55,
                      alignment: 'center',
                      border: [false, false, false, false]
                    },
                    {
                      alignment: 'right',
                      border: [false, false, false, false],
                      text: '\n' + this.getSupermercado(elemento.identificacion.codigoGeneracion).BZIRK,
                      fontSize: 12
                    },

                  ]
                ]

              }, //fin tabla
            }, //fin bracket tabla
            linea(),

            {
              table: {
                layout: 'noBorders',

                widths: [250, '*'],
                body: [
                  [{
                      stack: [{
                          text: [{
                              text: 'Código de Generación: ',
                              bold: true,
                              fontSize: 6
                            },

                            {
                              text: elemento.identificacion.codigoGeneracion,
                              fontSize: 6
                            },

                          ],
                        },

                        {
                          text: [{
                              text: 'Número de Control : ',
                              bold: true,
                              fontSize: 6
                            },

                            {
                              text: elemento.identificacion.numeroControl,
                              fontSize: 6
                            },

                          ],
                        },

                        {
                          text: [{
                              text: 'Sello de Recepción: ',
                              bold: true,
                              fontSize: 6
                            },

                            {
                              text: this.getSupermercado(elemento.identificacion.codigoGeneracion).CAMPO2,
                              fontSize: 6
                            },

                          ],
                        },


                      ],
                      border: [false, false, false, false]
                    },
                    {
                      stack: [{
                          text: [{
                              text: 'Modelo de Facturación: ',
                              bold: true,
                              fontSize: 6,
                              alignment: 'right',
                            },

                            {
                              text: elemento.identificacion.tipoModelo,
                              fontSize: 6,
                              alignment: 'right',

                            },

                          ],
                        },

                        {
                          text: [{
                              text: 'Tipo de Transmisión:',
                              bold: true,
                              fontSize: 6,
                              alignment: 'right',
                            },

                            {
                              text: elemento.identificacion.tipoOperacion,
                              fontSize: 6,
                              alignment: 'right',
                            },

                          ],
                        },

                        {
                          text: [{
                              text: 'Fecha y Hora de Generación: ',
                              bold: true,
                              fontSize: 6,
                              alignment: 'right',
                            },

                            {
                              text: elemento.identificacion.fecEmi + ' ' + elemento.identificacion.horEmi,
                              fontSize: 6,
                              alignment: 'right',
                            },

                          ],
                        },


                      ],
                      border: [false, false, false, false]
                    },

                  ]
                ],

              }
            },
            {
              text: mensajeEspecial,
              fontSize: 4
            },
            {
              table: {
                widths: ['49%', '2%', '49%'], // Definimos dos columnas con igual ancho
                body: [
                  [{
                      stack: [{
                          text: 'Emisor',
                          alignment: 'center',
                          bold: true,
                        },
                        {
                          text: [{
                            text: 'Nombre o Razón social: ',
                            bold: true
                          }, elemento.emisor.nombre]
                        },
                        {
                          text: [{
                            text: 'NIT: ',
                            bold: true
                          }, elemento.emisor.nit]
                        },
                        {
                          text: [{
                            text: 'NRC: ',
                            bold: true
                          }, elemento.emisor.nrc]
                        },
                        {
                          text: [{
                            text: 'Actividad Economica: ',
                            bold: true
                          }, elemento.emisor.descActividad]
                        },
                        {
                          text: [{
                              text: 'Direccion:  ',
                              bold: true
                            },
                            "Calle Siemens #1, Parque Industrial Santa Elena" //elemento.emisor.direccion.complemento
                          ]
                        },
                        {


                          text: this.getDepartamento(elemento.emisor.direccion.departamento).toUpperCase() + ' - ' + this.getMunicipio(elemento.emisor.direccion.departamento, elemento.emisor.direccion.municipio).toUpperCase()
                        },
                        {
                          text: [{
                            text: 'Numero de teléfono: ',
                            bold: true
                          }, elemento.emisor.telefono]
                        },
                        {
                          text: [{
                            text: 'Correo electrónico: ',
                            bold: true
                          }, elemento.emisor.correo]
                        },
                        {
                          text: [{
                            text: 'Nombre Comercial: ',
                            bold: true
                          }, elemento.emisor.nombreComercial]
                        },
                        {
                          text: [{
                            text: 'Tipo Establecimiento: ',
                            bold: true
                          }, this.getTipoEstablecimiento(elemento.emisor.tipoEstablecimiento)]
                        },
                        {
                          text: [{
                            text: 'Régimen de exportación: ',
                            bold: true
                          }, "Exportación Definitiva"]
                        },

                      ],
                      fontSize: 6,
                      border: [true, true, true, true], // Borde en los cuatro lados
                      margin: [5, 5], // Márgenes para separación y espacio interno
                    },
                    {
                      text: '',
                      border: [0, 0, 0, 0],
                    },
                    {
                      stack: [{
                          text: 'Receptor',
                          alignment: 'center',
                          bold: true,
                        },
                        {
                          text: [{
                            text: 'Nombre o razón social: ',
                            bold: true
                          }, elemento.receptor.nombre + '']
                        },
                        {
                          text: [{
                            text: 'Tipo de Documento: ',
                            bold: true
                          }, this.getTipoDocumento(elemento.receptor.tipoDocumento)]
                        },

                        {
                          text: [{
                            text: 'Nro. documento: ',
                            bold: true
                          }, elemento.receptor.numDocumento]
                        },
                        {
                          text: [{
                            text: 'Correo electrónico: ',
                            bold: true
                          }, elemento.receptor.correo]
                        },
                        {
                          text: [{
                            text: 'Nombre comercial: ',
                            bold: true
                          }, this.getSupermercado(elemento.identificacion.codigoGeneracion).NAME2]
                        },
                        {
                          text: [{
                            text: 'Ruta de ventas: ',
                            bold: true
                          }, this.getSupermercado(elemento.identificacion.codigoGeneracion).BZIRK]
                        },
                        {
                          text: [{
                            text: 'Dirección: ',
                            bold: true
                          }, elemento.receptor?.complemento]
                        },
                        {
                          text: [{
                            text: 'País de destino: ',
                            bold: true
                          }, elemento.receptor.nombrePais]
                        },
                        {
                          text: [{
                            text: 'Teléfono: ',
                            bold: true
                          }, elemento.receptor.telefono]
                        },

                      ],
                      fontSize: 6,
                      border: [true, true, true, true], // Borde en los cuatro lados
                      margin: [5, 5], // Márgenes para separación y espacio interno
                    },
                  ],
                ],
              },
            },

            {
              text: '\n'
            },

            ...documentosRel,
            {
              table: {
                headerRows: 1,
                widths: ['2%', '5%', '4%', '5%', '14%', '34%', '7%', '4%', '26%'],
                body: [
                  [{
                      text: 'N°',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Cnt.',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Und.',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Cod.p',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Cod.b' + ((this.getSupermercado(elemento.identificacion.codigoGeneracion).KUNNR == '2000000057') ? '         Reg. \n Sanit. ' : ''),
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                      alignment: ((this.getSupermercado(elemento.identificacion.codigoGeneracion).KUNNR == '2000000057') ? 'right' : 'left'),
                    },
                    {
                      text: 'Descripción',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Precio Unitario',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Dtos',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Vtas Afectas',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                  ],
                  ...this.conversorLineaExportaPDF(elemento),


                ]
              }
            }, //fin tabla detalle

            {
              table: {
                widths: ['50%', '35%', '16%'],
                body: [
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Total operaciones afectas:',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },

                    {
                      text: '$ ' + this.numberFormat(elemento.resumen.totalGravada),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 1, 1, 0],
                    },

                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Monto global de Desc., Rebajas de operaciones afectas:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: '$ ' + this.numberFormat(elemento.resumen.totalDescu),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },

                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Seguro:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: '$ ' + this.numberFormat(elemento.resumen.seguro),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Flete:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: '$ ' + this.numberFormat(elemento.resumen.flete),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: '',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: '',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Total Otros Montos No Afectos:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: '$ ' + this.numberFormat(elemento.resumen.totalNoGravado),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Total General:',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },

                    {
                      text: '$ ' + this.numberFormat(elemento.resumen.totalPagar),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 1],
                    },
                  ],

                ]
              } //fin tabla resumen abajo
            },
            {
              text: "\n"
            },
            {
              table: {
                widths: ['15%', '35%', '25%', '26%'],
                body: [
                  [{
                      text: 'Valor en letras: ',
                      fontSize: 7,
                      border: [1, 1, 0, 0],
                    }, {
                      text: elemento.resumen.totalLetras + ' ' + elemento.identificacion.tipoMoneda,
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: 'Condición de la Operación: ',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: (elemento.resumen.condicionOperacion == 2) ? 'Crédito' : 'Contado',
                      fontSize: 7,
                      border: [0, 1, 1, 0],
                    }
                  ],

                  [{
                      text: 'Descripción: ',
                      fontSize: 7,
                      border: [1, 0, 0, 1],
                    }, {
                      text: elemento.resumen.descIncoterms,
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: 'Documento ERP: ',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: this.getSupermercado(elemento.identificacion.codigoGeneracion).VBELN,
                      fontSize: 7,
                      border: [0, 0, 1, 1],
                    }
                  ],
                  [{
                      text: 'Observaciones: ',
                      fontSize: 7,
                      border: [1, 0, 0, 1],
                    }, {
                      text: (elemento.receptor.nombrePais == 'COSTA RICAAAA') ? elemento.resumen.observaciones : 'Valor incluye Flete y Seguro',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: 'Solicitante: ',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: this.getSupermercado(elemento.identificacion.codigoGeneracion).KUNNR,
                      fontSize: 7,
                      border: [0, 0, 1, 1],
                    }
                  ],
                  [{
                      text: 'No. Pedido:  ',
                      fontSize: 7,
                      border: [1, 0, 0, 1],
                    }, {
                      text: '',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: ' ',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: '',
                      fontSize: 7,
                      border: [0, 0, 1, 1],
                    }
                  ],
                ]
              }
            },
            {
              text: '\n'
            },
            {
              table: {
                widths: ['15%', '35%', '25%', '26%'],
                body: [
                  [{
                      text: 'Responsable por: ',
                      fontSize: 7,
                      border: [1, 1, 0, 0],
                    }, {
                      text: '',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: 'Nro. de Documento: ',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: '',
                      fontSize: 7,
                      border: [0, 1, 1, 0],
                    }
                  ],
                  [{
                      text: 'Responsable por: ',
                      fontSize: 7,
                      border: [1, 0, 0, 1],
                    }, {
                      text: '',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: 'Nro. de Documento: ',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: '',
                      fontSize: 7,
                      border: [0, 0, 1, 1],
                    }
                  ],
                ]
              }
            },



          ],
        };


        let q = pdfMake.createPdf(dd);
        if (acion == 'b64') {

          const data = await new Promise((resolve, reject) => {
            q.getBase64((pdfData) => {

              let cantidadAImprimir = 1;
              if (this.cantidadImpresion == 1) {
                if (elemento.receptor.nombre.toUpperCase().includes("CALLEJA")) {
                  //cantidadAImprimir = 2;
                  cantidadAImprimir = 1;
                } else if (elemento.receptor.nombre.toUpperCase().includes("OPERADORA")) {
                  cantidadAImprimir = 3;
                } else {
                  cantidadAImprimir = (elemento.resumen.condicionOperacion == 2) ? 1 : 1
                }
              } else {
                cantidadAImprimir = this.cantidadImpresion;
              }
              app.base64List.push({
                "document": pdfData,
                "printing_type": (elemento.receptor.nombre.toUpperCase().includes("CALLEJA")) ? 'double' : 'single',
                "copies": cantidadAImprimir,
                "cod": elemento.identificacion.codigoGeneracion,
              });
              resolve(pdfData);
            }, (error) => {
              reject(error);
            });


          });
        } else if (acion == 'crear') {
          //lo manda a php para hacer el fisico en el server

          const data = await new Promise((resolve, reject) => {
            q.getBase64((pdfData) => {
              resolve(pdfData);
            }, (error) => {
              reject(error);
            });
          });

          try {
            // Realiza la petición Axios para guardar el PDF
            const response = await axios.post('<?= route('conversor') ?>', {
              elpdf: data,
              id: 'cc-' + elemento.identificacion.codigoGeneracion
            });
            console.log(response);
          } catch (error) {
            console.error(error);
            app.loading = false;
          }

        } else {
          this.loading = false;
          //abre el pdf
          q.open();
        }



      },


      async getNotaCredito(elemento, acion = '') {

        //const qr = await this.getCodigoQR(elemento.identificacion.codigoGeneracion, elemento.identificacion.fecEmi);
        let urlQr = 'https://admin.factura.gob.sv/consultaPublica?ambiente=01&codGen=' + elemento.identificacion.codigoGeneracion + '&fechaEmi=' + elemento.identificacion.fecEmi
        const qr = generarQR(urlQr)
        let mensajeEspecial = ''
        mensajeEspecial = '***formato particular, para ver el oficial consulte el QR***';
        let old = false
        if (dayjs(elemento.identificacion.fecEmi).isBefore(dayjs('2023-10-14'))) {
          old = true
        }

        const customColors = {
          customOrange: '#ff4b00',
          //customOrange: '#ff9a00',
          customRed: '#FF0000',
          customRed: '#FFFFFF',
        };


        var dd = {
          pageSize: 'letter',
          /* background: [{
             image: logo_trasparente,
             fit: [595.28, 841.89],
             margin: [0, 240, 0, 0]
           }, ],*/
          footer: function(currentPage, pageCount) {
            return {
              text: `Página ${currentPage} de ${pageCount} - ${elemento.identificacion.numeroControl}`,
              fontSize: 7,
              alignment: 'center', // Alinea el texto al centro
            };
          },
          pageMargins: [30, 9, 20, 45],
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
                widths: [150, '*', 70, 50],
                body: [
                  [{
                      image: logo,
                      width: 220,
                      alignment: 'center',
                      border: [false, false, false, false],
                      style: 'imagenConMargen',
                    },
                    {
                      stack: [{
                          text: "DOCUMENTO TRIBUTARIO ELECTRÓNICO",
                          alignment: 'center',
                          fontSize: 10,
                          style: 'customMargin',
                        },
                        {
                          text: "NOTA DE CRÉDITO",
                          alignment: 'center',
                          fontSize: 10
                        },
                      ],
                      border: [false, false, false, false]
                    },
                    {
                      image: qr,
                      width: 55,
                      alignment: 'center',
                      border: [false, false, false, false]
                    },
                    {
                      alignment: 'right',
                      border: [false, false, false, false],
                      text: '\n' + this.getSupermercado(elemento.identificacion.codigoGeneracion).BZIRK,
                      fontSize: 12
                    },

                  ]
                ]

              }, //fin tabla
            }, //fin bracket tabla
            linea(),

            {
              table: {
                layout: 'noBorders',

                widths: [250, '*'],
                body: [
                  [{
                      stack: [{
                          text: [{
                              text: 'Código de Generación: ',
                              bold: true,
                              fontSize: 6
                            },

                            {
                              text: elemento.identificacion.codigoGeneracion,
                              fontSize: 6
                            },

                          ],
                        },

                        {
                          text: [{
                              text: 'Número de Control : ',
                              bold: true,
                              fontSize: 6
                            },

                            {
                              text: elemento.identificacion.numeroControl,
                              fontSize: 6
                            },

                          ],
                        },

                        {
                          text: [{
                              text: 'Sello de Recepción: ',
                              bold: true,
                              fontSize: 6
                            },

                            {
                              text: this.getSupermercado(elemento.identificacion.codigoGeneracion).CAMPO2,
                              fontSize: 6
                            },

                          ],
                        },


                      ],
                      border: [false, false, false, false]
                    },
                    {
                      stack: [{
                          text: [{
                              text: 'Modelo de Facturación: ',
                              bold: true,
                              fontSize: 6,
                              alignment: 'right',
                            },

                            {
                              text: elemento.identificacion.tipoModelo,
                              fontSize: 6,
                              alignment: 'right',

                            },

                          ],
                        },

                        {
                          text: [{
                              text: 'Tipo de Transmisión:',
                              bold: true,
                              fontSize: 6,
                              alignment: 'right',
                            },

                            {
                              text: elemento.identificacion.tipoOperacion,
                              fontSize: 6,
                              alignment: 'right',
                            },

                          ],
                        },

                        {
                          text: [{
                              text: 'Fecha y Hora de Generación: ',
                              bold: true,
                              fontSize: 6,
                              alignment: 'right',
                            },

                            {
                              text: elemento.identificacion.fecEmi + ' ' + elemento.identificacion.horEmi,
                              fontSize: 6,
                              alignment: 'right',
                            },

                          ],
                        },


                      ],
                      border: [false, false, false, false]
                    },

                  ]
                ],

              }
            },
            {
              text: mensajeEspecial,
              fontSize: 4
            },
            {
              table: {
                widths: ['49%', '2%', '49%'], // Definimos dos columnas con igual ancho
                body: [
                  [{
                      stack: [{
                          text: 'Emisor',
                          alignment: 'center',
                          bold: true,
                        },
                        {
                          text: [{
                            text: 'Nombre o Razón social: ',
                            bold: true
                          }, elemento.emisor.nombre]
                        },
                        {
                          text: [{
                            text: 'NIT: ',
                            bold: true
                          }, elemento.emisor.nit]
                        },
                        {
                          text: [{
                            text: 'NRC: ',
                            bold: true
                          }, elemento.emisor.nrc]
                        },
                        {
                          text: [{
                            text: 'Actividad Economica: ',
                            bold: true
                          }, elemento.emisor.descActividad]
                        },
                        {
                          text: [{
                            text: 'Direccion:  ',
                            bold: true
                          }, elemento.emisor.direccion.complemento]
                        },
                        {


                          text: this.getDepartamento(elemento.emisor.direccion.departamento).toUpperCase() + ' - ' + this.getMunicipio(elemento.emisor.direccion.departamento, elemento.emisor.direccion.municipio).toUpperCase()
                        },
                        {
                          text: [{
                            text: 'Numero de teléfono: ',
                            bold: true
                          }, elemento.emisor.telefono]
                        },
                        {
                          text: [{
                            text: 'Correo electrónico: ',
                            bold: true
                          }, elemento.emisor.correo]
                        },
                        {
                          text: [{
                            text: 'Nombre Comercial: ',
                            bold: true
                          }, elemento.emisor.nombreComercial]
                        },
                        {
                          text: [{
                            text: 'Tipo Establecimiento: ',
                            bold: true
                          }, this.getTipoEstablecimiento(elemento.emisor.tipoEstablecimiento)]
                        },

                      ],
                      fontSize: 6,
                      border: [true, true, true, true], // Borde en los cuatro lados
                      margin: [5, 5], // Márgenes para separación y espacio interno
                    },
                    {
                      text: '',
                      border: [0, 0, 0, 0],
                    },
                    {
                      stack: [{
                          text: 'Receptor',
                          alignment: 'center',
                          bold: true,
                        },
                        {
                          text: [{
                            text: 'Nombre o razón social: ',
                            bold: true
                          }, elemento.receptor.nombre + ' ( ' + this.getSupermercado(elemento.identificacion.codigoGeneracion).KUNNR + ' )']
                        },
                        {
                          text: [{
                            text: 'Nombre comercial: ',
                            bold: true
                          }, this.getSupermercado(elemento.identificacion.codigoGeneracion).NAME2]
                        },
                        {
                          text: [{
                            text: 'NIT: ',
                            bold: true
                          }, elemento.receptor.nit]
                        },
                        {
                          text: [{
                            text: 'NRC: ',
                            bold: true
                          }, elemento.receptor.nrc]
                        },
                        {
                          text: [{
                            text: 'Actividad económica: ',
                            bold: true
                          }, elemento.receptor.descActividad]
                        },
                        {
                          text: [{
                            text: 'Dirección: ',
                            bold: true
                          }, elemento.receptor.direccion.complemento]
                        },
                        {
                          text: this.getDepartamento(elemento.receptor.direccion.departamento) + ' ' + this.getMunicipio(elemento.receptor.direccion.municipio)
                        },
                        {
                          text: [{
                            text: 'Correo electrónico: ',
                            bold: true
                          }, elemento.receptor.correo]
                        },
                        {
                          text: [{
                            text: 'Teléfono: ',
                            bold: true
                          }, elemento.receptor.telefono]
                        },

                      ],
                      fontSize: 6,
                      border: [true, true, true, true], // Borde en los cuatro lados
                      margin: [5, 5], // Márgenes para separación y espacio interno
                    },
                  ],
                ],
              },
            },

            {
              text: '\n'
            },
            {
              text: 'Documentos Relacionados',
              alignment: 'center',
              fontSize: 7,
            },
            {
              table: {
                headerRows: 1,
                widths: ['33%', '33%', '35%'],
                body: [
                  [{
                      text: 'Tipo de Documento',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'N° de Documento',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Fecha de Documento',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                  ],

                  ...elemento.documentoRelacionado.map(r => {
                    return [{
                        text: this.getTipoDocumento(r.tipoDocumento),
                        fontSize: 7,
                        border: [0, 0, 0, 0],
                      },
                      {
                        text: r.numeroDocumento,
                        fontSize: 7,
                        border: [0, 0, 0, 0],
                      },
                      {
                        text: r.fechaEmision,
                        fontSize: 7,
                        border: [0, 0, 0, 0],
                      },
                    ]
                  })


                ],
              }
            },

            {
              table: {
                headerRows: 1,
                widths: ['2%', '4%', '4%', '5%', '11%', '45%', '7%', '4%', '6%', '6%', '7%'],
                body: [
                  [{
                      text: 'N°',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Cnt.',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Und.',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Cod.p',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Cod.b',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Descripción',
                      bold: true,
                      color: 'white',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Precio Unitario',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Dtos',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },

                    {
                      text: 'Vtas no sujetas',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Vtas Exentas',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                    {
                      text: 'Vtas Gravadas',
                      bold: true,
                      color: 'white',
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                      fillColor: customColors.customOrange,
                    },
                  ],
                  ...this.conversorLineaNotaCredito(elemento),


                ]
              }
            }, //fin tabla detalle

            {
              table: {
                widths: ['50%', '35%', '16%'],
                body: [
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Suma de Ventas:',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.subTotalVentas),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 1, 1, 0],
                    },

                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Suma Total de Operaciones:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.totalGravada),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },

                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Monto global Desc., Rebajas y otros a ventas no sujetas:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.totalNoSuj),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Monto global Desc., Rebajas y otros a ventas Exentas:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.totalExenta),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],

                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Impuesto al Valor Agregado 13%:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      //text: (elemento.resumen.tributos.find(r => r.codigo == '20')) ? elemento.resumen.tributos.find(r => r.codigo == '20').valor : 0,
                      text: (old) ? this.numberFormat(parseFloat(elemento.resumen.subTotal) * 0.13) : ((elemento.resumen.tributos.find(r => r.codigo == '20')) ? elemento.resumen.tributos.find(r => r.codigo == '20').valor : 0),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Sub-Total:',
                      fontSize: 7,
                      border: [0, 0, 0, 0],
                    },

                    {
                      text: this.numberFormat(elemento.resumen.subTotal),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 0],
                    },
                  ],
                  [{
                      text: '',
                      border: [0, 0, 1, 0],
                    }, {
                      alignment: 'right',
                      text: 'Monto Total de la Operación:',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },

                    {
                      //text: this.numberFormat(elemento.resumen.montoTotalOperacion),
                      text: (old) ? this.numberFormat(parseFloat(elemento.resumen.subTotal) * 1.13) : this.numberFormat(elemento.resumen.montoTotalOperacion),
                      alignment: 'right',
                      fontSize: 7,
                      border: [0, 0, 1, 1],
                    },
                  ],
                ]
              } //fin tabla resumen abajo
            },
            {
              text: "\n"
            },
            {
              table: {
                widths: ['15%', '35%', '25%', '26%'],
                body: [
                  [{
                      text: 'Valor en letras: ',
                      fontSize: 7,
                      border: [1, 1, 0, 0],
                    }, {
                      text: (old) ? this.numeroALetras(parseFloat(elemento.resumen.subTotal) * 1.13) : elemento.resumen.totalLetras,
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: 'Condición de la Operación: ',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: (elemento.resumen.condicionOperacion == 2) ? 'Crédito' : 'Contado',
                      fontSize: 7,
                      border: [0, 1, 1, 0],
                    }
                  ],
                  [{
                      text: 'Observaciones: ',
                      fontSize: 7,
                      border: [1, 0, 0, 1],
                    }, {
                      text: '',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: 'Documento ERP: ',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: this.getSupermercado(elemento.identificacion.codigoGeneracion).VBELN,
                      fontSize: 7,
                      border: [0, 0, 1, 1],
                    }
                  ],
                ]
              }
            },
            {
              text: '\n'
            },
            {
              table: {
                widths: ['15%', '35%', '25%', '26%'],
                body: [
                  [{
                      text: 'Responsable por: ',
                      fontSize: 7,
                      border: [1, 1, 0, 0],
                    }, {
                      text: '',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: 'Nro. de Documento: ',
                      fontSize: 7,
                      border: [0, 1, 0, 0],
                    },
                    {
                      text: '',
                      fontSize: 7,
                      border: [0, 1, 1, 0],
                    }
                  ],
                  [{
                      text: 'Responsable por: ',
                      fontSize: 7,
                      border: [1, 0, 0, 1],
                    }, {
                      text: '',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: 'Nro. de Documento: ',
                      fontSize: 7,
                      border: [0, 0, 0, 1],
                    },
                    {
                      text: '',
                      fontSize: 7,
                      border: [0, 0, 1, 1],
                    }
                  ],
                ]
              }
            },



          ],
        };


        let q = pdfMake.createPdf(dd);
        if (acion == 'b64') {

          const data = await new Promise((resolve, reject) => {
            q.getBase64((pdfData) => {

              let cantidadAImprimir = 1;
              if (this.cantidadImpresion == 1) {
                if (elemento.receptor.nombre.toUpperCase().includes("CALLEJA")) {
                  //cantidadAImprimir = 2;
                  cantidadAImprimir = 1;
                } else if (elemento.receptor.nombre.toUpperCase().includes("OPERADORA")) {
                  cantidadAImprimir = 3;
                } else {
                  cantidadAImprimir = (elemento.resumen.condicionOperacion == 2) ? 2 : 1
                }
              } else {
                cantidadAImprimir = this.cantidadImpresion;
              }
              app.base64List.push({
                "document": pdfData,
                "printing_type": (elemento.receptor.nombre.toUpperCase().includes("CALLEJA")) ? 'double' : 'single',
                "copies": cantidadAImprimir,
                "cod": elemento.identificacion.codigoGeneracion,
              });
              resolve(pdfData);
            }, (error) => {
              reject(error);
            });


          });
        } else if (acion == 'crear') {
          //lo manda a php para hacer el fisico en el server

          const data = await new Promise((resolve, reject) => {
            q.getBase64((pdfData) => {
              resolve(pdfData);
            }, (error) => {
              reject(error);
            });
          });

          try {
            // Realiza la petición Axios para guardar el PDF
            const response = await axios.post('<?= route('conversor') ?>', {
              elpdf: data,
              id: 'cc-' + elemento.identificacion.codigoGeneracion
            });
            console.log(response);
          } catch (error) {
            console.error(error);
            app.loading = false;
          }

        } else {
          this.loading = false;
          //abre el pdf
          q.open();
        }



      },

      mostrarPDF(c) {
        this.showPDF = true;
        this.pdfUrl = '<?= url('storage') ?>/' + c + '.pdf';
      },
      rutaValidacion(elemento) {
        if (elemento?.apendice) {
          if (elemento?.apendice?.find(w => w.etiqueta == 'Ruta')) {
            return elemento.apendice.find(w => w.etiqueta == 'Ruta').valor
          }
        }
        return this.getSupermercado(elemento.identificacion.codigoGeneracion).BZIRK;
      },
      ocValidacion(elemento) {
        if (elemento?.apendice) {
          if (elemento?.apendice?.find(w => w.campo == 'OrdenCompra')) {
            return "OC-" + elemento.apendice.find(w => w.campo == 'OrdenCompra').valor
          }
        }
        return "";
      },

      getNombreComercial(d) {
        if (this.supemercados.length > 0) {
          let v = this.supemercados.find(r => r.CAMPO1 == d.cod_gen_dte);
          if (!v) {
            return '';
          }
          //v = JSON.parse(v)
          return (v.NAME2)
        } else {
          return ""
        }

      },
      getCodigoBarra(d) {
        let v = this.codigoBarra.find(r => parseInt(r.MATNR) == parseInt(d));
        if (!v) {
          return '';
        }
        return parseInt(v.EAN11)
      },
      getUnidad(d) {
        let v = this.unidadesList.find(r => parseInt(r.id) == parseInt(d));
        if (!v) {
          return '';
        }
        return v.und
      },
      getTipoDocumento(d) {
        let v = this.tipoDocumentoList.find(r => (r.id) == (d));
        if (!v) {
          return '';
        }
        return v.nombre
      },
      getTipoEstablecimiento(d) {
        let v = this.tipoEstablecimientoList.find(r => (r.id) == (d));
        if (!v) {
          return '';
        }
        return v.nombre
      },
      getDepartamento(d) {
        let v = this.departamentos.find(r => r.codigo == d)
        return (v) ? v.valor : ''
      },
      getMunicipio(d, m) {
        let v = this.municipios.find(r => (r.codigo == m && r.cod_departamento == d))
        return (v) ? v.valor : ''
      },
      numberFormat(n, r = 2) {
        const numberWithTwoDecimals = Number(n).toFixed(r);
        let v = numberWithTwoDecimals.toLocaleString('es-MX', {
          minimumFractionDigits: r, // Asegura que siempre haya 2 decimales
          maximumFractionDigits: r, // Asegura que siempre haya 2 decimales
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
      getSupermercado(f) {
        let v = this.supemercados.find(r => (r.CAMPO1 == f))
        return (v) ? v : ''
      },
      async getCodigoQR(texto, fecha) {
        //let url = 'https://ywyjwovdqgzoiyx3h3omb7qpm40pgmre.lambda-url.us-east-1.on.aws/codigo_dte='


        let url = 'https://webapp.dtes.mh.gob.sv/consultaPublica?ambiente=01&codGen=' + texto + '&fechaEmi=' + fecha
        try {
          const response = await axios.post('https://sv.lacnetcorp.com/generar-qr/base64', {
            texto: url
          });
          // Devuelve la respuesta de la promesa axios
          console.log(response.data);
          return response.data;
        } catch (error) {
          // Lanza una excepción si ocurre un error
          throw error;
        }
      },

      async getSupermercados() {
        this.supemercados = []
        let fecha = dayjs(this.fecha).format('DD.MM.YYYY')
        await axios.get('<?= route('getSupermercados') ?>?fecha=' + fecha, {
            fecha: fecha
          })
          .then(res => {
            this.supemercados = res.data;
            return
          })
          .catch(err => {
            console.error(err);
          });
      },
      getCodigoBarras() {
        axios.get('<?= route('getCodigoBarra') ?>', {

          })
          .then(res => {
            this.codigoBarra = res.data;
          })
          .catch(err => {
            console.error(err);
          });
      },
      getDepartamentos() {
        axios.get('<?= route('getDepartamentos') ?>', {})
          .then(res => {
            this.departamentos = res.data;
          })
          .catch(err => {
            console.error(err);
          });
      },
      getMunicipios() {
        axios.get('<?= route('getMunicipios') ?>', {})
          .then(res => {
            this.municipios = res.data;
          })
          .catch(err => {
            console.error(err);
          });
      },
      getCodigoBarras() {
        axios.get('<?= route('getCodigoBarra') ?>', {

          })
          .then(res => {
            this.codigoBarra = res.data;
          })
          .catch(err => {
            console.error(err);
          });
      },


      numeroALetras(num, currency) {
        currency = currency || {}
        const data = {
          numero: num,
          enteros: Math.floor(num),
          centavos: Math.round(num * 100) - Math.floor(num) * 100,
          letrasCentavos: '',
          letrasMonedaPlural: currency.plural || 'DOLARES', // 'PESOS', 'DÃƒÆ’Ã‚Â³lares', 'BolÃƒÆ’Ã‚Â­vares', 'etcs'
          letrasMonedaSingular: currency.singular || 'DOLAR', // 'PESO', 'DÃƒÆ’Ã‚Â³lar', 'Bolivar', 'etc'
          letrasMonedaCentavoPlural: currency.centPlural || 'CENTAVOS',
          letrasMonedaCentavoSingular: currency.centSingular || 'CENTAVO',
        }

        if (data.centavos === 100) {
          data.letrasCentavos = '00/100'
          data.enteros++
        } else if (data.centavos > 0) {
          data.letrasCentavos = `${data.centavos.toString().length === 1 ? '0' : ''}${
      data.centavos
    }/100`
        } else {
          data.letrasCentavos = '00/100'
        }

        if (data.enteros === 0)
          return 'CERO ' + data.letrasMonedaPlural + ' ' + data.letrasCentavos
        if (data.enteros === 1)
          return (
            Millones(data.enteros) +
            ' ' +
            data.letrasMonedaSingular +
            ' ' +
            data.letrasCentavos
          )
        else
          return (
            Millones(data.enteros) +
            ' ' +
            data.letrasMonedaPlural +
            ' ' +
            data.letrasCentavos
          )

        // CÃƒÂ³digo basado en https://gist.github.com/alfchee/e563340276f89b22042a
        function Unidades(num) {
          switch (num) {
            case 1:
              return 'UN'
            case 2:
              return 'DOS'
            case 3:
              return 'TRES'
            case 4:
              return 'CUATRO'
            case 5:
              return 'CINCO'
            case 6:
              return 'SEIS'
            case 7:
              return 'SIETE'
            case 8:
              return 'OCHO'
            case 9:
              return 'NUEVE'
          }

          return ''
        } // Unidades()

        function Decenas(num) {
          const decena = Math.floor(num / 10)
          const unidad = num - decena * 10

          switch (decena) {
            case 1:
              switch (unidad) {
                case 0:
                  return 'DIEZ'
                case 1:
                  return 'ONCE'
                case 2:
                  return 'DOCE'
                case 3:
                  return 'TRECE'
                case 4:
                  return 'CATORCE'
                case 5:
                  return 'QUINCE'
                default:
                  return 'DIECI' + Unidades(unidad)
              }
            case 2:
              switch (unidad) {
                case 0:
                  return 'VEINTE'
                default:
                  return 'VEINTI' + Unidades(unidad)
              }
            case 3:
              return DecenasY('TREINTA', unidad)
            case 4:
              return DecenasY('CUARENTA', unidad)
            case 5:
              return DecenasY('CINCUENTA', unidad)
            case 6:
              return DecenasY('SESENTA', unidad)
            case 7:
              return DecenasY('SETENTA', unidad)
            case 8:
              return DecenasY('OCHENTA', unidad)
            case 9:
              return DecenasY('NOVENTA', unidad)
            case 0:
              return Unidades(unidad)
          }
        } // Unidades()

        function DecenasY(strSin, numUnidades) {
          if (numUnidades > 0) return strSin + ' Y ' + Unidades(numUnidades)

          return strSin
        } // DecenasY()

        function Centenas(num) {
          const centenas = Math.floor(num / 100)
          const decenas = num - centenas * 100

          switch (centenas) {
            case 1:
              if (decenas > 0) return 'CIENTO ' + Decenas(decenas)
              return 'CIEN'
            case 2:
              return 'DOSCIENTOS ' + Decenas(decenas)
            case 3:
              return 'TRESCIENTOS ' + Decenas(decenas)
            case 4:
              return 'CUATROCIENTOS ' + Decenas(decenas)
            case 5:
              return 'QUINIENTOS ' + Decenas(decenas)
            case 6:
              return 'SEISCIENTOS ' + Decenas(decenas)
            case 7:
              return 'SETECIENTOS ' + Decenas(decenas)
            case 8:
              return 'OCHOCIENTOS ' + Decenas(decenas)
            case 9:
              return 'NOVECIENTOS ' + Decenas(decenas)
          }

          return Decenas(decenas)
        } // Centenas()

        function Seccion(num, divisor, strSingular, strPlural) {
          const cientos = Math.floor(num / divisor)
          const resto = num - cientos * divisor

          let letras = ''

          if (cientos > 0)
            if (cientos > 1) letras = Centenas(cientos) + ' ' + strPlural
          else letras = strSingular

          if (resto > 0) letras += ''

          return letras
        } // Seccion()

        function Miles(num) {
          const divisor = 1000
          const cientos = Math.floor(num / divisor)
          const resto = num - cientos * divisor

          const strMiles = Seccion(num, divisor, 'UN MIL', 'MIL')
          const strCentenas = Centenas(resto)

          if (strMiles === '') return strCentenas

          return strMiles + ' ' + strCentenas
        } // Miles()

        function Millones(num) {
          const divisor = 1000000
          const cientos = Math.floor(num / divisor)
          const resto = num - cientos * divisor

          const strMillones = Seccion(num, divisor, 'UN MILLON DE', 'MILLONES DE')
          const strMiles = Miles(resto)

          if (strMillones === '') return strMiles

          return strMillones + ' ' + strMiles
        } // Millones()
      },



      dateFormater(d, f = 'DD/MM/YYYY HH:mm') {
        return (dayjs(d).format(f) == 'Invalid Date') ? '-' : dayjs(d).format(f)
      },
      timeFormater(d) {
        return dayjs(d).format('HH:mm')
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
      }
    },
    computed: {
      listadoSupermercadoDistinct() {
        if (this.supemercados.length == 0) {
          return []
        }
        const valoresUnicos = new Set();
        this.supemercados.forEach(objeto => {
          valoresUnicos.add(objeto.BZIRK);
        });

        const valoresUnicosArray = [...valoresUnicos];

        return valoresUnicosArray.sort();
      },
      seleccionados() {
        return this.registros.filter(r => r.seleccionado);
      },
      registrosFiltrado() {
        let data = this.registros
        /*data.forEach(ea => {
          
          ea.gestion = (this.getSupermercado(ea.cod_gen_dte).BZIRK)?this.getSupermercado(ea.cod_gen_dte).BZIRK:'';
          
        });*/

        if (this.correoFiltro != '') {
          if (this.correoFiltro == '0') {
            data = data.filter(r => r.correo_enviado == 0);
          }
          if (this.correoFiltro == '1') {
            data = data.filter(r => r.correo_enviado == 1);
          }
        }
        if (this.tipoDocumentoFiltro != '') {
          if (this.tipoDocumentoFiltro == '01') {
            data = data.filter(r => r.tipo_dte == '01');
          }
          if (this.tipoDocumentoFiltro == '03') {
            data = data.filter(r => r.tipo_dte == '03');
          }
          if (this.tipoDocumentoFiltro == '05') {
            data = data.filter(r => r.tipo_dte == "05");
          }
          if (this.tipoDocumentoFiltro == '11') {
            data = data.filter(r => r.tipo_dte == "11");
          }
        }
        if (this.supermercadosFiltro != '') {
          let facturas = this.supemercados.filter(s => s.BZIRK == this.supermercadosFiltro).map(t => t.CAMPO1);
          data = data.filter(r => facturas.includes(r.cod_gen_dte));
        }

        if (this.listadoRegionesAFiltrar.length > 0) {
          data = data.filter(r => this.listadoRegionesAFiltrar.includes(r.gestion));
        }


        if (this.busqueda.length > 0) {
          return data.filter(b => (
            (b.cod_gen_dte.includes(this.busqueda.toUpperCase())) ||
            (b.comercial?.toUpperCase().includes(this.busqueda?.toUpperCase())) ||
            ((this.dateFormater(b.fecha, 'DD/MM/YYYY')).includes(this.busqueda)) ||
            (b.nombre?.toUpperCase().includes(this.busqueda.toUpperCase())) ||
            (b.valor?.includes(this.busqueda))

          ))
        }
        return data
      },
      paraSincronizar() {
        if (this.supemercados.length == 0) {
          return [];
        }

        //let resultadoFiltrado = this.supemercados.filter(item => item.BZIRK.startsWith("SUP") || item.BZIRK.startsWith("SSM") || item.BZIRK.startsWith("INS"));
        let resultadoFiltrado = []
        this.supemercados.forEach(d => {
          if (!this.registros.map(r => r.cod_gen_dte).includes(d.CAMPO1)) {
            resultadoFiltrado.push(d)
          }

        });
        return resultadoFiltrado
      }
    },
    mounted() {
      //this.loading = false;
      //this.getSupermercados();
      this.getCodigoBarras();
      this.getDepartamentos();
      this.getMunicipios();
      this.getRegistros();
    },
    watch: {
      gestion(d) {
        if (d !== '') {
          const rangeMatch = d.match(/(\w+)(\d+)-(\d+)/);

          if (rangeMatch) {

            //const prefix = rangeMatch[1];
            const prefix = d.substr(0, 3);
            const start = parseInt(rangeMatch[2], 10);
            const end = parseInt(rangeMatch[3], 10);

            this.listadoRegionesAFiltrar = this.listadoSupermercadoDistinct.filter(r => {
              let rr = r.replace('DET', '').replace('INS', '').replace('SUP', '').replace('SSM', '').replace('MER', '').replace('PSM', '').replace('DSM', '').replace('SPL', '').replace('SPS', '')
              //console.log(parseInt(rr) +" >= "+start+" && "+ parseInt(rr)+" <="+ end);
              return (r.startsWith(prefix) && parseInt(rr) >= start && parseInt(rr) <= end);
            });
            /*
            this.listadoRegionesAFiltrar = this.listadoSupermercadoDistinct.filter(r => {
              const match = r.match(/^(\w+)(\d+)$/);
              if (match) {
                const regionPrefix = match[1];
                const regionNumber = parseInt(match[2], 10);
                return (
                  regionPrefix === prefix && regionNumber >= start && regionNumber <= end
                );
              } else {
                return false;
              }
            });*/


          } else {
            this.listadoRegionesAFiltrar = this.listadoSupermercadoDistinct.filter(r => r.includes(d.toUpperCase()));
          }
        } else {
          this.listadoRegionesAFiltrar = [];
        }
      }
    }
  });


  // Method to upload a valid excel file
  function upload() {
    if (document.getElementById('file_upload').value == "") {
      return
    }
    var files = document.getElementById('file_upload').files;
    if (files.length == 0) {
      alert("Seleccione un documento");
      app.cvs = []
      limpiar()
      return;
    }
    var filename = files[0].name;
    var extension = filename.substring(filename.lastIndexOf(".")).toUpperCase();
    if (extension == '.XLS' || extension == '.XLSX') {
      excelFileToJSON(files[0]);
    } else {
      alert("Seleccione un documento valido.");
      app.cvs = []
      limpiar()
    }
  }

  function limpiar() {
    document.getElementById('file_upload').value = ""
  }

  //Method to read excel file and convert it into JSON 
  function excelFileToJSON(file) {
    try {
      var reader = new FileReader();
      reader.readAsBinaryString(file);
      reader.onload = function(e) {

        var data = e.target.result;
        var workbook = XLSX.read(data, {
          type: 'binary'
        });
        var result = {};
        workbook.SheetNames.forEach(function(sheetName) {
          var roa = XLSX.utils.sheet_to_row_object_array(workbook.Sheets[sheetName]);
          if (roa.length > 0) {
            result[sheetName] = roa;
          }
        });
        //displaying the json result
        //var resultEle = document.getElementById("json-result");
        app.cvs = result[Object.keys(result)]
        //resultEle.value = JSON.stringify(result, null, 4);
        //resultEle.style.display = 'block';
        limpiar()
      }
    } catch (e) {
      console.error(e);
      limpiar()
      app.cvs = []
    }
  }



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

<script>
  function generarQR(texto) {

    // Crear un elemento <div> temporal para generar el código QR
    const divTemporal = document.createElement("div");
    const codigoQR = new QRCode(divTemporal, {
      text: texto,
      width: 128,
      height: 128,
    });

    // Acceder al elemento <canvas> generado
    const canvasElement = divTemporal.querySelector("canvas");

    // Convertir el elemento <canvas> en base64
    const codigoQRBase64 = canvasElement.toDataURL("image/png");

    // Eliminar el elemento temporal
    //document.body.removeChild(divTemporal);

    return codigoQRBase64;
  }
</script>
@endverbatim
@endsection