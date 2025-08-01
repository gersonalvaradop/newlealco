<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/pdfmake.min.js" integrity="sha512-rDbVu5s98lzXZsmJoMa0DjHNE+RwPJACogUCLyq3Xxm2kJO6qsQwjbE5NDk2DqmlKcxDirCnU1wAzVLe12IM3w==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.5/vfs_fonts.js" integrity="sha512-cktKDgjEiIkPVHYbn8bh/FEyYxmt4JDJJjOCu5/FQAkW4bc911XtKYValiyzBiJigjVEvrIAyQFEbRJZyDA1wQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.14/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jsbarcode@3.11.0/dist/JsBarcode.all.min.js"></script>
    <script src="https://cdn.rawgit.com/davidshimjs/qrcodejs/gh-pages/qrcode.min.js"></script>
</head>

<body>
    <div id="qrcode" class="d-none"></div>
    <div id="app"></div>
    <img id="barcode" />

    <script>
        const logo = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP89+/vTwAJ7wP0OgfquAAAAABJRU5ErkJggg==";
        const logo_trasparente = "data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAYAAAAfFcSJAAAADUlEQVR42mP89+/vTwAJ7wP0OgfquAAAAABJRU5ErkJggg=="

        let app = new Vue({
            el: '#app',
            data: {
                info: [],
                departamentos: [{
                        "id": "1",
                        "codigo": "01",
                        "valor": "Ahuachapán "
                    },
                    {
                        "id": "2",
                        "codigo": "02",
                        "valor": "Santa Ana "
                    },
                    {
                        "id": "3",
                        "codigo": "03",
                        "valor": "Sonsonate "
                    },
                    {
                        "id": "4",
                        "codigo": "04",
                        "valor": "Chalatenango "
                    },
                    {
                        "id": "5",
                        "codigo": "05",
                        "valor": "La Libertad "
                    },
                    {
                        "id": "6",
                        "codigo": "06",
                        "valor": "San Salvador "
                    },
                    {
                        "id": "7",
                        "codigo": "07",
                        "valor": "Cuscatlán "
                    },
                    {
                        "id": "8",
                        "codigo": "08",
                        "valor": "La Paz "
                    },
                    {
                        "id": "9",
                        "codigo": "09",
                        "valor": "Cabañas "
                    },
                    {
                        "id": "10",
                        "codigo": "10",
                        "valor": "San Vicente "
                    },
                    {
                        "id": "11",
                        "codigo": "11",
                        "valor": "Usulután "
                    },
                    {
                        "id": "12",
                        "codigo": "12",
                        "valor": "San Miguel "
                    },
                    {
                        "id": "13",
                        "codigo": "13",
                        "valor": "Morazán "
                    },
                    {
                        "id": "14",
                        "codigo": "14",
                        "valor": "La Unión"
                    }
                ],
                municipios: [{
                        "id": "2",
                        "codigo": "01",
                        "valor": "AHUACHAPÁN ",
                        "cod_departamento": "01"
                    },
                    {
                        "id": "3",
                        "codigo": "02",
                        "valor": "APANECA ",
                        "cod_departamento": "01"
                    },
                    {
                        "id": "4",
                        "codigo": "03",
                        "valor": "ATIQUIZAYA ",
                        "cod_departamento": "01"
                    },
                    {
                        "id": "5",
                        "codigo": "04",
                        "valor": "CONCEPCIÓN DE ATACO ",
                        "cod_departamento": "01"
                    },
                    {
                        "id": "6",
                        "codigo": "05",
                        "valor": "EL REFUGIO ",
                        "cod_departamento": "01"
                    },
                    {
                        "id": "7",
                        "codigo": "06",
                        "valor": "GUAYMANGO ",
                        "cod_departamento": "01"
                    },
                    {
                        "id": "8",
                        "codigo": "07",
                        "valor": "JUJUTLA ",
                        "cod_departamento": "01"
                    },
                    {
                        "id": "9",
                        "codigo": "08",
                        "valor": "SAN FRANCISCO MENÉNDEZ ",
                        "cod_departamento": "01"
                    },
                    {
                        "id": "10",
                        "codigo": "09",
                        "valor": "SAN LORENZO ",
                        "cod_departamento": "01"
                    },
                    {
                        "id": "11",
                        "codigo": "10",
                        "valor": "SAN PEDRO PUXTLA ",
                        "cod_departamento": "01"
                    },
                    {
                        "id": "12",
                        "codigo": "11",
                        "valor": "TACUBA ",
                        "cod_departamento": "01"
                    },
                    {
                        "id": "13",
                        "codigo": "12",
                        "valor": "TURÍN ",
                        "cod_departamento": "01"
                    },
                    {
                        "id": "14",
                        "codigo": "01",
                        "valor": "CANDELARIA DE LA FRONTERA ",
                        "cod_departamento": "02"
                    },
                    {
                        "id": "15",
                        "codigo": "02",
                        "valor": "COATEPEQUE ",
                        "cod_departamento": "02"
                    },
                    {
                        "id": "16",
                        "codigo": "03",
                        "valor": "CHALCHUAPA ",
                        "cod_departamento": "02"
                    },
                    {
                        "id": "17",
                        "codigo": "04",
                        "valor": "EL CONGO ",
                        "cod_departamento": "02"
                    },
                    {
                        "id": "18",
                        "codigo": "05",
                        "valor": "EL PORVENIR ",
                        "cod_departamento": "02"
                    },
                    {
                        "id": "19",
                        "codigo": "06",
                        "valor": "MASAHUAT ",
                        "cod_departamento": "02"
                    },
                    {
                        "id": "20",
                        "codigo": "07",
                        "valor": "METAPÁN ",
                        "cod_departamento": "02"
                    },
                    {
                        "id": "21",
                        "codigo": "08",
                        "valor": "SAN ANTONIO PAJONAL ",
                        "cod_departamento": "02"
                    },
                    {
                        "id": "22",
                        "codigo": "09",
                        "valor": "SAN SEBASTIÁN SALITRILLO ",
                        "cod_departamento": "02"
                    },
                    {
                        "id": "23",
                        "codigo": "10",
                        "valor": "SANTA ANA ",
                        "cod_departamento": "02"
                    },
                    {
                        "id": "24",
                        "codigo": "11",
                        "valor": "STA ROSA GUACHI ",
                        "cod_departamento": "02"
                    },
                    {
                        "id": "25",
                        "codigo": "12",
                        "valor": "STGO D LA FRONT ",
                        "cod_departamento": "02"
                    },
                    {
                        "id": "26",
                        "codigo": "13",
                        "valor": "TEXISTEPEQUE ",
                        "cod_departamento": "02"
                    },
                    {
                        "id": "27",
                        "codigo": "01",
                        "valor": "ACAJUTLA ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "28",
                        "codigo": "02",
                        "valor": "ARMENIA ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "29",
                        "codigo": "03",
                        "valor": "CALUCO ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "30",
                        "codigo": "04",
                        "valor": "CUISNAHUAT ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "31",
                        "codigo": "05",
                        "valor": "STA I ISHUATAN ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "32",
                        "codigo": "06",
                        "valor": "IZALCO ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "33",
                        "codigo": "07",
                        "valor": "JUAYÚA ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "34",
                        "codigo": "08",
                        "valor": "NAHUIZALCO ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "35",
                        "codigo": "09",
                        "valor": "NAHULINGO ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "36",
                        "codigo": "10",
                        "valor": "SALCOATITÁN ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "37",
                        "codigo": "11",
                        "valor": "SAN ANTONIO DEL MONTE ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "38",
                        "codigo": "12",
                        "valor": "SAN JULIÁN ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "39",
                        "codigo": "13",
                        "valor": "STA C MASAHUAT ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "40",
                        "codigo": "14",
                        "valor": "SANTO DOMINGO GUZMÁN ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "41",
                        "codigo": "15",
                        "valor": "SONSONATE ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "42",
                        "codigo": "16",
                        "valor": "SONZACATE ",
                        "cod_departamento": "03"
                    },
                    {
                        "id": "43",
                        "codigo": "01",
                        "valor": "AGUA CALIENTE ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "44",
                        "codigo": "02",
                        "valor": "ARCATAO ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "45",
                        "codigo": "03",
                        "valor": "AZACUALPA ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "46",
                        "codigo": "04",
                        "valor": "CITALÁ ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "47",
                        "codigo": "05",
                        "valor": "COMALAPA ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "48",
                        "codigo": "06",
                        "valor": "CONCEPCIÓN QUEZALTEPEQUE ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "49",
                        "codigo": "07",
                        "valor": "CHALATENANGO ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "50",
                        "codigo": "08",
                        "valor": "DULCE NOM MARÍA ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "51",
                        "codigo": "09",
                        "valor": "EL CARRIZAL ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "52",
                        "codigo": "10",
                        "valor": "EL PARAÍSO ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "53",
                        "codigo": "11",
                        "valor": "LA LAGUNA ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "54",
                        "codigo": "12",
                        "valor": "LA PALMA ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "55",
                        "codigo": "13",
                        "valor": "LA REINA ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "56",
                        "codigo": "14",
                        "valor": "LAS VUELTAS ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "57",
                        "codigo": "15",
                        "valor": "NOMBRE DE JESUS ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "58",
                        "codigo": "16",
                        "valor": "NVA CONCEPCIÓN ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "59",
                        "codigo": "17",
                        "valor": "NUEVA TRINIDAD ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "60",
                        "codigo": "18",
                        "valor": "OJOS DE AGUA ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "61",
                        "codigo": "19",
                        "valor": "POTONICO ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "62",
                        "codigo": "20",
                        "valor": "SAN ANT LA CRUZ ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "63",
                        "codigo": "21",
                        "valor": "SAN ANT RANCHOS ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "64",
                        "codigo": "22",
                        "valor": "SAN FERNANDO ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "65",
                        "codigo": "23",
                        "valor": "SAN FRANCISCO LEMPA ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "66",
                        "codigo": "24",
                        "valor": "SAN FRANCISCO MORAZÁN ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "67",
                        "codigo": "25",
                        "valor": "SAN IGNACIO ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "68",
                        "codigo": "26",
                        "valor": "SAN I LABRADOR ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "69",
                        "codigo": "27",
                        "valor": "SAN J CANCASQUE ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "70",
                        "codigo": "28",
                        "valor": "SAN JOSE FLORES ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "71",
                        "codigo": "29",
                        "valor": "SAN LUIS CARMEN ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "72",
                        "codigo": "30",
                        "valor": "SN MIG MERCEDES ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "73",
                        "codigo": "31",
                        "valor": "SAN RAFAEL ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "74",
                        "codigo": "32",
                        "valor": "SANTA RITA ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "75",
                        "codigo": "33",
                        "valor": "TEJUTLA ",
                        "cod_departamento": "04"
                    },
                    {
                        "id": "76",
                        "codigo": "01",
                        "valor": "ANTGO CUSCATLÁN ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "77",
                        "codigo": "02",
                        "valor": "CIUDAD ARCE ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "78",
                        "codigo": "03",
                        "valor": "COLON ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "79",
                        "codigo": "04",
                        "valor": "COMASAGUA ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "80",
                        "codigo": "05",
                        "valor": "CHILTIUPAN ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "81",
                        "codigo": "06",
                        "valor": "HUIZÚCAR ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "82",
                        "codigo": "07",
                        "valor": "JAYAQUE ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "83",
                        "codigo": "08",
                        "valor": "JICALAPA ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "84",
                        "codigo": "09",
                        "valor": "LA LIBERTAD ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "85",
                        "codigo": "10",
                        "valor": "NUEVO CUSCATLÁN ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "86",
                        "codigo": "11",
                        "valor": "SANTA TECLA ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "87",
                        "codigo": "12",
                        "valor": "QUEZALTEPEQUE ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "88",
                        "codigo": "13",
                        "valor": "SACACOYO ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "89",
                        "codigo": "14",
                        "valor": "SN J VILLANUEVA ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "90",
                        "codigo": "15",
                        "valor": "SAN JUAN OPICO ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "91",
                        "codigo": "16",
                        "valor": "SAN MATÍAS ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "92",
                        "codigo": "17",
                        "valor": "SAN P TACACHICO ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "93",
                        "codigo": "18",
                        "valor": "TAMANIQUE ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "94",
                        "codigo": "19",
                        "valor": "TALNIQUE ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "95",
                        "codigo": "20",
                        "valor": "TEOTEPEQUE ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "96",
                        "codigo": "21",
                        "valor": "TEPECOYO ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "97",
                        "codigo": "22",
                        "valor": "ZARAGOZA ",
                        "cod_departamento": "05"
                    },
                    {
                        "id": "98",
                        "codigo": "01",
                        "valor": "AGUILARES ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "99",
                        "codigo": "02",
                        "valor": "APOPA ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "100",
                        "codigo": "03",
                        "valor": "AYUTUXTEPEQUE ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "101",
                        "codigo": "04",
                        "valor": "CUSCATANCINGO ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "102",
                        "codigo": "05",
                        "valor": "EL PAISNAL ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "103",
                        "codigo": "06",
                        "valor": "GUAZAPA ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "104",
                        "codigo": "07",
                        "valor": "ILOPANGO ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "105",
                        "codigo": "08",
                        "valor": "MEJICANOS ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "106",
                        "codigo": "09",
                        "valor": "NEJAPA ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "107",
                        "codigo": "10",
                        "valor": "PANCHIMALCO ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "108",
                        "codigo": "11",
                        "valor": "ROSARIO DE MORA ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "109",
                        "codigo": "12",
                        "valor": "SAN MARCOS ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "110",
                        "codigo": "13",
                        "valor": "SAN MARTIN ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "111",
                        "codigo": "14",
                        "valor": "SAN SALVADOR ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "112",
                        "codigo": "15",
                        "valor": "STG TEXACUANGOS ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "113",
                        "codigo": "16",
                        "valor": "SANTO TOMAS ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "114",
                        "codigo": "17",
                        "valor": "SOYAPANGO ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "115",
                        "codigo": "18",
                        "valor": "TONACATEPEQUE ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "116",
                        "codigo": "19",
                        "valor": "CIUDAD DELGADO ",
                        "cod_departamento": "06"
                    },
                    {
                        "id": "117",
                        "codigo": "01",
                        "valor": "CANDELARIA ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "118",
                        "codigo": "02",
                        "valor": "COJUTEPEQUE ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "119",
                        "codigo": "03",
                        "valor": "EL CARMEN ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "120",
                        "codigo": "04",
                        "valor": "EL ROSARIO ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "121",
                        "codigo": "05",
                        "valor": "MONTE SAN JUAN ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "122",
                        "codigo": "06",
                        "valor": "ORAT CONCEPCIÓN ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "123",
                        "codigo": "07",
                        "valor": "SAN B PERULAPIA ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "124",
                        "codigo": "08",
                        "valor": "SAN CRISTÓBAL ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "125",
                        "codigo": "09",
                        "valor": "SAN J GUAYABAL ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "126",
                        "codigo": "10",
                        "valor": "SAN P PERULAPÁN ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "127",
                        "codigo": "11",
                        "valor": "SAN RAF CEDROS ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "128",
                        "codigo": "12",
                        "valor": "SAN RAMON ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "129",
                        "codigo": "13",
                        "valor": "STA C ANALQUITO ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "130",
                        "codigo": "14",
                        "valor": "STA C MICHAPA ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "131",
                        "codigo": "15",
                        "valor": "SUCHITOTO ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "132",
                        "codigo": "16",
                        "valor": "TENANCINGO ",
                        "cod_departamento": "07"
                    },
                    {
                        "id": "133",
                        "codigo": "01",
                        "valor": "CUYULTITÁN ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "134",
                        "codigo": "02",
                        "valor": "EL ROSARIO ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "135",
                        "codigo": "03",
                        "valor": "JERUSALÉN ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "136",
                        "codigo": "04",
                        "valor": "MERCED LA CEIBA ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "137",
                        "codigo": "05",
                        "valor": "OLOCUILTA ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "138",
                        "codigo": "06",
                        "valor": "PARAÍSO OSORIO ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "139",
                        "codigo": "07",
                        "valor": "SN ANT MASAHUAT ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "140",
                        "codigo": "08",
                        "valor": "SAN EMIGDIO ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "141",
                        "codigo": "09",
                        "valor": "SN FCO CHINAMEC ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "142",
                        "codigo": "10",
                        "valor": "SAN J NONUALCO ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "143",
                        "codigo": "11",
                        "valor": "SAN JUAN TALPA ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "144",
                        "codigo": "12",
                        "valor": "SAN JUAN TEPEZONTES ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "145",
                        "codigo": "13",
                        "valor": "SAN LUIS TALPA ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "146",
                        "codigo": "14",
                        "valor": "SAN MIGUEL TEPEZONTES ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "147",
                        "codigo": "15",
                        "valor": "SAN PEDRO MASAHUAT ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "148",
                        "codigo": "16",
                        "valor": "SAN PEDRO NONUALCO ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "149",
                        "codigo": "17",
                        "valor": "SAN R OBRAJUELO ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "150",
                        "codigo": "18",
                        "valor": "STA MA OSTUMA ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "151",
                        "codigo": "19",
                        "valor": "STGO NONUALCO ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "152",
                        "codigo": "20",
                        "valor": "TAPALHUACA ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "153",
                        "codigo": "21",
                        "valor": "ZACATECOLUCA ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "154",
                        "codigo": "22",
                        "valor": "SN LUIS LA HERR ",
                        "cod_departamento": "08"
                    },
                    {
                        "id": "155",
                        "codigo": "01",
                        "valor": "CINQUERA ",
                        "cod_departamento": "09"
                    },
                    {
                        "id": "156",
                        "codigo": "02",
                        "valor": "GUACOTECTI ",
                        "cod_departamento": "09"
                    },
                    {
                        "id": "157",
                        "codigo": "03",
                        "valor": "ILOBASCO ",
                        "cod_departamento": "09"
                    },
                    {
                        "id": "158",
                        "codigo": "04",
                        "valor": "JUTIAPA ",
                        "cod_departamento": "09"
                    },
                    {
                        "id": "159",
                        "codigo": "05",
                        "valor": "SAN ISIDRO ",
                        "cod_departamento": "09"
                    },
                    {
                        "id": "160",
                        "codigo": "06",
                        "valor": "SENSUNTEPEQUE ",
                        "cod_departamento": "09"
                    },
                    {
                        "id": "161",
                        "codigo": "07",
                        "valor": "TEJUTEPEQUE ",
                        "cod_departamento": "09"
                    },
                    {
                        "id": "162",
                        "codigo": "08",
                        "valor": "VICTORIA ",
                        "cod_departamento": "09"
                    },
                    {
                        "id": "163",
                        "codigo": "09",
                        "valor": "DOLORES ",
                        "cod_departamento": "09"
                    },
                    {
                        "id": "164",
                        "codigo": "01",
                        "valor": "APASTEPEQUE ",
                        "cod_departamento": "10"
                    },
                    {
                        "id": "165",
                        "codigo": "02",
                        "valor": "GUADALUPE ",
                        "cod_departamento": "10"
                    },
                    {
                        "id": "166",
                        "codigo": "03",
                        "valor": "SAN CAY ISTEPEQ ",
                        "cod_departamento": "10"
                    },
                    {
                        "id": "167",
                        "codigo": "04",
                        "valor": "SANTA CLARA ",
                        "cod_departamento": "10"
                    },
                    {
                        "id": "168",
                        "codigo": "05",
                        "valor": "SANTO DOMINGO ",
                        "cod_departamento": "10"
                    },
                    {
                        "id": "169",
                        "codigo": "06",
                        "valor": "SN EST CATARINA ",
                        "cod_departamento": "10"
                    },
                    {
                        "id": "170",
                        "codigo": "07",
                        "valor": "SAN ILDEFONSO ",
                        "cod_departamento": "10"
                    },
                    {
                        "id": "171",
                        "codigo": "08",
                        "valor": "SAN LORENZO ",
                        "cod_departamento": "10"
                    },
                    {
                        "id": "172",
                        "codigo": "09",
                        "valor": "SAN SEBASTIÁN ",
                        "cod_departamento": "10"
                    },
                    {
                        "id": "173",
                        "codigo": "10",
                        "valor": "SAN VICENTE ",
                        "cod_departamento": "10"
                    },
                    {
                        "id": "174",
                        "codigo": "11",
                        "valor": "TECOLUCA ",
                        "cod_departamento": "10"
                    },
                    {
                        "id": "175",
                        "codigo": "12",
                        "valor": "TEPETITÁN ",
                        "cod_departamento": "10"
                    },
                    {
                        "id": "176",
                        "codigo": "13",
                        "valor": "VERAPAZ ",
                        "cod_departamento": "10"
                    },
                    {
                        "id": "177",
                        "codigo": "01",
                        "valor": "ALEGRÍA ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "178",
                        "codigo": "02",
                        "valor": "BERLÍN ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "179",
                        "codigo": "03",
                        "valor": "CALIFORNIA ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "180",
                        "codigo": "04",
                        "valor": "CONCEP BATRES ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "181",
                        "codigo": "05",
                        "valor": "EL TRIUNFO ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "182",
                        "codigo": "06",
                        "valor": "EREGUAYQUÍN ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "183",
                        "codigo": "07",
                        "valor": "ESTANZUELAS ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "184",
                        "codigo": "08",
                        "valor": "JIQUILISCO ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "185",
                        "codigo": "09",
                        "valor": "JUCUAPA ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "186",
                        "codigo": "10",
                        "valor": "JUCUARÁN ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "187",
                        "codigo": "11",
                        "valor": "MERCEDES UMAÑA ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "188",
                        "codigo": "12",
                        "valor": "NUEVA GRANADA ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "189",
                        "codigo": "13",
                        "valor": "OZATLÁN ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "190",
                        "codigo": "14",
                        "valor": "PTO EL TRIUNFO ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "191",
                        "codigo": "15",
                        "valor": "SAN AGUSTÍN ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "192",
                        "codigo": "16",
                        "valor": "SN BUENAVENTURA ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "193",
                        "codigo": "17",
                        "valor": "SAN DIONISIO ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "194",
                        "codigo": "18",
                        "valor": "SANTA ELENA ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "195",
                        "codigo": "19",
                        "valor": "SAN FCO JAVIER ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "196",
                        "codigo": "20",
                        "valor": "SANTA MARÍA ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "197",
                        "codigo": "21",
                        "valor": "STGO DE MARÍA ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "198",
                        "codigo": "22",
                        "valor": "TECAPÁN ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "199",
                        "codigo": "23",
                        "valor": "USULUTÁN ",
                        "cod_departamento": "11"
                    },
                    {
                        "id": "200",
                        "codigo": "01",
                        "valor": "CAROLINA ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "201",
                        "codigo": "02",
                        "valor": "CIUDAD BARRIOS ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "202",
                        "codigo": "03",
                        "valor": "COMACARÁN ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "203",
                        "codigo": "04",
                        "valor": "CHAPELTIQUE ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "204",
                        "codigo": "05",
                        "valor": "CHINAMECA ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "205",
                        "codigo": "06",
                        "valor": "CHIRILAGUA ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "206",
                        "codigo": "07",
                        "valor": "EL TRANSITO ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "207",
                        "codigo": "08",
                        "valor": "LOLOTIQUE ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "208",
                        "codigo": "09",
                        "valor": "MONCAGUA ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "209",
                        "codigo": "10",
                        "valor": "NUEVA GUADALUPE ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "210",
                        "codigo": "11",
                        "valor": "NVO EDÉN S JUAN ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "211",
                        "codigo": "12",
                        "valor": "QUELEPA ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "212",
                        "codigo": "13",
                        "valor": "SAN ANT D MOSCO ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "213",
                        "codigo": "14",
                        "valor": "SAN GERARDO ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "214",
                        "codigo": "15",
                        "valor": "SAN JORGE ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "215",
                        "codigo": "16",
                        "valor": "SAN LUIS REINA ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "216",
                        "codigo": "17",
                        "valor": "SAN MIGUEL ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "217",
                        "codigo": "18",
                        "valor": "SAN RAF ORIENTE ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "218",
                        "codigo": "19",
                        "valor": "SESORI ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "219",
                        "codigo": "20",
                        "valor": "ULUAZAPA ",
                        "cod_departamento": "12"
                    },
                    {
                        "id": "220",
                        "codigo": "01",
                        "valor": "ARAMBALA ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "221",
                        "codigo": "02",
                        "valor": "CACAOPERA ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "222",
                        "codigo": "03",
                        "valor": "CORINTO ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "223",
                        "codigo": "04",
                        "valor": "CHILANGA ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "224",
                        "codigo": "05",
                        "valor": "DELIC DE CONCEP ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "225",
                        "codigo": "06",
                        "valor": "EL DIVISADERO ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "226",
                        "codigo": "07",
                        "valor": "EL ROSARIO ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "227",
                        "codigo": "08",
                        "valor": "GUALOCOCTI ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "228",
                        "codigo": "09",
                        "valor": "GUATAJIAGUA ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "229",
                        "codigo": "10",
                        "valor": "JOATECA ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "230",
                        "codigo": "11",
                        "valor": "JOCOAITIQUE ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "231",
                        "codigo": "12",
                        "valor": "JOCORO ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "232",
                        "codigo": "13",
                        "valor": "LOLOTIQUILLO ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "233",
                        "codigo": "14",
                        "valor": "MEANGUERA ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "234",
                        "codigo": "15",
                        "valor": "OSICALA ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "235",
                        "codigo": "16",
                        "valor": "PERQUÍN ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "236",
                        "codigo": "17",
                        "valor": "SAN CARLOS ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "238",
                        "codigo": "19",
                        "valor": "SAN FCO GOTERA ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "239",
                        "codigo": "20",
                        "valor": "SAN ISIDRO ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "240",
                        "codigo": "21",
                        "valor": "SAN SIMÓN ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "241",
                        "codigo": "22",
                        "valor": "SENSEMBRA ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "242",
                        "codigo": "23",
                        "valor": "SOCIEDAD ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "243",
                        "codigo": "24",
                        "valor": "TOROLA ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "244",
                        "codigo": "25",
                        "valor": "YAMABAL ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "245",
                        "codigo": "26",
                        "valor": "YOLOAIQUÍN ",
                        "cod_departamento": "13"
                    },
                    {
                        "id": "246",
                        "codigo": "01",
                        "valor": "ANAMOROS ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "247",
                        "codigo": "02",
                        "valor": "BOLÍVAR ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "248",
                        "codigo": "03",
                        "valor": "CONCEP DE OTE ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "249",
                        "codigo": "04",
                        "valor": "CONCHAGUA ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "250",
                        "codigo": "05",
                        "valor": "EL CARMEN ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "251",
                        "codigo": "06",
                        "valor": "EL SAUCE ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "252",
                        "codigo": "07",
                        "valor": "INTIPUCÁ ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "253",
                        "codigo": "08",
                        "valor": "LA UNIÓN ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "254",
                        "codigo": "09",
                        "valor": "LISLIQUE ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "255",
                        "codigo": "10",
                        "valor": "MEANG DEL GOLFO ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "256",
                        "codigo": "11",
                        "valor": "NUEVA ESPARTA ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "257",
                        "codigo": "12",
                        "valor": "PASAQUINA ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "258",
                        "codigo": "13",
                        "valor": "POLORÓS ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "259",
                        "codigo": "14",
                        "valor": "SAN ALEJO ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "260",
                        "codigo": "15",
                        "valor": "SAN JOSE ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "261",
                        "codigo": "16",
                        "valor": "SANTA ROSA LIMA ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "262",
                        "codigo": "17",
                        "valor": "YAYANTIQUE ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "263",
                        "codigo": "18",
                        "valor": "YUCUAIQUÍN ",
                        "cod_departamento": "14"
                    },
                    {
                        "id": "237",
                        "codigo": "18",
                        "valor": "SAN FERNANDO ",
                        "cod_departamento": "13"
                    }
                ],
                supemercados:[ { "VBELN": "0071388900", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000269", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS AHUACHAPAN", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2034200.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025047", "TEL_NUMBER": "", "CAMPO1": "E6563A46-C8BC-4F22-9E77-B91DB03AF286", "CAMPO2": "2023FF5E9289948847F2B17383F01EAFBDF0CNOU", "CAMPO4": "" }, { "VBELN": "0071388901", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000269", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS AHUACHAPAN", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "3157180.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025047", "TEL_NUMBER": "", "CAMPO1": "DEEFA006-2DB8-4D84-A08D-3ACD6E6FE5A9", "CAMPO2": "2023DB3CCAF97240410F908F98AFA57DD93D7HXY", "CAMPO4": "" }, { "VBELN": "0071388902", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000317", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CIUDAD REAL", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1394490.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025095", "TEL_NUMBER": "", "CAMPO1": "F41DBD6B-3738-4DD7-8E6E-58F117D97E20", "CAMPO2": "20238AEEA509C2814117B96F24E457A7EEF5ES8X", "CAMPO4": "" }, { "VBELN": "0071388903", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000342", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS AHUACHAPAN II", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1972470.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025120", "TEL_NUMBER": "", "CAMPO1": "66C8F44C-2269-48EC-941D-04D3F7D2D287", "CAMPO2": "2023857F7E3E12CF4674840F98F0FFAA458CZ2DH", "CAMPO4": "" }, { "VBELN": "0071388904", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000344", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS CHALCHUAPA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "500160.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025122", "TEL_NUMBER": "", "CAMPO1": "B3A12CC9-43D1-464D-B0AC-9974E04C4ABD", "CAMPO2": "2023405777989AD04EF7B89B8E9B2890864BZAHB", "CAMPO4": "" }, { "VBELN": "0071388905", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000344", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS CHALCHUAPA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2018420.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025122", "TEL_NUMBER": "", "CAMPO1": "4C43EBBE-E908-4B8C-94A7-9C482DBE40AA", "CAMPO2": "2023BED1E177D7384922A26F86D9974C3793QQ8V", "CAMPO4": "" }, { "VBELN": "0071388906", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000397", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF AHUACHAPAN", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1527910.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025175", "TEL_NUMBER": "", "CAMPO1": "E81664E3-F9D8-4CF2-B852-7855663039E0", "CAMPO2": "20238DF03CE518B0472285CB8549DDEF7F066BFR", "CAMPO4": "" }, { "VBELN": "0071388907", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000400", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF ATIQUIZAYA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1066990.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025178", "TEL_NUMBER": "", "CAMPO1": "48F4173D-1111-47C5-AED2-5EE499BE7472", "CAMPO2": "2023ED99F23EAA2642C89DD3E961AF7AF4E3S1VI", "CAMPO4": "" }, { "VBELN": "0071388908", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000404", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CHALCHUAPA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1254250.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025182", "TEL_NUMBER": "", "CAMPO1": "96544FEF-32F0-4F82-9304-B81F81110C92", "CAMPO2": "2023DD1425423ABE4F29A8CE71B90401E77EEMLV", "CAMPO4": "" }, { "VBELN": "0071388909", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000449", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "MAXI DESPENSA SANTA ANA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2933110.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025227", "TEL_NUMBER": "", "CAMPO1": "B3F531E2-F018-4BD2-AB4A-7D12FE938481", "CAMPO2": "2023B265A2A2681F4B979195606146FC48E5NT20", "CAMPO4": "" }, { "VBELN": "0071388910", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000023528", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS ATIQUIZAYA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1342980.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000050443", "TEL_NUMBER": "", "CAMPO1": "4F7722A8-BE73-4F6F-A2EF-12F54F572C11", "CAMPO2": "2023737B7C08643649D1AD8021947DCCF2E0XLCQ", "CAMPO4": "" }, { "VBELN": "0071388911", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000026477", "NAME1": "OPERADORA DEL SUR, S.A. DE  C.", "NAME2": "MAXI DESPENSA AHUCHAPAN", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1398320.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000055413", "TEL_NUMBER": "", "CAMPO1": "14DEA658-EC74-442A-83CF-A0F55B48900F", "CAMPO2": "2023AD0CEF6C9809419EAD7AFDA67C8BA78D1Y2J", "CAMPO4": "" }, { "VBELN": "0071388912", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000293", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MERLIOT II", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2281930.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025071", "TEL_NUMBER": "", "CAMPO1": "7713BEB9-F75D-4D7B-80CF-E3B6F70710FB", "CAMPO2": "20239B31BE14F989410BA316075F0E223712KWWK", "CAMPO4": "" }, { "VBELN": "0071388913", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000293", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MERLIOT II", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "24300.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025071", "TEL_NUMBER": "", "CAMPO1": "D67E78FE-4379-4B52-8C40-E6D036C820F7", "CAMPO2": "20235B5DEF2DA5A64650BA24880CC35B6FEF7EH9", "CAMPO4": "" }, { "VBELN": "0071388914", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000293", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MERLIOT II", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "951000.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025071", "TEL_NUMBER": "", "CAMPO1": "4ADD7CC9-1529-4163-A1E6-BFA400D31CFF", "CAMPO2": "2023C11AC5482DC94B78A1503B69731732446ZSJ", "CAMPO4": "" }, { "VBELN": "0071388915", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000300", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS NOVOCENTRO", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1204620.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025078", "TEL_NUMBER": "", "CAMPO1": "E52E4F7B-3F5E-457B-B27D-80BE1EE2E03A", "CAMPO2": "202396C56BA8B44A4F0CA85F13EABFBBA4CDXLGX", "CAMPO4": "" }, { "VBELN": "0071388916", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000302", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS PLAZA MERLIOT", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "649230.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025080", "TEL_NUMBER": "", "CAMPO1": "32A5A7AD-1F84-41A6-B5F7-0F0D3802547F", "CAMPO2": "20235F4D0B6D5E144C6594677AB755F8DFC0UA6D", "CAMPO4": "" }, { "VBELN": "0071388917", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000302", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS PLAZA MERLIOT", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "758910.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025080", "TEL_NUMBER": "", "CAMPO1": "FE84532C-EF1A-443B-90C6-043DACD9B9D8", "CAMPO2": "20237E2A3D8D057D4F2C83F68D5635D9C81EN6YH", "CAMPO4": "" }, { "VBELN": "0071388918", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000323", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA TECLA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1484770.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025101", "TEL_NUMBER": "", "CAMPO1": "DA0FA19D-74C3-465D-8E53-DAB0A63E4E66", "CAMPO2": "20230DB9F82ADA2942428826D134CBF35B96QCQJ", "CAMPO4": "" }, { "VBELN": "0071388919", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000379", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ JARDINES DE LA LIBERTAD", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "539330.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025157", "TEL_NUMBER": "", "CAMPO1": "4A84FC1F-4F07-4E36-A13E-51038EAF3B4E", "CAMPO2": "2023707113C353F34987BE67B460D632D9BEP5AF", "CAMPO4": "" }, { "VBELN": "0071388920", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000379", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ JARDINES DE LA LIBERTAD", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "442240.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025157", "TEL_NUMBER": "", "CAMPO1": "04E4B158-BFEC-47A8-AD0A-D5F80EE803DC", "CAMPO2": "2023A5DB26783EC64931A0601FF2BD98EF16W1DH", "CAMPO4": "" }, { "VBELN": "0071388921", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000421", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SANTA TECLA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "612340.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025199", "TEL_NUMBER": "", "CAMPO1": "64CD9DEC-99C1-4961-95CB-D16209F2E587", "CAMPO2": "202348C29B3601D54B37843CC99B644FD17DEU6G", "CAMPO4": "" }, { "VBELN": "0071388922", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000438", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SAN MARTIN", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "834630.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025216", "TEL_NUMBER": "", "CAMPO1": "11B573C4-5BB5-46EB-A21F-58AB5BA67A7E", "CAMPO2": "2023E3A57F145BB24FEF91D7C79F78157A43WAWI", "CAMPO4": "" }, { "VBELN": "0071388923", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000023672", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ROSA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2992300.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000050677", "TEL_NUMBER": "", "CAMPO1": "677E2E93-41EB-4AF5-8860-011312AD8FAF", "CAMPO2": "2023803E1B4036FF4643A045F7D91C6A2B33XECN", "CAMPO4": "" }, { "VBELN": "0071388924", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000023672", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ROSA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "526980.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000050677", "TEL_NUMBER": "", "CAMPO1": "D4862BBC-9C5F-410D-9889-D97D2C01EA2A", "CAMPO2": "2023B643D3AA49FA442EADC0628C9A49E46DYUFB", "CAMPO4": "" }, { "VBELN": "0071388925", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000274", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS AUTOPISTA SUR", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2666140.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025052", "TEL_NUMBER": "", "CAMPO1": "689B154B-6E81-448F-AC74-D4881202648C", "CAMPO2": "2023AA415A79AF4B4E5C948E6AD7C8C8079FBXDE", "CAMPO4": "" }, { "VBELN": "0071388926", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000282", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA CIMA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2410180.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025060", "TEL_NUMBER": "", "CAMPO1": "2A967271-C76C-45BE-812D-220403B75D08", "CAMPO2": "2023FE74D1D851B3452695A285C17B730B3FPN3J", "CAMPO4": "" }, { "VBELN": "0071388927", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000282", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA CIMA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "31680.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025060", "TEL_NUMBER": "", "CAMPO1": "97A4F4BF-757D-4A48-8683-F9EE1AECD80A", "CAMPO2": "2023991E0323041541E5BC16807330D308EA1TNO", "CAMPO4": "" }, { "VBELN": "0071388928", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000285", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA SULTANA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1298180.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025063", "TEL_NUMBER": "", "CAMPO1": "02FEF038-2014-4971-B76F-B686B78AE5E1", "CAMPO2": "20238DD496A7E7DA4DDC8E483D914E28CB30I74S", "CAMPO4": "" }, { "VBELN": "0071388929", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000285", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA SULTANA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1460140.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025063", "TEL_NUMBER": "", "CAMPO1": "DCB4FA15-1AA6-43CA-8BF2-0DADCD8EBC4D", "CAMPO2": "202358F514E653554DFCAEFD44DDFDC9BFFAZOHE", "CAMPO4": "" }, { "VBELN": "0071388930", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000299", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MULTIPLAZA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "750990.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025077", "TEL_NUMBER": "", "CAMPO1": "2445D866-AC2F-467B-A28F-EB689BCD3F11", "CAMPO2": "20238DD83CA7ABD94E168303BA93902FBCCBKIB9", "CAMPO4": "" }, { "VBELN": "0071388931", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000299", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MULTIPLAZA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "867000.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025077", "TEL_NUMBER": "", "CAMPO1": "055E9E61-B97C-4C68-9C58-CDF21B4DA3E3", "CAMPO2": "202367F91AFB6A7C42169B477686CCEB6CEFWB9K", "CAMPO4": "" }, { "VBELN": "0071388932", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000021876", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ELENA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2137120.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000047424", "TEL_NUMBER": "", "CAMPO1": "8F5FC518-0F17-45D6-A2BD-1FAA7F202F81", "CAMPO2": "2023C99FE91E269B4CCFAD6F3F79F052ED1DWHGZ", "CAMPO4": "" }, { "VBELN": "0071388933", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000021876", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ELENA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "311220.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000047424", "TEL_NUMBER": "", "CAMPO1": "8AF60A68-D321-4645-9E8F-555260ED0F49", "CAMPO2": "20233816D3E73BB947928F18BF783B155AD5LKTY", "CAMPO4": "" }, { "VBELN": "0071388934", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000024357", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LAS CASCADAS", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2400900.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000052048", "TEL_NUMBER": "", "CAMPO1": "7E437BAA-1FF5-4F29-A4FB-2A1212CCBB52", "CAMPO2": "20235F399F0073AC4B57B3563965DAEF1568HGFX", "CAMPO4": "" }, { "VBELN": "0071388935", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000025859", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SANTA ELENA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "331200.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000054717", "TEL_NUMBER": "", "CAMPO1": "3798A502-90D2-49D3-9C87-A56C8C4ED8FB", "CAMPO2": "202350DC452A14DF48B7A2D8E69A5644AA0CTSKQ", "CAMPO4": "" }, { "VBELN": "0071388936", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000025859", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SANTA ELENA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "895380.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000054717", "TEL_NUMBER": "", "CAMPO1": "C1FAB9D7-F1EF-414B-871F-BA8121BBFDFE", "CAMPO2": "2023DAD0B60FC40E41889238BA7FE55F2146LCSZ", "CAMPO4": "" }, { "VBELN": "0071388937", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000025859", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SANTA ELENA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "3530140.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000054717", "TEL_NUMBER": "", "CAMPO1": "BA31FFC6-A477-42E5-8B12-B1883EE019EF", "CAMPO2": "2023351238DF77974ADF956C7BC450BF5B27DLVG", "CAMPO4": "" }, { "VBELN": "0071388938", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000025859", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SANTA ELENA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "39600.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000054717", "TEL_NUMBER": "", "CAMPO1": "8684E3C5-4D1A-4813-88F0-9657C93EC1DE", "CAMPO2": "2023201D32B2C65747F9A01CCED41006202ACQUR", "CAMPO4": "" }, { "VBELN": "0071388939", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000281", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS GIGANTE", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "2601690.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025059", "TEL_NUMBER": "", "CAMPO1": "4F8D4D1C-0E0F-4094-8403-623B8F52DCD5", "CAMPO2": "2023E0BCB9B8D0C54AAA9B42D5B2C1B03259GRQW", "CAMPO4": "" }, { "VBELN": "0071388940", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000328", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS TRIGUEROS", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "598180.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025106", "TEL_NUMBER": "", "CAMPO1": "CB63DC03-8AB8-4FC1-8902-E0A7117890D2", "CAMPO2": "2023EB8201C84B3B436D8334616132B719AAEKT9", "CAMPO4": "" }, { "VBELN": "0071388941", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000330", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ZACAMIL", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "1143380.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025108", "TEL_NUMBER": "", "CAMPO1": "695917E5-69F8-44FF-A380-4A6A269FE8EA", "CAMPO2": "2023FBB80C524F8546D6BDC26493978B2A10CESA", "CAMPO4": "" }, { "VBELN": "0071388942", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000377", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ESCALON NORTE", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "79600.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025155", "TEL_NUMBER": "", "CAMPO1": "8F6CE10E-BD41-4E82-B777-99F30C485A74", "CAMPO2": "20236CA383B6BB0F461989E49992BD143646G70B", "CAMPO4": "" }, { "VBELN": "0071388943", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000377", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ESCALON NORTE", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "1725150.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025155", "TEL_NUMBER": "", "CAMPO1": "858E4D88-1825-43DD-BD6A-2260104FF4CE", "CAMPO2": "2023591A29F84A0141CB84E4579B861BDB3BESYT", "CAMPO4": "" }, { "VBELN": "0071388944", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000016677", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "WALMART SAN SALVADOR", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "1348890.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000041455", "TEL_NUMBER": "", "CAMPO1": "F5FBF51D-C95A-483E-9A6A-B3FF557E7CD3", "CAMPO2": "20232C32F2936F3F411D81E522D7EE0E999A5HQM", "CAMPO4": "" }, { "VBELN": "0071388945", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000021877", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART CONSTITUCION", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "526600.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000047427", "TEL_NUMBER": "", "CAMPO1": "4D6937C4-7B25-481D-8CEC-418C936ECFA4", "CAMPO2": "20232D5DACDAE8B346D6A7069C90463FA24A6NI8", "CAMPO4": "" }, { "VBELN": "0071388946", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000022623", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "CENTRO DE PRODUCCION DELI", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "546000.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000049000", "TEL_NUMBER": "", "CAMPO1": "A3070C5B-DF1D-4BEB-B8D0-848C25E32502", "CAMPO2": "20238E448949D2B14BD2BD3C7827C2D0CE36E4N0", "CAMPO4": "" }, { "VBELN": "0071388947", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000026545", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SELECTOS SAN GABRIEL", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "791800.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000055529", "TEL_NUMBER": "", "CAMPO1": "3DA80524-B452-4696-B624-F4F52C659864", "CAMPO2": "2023C52E761D184F49C385F44033C9D6ECDFLNWK", "CAMPO4": "" }, { "VBELN": "0071388948", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000277", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CENTRO ANTEL", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "606630.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025055", "TEL_NUMBER": "", "CAMPO1": "8951BD9D-B747-4B98-A05A-F2B8537EA9EA", "CAMPO2": "20237EB2605D7BD644BC8C6259B461EC95BFZ5Q1", "CAMPO4": "" }, { "VBELN": "0071388949", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000277", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CENTRO ANTEL", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "677310.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025055", "TEL_NUMBER": "", "CAMPO1": "088DE3AA-4E1A-423B-A106-A74E1F7C8867", "CAMPO2": "2023D4CB29F928FE43BA82B337108E89399DFO1J", "CAMPO4": "" }, { "VBELN": "0071388950", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000374", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CENTRO LA LIBERTAD", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "654730.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025152", "TEL_NUMBER": "", "CAMPO1": "EB68DF72-F6E4-41B1-ABF9-B9E3A8753C28", "CAMPO2": "2023A1D26F2EEE0E48288DEC103C14D4DD38K8NS", "CAMPO4": "" }, { "VBELN": "0071388951", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000270", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS APOPA I", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "713920.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025048", "TEL_NUMBER": "", "CAMPO1": "20FDAEF9-5946-47FE-8A97-91D6FA23505F", "CAMPO2": "202344A613F0D2BE489DBEB2CF187307225BEH4S", "CAMPO4": "" }, { "VBELN": "0071388952", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000291", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MEGA SELECTOS", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1765480.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025069", "TEL_NUMBER": "", "CAMPO1": "A3DAB0B4-0EC2-4DD0-857A-E0CCC6DB1EF0", "CAMPO2": "202317933EDD8C5D42888B6D6AD51DFA7DA0NNJW", "CAMPO4": "" }, { "VBELN": "0071388953", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000292", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MEJICANOS", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1040360.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025070", "TEL_NUMBER": "", "CAMPO1": "37A6C508-B5BE-4375-B7F2-294B95450AA8", "CAMPO2": "2023BBAE28E6AFEE4A43A5B9488C4247A494YX4K", "CAMPO4": "" }, { "VBELN": "0071388954", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000411", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF MEJICANOS", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "522190.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025189", "TEL_NUMBER": "", "CAMPO1": "C70F55F0-D382-4F75-BB14-84D73F03C8BE", "CAMPO2": "20237BDC93E29071462A8E2CD47B08D9C4DFZGL1", "CAMPO4": "" }, { "VBELN": "0071388955", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000437", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CUSCATANCINGO", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "315540.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025215", "TEL_NUMBER": "", "CAMPO1": "97964D68-8923-4799-84CC-FD96CD2ED99C", "CAMPO2": "202320173368D32A4CD9A92999F8C83B6F78LFNT", "CAMPO4": "" }, { "VBELN": "0071388956", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000445", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CIUDAD DELGADO", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "522390.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025223", "TEL_NUMBER": "", "CAMPO1": "45B31CDD-912D-44EA-BE87-65314226F0E0", "CAMPO2": "2023DF02CFCCB8964850ADFABA8E58895DA5IUFB", "CAMPO4": "" }, { "VBELN": "0071388957", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000446", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF APOPA PERICENTRO", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "646260.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025224", "TEL_NUMBER": "", "CAMPO1": "35FCAD67-9F01-48FC-B914-D4157B231DA9", "CAMPO2": "2023A216232DBC404C1CBB2A52D6FFF56D29MJ14", "CAMPO4": "" }, { "VBELN": "0071388958", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000024504", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI PRADOS DE VENECIA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1743070.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000052430", "TEL_NUMBER": "", "CAMPO1": "98312850-7640-4EAF-9A71-377C614342C2", "CAMPO2": "2023E4F3A65DEFDD4BB4880CAF84077B0E90JMIJ", "CAMPO4": "" }, { "VBELN": "0071388959", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000024876", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CUSCATANCINGO NORTE", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "474700.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000053067", "TEL_NUMBER": "", "CAMPO1": "C8EC3635-8A03-4D79-A9E1-885A0A1AA9A7", "CAMPO2": "20230C88639CB8D64ECC9961A9AB3558DA95IJQL", "CAMPO4": "" }, { "VBELN": "0071388960", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000029100", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SELECTOS PLAZA MUNDO APO", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "2518430.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000059675", "TEL_NUMBER": "", "CAMPO1": "C9FC393D-3FFA-48D7-A20A-40195E4E2045", "CAMPO2": "20237562F80429D9412B88330F6A4B6F5C26RP67", "CAMPO4": "" }, { "VBELN": "0071388961", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000268", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS AGUILARES", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1080370.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025046", "TEL_NUMBER": "", "CAMPO1": "DC3AB387-10D1-49AC-AD1D-1B8EA5849835", "CAMPO2": "202311B1EAB2879E455EBD9544B0EA2C0C52ISDO", "CAMPO4": "" }, { "VBELN": "0071388962", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000271", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS APOPA III", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "978650.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025049", "TEL_NUMBER": "", "CAMPO1": "4D4B31B6-9CE6-48D9-B8EC-977A661AE923", "CAMPO2": "2023DC711CB268514AD8A314CAE83DBE67B2YDRS", "CAMPO4": "" }, { "VBELN": "0071388963", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000353", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS QUEZALTEPEQUE", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "781040.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025131", "TEL_NUMBER": "", "CAMPO1": "0D52AA4E-9963-4965-8671-5B01A1BFF783", "CAMPO2": "2023F53830201DB447B28A0AEAF2C99262CFGTKI", "CAMPO4": "" }, { "VBELN": "0071388964", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000396", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF AGUILARES", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "542770.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025174", "TEL_NUMBER": "", "CAMPO1": "59058253-0809-4400-8C9F-8ABEC519B458", "CAMPO2": "202364D7143D22494E7C8EE52FD00A41CCE5DAB9", "CAMPO4": "" }, { "VBELN": "0071388965", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000398", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF APOPA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1112860.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025176", "TEL_NUMBER": "", "CAMPO1": "1C4B5923-5F73-4FB8-B4A9-223AC8AD4931", "CAMPO2": "2023B0FCF0E0C2EF405488586345F6C0816BNPXB", "CAMPO4": "" }, { "VBELN": "0071388966", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000413", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF QUEZALTEPEQUE", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "849230.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025191", "TEL_NUMBER": "", "CAMPO1": "A19F934D-4E82-4C45-9280-253B892DFB80", "CAMPO2": "20231F110CAB80664D969EB875CE34F4B9CBRZQQ", "CAMPO4": "" }, { "VBELN": "0071388967", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000000439", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF QUEZALTEPEQUE 2", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "505390.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025217", "TEL_NUMBER": "", "CAMPO1": "318EF8F1-42EB-4F2A-BFF3-374FAFEC29D0", "CAMPO2": "20239CD512D6E96941F1BB07A8CB75A3C7ABE1SH", "CAMPO4": "" }, { "VBELN": "0071388968", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000022862", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "MAXI APOPA", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1160300.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000049394", "TEL_NUMBER": "", "CAMPO1": "F4E2854C-F801-4437-9817-1CE38AC434C6", "CAMPO2": "20236E279CA39F08497FB09D99FCA705FDBCWC7P", "CAMPO4": "" }, { "VBELN": "0071388969", "FKART": "ZSC1", "FKDAT": "20231002", "KUNNR": "2000032378", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SEL. AGUILARES EL ENCUEN", "AEDAT": "20231002", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1513650.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000064531", "TEL_NUMBER": "", "CAMPO1": "1020F11C-6495-4B3A-B42C-84137AD205C7", "CAMPO2": "20238407960443ED4592A2E7C7A228643FE5KVIK", "CAMPO4": "" }, { "VBELN": "0071389567", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000318", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ANA COLON", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "965710.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025096", "TEL_NUMBER": "", "CAMPO1": "E4FA749C-E8CA-46EA-AFC7-47B95F4DF759", "CAMPO2": "2023B3DD452C86E041ED8442F1EEA8EAE0CE4MVQ", "CAMPO4": "" }, { "VBELN": "0071389568", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000319", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ANA METROCENTRO", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "87600.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025097", "TEL_NUMBER": "", "CAMPO1": "1081A939-40CD-47E8-A84A-3FE0304B718F", "CAMPO2": "2023B6B0DAC645E042E3A1DA5A1CF351906BENQN", "CAMPO4": "" }, { "VBELN": "0071389569", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000319", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ANA METROCENTRO", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1799150.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025097", "TEL_NUMBER": "", "CAMPO1": "1DBE7ED5-FCD4-466A-B6C4-46FAB4D77BEB", "CAMPO2": "20238244FF22E3FC48D3BE0E3AC488B34552MZBK", "CAMPO4": "" }, { "VBELN": "0071389570", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000390", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ SANTA ANA PALMAR", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "23760.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025168", "TEL_NUMBER": "", "CAMPO1": "7F2E8E08-630C-416C-8BDD-C6297BD6ACB5", "CAMPO2": "202325FCB4A41265430ABA5C8589C04B41A0DX8X", "CAMPO4": "" }, { "VBELN": "0071389571", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000390", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ SANTA ANA PALMAR", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1566780.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025168", "TEL_NUMBER": "", "CAMPO1": "8E1E214E-F935-4328-87B8-7132F5801445", "CAMPO2": "2023794A52B6AA3845F68983BC6C06BA3902QZGX", "CAMPO4": "" }, { "VBELN": "0071389572", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000418", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SANTA ANA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "435440.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025196", "TEL_NUMBER": "", "CAMPO1": "6DD064ED-90FE-4B81-A113-4182BA32388E", "CAMPO2": "20235B1DFE648090474896D7B6E369CC4197BCJU", "CAMPO4": "" }, { "VBELN": "0071389573", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000419", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SANTA ANA COLON", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1712530.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025197", "TEL_NUMBER": "", "CAMPO1": "DCB08BDB-9472-461E-A1B2-0716FC3E3FD9", "CAMPO2": "2023F584DC80724948B8AA2D1A6269DF65C0J1QD", "CAMPO4": "" }, { "VBELN": "0071389574", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000024215", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SANTA ANA NORTE", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "306130.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000051710", "TEL_NUMBER": "", "CAMPO1": "A78A0371-A712-4F14-A66C-879D5CA95452", "CAMPO2": "20236CE98186156A4E04AD7FBFB01D2B80EFIVJA", "CAMPO4": "" }, { "VBELN": "0071389575", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000028933", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "WM SANTA ANA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2136330.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000059447", "TEL_NUMBER": "", "CAMPO1": "B7003BE2-6B64-45D1-8426-BE91E6FA8149", "CAMPO2": "202351E251EEC1F548BDB655A2DEB3E24C32PAB7", "CAMPO4": "" }, { "VBELN": "0071389576", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000028933", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "WM SANTA ANA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "40000.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000059447", "TEL_NUMBER": "", "CAMPO1": "1ACD1F0E-4CC5-4C9F-96EE-AA36C0377244", "CAMPO2": "2023E062D71416FF41588D7B04B5B6879AA3JQSV", "CAMPO4": "" }, { "VBELN": "0071389577", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000029227", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI DESPENSA SAN JUAN", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "624090.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000059876", "TEL_NUMBER": "", "CAMPO1": "146CF919-1C42-4EFE-92B6-5D92E218F709", "CAMPO2": "20230C65D4BDD907441497893A24945C58CDIDYD", "CAMPO4": "" }, { "VBELN": "0071389581", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000283", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA JOYA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1804750.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025061", "TEL_NUMBER": "", "CAMPO1": "92653AD2-D7BD-4837-856D-3B4960A2D86D", "CAMPO2": "2023D4DC5C3A569F421CB7C337CEBE7A78ABIWVP", "CAMPO4": "" }, { "VBELN": "0071389582", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000284", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS EL FARO", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1040610.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025062", "TEL_NUMBER": "", "CAMPO1": "28002029-CE8B-4D5E-8119-4082AD0E6C15", "CAMPO2": "20234D152304E57A4CD9AADD01A5CA9846649BU4", "CAMPO4": "" }, { "VBELN": "0071389583", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000284", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS EL FARO", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "157250.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025062", "TEL_NUMBER": "", "CAMPO1": "1AFF921E-C2EA-4D0A-BCE5-15BAD60B44F3", "CAMPO2": "202336DCFC5FC9F54E54B4B81416B2E29970CGTW", "CAMPO4": "" }, { "VBELN": "0071389584", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000333", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ZARAGOZA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1429200.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025111", "TEL_NUMBER": "", "CAMPO1": "AADA4C72-38D0-41C9-A142-335F6AE9FBB4", "CAMPO2": "202360DD2EA3D8D7419A94CC4937302B60A7K9TD", "CAMPO4": "" }, { "VBELN": "0071389585", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000333", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ZARAGOZA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "580540.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025111", "TEL_NUMBER": "", "CAMPO1": "F90B8AEF-94A9-47B3-B936-3E6A1C3F5873", "CAMPO2": "2023385094A400B94064B4960CD30DEF40CCBKIR", "CAMPO4": "" }, { "VBELN": "0071389586", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000339", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LAS PALMAS", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "3019480.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025117", "TEL_NUMBER": "", "CAMPO1": "2520CCF6-4DA2-4591-94F9-82B734ABF066", "CAMPO2": "20235C42B961F20E4D9D89F7223FFB016A971TQZ", "CAMPO4": "" }, { "VBELN": "0071389587", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000339", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LAS PALMAS", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1591580.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025117", "TEL_NUMBER": "", "CAMPO1": "53CA7C8D-A269-4480-9619-8BB933A0EB1F", "CAMPO2": "2023D49180A0A6924598A1F0C428846AC522SKBP", "CAMPO4": "" }, { "VBELN": "0071389588", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000378", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ HOLANDA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "307060.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025156", "TEL_NUMBER": "", "CAMPO1": "79BD0D29-FFA9-4E9C-8964-4A3A0EE1EFA0", "CAMPO2": "2023BAB98038803B48D1A9BAC58B53B88E6EONPV", "CAMPO4": "" }, { "VBELN": "0071389589", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000378", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ HOLANDA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "39340.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025156", "TEL_NUMBER": "", "CAMPO1": "69AD40FA-6105-4FAB-9CDF-00112CE4FE50", "CAMPO2": "2023B662F370E3BD4A1BA3E36ABFB2F42886FYC3", "CAMPO4": "" }, { "VBELN": "0071389590", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000408", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF LA LIBERTAD", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "825280.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025186", "TEL_NUMBER": "", "CAMPO1": "85474CBB-6673-4749-997B-4A844DE6AA96", "CAMPO2": "2023EB760D9A9CE641A7B27473390FAAB6DDYWD9", "CAMPO4": "" }, { "VBELN": "0071389599", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000275", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS BETHOVEN", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "3157170.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025053", "TEL_NUMBER": "", "CAMPO1": "0010662C-88A5-46F0-8BA0-61234F57E088", "CAMPO2": "20237A07B17C48A041AB90ECD5D09EB73570Q49O", "CAMPO4": "" }, { "VBELN": "0071389600", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000290", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MASFERRER", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2239310.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025068", "TEL_NUMBER": "", "CAMPO1": "28B6D2B9-BDAA-4D8A-8A89-8F899597B191", "CAMPO2": "2023A194195C2C254733B5ED582144B9B42EMZSY", "CAMPO4": "" }, { "VBELN": "0071389601", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000290", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MASFERRER", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "204000.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025068", "TEL_NUMBER": "", "CAMPO1": "33288D5B-C47A-4695-BF2B-4F781B884667", "CAMPO2": "2023608D1F1381B24FF4BDDA46C63EB3D92FOFXD", "CAMPO4": "" }, { "VBELN": "0071389602", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000301", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ESCALON", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2204840.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025079", "TEL_NUMBER": "", "CAMPO1": "B29E5139-E800-4CD9-917E-C88DA14EEF5D", "CAMPO2": "2023EE6FE8CA4DC14D6183F37ACDA3BF2C878UEB", "CAMPO4": "" }, { "VBELN": "0071389603", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000301", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ESCALON", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "154720.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025079", "TEL_NUMBER": "", "CAMPO1": "B364A4E0-CB96-4118-B1A2-CC51B0604BF7", "CAMPO2": "2023E2E985A58FA0461EAD6FDE1C9E3F02B2VZQ9", "CAMPO4": "" }, { "VBELN": "0071389604", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000304", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN BENITO", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2450180.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025082", "TEL_NUMBER": "", "CAMPO1": "78C8CD8F-AB99-4823-B797-7FC1B79BE84D", "CAMPO2": "2023E976B432C1664168BC87E9F3E2A15BA3YQJG", "CAMPO4": "" }, { "VBELN": "0071389605", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000320", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA EMILIA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1881440.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025098", "TEL_NUMBER": "", "CAMPO1": "730D877E-AC3F-41D4-A882-5DD3F5920EE3", "CAMPO2": "202309FC8EBB64DE4264ABF897672BCDB11DYSNT", "CAMPO4": "" }, { "VBELN": "0071389607", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000294", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS METROCENTRO", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "2275330.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025072", "TEL_NUMBER": "", "CAMPO1": "026DB339-E189-46B2-B5C3-2F06BFB5E5C7", "CAMPO2": "2023E409A5AF35E9445F8662E8C9218F5E521RG8", "CAMPO4": "" }, { "VBELN": "0071389608", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000296", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS METROSUR", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "783810.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025074", "TEL_NUMBER": "", "CAMPO1": "C286D402-B9D5-4FFB-BB55-FE4355B210F8", "CAMPO2": "20232703E502E35C418BABDB01A01A06523C2IRU", "CAMPO4": "" }, { "VBELN": "0071389609", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000307", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN LUIS", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "2092720.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025085", "TEL_NUMBER": "", "CAMPO1": "B5EC2E5E-C04E-48A1-A9DE-2C6F62C09D07", "CAMPO2": "20238549AD4B72824662838FA4985E9A47CDLBQ4", "CAMPO4": "" }, { "VBELN": "0071389610", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000307", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN LUIS", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "336840.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025085", "TEL_NUMBER": "", "CAMPO1": "A79A97AB-E3BD-42B7-9F02-23003A5EB103", "CAMPO2": "2023A5B80FE54B6344F98C9E7313D166DD7ADERB", "CAMPO4": "" }, { "VBELN": "0071389611", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000336", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS METROCENTRO 8av ETAPA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "614120.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025114", "TEL_NUMBER": "", "CAMPO1": "2348F2DE-648D-44AF-8129-B2BCA94DF63B", "CAMPO2": "202305AFF31E07C44B62A4AC386919231B29UBSX", "CAMPO4": "" }, { "VBELN": "0071389612", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000383", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ LOS HEROES", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "442770.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025161", "TEL_NUMBER": "", "CAMPO1": "4A1FB88A-8F8A-4A65-9C84-63ED3686C413", "CAMPO2": "2023A3C2AEFE721343D7AD5A1BCC0D6A333D31RA", "CAMPO4": "" }, { "VBELN": "0071389613", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000280", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ESPAÑA #36", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "709250.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025058", "TEL_NUMBER": "", "CAMPO1": "2027C8B4-E995-4D84-A0C1-93569CAA4BA5", "CAMPO2": "2023A8F2A41CACF34EF3BCE42B60D4A33A988GRT", "CAMPO4": "" }, { "VBELN": "0071389614", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000305", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN JACINTO", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "2174500.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025083", "TEL_NUMBER": "", "CAMPO1": "493B5540-2302-434B-B515-A0E36E34E990", "CAMPO2": "202385B0348DB68C4CD1A71C32A324B54966JH57", "CAMPO4": "" }, { "VBELN": "0071389615", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000305", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN JACINTO", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "1135790.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025083", "TEL_NUMBER": "", "CAMPO1": "515C2325-09C4-49D2-A32B-CD99B880485B", "CAMPO2": "2023BF85A341F0C64509BA0872B713838B6CAXVT", "CAMPO4": "" }, { "VBELN": "0071389616", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000444", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SAN JACINTO", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "626660.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025222", "TEL_NUMBER": "", "CAMPO1": "2E37551E-34E8-4483-B561-E1E9AD86BBA3", "CAMPO2": "2023D2EF177E04374ACD9A2D97B2784151B4RSR2", "CAMPO4": "" }, { "VBELN": "0071389617", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000448", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "MAXI BODEGA SAN MARCOS", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "1446810.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025226", "TEL_NUMBER": "", "CAMPO1": "A15D6196-1F5C-4DAE-B032-C8955D9FD468", "CAMPO2": "2023B20C5273E27548EB8E6BEBB08A5923187QWY", "CAMPO4": "" }, { "VBELN": "0071389618", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000023604", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTO TOMAS", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "3061910.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000050544", "TEL_NUMBER": "", "CAMPO1": "E790F73D-7629-4797-9E16-F512D38C40F1", "CAMPO2": "2023E5F5DB6B7CE04DF59AD126A9BF85CAEFDXDB", "CAMPO4": "" }, { "VBELN": "0071389619", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000026543", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "S. SELECTOS SAN MARCOS EL ENCU", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "4343750.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000055524", "TEL_NUMBER": "", "CAMPO1": "0F926B4D-6E94-41BD-9849-38969740498E", "CAMPO2": "2023338A74CE9576451EBECF2D56990232B0AYYB", "CAMPO4": "" }, { "VBELN": "0071389620", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000026543", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "S. SELECTOS SAN MARCOS EL ENCU", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "141740.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000055524", "TEL_NUMBER": "", "CAMPO1": "E6149D88-4212-4191-BD98-E92398CE415F", "CAMPO2": "202378BDC45320C841D29ECAB110524A683BR9JU", "CAMPO4": "" }, { "VBELN": "0071389621", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000303", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS PLAZA MUNDO #203", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1975300.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025081", "TEL_NUMBER": "", "CAMPO1": "8A70151B-7ADA-4285-A569-03FEBEAC7B79", "CAMPO2": "2023267B116769F743B2A09BC72A4F96EC50HT6Z", "CAMPO4": "" }, { "VBELN": "0071389622", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000321", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA LUCIA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1106260.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025099", "TEL_NUMBER": "", "CAMPO1": "1890AB95-ADB1-4DC3-A425-B397571BD916", "CAMPO2": "2023FD3E5F08BC4545C7A2527CC54E935A64E0WJ", "CAMPO4": "" }, { "VBELN": "0071389623", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000367", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SOYAPANGO", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "4064450.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025145", "TEL_NUMBER": "", "CAMPO1": "626DE29D-67C5-462E-88E4-192B7703A52A", "CAMPO2": "2023704CFDAF9E9946E290C42F3E93554709WW0F", "CAMPO4": "" }, { "VBELN": "0071389624", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000023323", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI DESPENSA BOULEVARD DEL EJ", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "455590.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000050035", "TEL_NUMBER": "", "CAMPO1": "FBE64D06-9674-4857-B445-50F95A3E8484", "CAMPO2": "20232964C6E17424423C8583FEF745A10BC3YLP8", "CAMPO4": "" }, { "VBELN": "0071389625", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000335", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SENSUNTEPEQUE", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "793140.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025113", "TEL_NUMBER": "", "CAMPO1": "D00F3D82-52D7-47F2-AB6B-1BEE9FC789F7", "CAMPO2": "20237A572E2765EF42D49F1100A965DDAD3A4ETM", "CAMPO4": "" }, { "VBELN": "0071389626", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000338", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS COJUTEPEQUE CENTRO", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1131970.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025116", "TEL_NUMBER": "", "CAMPO1": "CA6E9A36-3104-446C-AD43-1704A6A83A4E", "CAMPO2": "20239CF096591D1E4E5D8D983E152C97BA5EVU89", "CAMPO4": "" }, { "VBELN": "0071389627", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000345", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS COJUTEPEQUE II", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1184790.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025123", "TEL_NUMBER": "", "CAMPO1": "A093980F-D740-443A-BD42-67C16A4D00BF", "CAMPO2": "20231E9078F4376143A7B22B3B597BC4829AHUVS", "CAMPO4": "" }, { "VBELN": "0071389628", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000346", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS ILOBASCO II", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1080790.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025124", "TEL_NUMBER": "", "CAMPO1": "4770305D-D624-40EB-848F-A0358B4BE604", "CAMPO2": "202370EAF32167E549F0A506C0D71FF6BA3BY6H2", "CAMPO4": "" }, { "VBELN": "0071389629", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000352", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ILOBASCO", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1768440.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025130", "TEL_NUMBER": "", "CAMPO1": "B02CFD43-644B-4BF9-BAF3-256AE9766D4C", "CAMPO2": "202352645854792742709F3C6F9818E6C66FWMHE", "CAMPO4": "" }, { "VBELN": "0071389630", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000405", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF COJUTEPEQUE", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "381200.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025183", "TEL_NUMBER": "", "CAMPO1": "00A9E5A2-233D-46AC-9085-D21D8634E647", "CAMPO2": "2023A1F417AE589A490D87E65F6953639DEDUZ7K", "CAMPO4": "" }, { "VBELN": "0071389631", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000424", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SENSUNTEPEQUE", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "512070.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025202", "TEL_NUMBER": "", "CAMPO1": "D0266359-980F-4223-9AF7-CEB07398489B", "CAMPO2": "2023A139B2A2E7EB4946907D535A97DFC9B2FW9S", "CAMPO4": "" }, { "VBELN": "0071389632", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000026814", "NAME1": "OPERADORA DEL SUR, S.A. DE  C.", "NAME2": "MAXI DESPENSA ILOBASCO", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "547750.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000056069", "TEL_NUMBER": "", "CAMPO1": "C9C61A39-868F-4982-89EC-B2597A17A8E2", "CAMPO2": "20236888ADA266B1446D8B8B212EEF9E554EIZ3Q", "CAMPO4": "" }, { "VBELN": "0071389633", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000037973", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "S. SELECTOS SANTA TECLA LAS RA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "3072450.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000070781", "TEL_NUMBER": "", "CAMPO1": "8D15EB23-2715-47AE-9D85-F6E77ECEEF31", "CAMPO2": "20239F5323218905485F8334D2A456CAA0A3IVDE", "CAMPO4": "" }, { "VBELN": "0071389634", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000037973", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "S. SELECTOS SANTA TECLA LAS RA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2033120.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000070781", "TEL_NUMBER": "", "CAMPO1": "583EE10B-B2B8-48B2-9E28-DEAD3B85C8E8", "CAMPO2": "202356B82F91522C4CA4A79DAD3BA4A0E8F6RVJL", "CAMPO4": "" }, { "VBELN": "0071389636", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000316", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ANA CENTRO", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1468610.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025094", "TEL_NUMBER": "", "CAMPO1": "D877104C-B99A-4257-839B-715421DDB2B6", "CAMPO2": "202366FA7FDD7F0144AAAA48E3299F394667O5LG", "CAMPO4": "" }, { "VBELN": "0071389637", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000389", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CATEDRAL SANTA ANA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "497880.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025167", "TEL_NUMBER": "", "CAMPO1": "9C36D432-A697-4D69-91DB-0BEB663E9DEC", "CAMPO2": "2023A84A6CF6BC56458C99B2B47F474D64A4OORH", "CAMPO4": "" }, { "VBELN": "0071389638", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000350", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS LIBERTAD", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "872470.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025128", "TEL_NUMBER": "", "CAMPO1": "7762CBF0-6349-427B-877C-25DFC2FCFC1C", "CAMPO2": "2023D28A91C618D249B99A7B0C17EB447D20TWE7", "CAMPO4": "" }, { "VBELN": "0071389639", "FKART": "ZSC1", "FKDAT": "20231003", "KUNNR": "2000000378", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ HOLANDA", "AEDAT": "20231003", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1180880.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025156", "TEL_NUMBER": "", "CAMPO1": "25B7C827-971C-457B-B5EF-52DFA21B9BEB", "CAMPO2": "202344BE567F508C415F9A20073836CD1EFDPPMZ", "CAMPO4": "" }, { "VBELN": "0071390216", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000325", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SONSONATE II", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2022250.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025103", "TEL_NUMBER": "", "CAMPO1": "1E0C31B5-8EEE-49DB-846E-AA4DCB934EF2", "CAMPO2": "202327CEE42A44BB4B958218843104BD3A36S9CK", "CAMPO4": "" }, { "VBELN": "0071390217", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000326", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SONSONATE III", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "825730.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025104", "TEL_NUMBER": "", "CAMPO1": "21340264-578F-4813-A10E-69047A5C9F16", "CAMPO2": "202311FDF2A0326E46AE9984D7F843FC9EECDDMA", "CAMPO4": "" }, { "VBELN": "0071390218", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000351", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS IZALCO", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1283830.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025129", "TEL_NUMBER": "", "CAMPO1": "5A6B76C1-1095-4B8D-9638-D145DDEB7D7E", "CAMPO2": "2023E86FB8F461324D7F9682DB95C74D07E5NJYA", "CAMPO4": "" }, { "VBELN": "0071390219", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000391", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ SONSONATE CATEDRAL", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "15840.00", "KUNAG": "", "SMTP_ADDR": "ebsalaedisv@walmarmart.com", "ADRNR": "0000025169", "TEL_NUMBER": "", "CAMPO1": "C6149029-74A1-46F6-BB46-2E2B424CF44D", "CAMPO2": "2023DFB91E89EFA34EE88559DA0F53A0A627MCH0", "CAMPO4": "" }, { "VBELN": "0071390220", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000391", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ SONSONATE CATEDRAL", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "993780.00", "KUNAG": "", "SMTP_ADDR": "ebsalaedisv@walmarmart.com", "ADRNR": "0000025169", "TEL_NUMBER": "", "CAMPO1": "927E5B71-228D-4E94-B9D5-0ED4D4E697E3", "CAMPO2": "202346EC04BC5F394BC9810929356273663CQ9FJ", "CAMPO4": "" }, { "VBELN": "0071390221", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000399", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF ARMENIA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "890950.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025177", "TEL_NUMBER": "", "CAMPO1": "D384284E-9478-4734-9063-BBD929EFE5EB", "CAMPO2": "20233C8A08A4D75245F9836C13B431121055AEY8", "CAMPO4": "" }, { "VBELN": "0071390222", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000407", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF IZALCO", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "490290.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025185", "TEL_NUMBER": "", "CAMPO1": "3EB9149A-895B-479C-B052-28B7516F50AC", "CAMPO2": "2023245FB7C54B914B24958AB9B79075A417AKJ6", "CAMPO4": "" }, { "VBELN": "0071390223", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000436", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DESPENSA FAMILIAR SONSONATE", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "862580.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025214", "TEL_NUMBER": "", "CAMPO1": "734BF30C-AA73-41AB-A2E1-B6AFD7521CD0", "CAMPO2": "2023B8C542E56169453D81DA8DA3FFB8BFC1AAOB", "CAMPO4": "" }, { "VBELN": "0071390224", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000016864", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI DESPENSA SONSONATE", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1881360.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000041642", "TEL_NUMBER": "", "CAMPO1": "E711991F-AA74-425E-97F8-523D7C61602B", "CAMPO2": "2023437AA9DA87AD4FB8A25BD402020B6581IPPN", "CAMPO4": "" }, { "VBELN": "0071390225", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000024863", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SONZACATE", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "240410.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000053018", "TEL_NUMBER": "", "CAMPO1": "4045D61C-D37F-4780-87A1-5BF1725826F7", "CAMPO2": "20234601A976A43C42B8A410DB7165B19008ERMA", "CAMPO4": "" }, { "VBELN": "0071390226", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000031305", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUP.SEL. SONSONATE EL ENCUENTR", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1807470.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000062859", "TEL_NUMBER": "", "CAMPO1": "C3251537-E549-4632-826E-6FEE532A04FF", "CAMPO2": "202363CA633DB5D549DA993DF5F8BDF060E7MXH9", "CAMPO4": "" }, { "VBELN": "0071390227", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000032681", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SELECTOS ACAJUTLA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1132920.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000065099", "TEL_NUMBER": "", "CAMPO1": "6D9F73ED-B480-4039-8F7E-8E5B49FB7FF2", "CAMPO2": "2023F1C227BAD8AB42439CD6CBEF2E04993BU9F3", "CAMPO4": "" }, { "VBELN": "0071390234", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000288", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LOURDES", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1355440.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025066", "TEL_NUMBER": "", "CAMPO1": "47C96B94-ACCF-438B-9DFD-3620A9179CDC", "CAMPO2": "2023161B50E6BF2F427E83BCC864D80BEDFBE7JS", "CAMPO4": "" }, { "VBELN": "0071390235", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000288", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LOURDES", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "922150.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025066", "TEL_NUMBER": "", "CAMPO1": "0ACC4A01-487A-4F60-A0FF-38AF58DA0BD5", "CAMPO2": "2023DCD644C3B17B4EBDBDBF3EC33D32A10EI9OI", "CAMPO4": "" }, { "VBELN": "0071390236", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000289", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LOURDES II", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1171470.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025067", "TEL_NUMBER": "", "CAMPO1": "3141DFB3-32AB-49D1-AE8B-FF9C1CCD13E4", "CAMPO2": "2023F5CCE69DC0A34540A4A464B7085B6738OIRC", "CAMPO4": "" }, { "VBELN": "0071390237", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000293", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MERLIOT II", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "70200.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025071", "TEL_NUMBER": "", "CAMPO1": "25D672E9-3E1E-4544-AF87-1BAA653B8AFD", "CAMPO2": "20235730BCD1577D430EAF06AE8EFA02D66FQAUG", "CAMPO4": "" }, { "VBELN": "0071390238", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000293", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MERLIOT II", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2673150.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025071", "TEL_NUMBER": "", "CAMPO1": "F3EF02EB-1E97-4476-9F42-F82B6520E624", "CAMPO2": "202370B909C2682C46FF9E7FF50A516D8202CMJL", "CAMPO4": "" }, { "VBELN": "0071390239", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000392", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ UNICENTRO LOURDES", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2311870.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025170", "TEL_NUMBER": "", "CAMPO1": "0A94F216-B082-4AB0-A69C-74B4431650DF", "CAMPO2": "202360F7FDD925FD49579F6D05965251C0C84GS2", "CAMPO4": "" }, { "VBELN": "0071390240", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000410", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF LOURDES", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1480820.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025188", "TEL_NUMBER": "", "CAMPO1": "2781FD32-073D-4F56-9B49-90D96428D8B8", "CAMPO2": "20232FA2CEBE7F0C4FD5886EF9EAC39CF6FC9KNR", "CAMPO4": "" }, { "VBELN": "0071390241", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000022198", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI LOURDES", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1415460.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000048232", "TEL_NUMBER": "", "CAMPO1": "8E0CD4B7-CEC0-4E95-B931-97F559ABA763", "CAMPO2": "20238B103E2E513A40A9AB31370BC5925CAAWQYU", "CAMPO4": "" }, { "VBELN": "0071390242", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000024309", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS EL ENCUENTRO", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1995620.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000051883", "TEL_NUMBER": "", "CAMPO1": "6BBE1509-2ABA-4E44-8AD7-22CC392B62C6", "CAMPO2": "20235747E85D0A0241F98EC2CD86D66FA70CHRSN", "CAMPO4": "" }, { "VBELN": "0071390243", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000027009", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI CAMPOS VERDES", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1125930.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000056480", "TEL_NUMBER": "", "CAMPO1": "F7CBA4E4-6791-422A-9CEC-4F651717B8E5", "CAMPO2": "20236559922BE3F34F1BA7F51EDA3BC8AFF5GDOS", "CAMPO4": "" }, { "VBELN": "0071390244", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000031290", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUP. SELECT. OPICO EL ENCUENTR", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2999230.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000062829", "TEL_NUMBER": "", "CAMPO1": "7F55A3F2-795C-4171-81CA-7371DDCFE39A", "CAMPO2": "202397BF04CCB23743B8BEB2544211E26CFEIPDW", "CAMPO4": "" }, { "VBELN": "0071390255", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000285", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA SULTANA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1315810.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025063", "TEL_NUMBER": "", "CAMPO1": "949F976E-8209-4451-A5C1-7ECAB4258090", "CAMPO2": "2023439DBEF980EC44729D4DF2301D6D91D8BEPR", "CAMPO4": "" }, { "VBELN": "0071390256", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000285", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA SULTANA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1242730.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025063", "TEL_NUMBER": "", "CAMPO1": "C6EF0F74-A5FB-48F2-AC5F-AE14C21A6C54", "CAMPO2": "20232863C7568144496C92F38F230BBACD6CEKUI", "CAMPO4": "" }, { "VBELN": "0071390257", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000372", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ANTIGUO", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP003", "NETWR": "7920.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025150", "TEL_NUMBER": "", "CAMPO1": "8AFA586B-F155-42F0-825F-77AC1F7C9357", "CAMPO2": "2023C64C23C0F5C94A31AFDC5AF3A6FB7205U4UH", "CAMPO4": "" }, { "VBELN": "0071390258", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000372", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ANTIGUO", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP003", "NETWR": "842450.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025150", "TEL_NUMBER": "", "CAMPO1": "A591CABC-15E2-420D-98F5-87074DAE1774", "CAMPO2": "2023628BD8FB48164BDC81725D28BE170341WTDX", "CAMPO4": "" }, { "VBELN": "0071390259", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000372", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ANTIGUO", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1176840.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025150", "TEL_NUMBER": "", "CAMPO1": "31D66BA9-7815-4AAD-AA57-AC0C0541DB5F", "CAMPO2": "202327795448CDAD4EFE97EF7513A605D16EPTM9", "CAMPO4": "" }, { "VBELN": "0071390260", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000380", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ LA CIMA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP003", "NETWR": "79600.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025158", "TEL_NUMBER": "", "CAMPO1": "6994DC4D-1400-4996-9950-D2FB5284F551", "CAMPO2": "20239279C3A7E9BD4DC8BAC1B4F34542FA91PCMQ", "CAMPO4": "" }, { "VBELN": "0071390261", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000021876", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ELENA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP003", "NETWR": "510590.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000047424", "TEL_NUMBER": "", "CAMPO1": "F4A40BFA-E900-4530-A280-362969F1BC65", "CAMPO2": "202303731D2086CE4F41A26691A7E9E6E6E20ZAG", "CAMPO4": "" }, { "VBELN": "0071390262", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000021876", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ELENA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP003", "NETWR": "798030.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000047424", "TEL_NUMBER": "", "CAMPO1": "216A2A46-8192-42CB-A303-D6A652601DC2", "CAMPO2": "202374C8D29349A0407183AE2A24B98FC656T2P1", "CAMPO4": "" }, { "VBELN": "0071390263", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000025859", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SANTA ELENA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP003", "NETWR": "403560.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000054717", "TEL_NUMBER": "", "CAMPO1": "09D9BDC5-741D-4B0B-BC87-7F10F1DCD6E2", "CAMPO2": "2023FF46E92FF0F24C00B2DF7C3827F0B51AI8AW", "CAMPO4": "" }, { "VBELN": "0071390264", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000025859", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SANTA ELENA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP003", "NETWR": "55440.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000054717", "TEL_NUMBER": "", "CAMPO1": "E2289E9A-D965-4DA3-A38E-DB9171C3C2A7", "CAMPO2": "20235FDE7A634BE5496E8217CA290764CF2BVWJI", "CAMPO4": "" }, { "VBELN": "0071390265", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000025859", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SANTA ELENA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1607580.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000054717", "TEL_NUMBER": "", "CAMPO1": "62C2C9FA-0C71-4CD9-8EE6-DE47FF84307F", "CAMPO2": "2023C91063E7614C4AE595A3606F2E28D902OFLF", "CAMPO4": "" }, { "VBELN": "0071390269", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000295", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS METROPOLIS", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP004", "NETWR": "720410.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025073", "TEL_NUMBER": "", "CAMPO1": "67E466BF-6356-4764-A155-8A364DFE6D3D", "CAMPO2": "202301127F7701FF4B418F9E0D31792A95D9PKPO", "CAMPO4": "" }, { "VBELN": "0071390270", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000297", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MIRALVALLE I", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP004", "NETWR": "1906230.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025075", "TEL_NUMBER": "", "CAMPO1": "71A99414-1AF5-4032-B59D-37273EB221AB", "CAMPO2": "2023ECF45B8B1D254A7F96AAB9611139071DRLVP", "CAMPO4": "" }, { "VBELN": "0071390271", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000298", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MIRALVALLE II", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP004", "NETWR": "3211480.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025076", "TEL_NUMBER": "", "CAMPO1": "227E4D77-5413-4F97-8414-5AA91B5483A6", "CAMPO2": "202359E45EBE4B9447358BBAB643D1C4403BVR38", "CAMPO4": "" }, { "VBELN": "0071390272", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000022176", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF METROPOLIS", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP004", "NETWR": "368230.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000048141", "TEL_NUMBER": "", "CAMPO1": "6C1BF1D9-4AFC-4D72-A726-4C2B66CE0CEA", "CAMPO2": "202380682DF5832A40B5A45E0CB5C99C9D99HCTW", "CAMPO4": "" }, { "VBELN": "0071390273", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000026545", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SELECTOS SAN GABRIEL", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP004", "NETWR": "94700.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000055529", "TEL_NUMBER": "", "CAMPO1": "B25DA5FB-1E1B-4393-8D76-6972B6DE1808", "CAMPO2": "2023269228DAA0734145B24E3895C83B08C8OKIR", "CAMPO4": "" }, { "VBELN": "0071390274", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000026545", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SELECTOS SAN GABRIEL", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP004", "NETWR": "3808130.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000055529", "TEL_NUMBER": "", "CAMPO1": "D06D3B82-D7C2-421B-989F-15FDC6157EC9", "CAMPO2": "20232FCE5FDF5DF64390988AE0036044407FSUZC", "CAMPO4": "" }, { "VBELN": "0071390278", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000306", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS CENTRO SAN JOSE", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP005", "NETWR": "348220.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025084", "TEL_NUMBER": "", "CAMPO1": "CA5C0DE5-5F77-4737-A37D-5416696AFC90", "CAMPO2": "20233063BA7350FE4663878490F1E88D6045LJGB", "CAMPO4": "" }, { "VBELN": "0071390279", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000313", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN MIGUELITO I", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP005", "NETWR": "1024560.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025091", "TEL_NUMBER": "", "CAMPO1": "9860D147-BC0D-47AF-9FF4-D4A108C28885", "CAMPO2": "2023E103C8FE9EB44EB584560626DD619836H6TH", "CAMPO4": "" }, { "VBELN": "0071390280", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000314", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN MIGUELITO II", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP005", "NETWR": "1468560.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025092", "TEL_NUMBER": "", "CAMPO1": "60681709-D379-4378-997B-145B05AF6B88", "CAMPO2": "20239D4F596465D84E06884FB503A15148DACQUB", "CAMPO4": "" }, { "VBELN": "0071390281", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000381", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ LAS TERRAZAS", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP005", "NETWR": "728480.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025159", "TEL_NUMBER": "", "CAMPO1": "B1E64CA2-C8C1-4482-9C61-C92A64715D0C", "CAMPO2": "2023DA2F44D430E5424CA58871E0E36E4028AFDS", "CAMPO4": "" }, { "VBELN": "0071390282", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000381", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ LAS TERRAZAS", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP005", "NETWR": "73360.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025159", "TEL_NUMBER": "", "CAMPO1": "5F0D3E49-CB41-4EF4-817D-13A6DDFC4139", "CAMPO2": "202348692CBECFD84089B704C8C14707F8C2DG3Q", "CAMPO4": "" }, { "VBELN": "0071390283", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000441", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF EL CENTRO", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP005", "NETWR": "2705500.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025219", "TEL_NUMBER": "", "CAMPO1": "52011180-7563-4046-8147-3FCFC9924BB4", "CAMPO2": "20233DB41150CCBC4770B848BBC4FF54EE0BRT1J", "CAMPO4": "" }, { "VBELN": "0071390284", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000286", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LOS ANGELES", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP006", "NETWR": "892180.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025064", "TEL_NUMBER": "", "CAMPO1": "1CC4899A-52E2-4C5E-87EC-93E5BD759707", "CAMPO2": "2023E135740C036D460FB138C528CEA6528AQ80S", "CAMPO4": "" }, { "VBELN": "0071390285", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000308", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN MARTIN", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1661690.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025086", "TEL_NUMBER": "", "CAMPO1": "945D2611-4A38-485C-A8C2-75D0DD1E1F70", "CAMPO2": "2023CF00DABBBAEC478780FC37FE9367E2CDNWC7", "CAMPO4": "" }, { "VBELN": "0071390286", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000332", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN BARTOLO", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP006", "NETWR": "35280.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025110", "TEL_NUMBER": "", "CAMPO1": "50CA71E6-C525-4F3E-A41E-CCB3611FF5A5", "CAMPO2": "20239D7A7A7936A246D2AD6FAD186954499AWLWE", "CAMPO4": "" }, { "VBELN": "0071390287", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000332", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN BARTOLO", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP006", "NETWR": "2175190.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025110", "TEL_NUMBER": "", "CAMPO1": "D1B47B35-5AF2-458F-9E83-861514EF1C04", "CAMPO2": "202364CA5C2BA2104F4AB30C5580BF12BF11NZGA", "CAMPO4": "" }, { "VBELN": "0071390288", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000371", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ALTAVISTA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP006", "NETWR": "15840.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025149", "TEL_NUMBER": "", "CAMPO1": "6054A526-12A7-49B5-8D5E-10BDCB3AE7C7", "CAMPO2": "2023EFBA3578923F4B3A87771465DDF8A2B0ZE5A", "CAMPO4": "" }, { "VBELN": "0071390289", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000371", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ALTAVISTA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP006", "NETWR": "888750.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025149", "TEL_NUMBER": "", "CAMPO1": "F60D4C5C-FF41-4F40-A460-6509FF42EA88", "CAMPO2": "20232727E9C2BC204ED4BC5C84E1C23651BBDGTF", "CAMPO4": "" }, { "VBELN": "0071390290", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000384", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "MAXI DESPENSA SAN BARTOLO", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP006", "NETWR": "531350.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025162", "TEL_NUMBER": "", "CAMPO1": "3A78B7C1-4AD5-4AE8-A3C4-2A6189FB8DA7", "CAMPO2": "20232692795771864C148F4FEB84BAD326A2RGIU", "CAMPO4": "" }, { "VBELN": "0071390291", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000393", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ UNICENTRO SOYAPANGO", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1433270.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025171", "TEL_NUMBER": "", "CAMPO1": "57569A93-65D6-4C29-A94E-9910A73B5247", "CAMPO2": "20237F3E538D80974F6B82696D39DDFEDB0C4JQA", "CAMPO4": "" }, { "VBELN": "0071390292", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000414", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SAN MARTIN", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1091810.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025192", "TEL_NUMBER": "", "CAMPO1": "FF438A6E-5CBB-43F4-A00B-EC3EE53F3179", "CAMPO2": "20239583874C62D54A5DB61A0F3E9483D27ETWYN", "CAMPO4": "" }, { "VBELN": "0071390293", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000029929", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUP. SELEC. SAN MARTIN EL ENCU", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP006", "NETWR": "81000.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000060802", "TEL_NUMBER": "", "CAMPO1": "97A642E6-8E17-40E5-BA0E-CB37D8860E1F", "CAMPO2": "2023340AE4BD20DE4F52AF5CE9F651189153HBRH", "CAMPO4": "" }, { "VBELN": "0071390294", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000029929", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUP. SELEC. SAN MARTIN EL ENCU", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP006", "NETWR": "4582150.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000060802", "TEL_NUMBER": "", "CAMPO1": "76502FA4-6468-4CFA-97D1-9FCF79AC8752", "CAMPO2": "20239A58271102E14781ABD0C9E5E78D71B8QNZ7", "CAMPO4": "" }, { "VBELN": "0071390296", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000315", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN VICENTE", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1524910.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025093", "TEL_NUMBER": "", "CAMPO1": "6A890C87-6A2D-40AB-BE28-B018A4243F6A", "CAMPO2": "2023EE2ABAFC5A2A460E97BE81CD80511F5FDVJQ", "CAMPO4": "" }, { "VBELN": "0071390297", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000331", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ZACATECOLUCA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP007", "NETWR": "3167910.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025109", "TEL_NUMBER": "", "CAMPO1": "9E87D772-E92A-4561-A25F-DB2D1B3DBAC4", "CAMPO2": "2023CA99C2857CE44D9A93BC6FE34CBFF74FQ4S5", "CAMPO4": "" }, { "VBELN": "0071390298", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000395", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ZACATECOLUCA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP007", "NETWR": "2855530.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025173", "TEL_NUMBER": "", "CAMPO1": "6B063F0C-3A8E-4BA7-A0D1-8FEFA596302E", "CAMPO2": "20233A260F746ECC4DA187A6BC20C63D52B61U5K", "CAMPO4": "" }, { "VBELN": "0071390299", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000417", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SAN VICENTE", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1449070.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025195", "TEL_NUMBER": "", "CAMPO1": "9351E697-E8AA-4F85-8C1E-435158E9E517", "CAMPO2": "20231B9DAD3603F84EC680C39498347F288DIMAR", "CAMPO4": "" }, { "VBELN": "0071390300", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000431", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF ZACATECOLUCA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1403730.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025209", "TEL_NUMBER": "", "CAMPO1": "1EA6BDB6-EE2A-4160-AFC2-F7B38507C0C4", "CAMPO2": "2023BD45FA31E1534C35A93589FCA308B97CVFXQ", "CAMPO4": "" }, { "VBELN": "0071390301", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000024924", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "MAXI DESPENSA SANTA ELENA SAN", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP007", "NETWR": "2330940.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000053248", "TEL_NUMBER": "", "CAMPO1": "933F3740-3511-444C-A5B5-711B5643E2AE", "CAMPO2": "202332221D68C7134340A49ADAB66B3C7230PVXX", "CAMPO4": "" }, { "VBELN": "0071390305", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000324", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SONSONATE", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1176300.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025102", "TEL_NUMBER": "", "CAMPO1": "68BFA6F8-BF47-4654-8002-2F9135F6DC4E", "CAMPO2": "2023C60E5DF09B8549779DC4DFEF41C6DF2EEGTT", "CAMPO4": "" }, { "VBELN": "0071390306", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000031305", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUP.SEL. SONSONATE EL ENCUENTR", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2413720.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000062859", "TEL_NUMBER": "", "CAMPO1": "2E717DFD-A35A-4BA7-AF9A-EE65FCBC0BE5", "CAMPO2": "2023A6E85AE831124887A86B5042D0544C92OHMW", "CAMPO4": "" }, { "VBELN": "0071390307", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000032681", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SELECTOS ACAJUTLA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1639070.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000065099", "TEL_NUMBER": "", "CAMPO1": "969BC88C-DEB0-4552-A705-3F33D1B08718", "CAMPO2": "202389A78A514A434A85AE3C464B6D2F8A71IRVU", "CAMPO4": "" }, { "VBELN": "0071390308", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000289", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LOURDES II", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1400400.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025067", "TEL_NUMBER": "", "CAMPO1": "673FD69C-0EAB-4327-AB38-DCF05EE9302E", "CAMPO2": "20233002BD8780F346C784FEC217F961B0B7B2PJ", "CAMPO4": "" }, { "VBELN": "0071390309", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000024309", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS EL ENCUENTRO", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2319200.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000051883", "TEL_NUMBER": "", "CAMPO1": "C546296D-B485-4DD0-A28F-89986277C0CA", "CAMPO2": "20239CA3B6D046DD4979A240BE7E48E42CB5PELS", "CAMPO4": "" }, { "VBELN": "0071390310", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000031304", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SELECTOS MARSELLA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "3801210.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000062858", "TEL_NUMBER": "", "CAMPO1": "138538CB-7195-42DD-B708-4EAF8914AE7B", "CAMPO2": "2023696303492D3F477D87D5048E484E8631OYET", "CAMPO4": "" }, { "VBELN": "0071390311", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000031304", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SELECTOS MARSELLA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP002", "NETWR": "434760.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000062858", "TEL_NUMBER": "", "CAMPO1": "3257F9AC-6E60-49A5-9933-2659E72B83C1", "CAMPO2": "20239CFEDE9C3C684C598CF763CB0F4A8FB3MUYO", "CAMPO4": "" }, { "VBELN": "0071390312", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000380", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ LA CIMA", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1073930.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025158", "TEL_NUMBER": "", "CAMPO1": "2F9FCE11-A936-4BA7-989A-F715ECC3E134", "CAMPO2": "20238CF67A870F8843808D6825A6A9C07526QTP4", "CAMPO4": "" }, { "VBELN": "0071390313", "FKART": "ZSC1", "FKDAT": "20231004", "KUNNR": "2000000441", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF EL CENTRO", "AEDAT": "20231004", "AENAM": "MMORATAYA", "CTIME": "", "BZIRK": "SUP005", "NETWR": "917870.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025219", "TEL_NUMBER": "", "CAMPO1": "9FCACC4F-F656-4B09-8DE3-7C603B6C7E79", "CAMPO2": "2023862D4DF69A3347FBBB696E561236A8854PVH", "CAMPO4": "" }, { "VBELN": "0071390859", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000290", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MASFERRER", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2155020.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025068", "TEL_NUMBER": "", "CAMPO1": "1F1750C5-365A-48E1-901E-9AE324EBE998", "CAMPO2": "2023C946057417DE48D1B57907A3907D3F84VGX1", "CAMPO4": "" }, { "VBELN": "0071390860", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000299", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MULTIPLAZA", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "3198200.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025077", "TEL_NUMBER": "", "CAMPO1": "482FA232-BDD7-434D-9363-53C43B7C21A4", "CAMPO2": "2023759A7A070DBD4BFD9CBBF2D1BB4FED17DXR8", "CAMPO4": "" }, { "VBELN": "0071390861", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000299", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MULTIPLAZA", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "834550.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025077", "TEL_NUMBER": "", "CAMPO1": "C828400C-9142-4230-93DE-60EE384B18C8", "CAMPO2": "202360F47F4F18AD490F9AE9929B79D536C5RHX5", "CAMPO4": "" }, { "VBELN": "0071390862", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000301", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ESCALON", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1894030.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025079", "TEL_NUMBER": "", "CAMPO1": "16380101-6304-4627-8243-D9BDDECB2B89", "CAMPO2": "202393B2FFBA636648AABBF304BCEBD574BDL4BW", "CAMPO4": "" }, { "VBELN": "0071390863", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000301", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ESCALON", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "163960.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025079", "TEL_NUMBER": "", "CAMPO1": "ED97E581-977D-4025-B80C-4873A25E8B2F", "CAMPO2": "2023DB07877F35D24F99ACE4C34CE4CB50D2MJ5Q", "CAMPO4": "" }, { "VBELN": "0071390864", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000024357", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LAS CASCADAS", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1288420.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000052048", "TEL_NUMBER": "", "CAMPO1": "05DE247A-AD47-4856-B64D-5F9753A67AD4", "CAMPO2": "2023FEB06577CE5043BE9114EC814A6B9930IIHT", "CAMPO4": "" }, { "VBELN": "0071390865", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000024357", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LAS CASCADAS", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "135000.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000052048", "TEL_NUMBER": "", "CAMPO1": "C4CB6FB3-342D-4576-81EC-2CC46BA4E30C", "CAMPO2": "2023164F883D84CB43BFAB98C57DD1357D2FZS9X", "CAMPO4": "" }, { "VBELN": "0071390866", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000281", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS GIGANTE", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "2531440.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025059", "TEL_NUMBER": "", "CAMPO1": "BD7DCF90-8C06-4D49-ABD2-41FC43A34438", "CAMPO2": "2023873EEEA853514115B63912A6DCA308B9LNXB", "CAMPO4": "" }, { "VBELN": "0071390867", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000328", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS TRIGUEROS", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "410080.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025106", "TEL_NUMBER": "", "CAMPO1": "79D1D6E4-F0F5-4D86-B666-FF42EB748436", "CAMPO2": "2023484A797818BC460A86F79468B96A0D0AMZU3", "CAMPO4": "" }, { "VBELN": "0071390868", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000330", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ZACAMIL", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "2523880.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025108", "TEL_NUMBER": "", "CAMPO1": "895BE8F3-6C33-4DB3-8AFC-D53F87542471", "CAMPO2": "2023B00FBDF87E1C44C2A12064830F26A748FP2X", "CAMPO4": "" }, { "VBELN": "0071390869", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000377", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ESCALON NORTE", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "79600.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025155", "TEL_NUMBER": "", "CAMPO1": "B7601EEF-E9E1-4A56-BD25-8DD3A9FE4964", "CAMPO2": "2023D45546BE94AA4CFE8DD3A6B123D52DD1T4QC", "CAMPO4": "" }, { "VBELN": "0071390870", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000377", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ESCALON NORTE", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "2676850.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025155", "TEL_NUMBER": "", "CAMPO1": "0C528E22-E97F-4C01-9848-62F7FE1598EC", "CAMPO2": "20234CB0CBF8E1A94D42973BB260F1EBE8DEMHZT", "CAMPO4": "" }, { "VBELN": "0071390871", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000016677", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "WALMART SAN SALVADOR", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "5944820.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000041455", "TEL_NUMBER": "", "CAMPO1": "135CABD3-4EDD-4472-92A8-0412C2ED342F", "CAMPO2": "2023769D478051D8435E8391843BD3140287STYB", "CAMPO4": "" }, { "VBELN": "0071390872", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000016677", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "WALMART SAN SALVADOR", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "57520.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000041455", "TEL_NUMBER": "", "CAMPO1": "C64B4DE2-B5BB-4F35-A998-564992961349", "CAMPO2": "2023586F1E16A6A84C67B3F4F86BA7E763D9FDT3", "CAMPO4": "" }, { "VBELN": "0071390873", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000021877", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART CONSTITUCION", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "79200.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000047427", "TEL_NUMBER": "", "CAMPO1": "4472CC46-5D1C-4042-BF3C-42E571E2D122", "CAMPO2": "202353D5C13C36A34170935B8BB2B7889AD6YOAB", "CAMPO4": "" }, { "VBELN": "0071390874", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000021877", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART CONSTITUCION", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "1298060.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000047427", "TEL_NUMBER": "", "CAMPO1": "16E01404-3FA1-42F7-B4AF-4055FE411EA0", "CAMPO2": "202311CB760301F24F61AFE2944B56526551YUET", "CAMPO4": "" }, { "VBELN": "0071390875", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000273", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ARCE", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "1502690.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025051", "TEL_NUMBER": "", "CAMPO1": "029A49EE-6150-4DD4-BE32-9A19D5E7D687", "CAMPO2": "20236AB834A5BEBB440A8A8F457A5EA95517WNKZ", "CAMPO4": "" }, { "VBELN": "0071390876", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000276", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CENTRO", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "1162080.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025054", "TEL_NUMBER": "", "CAMPO1": "EC0A0992-9B85-4F30-9516-98306061650C", "CAMPO2": "202379EDC2A79F224AA187C7C4E8D79C9672VC9J", "CAMPO4": "" }, { "VBELN": "0071390877", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000277", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CENTRO ANTEL", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "952210.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025055", "TEL_NUMBER": "", "CAMPO1": "C5F6EF3F-754A-40B9-B834-016CBEFFE51D", "CAMPO2": "20231347E1C6B4264C53B3805AF9F2CE8C73YAEF", "CAMPO4": "" }, { "VBELN": "0071390878", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000277", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CENTRO ANTEL", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "1331180.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025055", "TEL_NUMBER": "", "CAMPO1": "0A500046-ABFF-45DE-8A92-C25796B20233", "CAMPO2": "2023AE66853E9AD54574AEA1BF7D5B3E2FB7OXD2", "CAMPO4": "" }, { "VBELN": "0071390879", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000374", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CENTRO LA LIBERTAD", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "1026250.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025152", "TEL_NUMBER": "", "CAMPO1": "34F17B60-003C-4BA4-9D59-738365521380", "CAMPO2": "20230BB845E873FF4F1D94BF43A8CD07BF02R7MP", "CAMPO4": "" }, { "VBELN": "0071390880", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000376", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF DARIO", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "715280.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025154", "TEL_NUMBER": "", "CAMPO1": "5E0D8AA4-5E4D-4CFB-B0CF-71A1BCD4AEE3", "CAMPO2": "202329AAA8B9FC194AD7BA6034C337C93EF47EVG", "CAMPO4": "" }, { "VBELN": "0071390881", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000270", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS APOPA I", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "2469070.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025048", "TEL_NUMBER": "", "CAMPO1": "2DE6C620-F165-4EAE-950D-596D39288F05", "CAMPO2": "20234A88EBF135D144C0A6C4B9E24C3DA57ANFM6", "CAMPO4": "" }, { "VBELN": "0071390882", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000279", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CIUDAD DELGADO", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "2068850.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025057", "TEL_NUMBER": "", "CAMPO1": "D0474ECA-466A-4C09-9AC2-AB4D5C7CE26B", "CAMPO2": "20234170ECA62CBF4B7AAB88DC5EDB08B0D3M5ZB", "CAMPO4": "" }, { "VBELN": "0071390883", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000279", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CIUDAD DELGADO", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1375000.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025057", "TEL_NUMBER": "", "CAMPO1": "EDC9CDDC-B92F-447B-834A-2653342BBB36", "CAMPO2": "2023590E04E51E214E0890C5233A1011BB32IAII", "CAMPO4": "" }, { "VBELN": "0071390884", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000291", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MEGA SELECTOS", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "3647060.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025069", "TEL_NUMBER": "", "CAMPO1": "2BD6EC28-F112-4C44-B99B-A0535DD2624E", "CAMPO2": "202379B5FBC84FB740B6B0ABD009F0C555311IJS", "CAMPO4": "" }, { "VBELN": "0071390885", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000291", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MEGA SELECTOS", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "184860.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025069", "TEL_NUMBER": "", "CAMPO1": "5F8CC37C-7E27-40F0-96C2-2F205E21B6EF", "CAMPO2": "2023DEDF9610E46249329C0597A4AB7DB3ACHBQK", "CAMPO4": "" }, { "VBELN": "0071390886", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000291", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MEGA SELECTOS", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "26000.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025069", "TEL_NUMBER": "", "CAMPO1": "AD1F2A57-FC9C-4AD5-85C6-A13D069EECA7", "CAMPO2": "2023916BD2C700754FC9BC847998C4B47C60REXP", "CAMPO4": "" }, { "VBELN": "0071390887", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000292", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MEJICANOS", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1907450.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025070", "TEL_NUMBER": "", "CAMPO1": "659BEF24-6AEE-4B33-AAA5-C92EA6B8FA8F", "CAMPO2": "202311CD7EB07A9D4976BAAD7006E8468927LOEI", "CAMPO4": "" }, { "VBELN": "0071390888", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000411", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF MEJICANOS", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "866450.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025189", "TEL_NUMBER": "", "CAMPO1": "B7CC1DC5-CAC3-41DB-96B8-94DD79FEDDF4", "CAMPO2": "202344DA4F5B3F01403CBD91A76CFBBF957CDWMU", "CAMPO4": "" }, { "VBELN": "0071390889", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000437", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CUSCATANCINGO", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "340890.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025215", "TEL_NUMBER": "", "CAMPO1": "B9FB8EAE-6A07-40F1-9D2E-96B9BBC1B21D", "CAMPO2": "2023926DE7472E8A478CBFCE2729330AB94E7FDB", "CAMPO4": "" }, { "VBELN": "0071390890", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000445", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CIUDAD DELGADO", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "547700.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025223", "TEL_NUMBER": "", "CAMPO1": "74602F21-DD8B-4CF0-9CF6-6ED6DE4EDD5D", "CAMPO2": "20231313BB259BDE496DB2323F7C22FB56BFBQ4W", "CAMPO4": "" }, { "VBELN": "0071390891", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000446", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF APOPA PERICENTRO", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "965130.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025224", "TEL_NUMBER": "", "CAMPO1": "BD44BA17-4AF7-4AA4-B1A8-84E736EE7EA6", "CAMPO2": "2023E813D48AEB1C4B628501D604FEF1D4BDCTJS", "CAMPO4": "" }, { "VBELN": "0071390892", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000024504", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI PRADOS DE VENECIA", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1786850.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000052430", "TEL_NUMBER": "", "CAMPO1": "D895B8DC-2752-4CCD-88E3-59AF860460A5", "CAMPO2": "20234DB73F0553694296B541057A7B38414BNBQ5", "CAMPO4": "" }, { "VBELN": "0071390893", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000024876", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CUSCATANCINGO NORTE", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "725550.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000053067", "TEL_NUMBER": "", "CAMPO1": "B4A07667-9F8E-406C-BC77-4C451FEB04DB", "CAMPO2": "20235D0BBE4177694FF5AD5D270FC095C76EALWD", "CAMPO4": "" }, { "VBELN": "0071390894", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000029100", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SELECTOS PLAZA MUNDO APO", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "5800700.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000059675", "TEL_NUMBER": "", "CAMPO1": "24D67420-5F60-4BD6-BBBE-AC4E80544571", "CAMPO2": "202393AA6D499F4C4FEBB02E4EEC6E8ED8A840UL", "CAMPO4": "" }, { "VBELN": "0071390895", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000029100", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SELECTOS PLAZA MUNDO APO", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "439940.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000059675", "TEL_NUMBER": "", "CAMPO1": "32690768-25B3-493F-A521-75C3C72D1E34", "CAMPO2": "2023AEA905583DA94374810C125C7CF617827FRN", "CAMPO4": "" }, { "VBELN": "0071390896", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000268", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS AGUILARES", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1834860.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025046", "TEL_NUMBER": "", "CAMPO1": "49FA9A0A-E7B5-4669-9706-0431D42C88B1", "CAMPO2": "20234815D7E2FFF74BF787D4C85029ED302EQNGR", "CAMPO4": "" }, { "VBELN": "0071390897", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000271", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS APOPA III", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "2102550.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025049", "TEL_NUMBER": "", "CAMPO1": "FFD15D57-5AFD-469E-A835-DA3E449D57AB", "CAMPO2": "20237D3C375AC1804C90A612F059E903EF39AD4Y", "CAMPO4": "" }, { "VBELN": "0071390898", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000271", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS APOPA III", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "41940.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025049", "TEL_NUMBER": "", "CAMPO1": "76D146D7-92A8-48B1-A686-EF57C044E090", "CAMPO2": "2023A8D65DBCDF1B418684E9BA80899F8423XUY0", "CAMPO4": "" }, { "VBELN": "0071390899", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000272", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS APOPA II", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "353270.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025050", "TEL_NUMBER": "", "CAMPO1": "8481EDC6-730B-48DE-B3DA-60BC0D3D4986", "CAMPO2": "2023FC425FFEAD6247638B0E1D9DA3DD0158CASN", "CAMPO4": "" }, { "VBELN": "0071390900", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000353", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS QUEZALTEPEQUE", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "2941460.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025131", "TEL_NUMBER": "", "CAMPO1": "58FC6FFB-112B-444B-AA2E-4791CA8706A3", "CAMPO2": "20233B4BF5A6ADE24CB89AA783CFC95E1F35WXD0", "CAMPO4": "" }, { "VBELN": "0071390901", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000353", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS QUEZALTEPEQUE", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "110850.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025131", "TEL_NUMBER": "", "CAMPO1": "D8A2E275-E1C5-4DEF-99DA-79F259E7E0F0", "CAMPO2": "20231C175E3D89A2406892509A0F4613974ETKTT", "CAMPO4": "" }, { "VBELN": "0071390902", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000396", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF AGUILARES", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "572680.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025174", "TEL_NUMBER": "", "CAMPO1": "32341048-CA83-476B-BAB1-9E1CE92E1E28", "CAMPO2": "202326BAC50336254412BCB67C8E6561B1BA3DGK", "CAMPO4": "" }, { "VBELN": "0071390903", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000398", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF APOPA", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1486120.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025176", "TEL_NUMBER": "", "CAMPO1": "5CED4ED6-2196-48D1-9E65-A2CB3A9B7B5B", "CAMPO2": "202355F17CE5A4264F5985ADC7EEB5DD105B0JCX", "CAMPO4": "" }, { "VBELN": "0071390904", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000413", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF QUEZALTEPEQUE", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1225390.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025191", "TEL_NUMBER": "", "CAMPO1": "4F4190F8-B99F-45E2-AD08-1BE36381F887", "CAMPO2": "2023253D736F8A6344C18BA6F6EB8369C240NCTP", "CAMPO4": "" }, { "VBELN": "0071390905", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000439", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF QUEZALTEPEQUE 2", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1142770.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025217", "TEL_NUMBER": "", "CAMPO1": "AEC08120-D39C-4869-8230-AE2BB16E8CA8", "CAMPO2": "2023427B5F45E33D40B88E7E87EDAECD9844VCFN", "CAMPO4": "" }, { "VBELN": "0071390906", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000022862", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "MAXI APOPA", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1602730.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000049394", "TEL_NUMBER": "", "CAMPO1": "5CF6E59B-C02D-4366-B868-039CA7E51164", "CAMPO2": "2023675A63E8E95543F19DA2ADC28C0C4A8B4TBI", "CAMPO4": "" }, { "VBELN": "0071390907", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000032378", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SEL. AGUILARES EL ENCUEN", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "2232060.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000064531", "TEL_NUMBER": "", "CAMPO1": "F864001C-D07F-4F52-B2E2-1A750765EBF4", "CAMPO2": "2023756EA7ABE98E4ED89EDA675AB4A8BDB68HJM", "CAMPO4": "" }, { "VBELN": "0071390909", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000269", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS AHUACHAPAN", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "4287880.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025047", "TEL_NUMBER": "", "CAMPO1": "F9CBC3D2-98A6-489A-83DC-841897EDCEF7", "CAMPO2": "202359CEC944682441C09CD5DCDC730D9DD3DZNF", "CAMPO4": "" }, { "VBELN": "0071390910", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000269", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS AHUACHAPAN", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "328090.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025047", "TEL_NUMBER": "", "CAMPO1": "6562FE9A-52EA-401A-8529-974033C2116A", "CAMPO2": "2023A01A12F7B0D949F28EA1A5550A01FC138DOQ", "CAMPO4": "" }, { "VBELN": "0071390911", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000317", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CIUDAD REAL", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "3134030.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025095", "TEL_NUMBER": "", "CAMPO1": "3D599BDE-FF75-48BB-8FEA-7AEAE9D24796", "CAMPO2": "2023F5A3B212C65B4C93967AAB573E520BF64GVM", "CAMPO4": "" }, { "VBELN": "0071390912", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000026477", "NAME1": "OPERADORA DEL SUR, S.A. DE  C.", "NAME2": "MAXI DESPENSA AHUCHAPAN", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2192810.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000055413", "TEL_NUMBER": "", "CAMPO1": "9928D43C-2902-4365-9D88-7944B973CC57", "CAMPO2": "2023B157B4A3AE9C4D42A7135447D40AE83DWU0F", "CAMPO4": "" }, { "VBELN": "0071390913", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000302", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS PLAZA MERLIOT", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "677660.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025080", "TEL_NUMBER": "", "CAMPO1": "9C6D9196-29CD-4B90-A4D0-F4EE0283638F", "CAMPO2": "202333818050B96949B18B1C7117F48247B6BMJO", "CAMPO4": "" }, { "VBELN": "0071390914", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000302", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS PLAZA MERLIOT", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1737030.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025080", "TEL_NUMBER": "", "CAMPO1": "A32ADC4C-49CC-4783-A4B6-6D70B3B4490D", "CAMPO2": "202338FDC07CD3094FE3A5CF8C7E89FF80E0LD5E", "CAMPO4": "" }, { "VBELN": "0071390915", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000323", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA TECLA", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1802530.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025101", "TEL_NUMBER": "", "CAMPO1": "89BB4E6A-A182-40E3-A775-5155C474D4A6", "CAMPO2": "20235C218AA59755423E8680734D5CD7BDB7MMUS", "CAMPO4": "" }, { "VBELN": "0071390916", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000379", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ JARDINES DE LA LIBERTAD", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "772170.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025157", "TEL_NUMBER": "", "CAMPO1": "6AFC338E-ACAB-4485-A876-CC528A226FA4", "CAMPO2": "202335E6E83C53534390B5F9B26E70E56AD8RN81", "CAMPO4": "" }, { "VBELN": "0071390917", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000421", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SANTA TECLA", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "896580.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025199", "TEL_NUMBER": "", "CAMPO1": "C4E4147C-3698-4003-A530-532D32F5DEB1", "CAMPO2": "20232BD5295E711D417AA56A39418E75A011WP7K", "CAMPO4": "" }, { "VBELN": "0071390918", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000438", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SAN MARTIN", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1602920.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025216", "TEL_NUMBER": "", "CAMPO1": "53584BE4-9846-42D6-B883-BC3F6A96C4F9", "CAMPO2": "2023441D1AD98DB64598B86AA2B1D477CCF1DMC0", "CAMPO4": "" }, { "VBELN": "0071390919", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000023672", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ROSA", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "3280180.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000050677", "TEL_NUMBER": "", "CAMPO1": "FBA53484-DB36-4FFF-A269-CC556DE74DD6", "CAMPO2": "2023786923C8433F4341BEAE0AA80584077EVQOU", "CAMPO4": "" }, { "VBELN": "0071390920", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000023672", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ROSA", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "277500.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000050677", "TEL_NUMBER": "", "CAMPO1": "0E2912D9-02EE-44B7-8DB4-B71F79C56C38", "CAMPO2": "202388C77C7D37C14CB9BEB322092D864251YDYE", "CAMPO4": "" }, { "VBELN": "0071390921", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000342", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS AHUACHAPAN II", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2467040.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025120", "TEL_NUMBER": "", "CAMPO1": "53DF1264-C0DD-4971-86A1-F0603F066BC0", "CAMPO2": "2023302DFDC94C4D4B8DA281F498AAF9BCF7UZKV", "CAMPO4": "" }, { "VBELN": "0071390922", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000344", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS CHALCHUAPA", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2635870.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025122", "TEL_NUMBER": "", "CAMPO1": "133BDEF6-5F03-45FB-88CB-96EAADDE5D7E", "CAMPO2": "2023DBB28BB7286E4EB69F96E354EF213910ZYSJ", "CAMPO4": "" }, { "VBELN": "0071390923", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000397", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF AHUACHAPAN", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1441240.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025175", "TEL_NUMBER": "", "CAMPO1": "0A01F083-68BD-4644-882F-824200CFBB90", "CAMPO2": "2023EEBD4E9F7B2448BB9031B0623A121BC1HNTF", "CAMPO4": "" }, { "VBELN": "0071390924", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000400", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF ATIQUIZAYA", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1665200.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025178", "TEL_NUMBER": "", "CAMPO1": "17A2B775-97B6-4F8E-86A3-F3CEFE7ACDA9", "CAMPO2": "2023CEA71182873242BF8ABCEAFB12E0F7F8YTTL", "CAMPO4": "" }, { "VBELN": "0071390925", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000000404", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CHALCHUAPA", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1837190.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025182", "TEL_NUMBER": "", "CAMPO1": "48A3CE60-9B1B-4C66-B646-CF2A1A0DC4A7", "CAMPO2": "2023C25D808E2D1D4023BBD7D8DB9926775DIKAF", "CAMPO4": "" }, { "VBELN": "0071390926", "FKART": "ZSC1", "FKDAT": "20231005", "KUNNR": "2000023528", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS ATIQUIZAYA", "AEDAT": "20231005", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2202140.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000050443", "TEL_NUMBER": "", "CAMPO1": "0D6C760A-E78D-4394-8215-A519D73B3708", "CAMPO2": "2023DAD7C72FAFB842198075DC7B44CA4C61RQCX", "CAMPO4": "" }, { "VBELN": "0071391385", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000316", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ANA CENTRO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "3542480.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025094", "TEL_NUMBER": "", "CAMPO1": "B7575B24-42F2-424C-9108-887B549C12E6", "CAMPO2": "2023D273E60252BD4F15BDBBEAB3A48C8337GLRN", "CAMPO4": "" }, { "VBELN": "0071391386", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000316", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ANA CENTRO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "206840.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025094", "TEL_NUMBER": "", "CAMPO1": "80CD70D6-EF51-4CFF-ADA8-B0006750C2F6", "CAMPO2": "2023D04FB234C52D4600AD9A738D6E8DFE19L5N5", "CAMPO4": "" }, { "VBELN": "0071391387", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000318", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ANA COLON", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1759450.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025096", "TEL_NUMBER": "", "CAMPO1": "83128E66-7986-4813-89CC-88EF76A16FFC", "CAMPO2": "202395F70218ACAC418BA2AD2663AE448225HNFA", "CAMPO4": "" }, { "VBELN": "0071391388", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000319", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ANA METROCENTRO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "3895530.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025097", "TEL_NUMBER": "", "CAMPO1": "BEB6C0F5-9977-433F-A07E-D79832228215", "CAMPO2": "2023B6CC10FF064B46F2A4D15A546FA33B7BDLGT", "CAMPO4": "" }, { "VBELN": "0071391389", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000389", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CATEDRAL SANTA ANA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "142380.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025167", "TEL_NUMBER": "", "CAMPO1": "6FAB825C-226C-44C1-AFF4-55469D7996DF", "CAMPO2": "202309DDA835640B4740AFD2C1C159F1CE02IVPZ", "CAMPO4": "" }, { "VBELN": "0071391390", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000389", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CATEDRAL SANTA ANA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1333390.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025167", "TEL_NUMBER": "", "CAMPO1": "DDA44DC7-95FF-4829-9BF8-58448534E370", "CAMPO2": "2023AF8439D6EF904E6B8D8545A66BA6E7206FOU", "CAMPO4": "" }, { "VBELN": "0071391391", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000390", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ SANTA ANA PALMAR", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2877770.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025168", "TEL_NUMBER": "", "CAMPO1": "E3308D35-69BD-465A-8500-A93D3054FA79", "CAMPO2": "2023602EB19ACB504744813173DC47821FCBWWDP", "CAMPO4": "" }, { "VBELN": "0071391392", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000418", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SANTA ANA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "868120.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025196", "TEL_NUMBER": "", "CAMPO1": "E93CEF73-7CEE-4EAF-A9BD-55A81457545B", "CAMPO2": "20239134D5DB0559429E8197A4490045F6A7L31N", "CAMPO4": "" }, { "VBELN": "0071391393", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000419", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SANTA ANA COLON", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2297030.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025197", "TEL_NUMBER": "", "CAMPO1": "A65C01A4-D34B-4760-B0DD-21E2569386A5", "CAMPO2": "20237CC9DEE83552497CBF915E2977EA2842S9II", "CAMPO4": "" }, { "VBELN": "0071391394", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000449", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "MAXI DESPENSA SANTA ANA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2666050.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025227", "TEL_NUMBER": "", "CAMPO1": "16C8BC91-F960-4AF6-863A-58F9C694CF2B", "CAMPO2": "2023FE4B0AE01D41451FA2A914E19AA78D5CVRTB", "CAMPO4": "" }, { "VBELN": "0071391395", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000024215", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SANTA ANA NORTE", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1011110.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000051710", "TEL_NUMBER": "", "CAMPO1": "213A881B-1957-48E2-9590-6116C34BE9E7", "CAMPO2": "20238040158954E0499E989105BB48AD1BB8W5UD", "CAMPO4": "" }, { "VBELN": "0071391396", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000028933", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "WM SANTA ANA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "3649910.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000059447", "TEL_NUMBER": "", "CAMPO1": "C067F607-A51C-4C98-93BB-6F57E63FB88C", "CAMPO2": "2023744374C4323A422CA1B28C12DDF2BDC9C8ZE", "CAMPO4": "" }, { "VBELN": "0071391397", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000028933", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "WM SANTA ANA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "136680.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000059447", "TEL_NUMBER": "", "CAMPO1": "61B734F7-BFB3-43DE-9B2E-01083A8CA914", "CAMPO2": "2023A6D81D9573394265A1ACD24B3D18EE15E2LR", "CAMPO4": "" }, { "VBELN": "0071391398", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000029227", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI DESPENSA SAN JUAN", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1064670.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000059876", "TEL_NUMBER": "", "CAMPO1": "ABE42260-15E5-4B87-8C3D-376FA7559DF0", "CAMPO2": "2023B9A1C2C99E624FA590A93036AADC5D64QRWY", "CAMPO4": "" }, { "VBELN": "0071391399", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000033502", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUP. SELECTOS SANTA ANA LAS RA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1833920.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000066171", "TEL_NUMBER": "", "CAMPO1": "17911CFF-68AB-4874-907A-30B2F88AB50A", "CAMPO2": "2023292985F70E68491888A079E1BE869C6DYMMV", "CAMPO4": "" }, { "VBELN": "0071391401", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000283", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA JOYA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1973040.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025061", "TEL_NUMBER": "", "CAMPO1": "33FAB640-6AAC-42B6-A9DC-46D6F0417C89", "CAMPO2": "20238495F54E27CA41A9986F3F211B0E9C05QKJE", "CAMPO4": "" }, { "VBELN": "0071391402", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000284", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS EL FARO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "195100.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025062", "TEL_NUMBER": "", "CAMPO1": "0BA5F587-6E6B-4F2B-AEA9-BAFCD396187B", "CAMPO2": "2023792968E350BA48498159B62E39F36A51BBBT", "CAMPO4": "" }, { "VBELN": "0071391403", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000284", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS EL FARO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1039790.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025062", "TEL_NUMBER": "", "CAMPO1": "F13AF335-CDE2-40A4-A144-91CC148F5D00", "CAMPO2": "20230DDA75A56F33483794066768904F9A56WSIZ", "CAMPO4": "" }, { "VBELN": "0071391404", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000293", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MERLIOT II", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "168480.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025071", "TEL_NUMBER": "", "CAMPO1": "1FCFD68C-D5ED-41F3-ADBB-B31189C6928C", "CAMPO2": "202398444C41827849479B48B788AF77D951XDN4", "CAMPO4": "" }, { "VBELN": "0071391405", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000293", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MERLIOT II", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2538580.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025071", "TEL_NUMBER": "", "CAMPO1": "E3BB6C24-982E-4811-8ECD-36E7E42922B9", "CAMPO2": "20230A3D9A1A0AC24463B7E92B1D27DB3BBF2FCL", "CAMPO4": "" }, { "VBELN": "0071391406", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000300", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS NOVOCENTRO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "988520.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025078", "TEL_NUMBER": "", "CAMPO1": "1D8493F7-CB7D-4A02-A924-C9ADBEF275FE", "CAMPO2": "2023BE605904182A4DDDB9FE0632DD7F0248RMTM", "CAMPO4": "" }, { "VBELN": "0071391407", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000333", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ZARAGOZA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1359330.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025111", "TEL_NUMBER": "", "CAMPO1": "A3644BC7-96D7-4D84-ACB6-30CFC6C9DB68", "CAMPO2": "202331CCBD57D0284E3A966CC201881D556AWECD", "CAMPO4": "" }, { "VBELN": "0071391408", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000339", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LAS PALMAS", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2257060.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025117", "TEL_NUMBER": "", "CAMPO1": "F7850355-E482-42C2-994E-30B353CE76D7", "CAMPO2": "2023090ED7DA20524CFABA5A2051BCA2DFC5RDJI", "CAMPO4": "" }, { "VBELN": "0071391409", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000339", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LAS PALMAS", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "196560.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025117", "TEL_NUMBER": "", "CAMPO1": "4911507B-D3EE-4132-ADB1-8963D8F4C87F", "CAMPO2": "2023D92C072B4F544372B65867918F3E3742CPWI", "CAMPO4": "" }, { "VBELN": "0071391410", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000350", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS LIBERTAD", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1201050.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025128", "TEL_NUMBER": "", "CAMPO1": "B3A006BA-8F9A-408D-933A-E65278580237", "CAMPO2": "2023A84A95537FF847F4B17DE62385DD856FPTIX", "CAMPO4": "" }, { "VBELN": "0071391411", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000378", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ HOLANDA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "15840.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025156", "TEL_NUMBER": "", "CAMPO1": "6D583756-9612-4B2D-96E4-12E465F48868", "CAMPO2": "2023AFAB5C2C891A46E28FADF4C8A02C47E8TVIR", "CAMPO4": "" }, { "VBELN": "0071391412", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000378", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ HOLANDA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "522360.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025156", "TEL_NUMBER": "", "CAMPO1": "34D8FE4C-FDF4-4CEF-A734-E628DEE316D6", "CAMPO2": "2023B71DCBDF950C468BB06F48CDA792E03AQRMU", "CAMPO4": "" }, { "VBELN": "0071391413", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000378", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ HOLANDA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2064130.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025156", "TEL_NUMBER": "", "CAMPO1": "00E5F6B4-E194-46B3-97F5-8C4F97E8BF4B", "CAMPO2": "2023FC276B07FE464D868E8E1032E33D1B41NA4Q", "CAMPO4": "" }, { "VBELN": "0071391414", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000408", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF LA LIBERTAD", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2509930.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025186", "TEL_NUMBER": "", "CAMPO1": "CF3EB68C-DD68-42CC-B670-657ABE1D6D08", "CAMPO2": "2023C935B7554D1B4326911B8B01968A670AWWKG", "CAMPO4": "" }, { "VBELN": "0071391415", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000037973", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "S. SELECTOS SANTA TECLA LAS RA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2604670.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000070781", "TEL_NUMBER": "", "CAMPO1": "B11CF261-904D-4469-AE8D-84C4999C699E", "CAMPO2": "2023057AF4CB1FB841D3B2017FDCEF3B7603CYIJ", "CAMPO4": "" }, { "VBELN": "0071391416", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000037973", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "S. SELECTOS SANTA TECLA LAS RA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "42240.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000070781", "TEL_NUMBER": "", "CAMPO1": "FBED29C9-1969-4223-A957-A08ADF5942AE", "CAMPO2": "2023DCB9FE1A398D4274913D8E7D2F027785OOPW", "CAMPO4": "" }, { "VBELN": "0071391420", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000274", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS AUTOPISTA SUR", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2209900.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025052", "TEL_NUMBER": "", "CAMPO1": "D099558F-D38A-4087-89C7-E75D0CF3C6B7", "CAMPO2": "2023E76C633045BC49DB930F2BEE4B5E7ED0YKVX", "CAMPO4": "" }, { "VBELN": "0071391421", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000275", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS BETHOVEN", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "505360.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025053", "TEL_NUMBER": "", "CAMPO1": "14847A47-BECD-473E-B50B-966F655A2E98", "CAMPO2": "20230CC809E654894A34AB5D481764B42BCCDRPL", "CAMPO4": "" }, { "VBELN": "0071391422", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000282", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA CIMA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2710440.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025060", "TEL_NUMBER": "", "CAMPO1": "AAD72DA0-317E-483B-AD65-4C810F70EA81", "CAMPO2": "20237DAF7E951E914FDEBE1D3AD44D44B5EB0II9", "CAMPO4": "" }, { "VBELN": "0071391423", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000282", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA CIMA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "14040.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025060", "TEL_NUMBER": "", "CAMPO1": "0E83AC62-B64A-4778-AE06-10A3D4D3E817", "CAMPO2": "2023774BD9AB837945AFBFD50CE826B7F704CN7T", "CAMPO4": "" }, { "VBELN": "0071391424", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000285", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA SULTANA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2435620.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025063", "TEL_NUMBER": "", "CAMPO1": "47F556F6-73A2-4345-A23F-E218FFF8EE7C", "CAMPO2": "20238118B0D7914E418C8934949AC92C500ED9ON", "CAMPO4": "" }, { "VBELN": "0071391425", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000285", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA SULTANA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1202990.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025063", "TEL_NUMBER": "", "CAMPO1": "BDE3DA13-39D1-4792-BFCD-F0307A979471", "CAMPO2": "20230A5A3D2B826D4D459BD7EAB32AE28737ME6M", "CAMPO4": "" }, { "VBELN": "0071391426", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000021876", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ELENA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1166130.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000047424", "TEL_NUMBER": "", "CAMPO1": "0329CF03-F7DC-4D57-9C69-54F32C55BFDC", "CAMPO2": "202336D6A78557CB4884BBAF7B919A611AA0SAFZ", "CAMPO4": "" }, { "VBELN": "0071391427", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000021876", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ELENA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2000670.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000047424", "TEL_NUMBER": "", "CAMPO1": "876415D0-96C3-4940-845B-501E818EABA2", "CAMPO2": "20235304FE4C376A43F18E46E8EF41F99AB23AVO", "CAMPO4": "" }, { "VBELN": "0071391428", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000025859", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SANTA ELENA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1823260.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000054717", "TEL_NUMBER": "", "CAMPO1": "BAFE6814-0CC3-42AA-9B29-C24EAB784293", "CAMPO2": "2023BDDE6DDAD44C433780FC96C9E3EEC0CDAVYF", "CAMPO4": "" }, { "VBELN": "0071391429", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000025859", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SANTA ELENA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2138290.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000054717", "TEL_NUMBER": "", "CAMPO1": "444FB4FC-0933-49F3-AAE7-717A23EB72FF", "CAMPO2": "202326CA9B1B74AB44438B381541D2F8CB31N1YT", "CAMPO4": "" }, { "VBELN": "0071391430", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000025859", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SANTA ELENA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "281400.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000054717", "TEL_NUMBER": "", "CAMPO1": "164BF6EF-022F-4E57-A178-D34145105A82", "CAMPO2": "20234BCF98782DA94434BE2F319ADD36A167PWQC", "CAMPO4": "" }, { "VBELN": "0071391431", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000294", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS METROCENTRO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "3380090.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025072", "TEL_NUMBER": "", "CAMPO1": "AE8D0F10-A807-4CE3-8A85-4AC890FF88F7", "CAMPO2": "20236AA61A5BD2D64B6C9653F766E91F331F58G0", "CAMPO4": "" }, { "VBELN": "0071391432", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000296", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS METROSUR", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "1521580.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025074", "TEL_NUMBER": "", "CAMPO1": "9CFD7522-67C5-42FB-83F2-24AAF5A75DFB", "CAMPO2": "2023D490D0A22AB84DBCB1079D74DCAB2A50LPHB", "CAMPO4": "" }, { "VBELN": "0071391433", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000307", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN LUIS", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "4010280.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025085", "TEL_NUMBER": "", "CAMPO1": "C41CF4D1-45F5-4B0B-910C-3F30598A511E", "CAMPO2": "20231B64939A3464489587D74728EEB4F92EZA6W", "CAMPO4": "" }, { "VBELN": "0071391434", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000307", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN LUIS", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "2877190.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025085", "TEL_NUMBER": "", "CAMPO1": "7EE97524-030A-4FC4-8B99-FFA4E5A15671", "CAMPO2": "20231257A71ACF7849309EF543C4B408FE5DBQHO", "CAMPO4": "" }, { "VBELN": "0071391435", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000336", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS METROCENTRO 8av ETAPA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "3103920.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025114", "TEL_NUMBER": "", "CAMPO1": "3A354E1F-E8CE-4FD7-811B-9BD6B4C693B9", "CAMPO2": "2023A2EF26B745844FAC8C88BB4174F8BF0DBT76", "CAMPO4": "" }, { "VBELN": "0071391436", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000373", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ AYUTUXTEPEQUE", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "32590.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025151", "TEL_NUMBER": "", "CAMPO1": "E1BF4403-55F6-4235-B40C-36286913CC58", "CAMPO2": "20232F3609C1C72B456DB5E012A46E5DABD57JWX", "CAMPO4": "" }, { "VBELN": "0071391437", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000373", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ AYUTUXTEPEQUE", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "6750.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025151", "TEL_NUMBER": "", "CAMPO1": "D76386D9-C51C-4D22-B1FE-6D7C62CD69E3", "CAMPO2": "202366E73A6701F642BA81547B28F278372D887I", "CAMPO4": "" }, { "VBELN": "0071391438", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000373", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ AYUTUXTEPEQUE", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "1817640.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025151", "TEL_NUMBER": "", "CAMPO1": "D586E250-B5DC-43E4-8885-040944A57AB8", "CAMPO2": "2023AD951F6E2F904403BA199B63729F6A485NDW", "CAMPO4": "" }, { "VBELN": "0071391439", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000383", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ LOS HEROES", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "974880.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025161", "TEL_NUMBER": "", "CAMPO1": "ED5B3D3B-5D42-48B0-874B-A78AA3FAED15", "CAMPO2": "2023B2867EB37F0F49DAA359B2901AC1FD12GQWK", "CAMPO4": "" }, { "VBELN": "0071391440", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000383", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ LOS HEROES", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "1462910.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025161", "TEL_NUMBER": "", "CAMPO1": "77CE725E-69CA-4669-8AE0-5F588635E9A6", "CAMPO2": "20236E0E2C8E5F6D4334985D51C857F85702FC7C", "CAMPO4": "" }, { "VBELN": "0071391441", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000305", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN JACINTO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "3463500.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025083", "TEL_NUMBER": "", "CAMPO1": "CF19CE1F-D2F4-40F6-BC42-6FB32660EDA5", "CAMPO2": "202384ED4C56A06E447D84EF7595EE691F30UMHB", "CAMPO4": "" }, { "VBELN": "0071391442", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000444", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SAN JACINTO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "659800.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025222", "TEL_NUMBER": "", "CAMPO1": "F8CAFDDB-C8FF-4B56-82D3-813B7244FC05", "CAMPO2": "20230177AA17CD3149089A943E21855B0AB5QMJ3", "CAMPO4": "" }, { "VBELN": "0071391443", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000448", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "MAXI BODEGA SAN MARCOS", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "169500.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025226", "TEL_NUMBER": "", "CAMPO1": "70525B09-3528-4169-8092-C2EB234C51D5", "CAMPO2": "2023B34E3A3F66B84EC7B0A6C7581DB3DCB6XXBE", "CAMPO4": "" }, { "VBELN": "0071391444", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000448", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "MAXI BODEGA SAN MARCOS", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "2301470.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025226", "TEL_NUMBER": "", "CAMPO1": "7FE4971D-9BE7-49E3-94B5-DF0AE3636803", "CAMPO2": "2023EEBED6B20F514FE982A9830F02D298BCUFQJ", "CAMPO4": "" }, { "VBELN": "0071391445", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000023604", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTO TOMAS", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "2845190.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000050544", "TEL_NUMBER": "", "CAMPO1": "1D5D016F-F533-4B8F-B613-E74C269B6FF2", "CAMPO2": "2023BC68635BD6B24AD98237F4E88306BAC7IZDJ", "CAMPO4": "" }, { "VBELN": "0071391446", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000026543", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "S. SELECTOS SAN MARCOS EL ENCU", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "4001090.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000055524", "TEL_NUMBER": "", "CAMPO1": "901C96DA-CB38-4854-AAB4-7483530231A6", "CAMPO2": "20236815C662CE1341749894270B1C0376F0BZ8O", "CAMPO4": "" }, { "VBELN": "0071391449", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000303", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS PLAZA MUNDO #203", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "4607700.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025081", "TEL_NUMBER": "", "CAMPO1": "CE6931C3-29CD-4D51-AB93-64420DF5B036", "CAMPO2": "2023D7F63A0F9D61423FBF4AE11DDF952B09HFKC", "CAMPO4": "" }, { "VBELN": "0071391450", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000321", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA LUCIA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "2030080.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025099", "TEL_NUMBER": "", "CAMPO1": "89F775FD-3524-4909-B3FA-54AB3946CCF9", "CAMPO2": "202325E88D162EE54D749FF7D802833E1561X1UH", "CAMPO4": "" }, { "VBELN": "0071391451", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000327", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SOYAPANGO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1532660.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025105", "TEL_NUMBER": "", "CAMPO1": "D0596F93-D944-443C-B050-B29429BF1B93", "CAMPO2": "2023140C3C9079BC4FDF886283D4373C941BHEMP", "CAMPO4": "" }, { "VBELN": "0071391452", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000367", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SOYAPANGO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "110880.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025145", "TEL_NUMBER": "", "CAMPO1": "3C214B27-FEC4-4CD0-B430-37EAE45E5227", "CAMPO2": "2023BF89623AE752476D8DAF060960A9A3493DYV", "CAMPO4": "" }, { "VBELN": "0071391453", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000427", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SOYAPANGO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "697390.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025205", "TEL_NUMBER": "", "CAMPO1": "C174D390-266A-4A91-A82D-7BCC17FD3C1D", "CAMPO2": "20237DC0847E0EAE48939D10601FBAC79B43CGTQ", "CAMPO4": "" }, { "VBELN": "0071391454", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000023323", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI DESPENSA BOULEVARD DEL EJ", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "428220.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000050035", "TEL_NUMBER": "", "CAMPO1": "3A77A2DD-E70F-4ED9-9A22-D8AE614C1FB2", "CAMPO2": "2023A41760DB6E064BC1BFCDD9D43564B39APCT4", "CAMPO4": "" }, { "VBELN": "0071391455", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000335", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SENSUNTEPEQUE", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1534990.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025113", "TEL_NUMBER": "", "CAMPO1": "9CC2E9E1-AF83-412B-BB8F-34A3C765C172", "CAMPO2": "20237B36F2FCA8BE486A857761B8EE8455ACTAHT", "CAMPO4": "" }, { "VBELN": "0071391456", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000338", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS COJUTEPEQUE CENTRO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1568650.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025116", "TEL_NUMBER": "", "CAMPO1": "7E9F1CA1-1D95-4E67-A6DD-084EE8080DB4", "CAMPO2": "202312C1FB0FC3E94E489BBD33E7124372EBQJWM", "CAMPO4": "" }, { "VBELN": "0071391457", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000345", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS COJUTEPEQUE II", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1264610.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025123", "TEL_NUMBER": "", "CAMPO1": "89F0B5FF-EE7C-4DF0-B4C3-52FD00FE72EA", "CAMPO2": "2023F08612408D294916A411B5191998856EVQRP", "CAMPO4": "" }, { "VBELN": "0071391458", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000346", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS ILOBASCO II", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1019920.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025124", "TEL_NUMBER": "", "CAMPO1": "78791A71-1F0F-4718-90D8-80727164A25A", "CAMPO2": "2023DBF4743B3E5F4200B5D0EEB2D7CA60BFR0PG", "CAMPO4": "" }, { "VBELN": "0071391459", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000352", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ILOBASCO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1314430.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025130", "TEL_NUMBER": "", "CAMPO1": "EC2BD8C3-3928-4C60-9111-C60A4FBE793D", "CAMPO2": "20231BC3EC4701E54B108B979F81EF326298E6UO", "CAMPO4": "" }, { "VBELN": "0071391460", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000405", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF COJUTEPEQUE", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "377450.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025183", "TEL_NUMBER": "", "CAMPO1": "F9C11149-3283-4CAF-952D-A8CE3E988419", "CAMPO2": "2023A01A6168B32E4C28B3D61712F9F2F066L2QS", "CAMPO4": "" }, { "VBELN": "0071391461", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000424", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SENSUNTEPEQUE", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "699210.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025202", "TEL_NUMBER": "", "CAMPO1": "D926203C-2547-4755-BF10-E09E90F174D2", "CAMPO2": "2023B0D7E559D7DF4C948675A7B1C4E2F6A8UTBJ", "CAMPO4": "" }, { "VBELN": "0071391462", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000026814", "NAME1": "OPERADORA DEL SUR, S.A. DE  C.", "NAME2": "MAXI DESPENSA ILOBASCO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1110460.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000056069", "TEL_NUMBER": "", "CAMPO1": "0B346B7E-033B-4EB0-BA71-17773E467B19", "CAMPO2": "2023859C927C07FA400792E9E37C0EAE3569LRUP", "CAMPO4": "" }, { "VBELN": "0071391473", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000320", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA EMILIA", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1855260.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025098", "TEL_NUMBER": "", "CAMPO1": "0C24CE9D-0137-4464-9326-7397B1E097DF", "CAMPO2": "202339DE30B610B04A8A9A3F34B7DCB56B6AAC3P", "CAMPO4": "" }, { "VBELN": "0071391474", "FKART": "ZSC1", "FKDAT": "20231006", "KUNNR": "2000000367", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SOYAPANGO", "AEDAT": "20231006", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "6409090.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025145", "TEL_NUMBER": "", "CAMPO1": "9A96F19B-F672-49DF-A424-CF734B227505", "CAMPO2": "2023D42B8DBC5D0240A3B6CF5F7E6702CD6DHTDL", "CAMPO4": "" }, { "VBELN": "0071392025", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000324", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SONSONATE", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "714810.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025102", "TEL_NUMBER": "", "CAMPO1": "2D153504-62E3-4DCD-8ACA-7BB28134F3AA", "CAMPO2": "2023EF05A8F679274778BE04FD41B9886F0FAXRW", "CAMPO4": "" }, { "VBELN": "0071392026", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000325", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SONSONATE II", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2176980.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025103", "TEL_NUMBER": "", "CAMPO1": "486DD5CC-9935-47A2-9152-9B1EA3D57C37", "CAMPO2": "20231BADF133B23F4A6280649959539E92DDXHO9", "CAMPO4": "" }, { "VBELN": "0071392027", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000326", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SONSONATE III", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1654100.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025104", "TEL_NUMBER": "", "CAMPO1": "D02C4334-35B9-4300-B201-993B1D5269DF", "CAMPO2": "202396B7888BA2394B12BCCC7585BE5A2C262PAC", "CAMPO4": "" }, { "VBELN": "0071392028", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000351", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS IZALCO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1278680.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025129", "TEL_NUMBER": "", "CAMPO1": "3D798700-FED8-4AED-ABEA-643DC7D22FC3", "CAMPO2": "2023BF62C524AB314F109855F8F220F3405A0K0T", "CAMPO4": "" }, { "VBELN": "0071392029", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000391", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ SONSONATE CATEDRAL", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1728300.00", "KUNAG": "", "SMTP_ADDR": "ebsalaedisv@walmarmart.com", "ADRNR": "0000025169", "TEL_NUMBER": "", "CAMPO1": "33A6718D-AEE2-4768-A734-EFF412E49FF5", "CAMPO2": "2023B549FC8BB23342BC9FC624B29C0AF76CVSMS", "CAMPO4": "" }, { "VBELN": "0071392030", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000391", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ SONSONATE CATEDRAL", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "155220.00", "KUNAG": "", "SMTP_ADDR": "ebsalaedisv@walmarmart.com", "ADRNR": "0000025169", "TEL_NUMBER": "", "CAMPO1": "72DD37F8-5D9F-4019-9B8B-1316EA910C6C", "CAMPO2": "2023B2112D60483C4EB1AEBED15C0D4818F3PJEX", "CAMPO4": "" }, { "VBELN": "0071392031", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000399", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF ARMENIA", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1389610.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025177", "TEL_NUMBER": "", "CAMPO1": "97FEE1B7-58F2-4839-B545-205C2E5C1103", "CAMPO2": "202376C585B71A3A4B1E89827F7426417D61HW1S", "CAMPO4": "" }, { "VBELN": "0071392032", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000407", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF IZALCO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1097580.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025185", "TEL_NUMBER": "", "CAMPO1": "D827209A-54E8-47B0-96F1-54BA7E98EE5A", "CAMPO2": "2023A95A6626FD9A49C59385961DAFC06B98P4PQ", "CAMPO4": "" }, { "VBELN": "0071392033", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000436", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DESPENSA FAMILIAR SONSONATE", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1005180.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025214", "TEL_NUMBER": "", "CAMPO1": "EA09B95D-CEBB-426F-B754-5CEDD0593636", "CAMPO2": "20235ADEE33B53784D889DD4DFD35F7FF359WKGD", "CAMPO4": "" }, { "VBELN": "0071392034", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000016864", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI DESPENSA SONSONATE", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "142380.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000041642", "TEL_NUMBER": "", "CAMPO1": "204C6537-6B38-4E2B-A4E4-F37D5E63B27D", "CAMPO2": "2023C03078084E624738AB373C3AEA323015VGRC", "CAMPO4": "" }, { "VBELN": "0071392035", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000016864", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI DESPENSA SONSONATE", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2619070.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000041642", "TEL_NUMBER": "", "CAMPO1": "C80BB077-7AF2-48DF-94A1-08C61DEE0B82", "CAMPO2": "2023348227BEC513483C9B9C8C12D1D7653BG3XA", "CAMPO4": "" }, { "VBELN": "0071392036", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000024863", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SONZACATE", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "626740.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000053018", "TEL_NUMBER": "", "CAMPO1": "57A220E8-B325-4A42-9FF2-5A6B92F2317D", "CAMPO2": "2023795B3966B1B846AEBAF61F843E5C20B2OMCH", "CAMPO4": "" }, { "VBELN": "0071392037", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000031305", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUP.SEL. SONSONATE EL ENCUENTR", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1281160.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000062859", "TEL_NUMBER": "", "CAMPO1": "CF5F4592-B5FD-4AF5-86A9-FEE45C57253C", "CAMPO2": "202330B3865203F5469DBE0498102DC112C6U4IO", "CAMPO4": "" }, { "VBELN": "0071392038", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000031305", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUP.SEL. SONSONATE EL ENCUENTR", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "620340.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000062859", "TEL_NUMBER": "", "CAMPO1": "7CDBAB20-7E38-4BE0-BBF1-193DB5684C46", "CAMPO2": "20236A8D55227D3C45A188A461AE47072F98YKSJ", "CAMPO4": "" }, { "VBELN": "0071392039", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000289", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LOURDES II", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1109990.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025067", "TEL_NUMBER": "", "CAMPO1": "863CFF4C-69D2-40EB-A82F-53D3EB2B2B72", "CAMPO2": "2023BD21C8A8DE694AC3B761B20D1D4CD186SEXQ", "CAMPO4": "" }, { "VBELN": "0071392040", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000289", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LOURDES II", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "835430.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025067", "TEL_NUMBER": "", "CAMPO1": "C2AD375B-2239-41F5-B026-F7C148505A7C", "CAMPO2": "2023C37095D9A324471EB18BA95380636BD3NBHN", "CAMPO4": "" }, { "VBELN": "0071392041", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000392", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ UNICENTRO LOURDES", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2088950.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025170", "TEL_NUMBER": "", "CAMPO1": "3C7297A5-FDB8-47DF-A294-5FEEC5D1107D", "CAMPO2": "20239D6E160266644CAAB72D3ED936B238FA9GIU", "CAMPO4": "" }, { "VBELN": "0071392042", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000392", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ UNICENTRO LOURDES", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "15840.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025170", "TEL_NUMBER": "", "CAMPO1": "D4489A7A-FA6C-468C-929B-0B8E069C92FA", "CAMPO2": "2023FAC0C68439204CA48C4E02D0DD8E884DUHXG", "CAMPO4": "" }, { "VBELN": "0071392043", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000410", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF LOURDES", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "897230.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025188", "TEL_NUMBER": "", "CAMPO1": "F2FF2539-5D6E-479E-AA22-AC52800F75FE", "CAMPO2": "20230524EE40B1AC4B258AC83D1B177CA684VRMJ", "CAMPO4": "" }, { "VBELN": "0071392044", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000022198", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI LOURDES", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1901310.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000048232", "TEL_NUMBER": "", "CAMPO1": "217FE16C-D8F6-4099-93ED-3CACE9BFEDF4", "CAMPO2": "2023BE9191ECA50147E9A6A0EBF3E327CAB0WZK6", "CAMPO4": "" }, { "VBELN": "0071392045", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000024309", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS EL ENCUENTRO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2180440.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000051883", "TEL_NUMBER": "", "CAMPO1": "E8E4C0E2-D548-4EA2-85C4-992C1EA9E12C", "CAMPO2": "202388787D72C27C4616B5C0EAB2256085A6HZFL", "CAMPO4": "" }, { "VBELN": "0071392046", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000024309", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS EL ENCUENTRO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1303260.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000051883", "TEL_NUMBER": "", "CAMPO1": "3C8AEA54-2B4A-4D70-811E-6F7D47159272", "CAMPO2": "2023A27EBE8464E14EB7BB22F7138E7DC476SSGT", "CAMPO4": "" }, { "VBELN": "0071392047", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000027009", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI CAMPOS VERDES", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "169500.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000056480", "TEL_NUMBER": "", "CAMPO1": "35B08B8E-4320-459B-A360-F2648C7EFE22", "CAMPO2": "20232AA22D13268046EDA83296DA87D5DBE7D9PR", "CAMPO4": "" }, { "VBELN": "0071392048", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000027009", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI CAMPOS VERDES", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1763650.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000056480", "TEL_NUMBER": "", "CAMPO1": "80B5F6E6-7B82-415C-822E-E730FAC7F109", "CAMPO2": "2023D434EBB108E54A178A6DA07EE98C4BDBTRI4", "CAMPO4": "" }, { "VBELN": "0071392049", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000031290", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUP. SELECT. OPICO EL ENCUENTR", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1581340.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000062829", "TEL_NUMBER": "", "CAMPO1": "96514EC4-8D45-440B-A1C1-3C702AA4645B", "CAMPO2": "202394F873EEAFF448769258B0FCF7529572SOPY", "CAMPO4": "" }, { "VBELN": "0071392050", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000290", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MASFERRER", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "314280.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025068", "TEL_NUMBER": "", "CAMPO1": "0FFB5A73-71C4-4F3D-A38E-892B7F26B8A7", "CAMPO2": "202397C15A1013FD484CAFAD50EBDFF9C379KS4I", "CAMPO4": "" }, { "VBELN": "0071392051", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000301", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ESCALON", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1794950.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025079", "TEL_NUMBER": "", "CAMPO1": "81786646-ABCA-443D-A389-ABBDAE8DF533", "CAMPO2": "20239AB4BE537E924338B100E3D015387F96INL9", "CAMPO4": "" }, { "VBELN": "0071392052", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000304", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN BENITO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "3027870.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025082", "TEL_NUMBER": "", "CAMPO1": "4A2499B2-5973-4CA7-B5C1-C035E25893E8", "CAMPO2": "2023C44C5F35385D43FEB4208348EEE2EB81JOGL", "CAMPO4": "" }, { "VBELN": "0071392053", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000304", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN BENITO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "185220.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025082", "TEL_NUMBER": "", "CAMPO1": "7C999827-3CD4-40FA-AE07-399158FD0966", "CAMPO2": "20237697D7CF764044D1B87398F928AD3313HZ2T", "CAMPO4": "" }, { "VBELN": "0071392054", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000372", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ANTIGUO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1291090.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025150", "TEL_NUMBER": "", "CAMPO1": "5FC66DE9-7712-4805-AC6B-26CB0D4BD77C", "CAMPO2": "202399E1D5FCD7DF4D76ABEF18F905BBE5E7ZZZQ", "CAMPO4": "" }, { "VBELN": "0071392055", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000372", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ANTIGUO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "63360.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025150", "TEL_NUMBER": "", "CAMPO1": "38E4E8C2-4CBA-42C6-99A6-123E09550312", "CAMPO2": "20235C984E29387E49C6B23D71F063A10F9CLTRS", "CAMPO4": "" }, { "VBELN": "0071392056", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000380", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ LA CIMA", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1079810.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025158", "TEL_NUMBER": "", "CAMPO1": "B5C81F27-E802-4E65-BF57-5CE9CD6BFC22", "CAMPO2": "20232AD04B80F4E54BA5BDFC30D3E8565D82YRRE", "CAMPO4": "" }, { "VBELN": "0071392057", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000295", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS METROPOLIS", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "3835530.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025073", "TEL_NUMBER": "", "CAMPO1": "0E384BA7-3F38-405C-ACBC-087DF41298C6", "CAMPO2": "2023D322AC7857694627862549524456C2F3HDB9", "CAMPO4": "" }, { "VBELN": "0071392058", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000297", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MIRALVALLE I", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "1690880.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025075", "TEL_NUMBER": "", "CAMPO1": "2C5B1933-4FBE-40D2-89D3-5DA79704ACD9", "CAMPO2": "202323EA4A57C80648B18448DE9CA075DC96XZUV", "CAMPO4": "" }, { "VBELN": "0071392059", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000298", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MIRALVALLE II", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "3855860.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025076", "TEL_NUMBER": "", "CAMPO1": "B5E212BA-BF21-403F-B4F7-3542F9A002A1", "CAMPO2": "2023804A0754EB984A349AEE1D4AB22AFCFEI07F", "CAMPO4": "" }, { "VBELN": "0071392060", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000022176", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF METROPOLIS", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "710730.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000048141", "TEL_NUMBER": "", "CAMPO1": "162088E4-558B-4CF9-8162-78E2E914D9BA", "CAMPO2": "2023787459E333E8494CB57E3C3E5E7CAC2E8VTD", "CAMPO4": "" }, { "VBELN": "0071392061", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000306", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS CENTRO SAN JOSE", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "938160.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025084", "TEL_NUMBER": "", "CAMPO1": "041B255A-B7E0-404B-9F95-F2D8A27FCACE", "CAMPO2": "2023BB669B937C7A4E0DBCA4F4D38704FAF03BSX", "CAMPO4": "" }, { "VBELN": "0071392062", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000313", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN MIGUELITO I", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "1515960.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025091", "TEL_NUMBER": "", "CAMPO1": "D7210757-E2AC-474C-8544-D1D6F43C0C45", "CAMPO2": "20237438B2435CF442319D950A852D231220F6RQ", "CAMPO4": "" }, { "VBELN": "0071392063", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000313", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN MIGUELITO I", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "36200.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025091", "TEL_NUMBER": "", "CAMPO1": "940A0F0B-187F-4CEB-8F48-4697BBD56F75", "CAMPO2": "20238037998E3F10413E88818506B8C8993EXK5Q", "CAMPO4": "" }, { "VBELN": "0071392064", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000314", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN MIGUELITO II", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "1427360.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025092", "TEL_NUMBER": "", "CAMPO1": "027F09D1-CDFF-4DE3-9B97-FC2D9D1293BD", "CAMPO2": "202383603EBCFDFB4A27B9D5F521742997E7OE5B", "CAMPO4": "" }, { "VBELN": "0071392065", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000381", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ LAS TERRAZAS", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "920440.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025159", "TEL_NUMBER": "", "CAMPO1": "74804238-6D87-4675-B5B2-5D3E2451F6D9", "CAMPO2": "20236259E0D5E6EE4F048C4DBA8A25397CADUQVU", "CAMPO4": "" }, { "VBELN": "0071392066", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000308", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN MARTIN", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1961760.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025086", "TEL_NUMBER": "", "CAMPO1": "03321DD0-413C-43A5-8A49-2D60D289EAF8", "CAMPO2": "20239244A047A11847A987406A6F0220DA6BWA6U", "CAMPO4": "" }, { "VBELN": "0071392067", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000332", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN BARTOLO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "289800.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025110", "TEL_NUMBER": "", "CAMPO1": "D238442D-C224-4FEE-8B8F-E2FFA0F5B272", "CAMPO2": "202382514B09054D425B86B1E4F9D95C22BBQFF9", "CAMPO4": "" }, { "VBELN": "0071392068", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000332", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN BARTOLO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1325910.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025110", "TEL_NUMBER": "", "CAMPO1": "21C938CC-AE10-4AFD-809E-F4163D078210", "CAMPO2": "202393409F2E05B44B9D80A08916B05A3134SPJN", "CAMPO4": "" }, { "VBELN": "0071392069", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000332", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN BARTOLO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "171040.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025110", "TEL_NUMBER": "", "CAMPO1": "7A3B37B0-AA46-4147-BD21-119747B62631", "CAMPO2": "2023C7697E70B00843A19849D05F19F71B38L4O2", "CAMPO4": "" }, { "VBELN": "0071392070", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000371", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ALTAVISTA", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1808850.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025149", "TEL_NUMBER": "", "CAMPO1": "0386FBEC-8833-4EBF-A64E-D685B9EC67F0", "CAMPO2": "20233020F8C98D304DF2A122C633C7F02D4AVN2O", "CAMPO4": "" }, { "VBELN": "0071392071", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000371", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ALTAVISTA", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "64320.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025149", "TEL_NUMBER": "", "CAMPO1": "79AFA386-47CE-4C11-B4AD-7F72BDCD1552", "CAMPO2": "2023940892F9204A420BAD5923949B806D3AJW7P", "CAMPO4": "" }, { "VBELN": "0071392072", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000384", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "MAXI DESPENSA SAN BARTOLO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1379870.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025162", "TEL_NUMBER": "", "CAMPO1": "813A4933-8AE4-471D-85AD-6118E7374536", "CAMPO2": "20233404393005AC45508FF10952B5E46E697SQU", "CAMPO4": "" }, { "VBELN": "0071392073", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000393", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ UNICENTRO SOYAPANGO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "2403660.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025171", "TEL_NUMBER": "", "CAMPO1": "CFEA8727-AAA3-43DF-AFB5-9CD7F7F8D249", "CAMPO2": "2023EF075EFDAC4C4A768F882E54003A1B3AGEWM", "CAMPO4": "" }, { "VBELN": "0071392074", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000393", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ UNICENTRO SOYAPANGO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "40200.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025171", "TEL_NUMBER": "", "CAMPO1": "8E67712C-9073-401F-B5E6-1B149F57B44D", "CAMPO2": "20237A5BF4871C924A50B77E340645A4F5B08KH5", "CAMPO4": "" }, { "VBELN": "0071392075", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000414", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SAN MARTIN", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1201290.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025192", "TEL_NUMBER": "", "CAMPO1": "5A7F3966-F66C-4B33-8BC1-9715EE236BE8", "CAMPO2": "202314AC0D59FF3E4E63845A86831261BC99DUQA", "CAMPO4": "" }, { "VBELN": "0071392076", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000414", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SAN MARTIN", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "169500.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025192", "TEL_NUMBER": "", "CAMPO1": "195CFA46-7A75-4E03-B6DA-12938B400A06", "CAMPO2": "2023B03BD0D7BECF40A1B82B56F9017B661DNVBQ", "CAMPO4": "" }, { "VBELN": "0071392077", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000420", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF ILOPANGO", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "575800.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025198", "TEL_NUMBER": "", "CAMPO1": "B24FEA51-2EC4-4EE7-A311-51F8B32E28AC", "CAMPO2": "202318597345069441D3969E3FE175F6D1A2ZUNJ", "CAMPO4": "" }, { "VBELN": "0071392078", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000029929", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUP. SELEC. SAN MARTIN EL ENCU", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1466060.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000060802", "TEL_NUMBER": "", "CAMPO1": "D4ECAFD7-B736-4AE9-8491-51D437DDAC40", "CAMPO2": "20236DD9189872AA44A9BED18D0269CB4BADCNJH", "CAMPO4": "" }, { "VBELN": "0071392079", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000315", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN VICENTE", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "3263680.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025093", "TEL_NUMBER": "", "CAMPO1": "37A84AAA-C1E5-4F1D-9FF9-0310E51A7B04", "CAMPO2": "2023A71DC1A9F89F4519A5BF450F5FA7C883OBNS", "CAMPO4": "" }, { "VBELN": "0071392080", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000331", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ZACATECOLUCA", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "3509980.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025109", "TEL_NUMBER": "", "CAMPO1": "A40070EE-3BDE-49C7-BA59-DD03CDADA63F", "CAMPO2": "202307D0F02ADBCE460BB85D49E224250496SNEN", "CAMPO4": "" }, { "VBELN": "0071392081", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000395", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ZACATECOLUCA", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1127490.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025173", "TEL_NUMBER": "", "CAMPO1": "860A5BA7-ECCB-4C14-A54D-E82804B1D0F2", "CAMPO2": "202304B3F1210900476BA73E598A7FC7D5E3ZX8H", "CAMPO4": "" }, { "VBELN": "0071392082", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000417", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SAN VICENTE", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1600480.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025195", "TEL_NUMBER": "", "CAMPO1": "4117140B-9945-4252-8FF4-94E70972DEE2", "CAMPO2": "2023AFB9A90652AC42AC8A47DC7CC9B59F139HA6", "CAMPO4": "" }, { "VBELN": "0071392083", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000431", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF ZACATECOLUCA", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1732100.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025209", "TEL_NUMBER": "", "CAMPO1": "8E033638-D03E-4DC9-8B05-428F705F54C3", "CAMPO2": "2023DF5A8D3FB2B94DBAAA916B70412DCB9FYHYO", "CAMPO4": "" }, { "VBELN": "0071392084", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000024924", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "MAXI DESPENSA SANTA ELENA SAN", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1046010.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000053248", "TEL_NUMBER": "", "CAMPO1": "778DA2EA-6B3D-437D-B295-99BFD2369A71", "CAMPO2": "2023F8686BE6D6E6433B85E68980B0238CA6XZRX", "CAMPO4": "" }, { "VBELN": "0071392085", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000301", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ESCALON", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1084660.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025079", "TEL_NUMBER": "", "CAMPO1": "47A29480-1898-4832-95E4-E83CAF7C1E13", "CAMPO2": "2023BC7FC4C2CE0945559DF69EE7856188960CEH", "CAMPO4": "" }, { "VBELN": "0071392086", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000380", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ LA CIMA", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "4173540.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025158", "TEL_NUMBER": "", "CAMPO1": "D18B6D5C-8396-486B-8A7A-6AC0F999A170", "CAMPO2": "2023BFADFFF7795A4CAFA3D5A18E28E5456BYWMT", "CAMPO4": "" }, { "VBELN": "0071392087", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000290", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MASFERRER", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2784860.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025068", "TEL_NUMBER": "", "CAMPO1": "6433C75B-0C2E-4CB5-A0E2-3604DB903B2D", "CAMPO2": "202315F9C3EF8E5B4E3D89832EC3B553AE969JJH", "CAMPO4": "" }, { "VBELN": "0071392088", "FKART": "ZSC1", "FKDAT": "20231007", "KUNNR": "2000000286", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LOS ANGELES", "AEDAT": "20231007", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1180910.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025064", "TEL_NUMBER": "", "CAMPO1": "17039F2E-B98E-4710-A090-92037C26968E", "CAMPO2": "20238736AA9AB6C94DCEA9BB975BE4ABDB57V7UA", "CAMPO4": "" }, { "VBELN": "0071392621", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000269", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS AHUACHAPAN", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "872940.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025047", "TEL_NUMBER": "", "CAMPO1": "BD25ACF2-7ED5-42E9-BCA1-DB2922C4595A", "CAMPO2": "20238607B861A2BC4E408FC8EC549BF37668TLFP", "CAMPO4": "" }, { "VBELN": "0071392622", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000269", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS AHUACHAPAN", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2656140.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025047", "TEL_NUMBER": "", "CAMPO1": "B29FA49B-7CD1-4DB9-8225-548C1886EC7C", "CAMPO2": "20230DC7B22837794665B76818FE498D55B6TUR0", "CAMPO4": "" }, { "VBELN": "0071392623", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000317", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CIUDAD REAL", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "373160.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025095", "TEL_NUMBER": "", "CAMPO1": "8B9E5696-1F67-4DFE-9666-AC582812DD19", "CAMPO2": "20231B9C4901FD574AC7B56B02AF4D6750C6WPLZ", "CAMPO4": "" }, { "VBELN": "0071392624", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000317", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CIUDAD REAL", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2116850.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025095", "TEL_NUMBER": "", "CAMPO1": "CF1C1BC6-5C78-4A77-97BC-58D9A63C056F", "CAMPO2": "2023669A48D0BE6F488B80EB6769DB7D4A94L8FY", "CAMPO4": "" }, { "VBELN": "0071392625", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000344", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS CHALCHUAPA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "117100.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025122", "TEL_NUMBER": "", "CAMPO1": "E9321D4A-FC4B-45B2-B369-CDD0DA5AC6B1", "CAMPO2": "20232C019DE9661546768C2FDCA05B44059BGR78", "CAMPO4": "" }, { "VBELN": "0071392626", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000344", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS CHALCHUAPA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2514340.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025122", "TEL_NUMBER": "", "CAMPO1": "0EE51BAE-39C9-44DD-A99B-F8555DF93CEB", "CAMPO2": "20235C3472DABE0147ECA7EF38C5162D1DA8FTSJ", "CAMPO4": "" }, { "VBELN": "0071392627", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000397", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF AHUACHAPAN", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1405090.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025175", "TEL_NUMBER": "", "CAMPO1": "78C81877-BC40-46E9-AA8D-BEF94CF28816", "CAMPO2": "2023734EF3038ACB460F8523F8DF229C6695HOFI", "CAMPO4": "" }, { "VBELN": "0071392628", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000400", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF ATIQUIZAYA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1220430.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025178", "TEL_NUMBER": "", "CAMPO1": "A3E40F9C-576C-4879-97F9-A6B0459398D4", "CAMPO2": "202380AEBA220E444CD19C7936692885D8ECVPCI", "CAMPO4": "" }, { "VBELN": "0071392629", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000404", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CHALCHUAPA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1509980.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025182", "TEL_NUMBER": "", "CAMPO1": "21AC8149-D833-42DB-9821-3B2061AC3E79", "CAMPO2": "2023BBB5B1A29915436597CD4B30670C46384MNS", "CAMPO4": "" }, { "VBELN": "0071392630", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000449", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "MAXI DESPENSA SANTA ANA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "3700170.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025227", "TEL_NUMBER": "", "CAMPO1": "8D19CDCA-13CB-4965-AA26-17E660717488", "CAMPO2": "2023510E4BAAE27D43DEA4B9D8CFA4DE93ECQEPG", "CAMPO4": "" }, { "VBELN": "0071392631", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000023528", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS ATIQUIZAYA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1498270.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000050443", "TEL_NUMBER": "", "CAMPO1": "5199ECD8-2745-49EA-AA6D-B4D8852BF5AC", "CAMPO2": "20235F75FFB35C3D4D8C96FDF0235514F225R2PH", "CAMPO4": "" }, { "VBELN": "0071392632", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000026477", "NAME1": "OPERADORA DEL SUR, S.A. DE  C.", "NAME2": "MAXI DESPENSA AHUCHAPAN", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "169500.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000055413", "TEL_NUMBER": "", "CAMPO1": "50C28553-67A3-4527-A3BC-C1307A674308", "CAMPO2": "2023812E6392B9C247298A8D223741B8277CBSQG", "CAMPO4": "" }, { "VBELN": "0071392633", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000026477", "NAME1": "OPERADORA DEL SUR, S.A. DE  C.", "NAME2": "MAXI DESPENSA AHUCHAPAN", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1524990.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000055413", "TEL_NUMBER": "", "CAMPO1": "F15C08A2-804D-48C0-A837-A873661BA0E9", "CAMPO2": "2023BF21F3D1755841AEAB54CB28E7D82B44R9KV", "CAMPO4": "" }, { "VBELN": "0071392634", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000293", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MERLIOT II", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1720480.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025071", "TEL_NUMBER": "", "CAMPO1": "6475FC2A-FC3E-4C86-916D-DC8B0749304F", "CAMPO2": "20234AB8C4C0377A443085B69ECAECB893A3IHKY", "CAMPO4": "" }, { "VBELN": "0071392635", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000300", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS NOVOCENTRO", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1270770.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025078", "TEL_NUMBER": "", "CAMPO1": "681F6F9B-47A2-4817-AA3D-708719C12CCE", "CAMPO2": "2023280AA71DEAFB475BB47EDB2700A01F5EYU2Y", "CAMPO4": "" }, { "VBELN": "0071392636", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000302", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS PLAZA MERLIOT", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "735290.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025080", "TEL_NUMBER": "", "CAMPO1": "47AFA86C-53B9-462D-8551-DA983F3682FF", "CAMPO2": "202366249A33226845E49FB43BB8A832E59AKLVF", "CAMPO4": "" }, { "VBELN": "0071392637", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000302", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS PLAZA MERLIOT", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "644670.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025080", "TEL_NUMBER": "", "CAMPO1": "060A6B40-C290-4068-9CB1-A7C275B7DBCE", "CAMPO2": "2023E5D11288E16247FE903D3588D94CDDB3LZNM", "CAMPO4": "" }, { "VBELN": "0071392638", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000323", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA TECLA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1635170.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025101", "TEL_NUMBER": "", "CAMPO1": "85D8FB17-E260-4762-83CD-9E279098CB2A", "CAMPO2": "2023FBDDDC151A8E4AD798AECB635DD2EA024MLM", "CAMPO4": "" }, { "VBELN": "0071392639", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000379", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ JARDINES DE LA LIBERTAD", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1021710.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025157", "TEL_NUMBER": "", "CAMPO1": "3053DA25-48A0-4CA9-A815-E8D57099E2F1", "CAMPO2": "2023D85AA315B0A340D5A95BAB16CE5E984A9LUY", "CAMPO4": "" }, { "VBELN": "0071392640", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000421", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SANTA TECLA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "506360.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025199", "TEL_NUMBER": "", "CAMPO1": "F4B7DC2C-9929-4083-9BB3-3AC2CCB61EDE", "CAMPO2": "20235690DB39F9214BE798C406664934911ATABV", "CAMPO4": "" }, { "VBELN": "0071392641", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000421", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SANTA TECLA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "94920.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025199", "TEL_NUMBER": "", "CAMPO1": "A64E2A87-A0B7-41F2-B765-90C7BE7FA124", "CAMPO2": "20231080F0F5823342B082F8AAD44F109B81SJLH", "CAMPO4": "" }, { "VBELN": "0071392642", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000438", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SAN MARTIN", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "297400.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025216", "TEL_NUMBER": "", "CAMPO1": "B214E509-C681-4E8B-9EA3-592D624E7267", "CAMPO2": "20238277E9DA0D2A44E7BF65279880494B95KCTK", "CAMPO4": "" }, { "VBELN": "0071392643", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000438", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SAN MARTIN", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "67800.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025216", "TEL_NUMBER": "", "CAMPO1": "E27AEB97-A639-4878-9446-1F506FC2AE75", "CAMPO2": "20235D956E5BA2AD4AC2A4E572B05F1BFE53S0RT", "CAMPO4": "" }, { "VBELN": "0071392644", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000023672", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ROSA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "4140720.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000050677", "TEL_NUMBER": "", "CAMPO1": "077A3805-422B-49AD-AF2D-19067BEB60C7", "CAMPO2": "2023338FCEB6C833482FBC8051E3F7C5896BPGLN", "CAMPO4": "" }, { "VBELN": "0071392645", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000274", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS AUTOPISTA SUR", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1478030.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025052", "TEL_NUMBER": "", "CAMPO1": "3DD366A4-D7E4-4315-B400-0721B677FB7A", "CAMPO2": "202396F744F1AE764C9F8A6EF95C7B31BB71XYZY", "CAMPO4": "" }, { "VBELN": "0071392646", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000282", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA CIMA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2594820.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025060", "TEL_NUMBER": "", "CAMPO1": "BA112FC6-EFD0-49DD-B100-2CA581A2BD3C", "CAMPO2": "202364C59701F91246E6B652D580D43293F30RBM", "CAMPO4": "" }, { "VBELN": "0071392647", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000285", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA SULTANA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1003050.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025063", "TEL_NUMBER": "", "CAMPO1": "0CFB3CFF-81DD-41F7-AE58-AB7F24175FDF", "CAMPO2": "20237D9796915599494FA1BB5B5662B38817SLEQ", "CAMPO4": "" }, { "VBELN": "0071392648", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000285", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA SULTANA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1319300.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025063", "TEL_NUMBER": "", "CAMPO1": "FF648EBD-35D2-4E09-9307-7A1F1E72357C", "CAMPO2": "202353ED3B121F464130B989D83F8B916CDEXBON", "CAMPO4": "" }, { "VBELN": "0071392649", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000299", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MULTIPLAZA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1298760.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025077", "TEL_NUMBER": "", "CAMPO1": "9EF55E35-318A-4033-A311-EB3F97AA9952", "CAMPO2": "2023DEACA63476FB4F92ACF516D52B1BCF7C7CD1", "CAMPO4": "" }, { "VBELN": "0071392650", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000021876", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ELENA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2515040.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000047424", "TEL_NUMBER": "", "CAMPO1": "F84EFFEA-7A3D-4E26-9D1C-C41FAE2B5B3C", "CAMPO2": "20238BE67B1AAA3C4241964430E7695394DFLL3S", "CAMPO4": "" }, { "VBELN": "0071392651", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000021876", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ELENA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "147850.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000047424", "TEL_NUMBER": "", "CAMPO1": "D82C8488-DEDF-4FC8-B34E-613EE04BF643", "CAMPO2": "202301912AE50B904121AEA8AEDDCA1BFEC64TNW", "CAMPO4": "" }, { "VBELN": "0071392652", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000024357", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LAS CASCADAS", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "4301780.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000052048", "TEL_NUMBER": "", "CAMPO1": "23F3866C-F20E-4C1A-8D2D-485087FA88D9", "CAMPO2": "20234B090B6398014A1B897BDD2CB84F9B11M6RE", "CAMPO4": "" }, { "VBELN": "0071392653", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000025859", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SANTA ELENA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "770280.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000054717", "TEL_NUMBER": "", "CAMPO1": "D2CEAF27-C2DF-49A1-BCAE-246E2A0A8F7B", "CAMPO2": "2023846FA8B2C2724002B545803C133C4046TI0X", "CAMPO4": "" }, { "VBELN": "0071392654", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000025859", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SANTA ELENA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1369250.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000054717", "TEL_NUMBER": "", "CAMPO1": "336DDF5E-A3D3-47CA-9628-08CE6AEFFBDF", "CAMPO2": "20237326DDBDBC78431191BCFC52E1A2FA399TQ0", "CAMPO4": "" }, { "VBELN": "0071392655", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000281", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS GIGANTE", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "2769110.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025059", "TEL_NUMBER": "", "CAMPO1": "64B77FC2-0B92-4BBD-A479-9F83FE2EC56C", "CAMPO2": "2023054AF2FA93CE4F858B7B2B33074B18595Z18", "CAMPO4": "" }, { "VBELN": "0071392656", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000328", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS TRIGUEROS", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "439310.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025106", "TEL_NUMBER": "", "CAMPO1": "98EBF69E-53A2-4165-9697-385724349945", "CAMPO2": "2023F6F9887C893649A9A3453C39C4FDB91F83PP", "CAMPO4": "" }, { "VBELN": "0071392657", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000330", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ZACAMIL", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "2010210.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025108", "TEL_NUMBER": "", "CAMPO1": "402878DA-3853-4F93-B5AC-D2ED6C178CB8", "CAMPO2": "20237809AC023F1D4CF3B493991F4A209556T3OC", "CAMPO4": "" }, { "VBELN": "0071392658", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000377", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ESCALON NORTE", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "378600.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025155", "TEL_NUMBER": "", "CAMPO1": "38979A28-144C-46D0-9C2F-1B10B4CDD4C1", "CAMPO2": "2023A6EF774F46B84A0C89F585759915BAA7B7XN", "CAMPO4": "" }, { "VBELN": "0071392659", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000377", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ESCALON NORTE", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "3960400.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025155", "TEL_NUMBER": "", "CAMPO1": "9C7A7C2B-DE0B-417E-BEDA-FDDCA3374E59", "CAMPO2": "20232C1142F7B606497ABC5876BAC0618DEDXKHF", "CAMPO4": "" }, { "VBELN": "0071392660", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000377", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ ESCALON NORTE", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "119200.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025155", "TEL_NUMBER": "", "CAMPO1": "15CF6CD7-FAE2-47A3-9F9B-2E9A0656D9A4", "CAMPO2": "202383CAB3FE5F8E4639B5C7E29F24C6FA12V9U1", "CAMPO4": "" }, { "VBELN": "0071392661", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000016677", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "WALMART SAN SALVADOR", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "970310.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000041455", "TEL_NUMBER": "", "CAMPO1": "8C227338-DC6C-4E4F-9257-B4B5E231BEC5", "CAMPO2": "20231537BABA3504446B8FD1CB2CEE3087EFZXGC", "CAMPO4": "" }, { "VBELN": "0071392662", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000016677", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "WALMART SAN SALVADOR", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "10000.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000041455", "TEL_NUMBER": "", "CAMPO1": "13EDAAF7-987A-4D0B-A94D-8DD07EF1D9D4", "CAMPO2": "2023286F5B384A164FFAA75FB64A8A02EA4BTD25", "CAMPO4": "" }, { "VBELN": "0071392663", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000021877", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART CONSTITUCION", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "2039400.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000047427", "TEL_NUMBER": "", "CAMPO1": "3795E7E0-B625-4B96-A693-6DD0D0169092", "CAMPO2": "2023A6AD32E859534006B2D0221254B940C4DOHK", "CAMPO4": "" }, { "VBELN": "0071392664", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000021877", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART CONSTITUCION", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "522600.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000047427", "TEL_NUMBER": "", "CAMPO1": "9AF0124C-1AFF-4DE3-917C-38C50DFBD237", "CAMPO2": "20236F9FBA510163486086D59B30C6C90782IMJW", "CAMPO4": "" }, { "VBELN": "0071392665", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000022623", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "CENTRO DE PRODUCCION DELI", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "546000.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000049000", "TEL_NUMBER": "", "CAMPO1": "3236590F-3F9A-4D09-BB6C-C950FD6351DE", "CAMPO2": "20234ED1B4BDE7C7453CB03F6CA92C439022FGGI", "CAMPO4": "" }, { "VBELN": "0071392666", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000026545", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SELECTOS SAN GABRIEL", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "1233820.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000055529", "TEL_NUMBER": "", "CAMPO1": "3CBCD718-6E10-44CC-AB24-17B1C999858F", "CAMPO2": "202324B1A235C84D4F738D587ECBDCE5B721AEXR", "CAMPO4": "" }, { "VBELN": "0071392667", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000273", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ARCE", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "697710.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025051", "TEL_NUMBER": "", "CAMPO1": "68DEFBD5-3F68-4BC5-8446-1BCDCA2B8E56", "CAMPO2": "20230EB39A5D1F5A4E279AAC9282F2B29176XEER", "CAMPO4": "" }, { "VBELN": "0071392668", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000277", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CENTRO ANTEL", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "764150.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025055", "TEL_NUMBER": "", "CAMPO1": "5651F06A-5A47-4F90-B1F8-A9F1611781B7", "CAMPO2": "202308FB0573F96D4E729AB3A3D63FD209ABUAE2", "CAMPO4": "" }, { "VBELN": "0071392669", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000277", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CENTRO ANTEL", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "584060.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025055", "TEL_NUMBER": "", "CAMPO1": "91516E8A-D649-411C-BA97-A0DECA890D65", "CAMPO2": "202326AEEC939C264E4A962F5D684AFE2F81XZN7", "CAMPO4": "" }, { "VBELN": "0071392670", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000278", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CENTRO LIBERTAD", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "614080.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025056", "TEL_NUMBER": "", "CAMPO1": "C5CC7133-07AB-4C93-B7FE-6D775CD26BB4", "CAMPO2": "2023DD5B5EF220B545FDBD130956AD3BE701XBN5", "CAMPO4": "" }, { "VBELN": "0071392671", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000374", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CENTRO LA LIBERTAD", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "690850.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025152", "TEL_NUMBER": "", "CAMPO1": "D65F7B47-7F0B-4AE8-B55C-429BEB5CF9A2", "CAMPO2": "20230362EBACE53B4840B8BD10A95492D55FYIYV", "CAMPO4": "" }, { "VBELN": "0071392672", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000374", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CENTRO LA LIBERTAD", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "169500.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025152", "TEL_NUMBER": "", "CAMPO1": "84DF59E3-B4CF-4872-9E97-849AD0617D0E", "CAMPO2": "20232DD2C5BB6C61425895A01C52F02463575H1G", "CAMPO4": "" }, { "VBELN": "0071392673", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000376", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF DARIO", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "536610.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025154", "TEL_NUMBER": "", "CAMPO1": "2C69096A-F8FF-443B-8B85-4E4A260EEF3F", "CAMPO2": "20237870CA7DD49046B9B736C989FF137543EF74", "CAMPO4": "" }, { "VBELN": "0071392674", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000270", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS APOPA I", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "2032480.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025048", "TEL_NUMBER": "", "CAMPO1": "551E861F-3D86-44A4-8F02-756E383CFED0", "CAMPO2": "20234EC21524FD4344269930E5305E55F761NJ1H", "CAMPO4": "" }, { "VBELN": "0071392675", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000279", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CIUDAD DELGADO", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1061360.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025057", "TEL_NUMBER": "", "CAMPO1": "A7FEFF76-FE58-46ED-B016-43D3A972D8BF", "CAMPO2": "20235CAE4538B2A04CD19E1795DE5D198DA2K2J7", "CAMPO4": "" }, { "VBELN": "0071392676", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000279", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS CIUDAD DELGADO", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "939840.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025057", "TEL_NUMBER": "", "CAMPO1": "6DF4C567-7AA9-46E7-B169-9AF52495D2D9", "CAMPO2": "2023046E15439C9748BB94D7E8038084F257UWZG", "CAMPO4": "" }, { "VBELN": "0071392677", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000291", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MEGA SELECTOS", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1688720.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025069", "TEL_NUMBER": "", "CAMPO1": "9F125579-FCB7-4863-AD8A-DF3C21EB10B0", "CAMPO2": "202343CD5C53C75F45EFB36049AE6BDD4184HTTV", "CAMPO4": "" }, { "VBELN": "0071392678", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000411", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF MEJICANOS", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "770860.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025189", "TEL_NUMBER": "", "CAMPO1": "D920BC45-D26C-4E1B-B8B3-DB90D248471C", "CAMPO2": "2023262A0E7FDFF74F8BA933796EA5DE82776SAU", "CAMPO4": "" }, { "VBELN": "0071392679", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000437", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CUSCATANCINGO", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "846600.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025215", "TEL_NUMBER": "", "CAMPO1": "B488D0A5-E9B4-43D7-A14F-2FA9B12DDEDC", "CAMPO2": "2023F615AA29929E4818984B7C20E365E4A0DLSP", "CAMPO4": "" }, { "VBELN": "0071392680", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000445", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CIUDAD DELGADO", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "601990.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025223", "TEL_NUMBER": "", "CAMPO1": "2A203AE0-B8E1-40CC-AA26-240E5CA04CE9", "CAMPO2": "2023BC4A664D6E944CB6BA70A13D4F00CB9CK8DB", "CAMPO4": "" }, { "VBELN": "0071392681", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000446", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF APOPA PERICENTRO", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "754580.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025224", "TEL_NUMBER": "", "CAMPO1": "DFD77F50-A3A3-4026-B1DA-6CF1A9F65D14", "CAMPO2": "20232E98BC01DE3745248D6D7CB2B041F789T1ZC", "CAMPO4": "" }, { "VBELN": "0071392682", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000024504", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI PRADOS DE VENECIA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1794550.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000052430", "TEL_NUMBER": "", "CAMPO1": "3B26D360-56DE-4A51-94E3-B638EE6C1C66", "CAMPO2": "2023E04F7843CB0E49D9A671496522F81199TICM", "CAMPO4": "" }, { "VBELN": "0071392683", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000024876", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CUSCATANCINGO NORTE", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "666260.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000053067", "TEL_NUMBER": "", "CAMPO1": "DA9AAC05-6E11-4DBD-9EC4-D184AC65D7EB", "CAMPO2": "20232442EC01FD1E419E8EFFEBF64D4E0DB5D36V", "CAMPO4": "" }, { "VBELN": "0071392684", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000029100", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SELECTOS PLAZA MUNDO APO", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "2460500.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000059675", "TEL_NUMBER": "", "CAMPO1": "98A847EB-3B10-4AF4-999A-09219445396D", "CAMPO2": "20235BDD42BD8DDA4126B6861450B26ADBBFHJRB", "CAMPO4": "" }, { "VBELN": "0071392685", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000268", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS AGUILARES", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1154160.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025046", "TEL_NUMBER": "", "CAMPO1": "39F3A9C6-C134-4DC9-BD23-27A6B59C0F85", "CAMPO2": "2023C79122559A6F4CA1A5DF03AF26ABBCBCDGEQ", "CAMPO4": "" }, { "VBELN": "0071392686", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000271", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS APOPA III", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1120410.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025049", "TEL_NUMBER": "", "CAMPO1": "B97D50F0-4FA1-4230-920A-6E9D18C6338A", "CAMPO2": "202317CEFC972D014A62AFD6F7C7AED08DDBOYFQ", "CAMPO4": "" }, { "VBELN": "0071392687", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000272", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS APOPA II", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "819670.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025050", "TEL_NUMBER": "", "CAMPO1": "B14821A4-F054-490A-A9DD-C1E4D22F1503", "CAMPO2": "2023D899A562D2FC43AFA518404825912502A6CM", "CAMPO4": "" }, { "VBELN": "0071392688", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000353", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS QUEZALTEPEQUE", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "2209290.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025131", "TEL_NUMBER": "", "CAMPO1": "77B3D1D9-17E9-47AF-8D25-364D1D7B8AE1", "CAMPO2": "20234C1451EEBF214B17B7582FA5D9BEB272UYLR", "CAMPO4": "" }, { "VBELN": "0071392689", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000353", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS QUEZALTEPEQUE", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "76380.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025131", "TEL_NUMBER": "", "CAMPO1": "3529C103-5C0A-4FE2-84D0-506D8FB8A4AF", "CAMPO2": "2023DF0A8B2E305449FBBBCEE8D6249ED759CPRF", "CAMPO4": "" }, { "VBELN": "0071392690", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000396", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF AGUILARES", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "765250.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025174", "TEL_NUMBER": "", "CAMPO1": "966C4B14-E257-4D7E-BDFC-6674B8A36E4F", "CAMPO2": "202321B71DEB00814F47AC5CC351CD18F6BBT2ZT", "CAMPO4": "" }, { "VBELN": "0071392691", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000398", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF APOPA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1375300.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025176", "TEL_NUMBER": "", "CAMPO1": "696055F9-8155-4558-8655-2AA7FB13B9FB", "CAMPO2": "202371CAEED6CE734EE981F008D0B18DD9B7HIRG", "CAMPO4": "" }, { "VBELN": "0071392692", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000413", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF QUEZALTEPEQUE", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "600300.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025191", "TEL_NUMBER": "", "CAMPO1": "A48F6E1E-7E95-405A-A29F-2B82C19005EB", "CAMPO2": "2023491C86FFE32F49F68D110C7AD582AEAASRIY", "CAMPO4": "" }, { "VBELN": "0071392693", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000000439", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF QUEZALTEPEQUE 2", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "512630.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025217", "TEL_NUMBER": "", "CAMPO1": "5D365AFD-8BE2-4324-BF9C-A435D6B870EE", "CAMPO2": "2023B966E4F853484705ABB9D4B6E100F3167HYT", "CAMPO4": "" }, { "VBELN": "0071392694", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000022862", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "MAXI APOPA", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1462150.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000049394", "TEL_NUMBER": "", "CAMPO1": "AA971047-52DB-4571-BA90-B74C2878BA0B", "CAMPO2": "2023775F5D7BC87E447384E334460BED55B0PKRE", "CAMPO4": "" }, { "VBELN": "0071392695", "FKART": "ZSC1", "FKDAT": "20231009", "KUNNR": "2000032378", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUPER SEL. AGUILARES EL ENCUEN", "AEDAT": "20231009", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "2125090.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000064531", "TEL_NUMBER": "", "CAMPO1": "171021D6-808F-4E23-88EB-9980502122FD", "CAMPO2": "202320CAEA0E673E4D57BBBC20D414527E55TAIY", "CAMPO4": "" }, { "VBELN": "0071393154", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000316", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ANA CENTRO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "3229760.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025094", "TEL_NUMBER": "", "CAMPO1": "A476F11F-33BF-40FB-988B-C236D3626DC1", "CAMPO2": "2023A10BCD6E7ABF4476B00FDDB53E059804PKQT", "CAMPO4": "" }, { "VBELN": "0071393155", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000318", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ANA COLON", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "484860.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025096", "TEL_NUMBER": "", "CAMPO1": "0F8CD7F5-DD90-4733-BBD7-8B61D9AD3D0D", "CAMPO2": "202317DEB83EF14C43659F067A2ACB0545A5KCO4", "CAMPO4": "" }, { "VBELN": "0071393156", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000318", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ANA COLON", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2441290.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025096", "TEL_NUMBER": "", "CAMPO1": "40702DF4-1B67-4041-8725-D4376C8FBFF7", "CAMPO2": "2023E4D8F55840764A9EA9933043BE6431BESC4O", "CAMPO4": "" }, { "VBELN": "0071393157", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000319", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA ANA METROCENTRO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "3087900.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025097", "TEL_NUMBER": "", "CAMPO1": "2DFA2FEB-6895-4C7B-9B23-1D8A10A20626", "CAMPO2": "2023C50E75FDEDF74A1D84260380D48827BDFGPS", "CAMPO4": "" }, { "VBELN": "0071393158", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000389", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF CATEDRAL SANTA ANA", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "857940.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025167", "TEL_NUMBER": "", "CAMPO1": "51505DE6-35CA-4084-A43C-73BD0A3F6BAD", "CAMPO2": "20231029577277C342FCA4A21164EE585FE6CUOZ", "CAMPO4": "" }, { "VBELN": "0071393159", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000390", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ SANTA ANA PALMAR", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "63360.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025168", "TEL_NUMBER": "", "CAMPO1": "4E3BBBC6-2C68-4815-AE46-890EC69528CC", "CAMPO2": "2023EC49803F54D44E72937D970BFE47B3019G6C", "CAMPO4": "" }, { "VBELN": "0071393160", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000390", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ SANTA ANA PALMAR", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1781460.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025168", "TEL_NUMBER": "", "CAMPO1": "39BC9320-F9CD-40A7-BAF5-6A582CB2A255", "CAMPO2": "20237F077CB290974531830FAD7111B10C0D6EG6", "CAMPO4": "" }, { "VBELN": "0071393161", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000419", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SANTA ANA COLON", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2504370.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025197", "TEL_NUMBER": "", "CAMPO1": "DAEE9933-4A20-4D5E-9314-7F699AC44632", "CAMPO2": "2023C414C173FFAE457C98013EB9C29C6D8AHORV", "CAMPO4": "" }, { "VBELN": "0071393162", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000024215", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SANTA ANA NORTE", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "464900.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000051710", "TEL_NUMBER": "", "CAMPO1": "90EA68E7-09EB-45EA-B60D-9A621E438D20", "CAMPO2": "2023BF3F7710F3E94BAEB4EE8E547717C36BB58Y", "CAMPO4": "" }, { "VBELN": "0071393163", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000028933", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "WM SANTA ANA", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "2519770.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000059447", "TEL_NUMBER": "", "CAMPO1": "5169B2D4-E509-40B6-B93B-BC9E0C56174E", "CAMPO2": "20237530E530C4BC4EC2B67DC976686838FE8WLG", "CAMPO4": "" }, { "VBELN": "0071393164", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000029227", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI DESPENSA SAN JUAN", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1740890.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000059876", "TEL_NUMBER": "", "CAMPO1": "C678519F-8251-46EA-9142-87E46E544BD1", "CAMPO2": "2023A7247C6665D14BDE91B1206D7D8919D7BEBH", "CAMPO4": "" }, { "VBELN": "0071393165", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000033502", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "SUP. SELECTOS SANTA ANA LAS RA", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP001", "NETWR": "1757420.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000066171", "TEL_NUMBER": "", "CAMPO1": "368CB2B1-5DAE-46D1-956F-343D9FC1B527", "CAMPO2": "2023505F3D4988CE47D8AB5669A0D923E46C7YPV", "CAMPO4": "" }, { "VBELN": "0071393166", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000283", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LA JOYA", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2659670.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025061", "TEL_NUMBER": "", "CAMPO1": "116F2DE9-BF58-4C8E-8D32-C9CEE93C0F09", "CAMPO2": "20231E63BB00F9F34DD1A1A8BC2DEB9DA6ABHSHQ", "CAMPO4": "" }, { "VBELN": "0071393167", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000284", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS EL FARO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1002700.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025062", "TEL_NUMBER": "", "CAMPO1": "4ADA3591-35D0-4ABD-8BB1-216CB43BA37E", "CAMPO2": "2023A2E1672EC04E4E3E9DE0B424E3D95129CY05", "CAMPO4": "" }, { "VBELN": "0071393168", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000284", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS EL FARO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "514100.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025062", "TEL_NUMBER": "", "CAMPO1": "6C3F15E3-BE63-4CAD-9422-60FE22DB84CC", "CAMPO2": "2023E49F7BC6CA124225B7D0062EC85CE017O8AD", "CAMPO4": "" }, { "VBELN": "0071393169", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000333", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ZARAGOZA", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1922370.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025111", "TEL_NUMBER": "", "CAMPO1": "4F7B3312-9F85-4EBC-A758-9C9C805E292A", "CAMPO2": "202357019E5A037545A5B1EE0E5DC0299F0AJCWD", "CAMPO4": "" }, { "VBELN": "0071393170", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000339", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LAS PALMAS", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "2718430.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025117", "TEL_NUMBER": "", "CAMPO1": "A05EDBD6-C26D-4A51-A843-FF664C994E38", "CAMPO2": "2023D6EF218A2A81464FA079F338052F80B2EB6P", "CAMPO4": "" }, { "VBELN": "0071393171", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000339", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LAS PALMAS", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1150.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025117", "TEL_NUMBER": "", "CAMPO1": "62C74292-5D1E-41EF-9B52-89594FB1081F", "CAMPO2": "2023C3FF48C8CDD94848BF4B96C9ED96A36CJRB7", "CAMPO4": "" }, { "VBELN": "0071393172", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000339", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS LAS PALMAS", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "27600.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025117", "TEL_NUMBER": "", "CAMPO1": "B046D2F5-3B15-46A7-B83D-C4FD9E4D0297", "CAMPO2": "2023755166488E054CA3B27AC8E8C133A4FEV9GI", "CAMPO4": "" }, { "VBELN": "0071393173", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000350", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS LIBERTAD", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "830900.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025128", "TEL_NUMBER": "", "CAMPO1": "2393A95E-9688-4D9F-8CF6-9A0DACE63E0D", "CAMPO2": "20239C6537A7DA5445CD8C1A3343E631687BQFYC", "CAMPO4": "" }, { "VBELN": "0071393174", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000378", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ HOLANDA", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "15840.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025156", "TEL_NUMBER": "", "CAMPO1": "931BE736-D626-4927-8EB3-93AE31C2F917", "CAMPO2": "202367CF6A25AE304B0D9C3A34640270E945PX1F", "CAMPO4": "" }, { "VBELN": "0071393175", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000378", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ HOLANDA", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "987450.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025156", "TEL_NUMBER": "", "CAMPO1": "CC34C169-2CBB-47C8-B7DD-3284FD90A7C3", "CAMPO2": "2023A10E16223FA44BECA5C7966ED966A53AV1OQ", "CAMPO4": "" }, { "VBELN": "0071393176", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000378", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ HOLANDA", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "15840.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025156", "TEL_NUMBER": "", "CAMPO1": "A3E510AD-BD84-400A-85D7-3CA46C0DC894", "CAMPO2": "2023E3B5B65EC2314A6597116555C58B13EAOFHH", "CAMPO4": "" }, { "VBELN": "0071393177", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000408", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF LA LIBERTAD", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "1443770.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025186", "TEL_NUMBER": "", "CAMPO1": "C8C034F7-A805-424D-B7D3-0BD2FC1EBBD7", "CAMPO2": "20235A12B17BDDFD46A198D21846CDCB378EOIRJ", "CAMPO4": "" }, { "VBELN": "0071393178", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000275", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS BETHOVEN", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "1291130.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025053", "TEL_NUMBER": "", "CAMPO1": "73043085-F3BF-4DAE-97ED-BC81CDF9CB6D", "CAMPO2": "2023335AA54B6B7C40D0BD19A654EB88F850ADMY", "CAMPO4": "" }, { "VBELN": "0071393179", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000290", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MASFERRER", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2509900.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025068", "TEL_NUMBER": "", "CAMPO1": "E74D0DA5-967A-46D4-B0AC-0F95389A8BAA", "CAMPO2": "202352F4608F855C4E3CAB74E0A514D2185DWPZP", "CAMPO4": "" }, { "VBELN": "0071393180", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000290", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS MASFERRER", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "341560.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025068", "TEL_NUMBER": "", "CAMPO1": "8B1B21E3-72AA-4A6F-8985-0EC4CD006B6B", "CAMPO2": "2023B89948D0C9C649D48DE6B7D718E02D00XPRD", "CAMPO4": "" }, { "VBELN": "0071393181", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000301", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ESCALON", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2428400.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025079", "TEL_NUMBER": "", "CAMPO1": "565F96BF-9522-4617-9E94-5C5316A9EC75", "CAMPO2": "20237D0DD48A81A44DEE9A26AB697532B8DCFUVV", "CAMPO4": "" }, { "VBELN": "0071393182", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000301", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ESCALON", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "123960.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025079", "TEL_NUMBER": "", "CAMPO1": "49D3FD0F-CB3D-4298-81F1-20CEA7F2503C", "CAMPO2": "2023112DC3DA5C7E476F9B4BEF9AC05E3277Y0RN", "CAMPO4": "" }, { "VBELN": "0071393183", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000304", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN BENITO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2817990.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025082", "TEL_NUMBER": "", "CAMPO1": "DC1DC7A5-F4CE-458F-8C2F-CF3B06619DC0", "CAMPO2": "2023772E62C651714229858F2E88370CE253B73R", "CAMPO4": "" }, { "VBELN": "0071393184", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000320", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA EMILIA", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP003", "NETWR": "2458670.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025098", "TEL_NUMBER": "", "CAMPO1": "34F39A3F-9F47-489D-AAD9-0B21BF091CBF", "CAMPO2": "2023A31DE3A2E4B54B88997AAB654E1A5527PDDW", "CAMPO4": "" }, { "VBELN": "0071393185", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000294", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS METROCENTRO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "2520860.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025072", "TEL_NUMBER": "", "CAMPO1": "7331E00E-E7BB-486F-9E5D-EB3B73C2CEBB", "CAMPO2": "2023BAD101A022084A1282A883AF7FC102635PMK", "CAMPO4": "" }, { "VBELN": "0071393186", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000296", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS METROSUR", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "1292750.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025074", "TEL_NUMBER": "", "CAMPO1": "316760E5-BF91-499D-B487-58528DE7A166", "CAMPO2": "20237CB524568D5E49768778D37880CC6B53ULEZ", "CAMPO4": "" }, { "VBELN": "0071393187", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000307", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN LUIS", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "2433110.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025085", "TEL_NUMBER": "", "CAMPO1": "FC873659-0422-411B-BE20-6E2B2EB3AA5C", "CAMPO2": "2023CF05CEB56A054C7CA7B638D8D23E0888Q9UT", "CAMPO4": "" }, { "VBELN": "0071393188", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000307", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN LUIS", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "1125920.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025085", "TEL_NUMBER": "", "CAMPO1": "A0495223-BE17-40CB-9B47-8DD594E9D58D", "CAMPO2": "2023930B53185BA4404CAE827EC2DFEF51E1WOHM", "CAMPO4": "" }, { "VBELN": "0071393189", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000336", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS METROCENTRO 8av ETAPA", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "1779750.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025114", "TEL_NUMBER": "", "CAMPO1": "F96AC99C-5FA8-4548-8B10-25E9ED709A27", "CAMPO2": "2023800E1E4B262C422F902CFF0EB49573B5VGOR", "CAMPO4": "" }, { "VBELN": "0071393190", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000373", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ AYUTUXTEPEQUE", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "7920.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025151", "TEL_NUMBER": "", "CAMPO1": "DA7BA169-E92B-438E-ABE2-FA563D6B528F", "CAMPO2": "2023BBF1F43A89844C59A8A54C85B64B6AAFV5MD", "CAMPO4": "" }, { "VBELN": "0071393191", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000373", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ AYUTUXTEPEQUE", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "2277650.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025151", "TEL_NUMBER": "", "CAMPO1": "7681C886-3956-4249-90F6-C813C4090C39", "CAMPO2": "20231176CF75210C43E28DCF238004B405C9KBBL", "CAMPO4": "" }, { "VBELN": "0071393192", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000383", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DDJ LOS HEROES", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP004", "NETWR": "364800.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025161", "TEL_NUMBER": "", "CAMPO1": "08E00D13-BC9D-4C0C-BE55-CF0CE4BCF062", "CAMPO2": "2023CC5A743F35F540DAA673B8ED5F6C2278ISO0", "CAMPO4": "" }, { "VBELN": "0071393193", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000280", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ESPAÑA #36", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "3033720.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025058", "TEL_NUMBER": "", "CAMPO1": "244184A2-6A9E-49C8-9486-5A24CDDDAE0A", "CAMPO2": "20234B3445FFE2644EE689E517D7557B8962WGSV", "CAMPO4": "" }, { "VBELN": "0071393194", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000305", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SAN JACINTO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "5915330.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025083", "TEL_NUMBER": "", "CAMPO1": "A7E29EE0-381F-47A1-851B-C1A31BDA133F", "CAMPO2": "2023FA9F11B186374AB4AE12C7C25411C9DEZZKV", "CAMPO4": "" }, { "VBELN": "0071393195", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000444", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SAN JACINTO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "781950.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025222", "TEL_NUMBER": "", "CAMPO1": "558F00CC-80C3-44FA-A9CF-58BD795E92B3", "CAMPO2": "2023DC399B5091FB48CA8F7B331E7E0E438CLOZH", "CAMPO4": "" }, { "VBELN": "0071393196", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000448", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "MAXI BODEGA SAN MARCOS", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "1945580.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025226", "TEL_NUMBER": "", "CAMPO1": "C6502BB9-576C-4DBA-8F38-00D656950491", "CAMPO2": "202360BA9D9DDBC84ABB8C92A6AA0C8A4B03JSIW", "CAMPO4": "" }, { "VBELN": "0071393197", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000023604", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTO TOMAS", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "2572740.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000050544", "TEL_NUMBER": "", "CAMPO1": "D6331D26-8B88-473C-BB84-4C3BF860E256", "CAMPO2": "2023FE0EBB9B3CC742148FDF91C28D3D6426UO0O", "CAMPO4": "" }, { "VBELN": "0071393198", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000026543", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "S. SELECTOS SAN MARCOS EL ENCU", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "225000.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000055524", "TEL_NUMBER": "", "CAMPO1": "4464431D-45D5-48C4-ABF0-5B3AB28AE165", "CAMPO2": "2023F2CA3A61E7754425A959A8656D5F9E212GIH", "CAMPO4": "" }, { "VBELN": "0071393199", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000026543", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "S. SELECTOS SAN MARCOS EL ENCU", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP005", "NETWR": "4547830.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000055524", "TEL_NUMBER": "", "CAMPO1": "71503AC7-843D-47B7-8AC9-47EFC0E1489D", "CAMPO2": "2023CE06F3F4028F43519A15B0BD06D196DAZIMG", "CAMPO4": "" }, { "VBELN": "0071393204", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000303", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS PLAZA MUNDO #203", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "4326490.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025081", "TEL_NUMBER": "", "CAMPO1": "B6C2FC1F-6EAC-4128-970B-CF569E8A2315", "CAMPO2": "2023AD95039B709E44F3B9AE59A72844F401UNFZ", "CAMPO4": "" }, { "VBELN": "0071393205", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000367", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SOYAPANGO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "2405610.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025145", "TEL_NUMBER": "", "CAMPO1": "54AA8F49-F5A6-41D2-97F1-A762BB75E95C", "CAMPO2": "202308E7F6FE13364A1294DD569AA11C5B76KL6L", "CAMPO4": "" }, { "VBELN": "0071393206", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000367", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "WALMART SOYAPANGO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "110880.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025145", "TEL_NUMBER": "", "CAMPO1": "6670F220-5046-4ACC-9C7D-B14F65A84C4E", "CAMPO2": "2023CD98DFFA3C05433AA3AE4FBDE254E303C5PN", "CAMPO4": "" }, { "VBELN": "0071393207", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000427", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SOYAPANGO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "478540.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025205", "TEL_NUMBER": "", "CAMPO1": "C93DBEA5-3F56-4409-BBBF-D4624B599FC6", "CAMPO2": "2023E72CF6B2CC2544528431F621D666A0F5ODWP", "CAMPO4": "" }, { "VBELN": "0071393208", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000022232", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI SOYAPANGO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "761380.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000048373", "TEL_NUMBER": "", "CAMPO1": "39C04FDA-A39C-48F8-A7D2-5A3AF2430192", "CAMPO2": "2023CC26329D4A39401BBD436656377BB297LE4S", "CAMPO4": "" }, { "VBELN": "0071393209", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000023323", "NAME1": "OPERADORA DEL SUR S.A. DE C.V.", "NAME2": "MAXI DESPENSA BOULEVARD DEL EJ", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "638770.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000050035", "TEL_NUMBER": "", "CAMPO1": "6C0BAE16-104B-437E-B2A7-8A5798335F01", "CAMPO2": "20239B51EA84D0974D7FA92886619DCA707A8OFM", "CAMPO4": "" }, { "VBELN": "0071393212", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000335", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SENSUNTEPEQUE", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1268660.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025113", "TEL_NUMBER": "", "CAMPO1": "09A71199-6B42-48DB-93B7-4EA34F4FB09F", "CAMPO2": "2023530432F68F2C49B787B30812E7B25B05FTR9", "CAMPO4": "" }, { "VBELN": "0071393213", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000338", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS COJUTEPEQUE CENTRO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "2010910.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025116", "TEL_NUMBER": "", "CAMPO1": "911B7387-B199-4916-981E-DF4C4918464F", "CAMPO2": "2023D880B59B93C34F199C420E5AD7B005B8ELBO", "CAMPO4": "" }, { "VBELN": "0071393214", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000345", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS COJUTEPEQUE II", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "985270.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025123", "TEL_NUMBER": "", "CAMPO1": "CE4C2E08-414A-4DF3-9589-C1DAB493A27B", "CAMPO2": "20230D4EE5CA2A064E8BA3D5CFAD93843C9ECT7I", "CAMPO4": "" }, { "VBELN": "0071393215", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000346", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SUPER SELECTOS ILOBASCO II", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1109210.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025124", "TEL_NUMBER": "", "CAMPO1": "BFFD5789-4056-4753-B6A5-A4E115B2110A", "CAMPO2": "202393ACB23048D1428DA471E968D4C443E395K7", "CAMPO4": "" }, { "VBELN": "0071393216", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000352", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS ILOBASCO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "951100.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025130", "TEL_NUMBER": "", "CAMPO1": "F87AEAF9-BAE2-4FEB-8E27-077617ECACA1", "CAMPO2": "2023BA1F2F060C904DFCB584AC3C4C73C0CBSOIA", "CAMPO4": "" }, { "VBELN": "0071393217", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000424", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF SENSUNTEPEQUE", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "788140.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025202", "TEL_NUMBER": "", "CAMPO1": "F9927053-40B6-4325-B10E-DCF0E5AA0AD4", "CAMPO2": "2023CF567CC9B88E45C5A82EBFFA275B55C4OTZ4", "CAMPO4": "" }, { "VBELN": "0071393218", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000026814", "NAME1": "OPERADORA DEL SUR, S.A. DE  C.", "NAME2": "MAXI DESPENSA ILOBASCO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "1042360.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000056069", "TEL_NUMBER": "", "CAMPO1": "7E54E1DE-708C-4775-89CA-AB1CDEC0058D", "CAMPO2": "2023CC90177B76614A10A51D65C0FC348576WMJZ", "CAMPO4": "" }, { "VBELN": "0071393231", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000037973", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "S. SELECTOS SANTA TECLA LAS RA", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "3059450.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000070781", "TEL_NUMBER": "", "CAMPO1": "7DE763ED-1F30-4C4C-8326-55BFBC8DB7EA", "CAMPO2": "202389D1569626A044C4BC8AC2DAAD6772F2K0B0", "CAMPO4": "" }, { "VBELN": "0071393232", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000037973", "NAME1": "CALLEJA S.A. DE C.V.", "NAME2": "S. SELECTOS SANTA TECLA LAS RA", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP002", "NETWR": "32400.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000070781", "TEL_NUMBER": "", "CAMPO1": "ABEE64FA-E446-424C-A141-317B2DBA25EC", "CAMPO2": "202391D0E8B010D94D5E82463394E050C6AFXFKM", "CAMPO4": "" }, { "VBELN": "0071393235", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000321", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SANTA LUCIA", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "1496440.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025099", "TEL_NUMBER": "", "CAMPO1": "0642C448-40FE-44C6-9C0F-4B6157B12872", "CAMPO2": "2023AD4826ACBEEE4D39A804BD35D92CC267APBL", "CAMPO4": "" }, { "VBELN": "0071393236", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000327", "NAME1": "CALLEJA, S.A. DE C.V.", "NAME2": "SELECTOS SOYAPANGO", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP006", "NETWR": "732430.00", "KUNAG": "", "SMTP_ADDR": "dte@superselectos.com.sv", "ADRNR": "0000025105", "TEL_NUMBER": "", "CAMPO1": "66681A2D-61E3-4EC8-85C5-57B9D5148EE7", "CAMPO2": "20238490F5142D2D4538A04F3C10659A44D8VOI1", "CAMPO4": "" }, { "VBELN": "0071393237", "FKART": "ZSC1", "FKDAT": "20231010", "KUNNR": "2000000405", "NAME1": "OPERADORA DEL SUR, S.A. DE C.V", "NAME2": "DF COJUTEPEQUE", "AEDAT": "20231010", "AENAM": "ADMONLOG3", "CTIME": "", "BZIRK": "SUP007", "NETWR": "860150.00", "KUNAG": "", "SMTP_ADDR": "ebslaedisv@walmart.com", "ADRNR": "0000025183", "TEL_NUMBER": "", "CAMPO1": "7A72D367-32DD-4333-8A9B-CF3669C4BFA7", "CAMPO2": "202373F82AE19A364083A4193FD6AE2A3713ZAE2", "CAMPO4": "" } ],

                codigoBarra: [{
                    "EAN11": "10400000005635",
                    "MATNR": "000000000000150001"
                }, {
                    "EAN11": "10400000005642",
                    "MATNR": "000000000000150003"
                }, {
                    "EAN11": "10400000005659",
                    "MATNR": "000000000000150005"
                }, {
                    "EAN11": "10400000005673",
                    "MATNR": "000000000000160005"
                }, {
                    "EAN11": "10400000002498",
                    "MATNR": "000000000000120004"
                }, {
                    "EAN11": "10400000004447",
                    "MATNR": "000000000000110003"
                }, {
                    "EAN11": "10400000005598",
                    "MATNR": "000000000000110005"
                }, {
                    "EAN11": "2000000000039",
                    "MATNR": "000000000000110006"
                }, {
                    "EAN11": "10400000004157",
                    "MATNR": "000000000000110007"
                }, {
                    "EAN11": "10400000004454",
                    "MATNR": "000000000000110009"
                }, {
                    "EAN11": "10400000005345",
                    "MATNR": "000000000000240002"
                }, {
                    "EAN11": "10400000005352",
                    "MATNR": "000000000000240003"
                }, {
                    "EAN11": "10400000005369",
                    "MATNR": "000000000000240004"
                }, {
                    "EAN11": "10400000005376",
                    "MATNR": "000000000000240005"
                }, {
                    "EAN11": "10400000005383",
                    "MATNR": "000000000000240007"
                }, {
                    "EAN11": "10400000005390",
                    "MATNR": "000000000000240008"
                }, {
                    "EAN11": "10400000005406",
                    "MATNR": "000000000000240009"
                }, {
                    "EAN11": "10400000005529",
                    "MATNR": "000000000000250004"
                }, {
                    "EAN11": "10400000001347",
                    "MATNR": "000000000000110036"
                }, {
                    "EAN11": "10400000004164",
                    "MATNR": "000000000000110037"
                }, {
                    "EAN11": "10400000001804",
                    "MATNR": "000000000000110039"
                }, {
                    "EAN11": "10400000001484",
                    "MATNR": "000000000000110056"
                }, {
                    "EAN11": "10400000001491",
                    "MATNR": "000000000000110057"
                }, {
                    "EAN11": "10400000001507",
                    "MATNR": "000000000000110058"
                }, {
                    "EAN11": "10400000001514",
                    "MATNR": "000000000000110060"
                }, {
                    "EAN11": "10400000001521",
                    "MATNR": "000000000000110061"
                }, {
                    "EAN11": "10400000001309",
                    "MATNR": "000000000000110062"
                }, {
                    "EAN11": "10400000001538",
                    "MATNR": "000000000000110063"
                }, {
                    "EAN11": "10400000001170",
                    "MATNR": "000000000000110065"
                }, {
                    "EAN11": "10400000003945",
                    "MATNR": "000000000000110066"
                }, {
                    "EAN11": "10400000003952",
                    "MATNR": "000000000000110067"
                }, {
                    "EAN11": "2000000000053",
                    "MATNR": "000000000000140005"
                }, {
                    "EAN11": "787003000861",
                    "MATNR": "000000000000140220"
                }, {
                    "EAN11": "787003000892",
                    "MATNR": "000000000000140221"
                }, {
                    "EAN11": "787003000878",
                    "MATNR": "000000000000140222"
                }, {
                    "EAN11": "787003001028",
                    "MATNR": "000000000000140223"
                }, {
                    "EAN11": "787003001523",
                    "MATNR": "000000000000140224"
                }, {
                    "EAN11": "787003250518",
                    "MATNR": "000000000000140225"
                }, {
                    "EAN11": "787003600184",
                    "MATNR": "000000000000140226"
                }, {
                    "EAN11": "787003600191",
                    "MATNR": "000000000000140227"
                }, {
                    "EAN11": "787003250549",
                    "MATNR": "000000000000140228"
                }, {
                    "EAN11": "10400000004461",
                    "MATNR": "000000000000110013"
                }, {
                    "EAN11": "2000000000190",
                    "MATNR": "000000000000110014"
                }, {
                    "EAN11": "10400000004478",
                    "MATNR": "000000000000110015"
                }, {
                    "EAN11": "10400000001422",
                    "MATNR": "000000000000110016"
                }, {
                    "EAN11": "10400000001460",
                    "MATNR": "000000000000110018"
                }, {
                    "EAN11": "10400000001316",
                    "MATNR": "000000000000110019"
                }, {
                    "EAN11": "10400000001323",
                    "MATNR": "000000000000110020"
                }, {
                    "EAN11": "10400000001330",
                    "MATNR": "000000000000110021"
                }, {
                    "EAN11": "10400000001767",
                    "MATNR": "000000000000110023"
                }, {
                    "EAN11": "10400000001569",
                    "MATNR": "000000000000110024"
                }, {
                    "EAN11": "10400000001774",
                    "MATNR": "000000000000110025"
                }, {
                    "EAN11": "10400000001576",
                    "MATNR": "000000000000110028"
                }, {
                    "EAN11": "10400000005871",
                    "MATNR": "000000000000110029"
                }, {
                    "EAN11": "10400000001477",
                    "MATNR": "000000000000110030"
                }, {
                    "EAN11": "10400000001095",
                    "MATNR": "000000000000110031"
                }, {
                    "EAN11": "10400000001781",
                    "MATNR": "000000000000110033"
                }, {
                    "EAN11": "10400000001798",
                    "MATNR": "000000000000110034"
                }, {
                    "EAN11": "10400000006304",
                    "MATNR": "000000000000200030"
                }, {
                    "EAN11": "10400000006298",
                    "MATNR": "000000000000200033"
                }, {
                    "EAN11": "10400000005338",
                    "MATNR": "000000000000240001"
                }, {
                    "EAN11": "10400000004362",
                    "MATNR": "000000000000110116"
                }, {
                    "EAN11": "10400000004379",
                    "MATNR": "000000000000110117"
                }, {
                    "EAN11": "10400000001200",
                    "MATNR": "000000000000110118"
                }, {
                    "EAN11": "10400000001217",
                    "MATNR": "000000000000110119"
                }, {
                    "EAN11": "10400000004386",
                    "MATNR": "000000000000110121"
                }, {
                    "EAN11": "10400000001446",
                    "MATNR": "000000000000110122"
                }, {
                    "EAN11": "10400000002504",
                    "MATNR": "000000000000120010"
                }, {
                    "EAN11": "10400000002511",
                    "MATNR": "000000000000120029"
                }, {
                    "EAN11": "10400000003969",
                    "MATNR": "000000000000110068"
                }, {
                    "EAN11": "10400000003976",
                    "MATNR": "000000000000110069"
                }, {
                    "EAN11": "10400000003983",
                    "MATNR": "000000000000110070"
                }, {
                    "EAN11": "10400000003990",
                    "MATNR": "000000000000110071"
                }, {
                    "EAN11": "10400000004003",
                    "MATNR": "000000000000110072"
                }, {
                    "EAN11": "10400000005888",
                    "MATNR": "000000000000110073"
                }, {
                    "EAN11": "10400000005895",
                    "MATNR": "000000000000110074"
                }, {
                    "EAN11": "10400000001415",
                    "MATNR": "000000000000110075"
                }, {
                    "EAN11": "10400000001187",
                    "MATNR": "000000000000110076"
                }, {
                    "EAN11": "10400000001354",
                    "MATNR": "000000000000110078"
                }, {
                    "EAN11": "10400000001361",
                    "MATNR": "000000000000110079"
                }, {
                    "EAN11": "10400000001378",
                    "MATNR": "000000000000110080"
                }, {
                    "EAN11": "10400000001385",
                    "MATNR": "000000000000110081"
                }, {
                    "EAN11": "10400000001392",
                    "MATNR": "000000000000110082"
                }, {
                    "EAN11": "10400000001408",
                    "MATNR": "000000000000110083"
                }, {
                    "EAN11": "10400000001194",
                    "MATNR": "000000000000110086"
                }, {
                    "EAN11": "10400000004133",
                    "MATNR": "000000000000110087"
                }, {
                    "EAN11": "10400000001439",
                    "MATNR": "000000000000110088"
                }, {
                    "EAN11": "10400000002177",
                    "MATNR": "000000000000110089"
                }, {
                    "EAN11": "10400000002184",
                    "MATNR": "000000000000110090"
                }, {
                    "EAN11": "10400000002191",
                    "MATNR": "000000000000110091"
                }, {
                    "EAN11": "10400000002207",
                    "MATNR": "000000000000110092"
                }, {
                    "EAN11": "10400000002214",
                    "MATNR": "000000000000110094"
                }, {
                    "EAN11": "10400000002221",
                    "MATNR": "000000000000110095"
                }, {
                    "EAN11": "10400000002238",
                    "MATNR": "000000000000110100"
                }, {
                    "EAN11": "10400000002245",
                    "MATNR": "000000000000110104"
                }, {
                    "EAN11": "10400000002139",
                    "MATNR": "000000000000110111"
                }, {
                    "EAN11": "10400000002146",
                    "MATNR": "000000000000110112"
                }, {
                    "EAN11": "10400000004348",
                    "MATNR": "000000000000110113"
                }, {
                    "EAN11": "10400000004355",
                    "MATNR": "000000000000110114"
                }, {
                    "EAN11": "10400000000005",
                    "MATNR": "000000000000120051"
                }, {
                    "EAN11": "10400000000333",
                    "MATNR": "000000000000120052"
                }, {
                    "EAN11": "10400000001750",
                    "MATNR": "000000000000120053"
                }, {
                    "EAN11": "10400000000340",
                    "MATNR": "000000000000120059"
                }, {
                    "EAN11": "10400000000425",
                    "MATNR": "000000000000120061"
                }, {
                    "EAN11": "10400000000357",
                    "MATNR": "000000000000120062"
                }, {
                    "EAN11": "10400000000494",
                    "MATNR": "000000000000120109"
                }, {
                    "EAN11": "10400000005956",
                    "MATNR": "000000000000120129"
                }, {
                    "EAN11": "10400000000364",
                    "MATNR": "000000000000120063"
                }, {
                    "EAN11": "10400000000432",
                    "MATNR": "000000000000120071"
                }, {
                    "EAN11": "10400000000449",
                    "MATNR": "000000000000120073"
                }, {
                    "EAN11": "10400000001910",
                    "MATNR": "000000000000120075"
                }, {
                    "EAN11": "10400000006038",
                    "MATNR": "000000000000120194"
                }, {
                    "EAN11": "10400000001972",
                    "MATNR": "000000000000120207"
                }, {
                    "EAN11": "10400000001989",
                    "MATNR": "000000000000120208"
                }, {
                    "EAN11": "10400000000951",
                    "MATNR": "000000000000120209"
                }, {
                    "EAN11": "10400000000968",
                    "MATNR": "000000000000120210"
                }, {
                    "EAN11": "10400000000975",
                    "MATNR": "000000000000120213"
                }, {
                    "EAN11": "10400000000982",
                    "MATNR": "000000000000120214"
                }, {
                    "EAN11": "10400000000999",
                    "MATNR": "000000000000120215"
                }, {
                    "EAN11": "10400000001996",
                    "MATNR": "000000000000120217"
                }, {
                    "EAN11": "10400000001002",
                    "MATNR": "000000000000120218"
                }, {
                    "EAN11": "10400000005994",
                    "MATNR": "000000000000120141"
                }, {
                    "EAN11": "10400000006007",
                    "MATNR": "000000000000120143"
                }, {
                    "EAN11": "10400000006014",
                    "MATNR": "000000000000120145"
                }, {
                    "EAN11": "10400000006021",
                    "MATNR": "000000000000120146"
                }, {
                    "EAN11": "10400000000500",
                    "MATNR": "000000000000120163"
                }, {
                    "EAN11": "10400000000050",
                    "MATNR": "000000000000120231"
                }, {
                    "EAN11": "10400000005970",
                    "MATNR": "000000000000120232"
                }, {
                    "EAN11": "10400000000067",
                    "MATNR": "000000000000120234"
                }, {
                    "EAN11": "10400000002016",
                    "MATNR": "000000000000120236"
                }, {
                    "EAN11": "10400000001071",
                    "MATNR": "000000000000120237"
                }, {
                    "EAN11": "10400000000159",
                    "MATNR": "000000000000120251"
                }, {
                    "EAN11": "10400000000166",
                    "MATNR": "000000000000120252"
                }, {
                    "EAN11": "10400000000173",
                    "MATNR": "000000000000120254"
                }, {
                    "EAN11": "10400000002528",
                    "MATNR": "000000000000120255"
                }, {
                    "EAN11": "10400000003402",
                    "MATNR": "000000000000120256"
                }, {
                    "EAN11": "10400000003310",
                    "MATNR": "000000000000120262"
                }, {
                    "EAN11": "10400000002535",
                    "MATNR": "000000000000120268"
                }, {
                    "EAN11": "10400000004126",
                    "MATNR": "000000000000120273"
                }, {
                    "EAN11": "10400000000456",
                    "MATNR": "000000000000120300"
                }, {
                    "EAN11": "10400000001019",
                    "MATNR": "000000000000120219"
                }, {
                    "EAN11": "10400000005963",
                    "MATNR": "000000000000120221"
                }, {
                    "EAN11": "10400000001026",
                    "MATNR": "000000000000120222"
                }, {
                    "EAN11": "10400000002009",
                    "MATNR": "000000000000120224"
                }, {
                    "EAN11": "10400000001033",
                    "MATNR": "000000000000120225"
                }, {
                    "EAN11": "10400000001040",
                    "MATNR": "000000000000120230"
                }, {
                    "EAN11": "787003000830",
                    "MATNR": "000000000000140232"
                }, {
                    "EAN11": "787003600221",
                    "MATNR": "000000000000140233"
                }, {
                    "EAN11": "787003000632",
                    "MATNR": "000000000000140234"
                }, {
                    "EAN11": "787003600214",
                    "MATNR": "000000000000140235"
                }, {
                    "EAN11": "787003600252",
                    "MATNR": "000000000000140236"
                }, {
                    "EAN11": "787003600375",
                    "MATNR": "000000000000140237"
                }, {
                    "EAN11": "787003600436",
                    "MATNR": "000000000000140238"
                }, {
                    "EAN11": "787003600368",
                    "MATNR": "000000000000140239"
                }, {
                    "EAN11": "787003600382",
                    "MATNR": "000000000000140240"
                }, {
                    "EAN11": "787003001356",
                    "MATNR": "000000000000140241"
                }, {
                    "EAN11": "787003001455",
                    "MATNR": "000000000000140211"
                }, {
                    "EAN11": "787003250532",
                    "MATNR": "000000000000140229"
                }, {
                    "EAN11": "787003250556",
                    "MATNR": "000000000000140230"
                }, {
                    "EAN11": "787003000847",
                    "MATNR": "000000000000140231"
                }, {
                    "EAN11": "2000000000060",
                    "MATNR": "000000000000140013"
                }, {
                    "EAN11": "787003001646",
                    "MATNR": "000000000000140015"
                }, {
                    "EAN11": "2000000000077",
                    "MATNR": "000000000000140023"
                }, {
                    "EAN11": "2000000000084",
                    "MATNR": "000000000000140034"
                }, {
                    "EAN11": "2000000000152",
                    "MATNR": "000000000000140040"
                }, {
                    "EAN11": "2000000000091",
                    "MATNR": "000000000000140041"
                }, {
                    "EAN11": "2000000000107",
                    "MATNR": "000000000000140055"
                }, {
                    "EAN11": "787003002346",
                    "MATNR": "000000000000140071"
                }, {
                    "EAN11": "2000000000114",
                    "MATNR": "000000000000140072"
                }, {
                    "EAN11": "2000000000121",
                    "MATNR": "000000000000140077"
                }, {
                    "EAN11": "2000000000138",
                    "MATNR": "000000000000140078"
                }, {
                    "EAN11": "2000000000145",
                    "MATNR": "000000000000140079"
                }, {
                    "EAN11": "787003000526",
                    "MATNR": "000000000000140184"
                }, {
                    "EAN11": "787003001622",
                    "MATNR": "000000000000140254"
                }, {
                    "EAN11": "787003600610",
                    "MATNR": "000000000000140255"
                }, {
                    "EAN11": "787003600627",
                    "MATNR": "000000000000140256"
                }, {
                    "EAN11": "787003600580",
                    "MATNR": "000000000000140257"
                }, {
                    "EAN11": "787003600597",
                    "MATNR": "000000000000140258"
                }, {
                    "EAN11": "787003001387",
                    "MATNR": "000000000000140259"
                }, {
                    "EAN11": "787003000793",
                    "MATNR": "000000000000140260"
                }, {
                    "EAN11": "787003600511",
                    "MATNR": "000000000000140261"
                }, {
                    "EAN11": "787003600535",
                    "MATNR": "000000000000140262"
                }, {
                    "EAN11": "787003000908",
                    "MATNR": "000000000000140263"
                }, {
                    "EAN11": "787003250341",
                    "MATNR": "000000000000140264"
                }, {
                    "EAN11": "787003000557",
                    "MATNR": "000000000000140265"
                }, {
                    "EAN11": "787003000526",
                    "MATNR": "000000000000140266"
                }, {
                    "EAN11": "787003000618",
                    "MATNR": "000000000000140267"
                }, {
                    "EAN11": "787003000601",
                    "MATNR": "000000000000140268"
                }, {
                    "EAN11": "787003001561",
                    "MATNR": "000000000000140269"
                }, {
                    "EAN11": "787003000977",
                    "MATNR": "000000000000140270"
                }, {
                    "EAN11": "787003000564",
                    "MATNR": "000000000000140271"
                }, {
                    "EAN11": "787003000915",
                    "MATNR": "000000000000140272"
                }, {
                    "EAN11": "787003250310",
                    "MATNR": "000000000000140273"
                }, {
                    "EAN11": "787003250365",
                    "MATNR": "000000000000140274"
                }, {
                    "EAN11": "787003250334",
                    "MATNR": "000000000000140275"
                }, {
                    "EAN11": "787003001592",
                    "MATNR": "000000000000140309"
                }, {
                    "EAN11": "787003120040",
                    "MATNR": "000000000000140310"
                }, {
                    "EAN11": "787003600498",
                    "MATNR": "000000000000140311"
                }, {
                    "EAN11": "787003002056",
                    "MATNR": "000000000000140312"
                }, {
                    "EAN11": "787003000038",
                    "MATNR": "000000000000140313"
                }, {
                    "EAN11": "787003002063",
                    "MATNR": "000000000000140314"
                }, {
                    "EAN11": "787003016084",
                    "MATNR": "000000000000140315"
                }, {
                    "EAN11": "787003115022",
                    "MATNR": "000000000000140316"
                }, {
                    "EAN11": "787003016077",
                    "MATNR": "000000000000140317"
                }, {
                    "EAN11": "787003016060",
                    "MATNR": "000000000000140318"
                }, {
                    "EAN11": "7419901501166",
                    "MATNR": "000000000000140319"
                }, {
                    "EAN11": "787003002070",
                    "MATNR": "000000000000140320"
                }, {
                    "EAN11": "2319373529154",
                    "MATNR": "000000000000140321"
                }, {
                    "EAN11": "787003002087",
                    "MATNR": "000000000000140322"
                }, {
                    "EAN11": "787003001691",
                    "MATNR": "000000000000140323"
                }, {
                    "EAN11": "787003001684",
                    "MATNR": "000000000000140324"
                }, {
                    "EAN11": "787003002292",
                    "MATNR": "000000000000140325"
                }, {
                    "EAN11": "787003116012",
                    "MATNR": "000000000000140326"
                }, {
                    "EAN11": "787003016107",
                    "MATNR": "000000000000140327"
                }, {
                    "EAN11": "787003000069",
                    "MATNR": "000000000000140328"
                }, {
                    "EAN11": "787003016091",
                    "MATNR": "000000000000140329"
                }, {
                    "EAN11": "787003116050",
                    "MATNR": "000000000000140330"
                }, {
                    "EAN11": "787003250372",
                    "MATNR": "000000000000140276"
                }, {
                    "EAN11": "787003001547",
                    "MATNR": "000000000000140277"
                }, {
                    "EAN11": "787003000649",
                    "MATNR": "000000000000140278"
                }, {
                    "EAN11": "787003600634",
                    "MATNR": "000000000000140279"
                }, {
                    "EAN11": "787003000663",
                    "MATNR": "000000000000140280"
                }, {
                    "EAN11": "787003001349",
                    "MATNR": "000000000000140281"
                }, {
                    "EAN11": "787003000656",
                    "MATNR": "000000000000140282"
                }, {
                    "EAN11": "787003001363",
                    "MATNR": "000000000000140283"
                }, {
                    "EAN11": "787003000670",
                    "MATNR": "000000000000140284"
                }, {
                    "EAN11": "787003001639",
                    "MATNR": "000000000000140285"
                }, {
                    "EAN11": "787003001882",
                    "MATNR": "000000000000140286"
                }, {
                    "EAN11": "787003001899",
                    "MATNR": "000000000000140287"
                }, {
                    "EAN11": "787003001905",
                    "MATNR": "000000000000140288"
                }, {
                    "EAN11": "787003001912",
                    "MATNR": "000000000000140289"
                }, {
                    "EAN11": "787003001929",
                    "MATNR": "000000000000140290"
                }, {
                    "EAN11": "787003001936",
                    "MATNR": "000000000000140291"
                }, {
                    "EAN11": "787003001943",
                    "MATNR": "000000000000140292"
                }, {
                    "EAN11": "787003001950",
                    "MATNR": "000000000000140293"
                }, {
                    "EAN11": "787003001967",
                    "MATNR": "000000000000140294"
                }, {
                    "EAN11": "787003001974",
                    "MATNR": "000000000000140295"
                }, {
                    "EAN11": "787003001189",
                    "MATNR": "000000000000140296"
                }, {
                    "EAN11": "787003001981",
                    "MATNR": "000000000000140297"
                }, {
                    "EAN11": "787003001998",
                    "MATNR": "000000000000140298"
                }, {
                    "EAN11": "787003002001",
                    "MATNR": "000000000000140299"
                }, {
                    "EAN11": "787003002018",
                    "MATNR": "000000000000140300"
                }, {
                    "EAN11": "787003000021",
                    "MATNR": "000000000000140301"
                }, {
                    "EAN11": "787003111055",
                    "MATNR": "000000000000140302"
                }, {
                    "EAN11": "787003000014",
                    "MATNR": "000000000000140303"
                }, {
                    "EAN11": "787003000106",
                    "MATNR": "000000000000140304"
                }, {
                    "EAN11": "787003001165",
                    "MATNR": "000000000000140305"
                }, {
                    "EAN11": "787003002025",
                    "MATNR": "000000000000140306"
                }, {
                    "EAN11": "787003002032",
                    "MATNR": "000000000000140307"
                }, {
                    "EAN11": "787003002049",
                    "MATNR": "000000000000140308"
                }, {
                    "EAN11": "787003001486",
                    "MATNR": "000000000000140250"
                }, {
                    "EAN11": "787003001493",
                    "MATNR": "000000000000140251"
                }, {
                    "EAN11": "787003001509",
                    "MATNR": "000000000000140252"
                }, {
                    "EAN11": "787003001615",
                    "MATNR": "000000000000140253"
                }, {
                    "EAN11": "787003002230",
                    "MATNR": "000000000000140375"
                }, {
                    "EAN11": "787003001202",
                    "MATNR": "000000000000140376"
                }, {
                    "EAN11": "787003001721",
                    "MATNR": "000000000000140377"
                }, {
                    "EAN11": "787003001738",
                    "MATNR": "000000000000140378"
                }, {
                    "EAN11": "2000000000169",
                    "MATNR": "000000000000140379"
                }, {
                    "EAN11": "787003001783",
                    "MATNR": "000000000000140380"
                }, {
                    "EAN11": "787003002872",
                    "MATNR": "000000000000140387"
                }, {
                    "EAN11": "2000000000015",
                    "MATNR": "000000000000140390"
                }, {
                    "EAN11": "787003001653",
                    "MATNR": "000000000000140401"
                }, {
                    "EAN11": "10400000006335",
                    "MATNR": "000000000000200037"
                }, {
                    "EAN11": "787003002100",
                    "MATNR": "000000000000140331"
                }, {
                    "EAN11": "787003002117",
                    "MATNR": "000000000000140332"
                }, {
                    "EAN11": "787003002124",
                    "MATNR": "000000000000140333"
                }, {
                    "EAN11": "787003002131",
                    "MATNR": "000000000000140334"
                }, {
                    "EAN11": "787003002148",
                    "MATNR": "000000000000140335"
                }, {
                    "EAN11": "787003002155",
                    "MATNR": "000000000000140336"
                }, {
                    "EAN11": "787003002162",
                    "MATNR": "000000000000140337"
                }, {
                    "EAN11": "787003002179",
                    "MATNR": "000000000000140338"
                }, {
                    "EAN11": "787003120026",
                    "MATNR": "000000000000140339"
                }, {
                    "EAN11": "787003002308",
                    "MATNR": "000000000000140340"
                }, {
                    "EAN11": "787003001080",
                    "MATNR": "000000000000140341"
                }, {
                    "EAN11": "787003001431",
                    "MATNR": "000000000000140342"
                }, {
                    "EAN11": "2319373529161",
                    "MATNR": "000000000000140343"
                }, {
                    "EAN11": "787003180013",
                    "MATNR": "000000000000140344"
                }, {
                    "EAN11": "787003180020",
                    "MATNR": "000000000000140345"
                }, {
                    "EAN11": "2319373529185",
                    "MATNR": "000000000000140346"
                }, {
                    "EAN11": "787003002186",
                    "MATNR": "000000000000140347"
                }, {
                    "EAN11": "787003001288",
                    "MATNR": "000000000000140348"
                }, {
                    "EAN11": "787003000700",
                    "MATNR": "000000000000140349"
                }, {
                    "EAN11": "787003002193",
                    "MATNR": "000000000000140350"
                }, {
                    "EAN11": "787003001752",
                    "MATNR": "000000000000140351"
                }, {
                    "EAN11": "787003002209",
                    "MATNR": "000000000000140352"
                }, {
                    "EAN11": "787003002315",
                    "MATNR": "000000000000140353"
                }, {
                    "EAN11": "787003002322",
                    "MATNR": "000000000000140354"
                }, {
                    "EAN11": "787003200100",
                    "MATNR": "000000000000140355"
                }, {
                    "EAN11": "787003002261",
                    "MATNR": "000000000000140356"
                }, {
                    "EAN11": "787003180068",
                    "MATNR": "000000000000140357"
                }, {
                    "EAN11": "787003180105",
                    "MATNR": "000000000000140358"
                }, {
                    "EAN11": "787003002278",
                    "MATNR": "000000000000140359"
                }, {
                    "EAN11": "787003001271",
                    "MATNR": "000000000000140360"
                }, {
                    "EAN11": "2319373529178",
                    "MATNR": "000000000000140361"
                }, {
                    "EAN11": "787003600672",
                    "MATNR": "000000000000140362"
                }, {
                    "EAN11": "787003600665",
                    "MATNR": "000000000000140363"
                }, {
                    "EAN11": "787003600658",
                    "MATNR": "000000000000140364"
                }, {
                    "EAN11": "787003600641",
                    "MATNR": "000000000000140365"
                }, {
                    "EAN11": "787003001448",
                    "MATNR": "000000000000140366"
                }, {
                    "EAN11": "787003001462",
                    "MATNR": "000000000000140367"
                }, {
                    "EAN11": "787003001479",
                    "MATNR": "000000000000140368"
                }, {
                    "EAN11": "787003002285",
                    "MATNR": "000000000000140369"
                }, {
                    "EAN11": "787003002339",
                    "MATNR": "000000000000140370"
                }, {
                    "EAN11": "787003002353",
                    "MATNR": "000000000000140371"
                }, {
                    "EAN11": "2000000000046",
                    "MATNR": "000000000000140372"
                }, {
                    "EAN11": "787003001196",
                    "MATNR": "000000000000140373"
                }, {
                    "EAN11": "787003002223",
                    "MATNR": "000000000000140374"
                }, {
                    "EAN11": "10400000005413",
                    "MATNR": "000000000000240010"
                }, {
                    "EAN11": "10400000005420",
                    "MATNR": "000000000000240011"
                }, {
                    "EAN11": "8012063000158",
                    "MATNR": "000000000000180021"
                }, {
                    "EAN11": "8012063001025",
                    "MATNR": "000000000000180022"
                }, {
                    "EAN11": "8012063000974",
                    "MATNR": "000000000000180023"
                }, {
                    "EAN11": "10400000005451",
                    "MATNR": "000000000000240014"
                }, {
                    "EAN11": "10400000005468",
                    "MATNR": "000000000000240016"
                }, {
                    "EAN11": "10400000005475",
                    "MATNR": "000000000000240017"
                }, {
                    "EAN11": "10400000005536",
                    "MATNR": "000000000000240018"
                }, {
                    "EAN11": "10400000005543",
                    "MATNR": "000000000000240019"
                }, {
                    "EAN11": "10400000005482",
                    "MATNR": "000000000000240020"
                }, {
                    "EAN11": "10400000005499",
                    "MATNR": "000000000000240021"
                }, {
                    "EAN11": "10400000005512",
                    "MATNR": "000000000000240023"
                }, {
                    "EAN11": "8012063000073",
                    "MATNR": "000000000000180000"
                }, {
                    "EAN11": "8012063000141",
                    "MATNR": "000000000000180001"
                }, {
                    "EAN11": "8012063000752",
                    "MATNR": "000000000000180002"
                }, {
                    "EAN11": "8012063000684",
                    "MATNR": "000000000000180003"
                }, {
                    "EAN11": "8012063000615",
                    "MATNR": "000000000000180004"
                }, {
                    "EAN11": "8012063000998",
                    "MATNR": "000000000000180005"
                }, {
                    "EAN11": "8012063000790",
                    "MATNR": "000000000000180006"
                }, {
                    "EAN11": "8012063001544",
                    "MATNR": "000000000000180007"
                }, {
                    "EAN11": "8012063000080",
                    "MATNR": "000000000000180008"
                }, {
                    "EAN11": "8005021013703",
                    "MATNR": "000000000000180009"
                }, {
                    "EAN11": "8012063001551",
                    "MATNR": "000000000000180010"
                }, {
                    "EAN11": "8012063000592",
                    "MATNR": "000000000000180011"
                }, {
                    "EAN11": "8012063000936",
                    "MATNR": "000000000000180012"
                }, {
                    "EAN11": "8012063000905",
                    "MATNR": "000000000000180013"
                }, {
                    "EAN11": "8005021013727",
                    "MATNR": "000000000000180014"
                }, {
                    "EAN11": "8012063001667",
                    "MATNR": "000000000000180015"
                }, {
                    "EAN11": "8012063001049",
                    "MATNR": "000000000000180016"
                }, {
                    "EAN11": "8012063000738",
                    "MATNR": "000000000000180017"
                }, {
                    "EAN11": "8012063001643",
                    "MATNR": "000000000000180018"
                }, {
                    "EAN11": "8012063001018",
                    "MATNR": "000000000000180019"
                }, {
                    "EAN11": "8012063000745",
                    "MATNR": "000000000000180020"
                }, {
                    "EAN11": "10400000005796",
                    "MATNR": "000000000000200040"
                }, {
                    "EAN11": "10400000005802",
                    "MATNR": "000000000000200043"
                }, {
                    "EAN11": "10400000006892",
                    "MATNR": "000000000000200046"
                }, {
                    "EAN11": "10400000000074",
                    "MATNR": "000000000000120492"
                }, {
                    "EAN11": "10400000001927",
                    "MATNR": "000000000000120493"
                }, {
                    "EAN11": "10400000001934",
                    "MATNR": "000000000000120494"
                }, {
                    "EAN11": "10400000001941",
                    "MATNR": "000000000000120495"
                }, {
                    "EAN11": "10400000001958",
                    "MATNR": "000000000000120496"
                }, {
                    "EAN11": "10400000002252",
                    "MATNR": "000000000000110173"
                }, {
                    "EAN11": "10400000002269",
                    "MATNR": "000000000000110174"
                }, {
                    "EAN11": "10400000002276",
                    "MATNR": "000000000000110175"
                }, {
                    "EAN11": "10400000002283",
                    "MATNR": "000000000000110177"
                }, {
                    "EAN11": "10400000002290",
                    "MATNR": "000000000000110178"
                }, {
                    "EAN11": "10400000005901",
                    "MATNR": "000000000000120497"
                }, {
                    "EAN11": "10400000002153",
                    "MATNR": "000000000000110179"
                }, {
                    "EAN11": "10400000002160",
                    "MATNR": "000000000000110180"
                }, {
                    "EAN11": "10400000004010",
                    "MATNR": "000000000000110183"
                }, {
                    "EAN11": "787003001578",
                    "MATNR": "000000000000150030"
                }, {
                    "EAN11": "10400000002559",
                    "MATNR": "000000000000120502"
                }, {
                    "EAN11": "10400000002566",
                    "MATNR": "000000000000120503"
                }, {
                    "EAN11": "10400000004409",
                    "MATNR": "000000000000110184"
                }, {
                    "EAN11": "10400000002306",
                    "MATNR": "000000000000110185"
                }, {
                    "EAN11": "787003001554",
                    "MATNR": "000000000000150031"
                }, {
                    "EAN11": "787003002391",
                    "MATNR": "000000000000140423"
                }, {
                    "EAN11": "787003002384",
                    "MATNR": "000000000000140424"
                }, {
                    "EAN11": "787003002421",
                    "MATNR": "000000000000140425"
                }, {
                    "EAN11": "787003002407",
                    "MATNR": "000000000000140426"
                }, {
                    "EAN11": "787003002414",
                    "MATNR": "000000000000140427"
                }, {
                    "EAN11": "787003002483",
                    "MATNR": "000000000000140428"
                }, {
                    "EAN11": "787003002452",
                    "MATNR": "000000000000140429"
                }, {
                    "EAN11": "787003002445",
                    "MATNR": "000000000000140430"
                }, {
                    "EAN11": "787003002438",
                    "MATNR": "000000000000140431"
                }, {
                    "EAN11": "787003002469",
                    "MATNR": "000000000000140432"
                }, {
                    "EAN11": "10400000001088",
                    "MATNR": "000000000000120316"
                }, {
                    "EAN11": "10400000000463",
                    "MATNR": "000000000000120304"
                }, {
                    "EAN11": "10400000005987",
                    "MATNR": "000000000000120305"
                }, {
                    "EAN11": "10400000005437",
                    "MATNR": "000000000000240031"
                }, {
                    "EAN11": "787003002377",
                    "MATNR": "000000000000140413"
                }, {
                    "EAN11": "10400000006045",
                    "MATNR": "000000000000120372"
                }, {
                    "EAN11": "787003002360",
                    "MATNR": "000000000000140417"
                }, {
                    "EAN11": "787003002247",
                    "MATNR": "000000000000140418"
                }, {
                    "EAN11": "787003002254",
                    "MATNR": "000000000000140419"
                }, {
                    "EAN11": "10400000002542",
                    "MATNR": "000000000000120336"
                }, {
                    "EAN11": "10400000005819",
                    "MATNR": "000000000000120472"
                }, {
                    "EAN11": "10400000005826",
                    "MATNR": "000000000000120473"
                }, {
                    "EAN11": "10400000005833",
                    "MATNR": "000000000000120474"
                }, {
                    "EAN11": "10400000003440",
                    "MATNR": "000000000000120475"
                }, {
                    "EAN11": "10400000000579",
                    "MATNR": "000000000000120714"
                }, {
                    "EAN11": "10400000002825",
                    "MATNR": "000000000000120743"
                }, {
                    "EAN11": "787003002926",
                    "MATNR": "000000000000140572"
                }, {
                    "EAN11": "787003002933",
                    "MATNR": "000000000000140574"
                }, {
                    "EAN11": "787003002940",
                    "MATNR": "000000000000140575"
                }, {
                    "EAN11": "10400000000616",
                    "MATNR": "000000000000120744"
                }, {
                    "EAN11": "10400000000623",
                    "MATNR": "000000000000120746"
                }, {
                    "EAN11": "787003002599",
                    "MATNR": "000000000000140434"
                }, {
                    "EAN11": "10400000000586",
                    "MATNR": "000000000000120722"
                }, {
                    "EAN11": "10400000004492",
                    "MATNR": "000000000000110283"
                }, {
                    "EAN11": "10400000001224",
                    "MATNR": "000000000000110254"
                }, {
                    "EAN11": "10400000006106",
                    "MATNR": "000000000000120724"
                }, {
                    "EAN11": "10400000001637",
                    "MATNR": "000000000000120754"
                }, {
                    "EAN11": "10400000006120",
                    "MATNR": "000000000000120755"
                }, {
                    "EAN11": "787003002957",
                    "MATNR": "000000000000140584"
                }, {
                    "EAN11": "787003002964",
                    "MATNR": "000000000000140585"
                }, {
                    "EAN11": "787003002704",
                    "MATNR": "000000000000140586"
                }, {
                    "EAN11": "10400000002580",
                    "MATNR": "000000000000120632"
                }, {
                    "EAN11": "10400000002719",
                    "MATNR": "000000000000120646"
                }, {
                    "EAN11": "10400000002726",
                    "MATNR": "000000000000120647"
                }, {
                    "EAN11": "10400000002733",
                    "MATNR": "000000000000120648"
                }, {
                    "EAN11": "10400000002740",
                    "MATNR": "000000000000120649"
                }, {
                    "EAN11": "10400000006137",
                    "MATNR": "000000000000120757"
                }, {
                    "EAN11": "10400000002351",
                    "MATNR": "000000000000110284"
                }, {
                    "EAN11": "787003002971",
                    "MATNR": "000000000000140587"
                }, {
                    "EAN11": "10400000002757",
                    "MATNR": "000000000000120702"
                }, {
                    "EAN11": "10400000002764",
                    "MATNR": "000000000000120705"
                }, {
                    "EAN11": "10400000001644",
                    "MATNR": "000000000000120758"
                }, {
                    "EAN11": "10400000003525",
                    "MATNR": "000000000000120766"
                }, {
                    "EAN11": "10400000003532",
                    "MATNR": "000000000000120767"
                }, {
                    "EAN11": "10400000003549",
                    "MATNR": "000000000000120768"
                }, {
                    "EAN11": "10400000003556",
                    "MATNR": "000000000000120769"
                }, {
                    "EAN11": "10400000003563",
                    "MATNR": "000000000000120770"
                }, {
                    "EAN11": "10400000003570",
                    "MATNR": "000000000000120771"
                }, {
                    "EAN11": "10400000003587",
                    "MATNR": "000000000000120772"
                }, {
                    "EAN11": "10400000003594",
                    "MATNR": "000000000000120777"
                }, {
                    "EAN11": "10400000003600",
                    "MATNR": "000000000000120778"
                }, {
                    "EAN11": "10400000003617",
                    "MATNR": "000000000000120779"
                }, {
                    "EAN11": "10400000003624",
                    "MATNR": "000000000000120780"
                }, {
                    "EAN11": "787003002742",
                    "MATNR": "000000000000140512"
                }, {
                    "EAN11": "787003002834",
                    "MATNR": "000000000000140553"
                }, {
                    "EAN11": "10400000006113",
                    "MATNR": "000000000000120725"
                }, {
                    "EAN11": "10400000001057",
                    "MATNR": "000000000000120726"
                }, {
                    "EAN11": "10400000000944",
                    "MATNR": "000000000000120729"
                }, {
                    "EAN11": "10400000000593",
                    "MATNR": "000000000000120730"
                }, {
                    "EAN11": "10400000000609",
                    "MATNR": "000000000000120731"
                }, {
                    "EAN11": "10400000000906",
                    "MATNR": "000000000000120708"
                }, {
                    "EAN11": "10400000000913",
                    "MATNR": "000000000000120709"
                }, {
                    "EAN11": "10400000000920",
                    "MATNR": "000000000000120711"
                }, {
                    "EAN11": "10400000003457",
                    "MATNR": "000000000000120759"
                }, {
                    "EAN11": "10400000003464",
                    "MATNR": "000000000000120760"
                }, {
                    "EAN11": "10400000003471",
                    "MATNR": "000000000000120761"
                }, {
                    "EAN11": "10400000003488",
                    "MATNR": "000000000000120762"
                }, {
                    "EAN11": "10400000005918",
                    "MATNR": "000000000000110193"
                }, {
                    "EAN11": "787003002575",
                    "MATNR": "000000000000140457"
                }, {
                    "EAN11": "787003003183",
                    "MATNR": "000000000000140458"
                }, {
                    "EAN11": "10400000002313",
                    "MATNR": "000000000000110197"
                }, {
                    "EAN11": "10400000002320",
                    "MATNR": "000000000000110198"
                }, {
                    "EAN11": "10400000002337",
                    "MATNR": "000000000000110203"
                }, {
                    "EAN11": "10400000000937",
                    "MATNR": "000000000000120712"
                }, {
                    "EAN11": "787003002520",
                    "MATNR": "000000000000140462"
                }, {
                    "EAN11": "787003002667",
                    "MATNR": "000000000000140463"
                }, {
                    "EAN11": "10400000006052",
                    "MATNR": "000000000000120557"
                }, {
                    "EAN11": "10400000006069",
                    "MATNR": "000000000000120558"
                }, {
                    "EAN11": "10400000006076",
                    "MATNR": "000000000000120559"
                }, {
                    "EAN11": "10400000006083",
                    "MATNR": "000000000000120560"
                }, {
                    "EAN11": "10400000001590",
                    "MATNR": "000000000000110273"
                }, {
                    "EAN11": "10400000003495",
                    "MATNR": "000000000000120763"
                }, {
                    "EAN11": "10400000003501",
                    "MATNR": "000000000000120764"
                }, {
                    "EAN11": "10400000003518",
                    "MATNR": "000000000000120765"
                }, {
                    "EAN11": "787003001295",
                    "MATNR": "000000000000140444"
                }, {
                    "EAN11": "787003001318",
                    "MATNR": "000000000000140445"
                }, {
                    "EAN11": "787003001301",
                    "MATNR": "000000000000140446"
                }, {
                    "EAN11": "787003001530",
                    "MATNR": "000000000000140447"
                }, {
                    "EAN11": "787003001394",
                    "MATNR": "000000000000140448"
                }, {
                    "EAN11": "787003001417",
                    "MATNR": "000000000000140449"
                }, {
                    "EAN11": "787003001400",
                    "MATNR": "000000000000140450"
                }, {
                    "EAN11": "787003001820",
                    "MATNR": "000000000000140451"
                }, {
                    "EAN11": "20787003001282",
                    "MATNR": "000000000000140452"
                }, {
                    "EAN11": "10400000001583",
                    "MATNR": "000000000000110213"
                }, {
                    "EAN11": "10400000000562",
                    "MATNR": "000000000000120713"
                }, {
                    "EAN11": "10400000003631",
                    "MATNR": "000000000000120781"
                }, {
                    "EAN11": "10400000003648",
                    "MATNR": "000000000000120782"
                }, {
                    "EAN11": "10400000003655",
                    "MATNR": "000000000000120783"
                }, {
                    "EAN11": "787003002568",
                    "MATNR": "000000000000140588"
                }, {
                    "EAN11": "787003002674",
                    "MATNR": "000000000000140589"
                }, {
                    "EAN11": "787003002889",
                    "MATNR": "000000000000140562"
                }, {
                    "EAN11": "10400000006090",
                    "MATNR": "000000000000120693"
                }, {
                    "EAN11": "10400000000548",
                    "MATNR": "000000000000120694"
                }, {
                    "EAN11": "10400000006311",
                    "MATNR": "000000000000200080"
                }, {
                    "EAN11": "10400000000371",
                    "MATNR": "000000000000120617"
                }, {
                    "EAN11": "10400000002597",
                    "MATNR": "000000000000120633"
                }, {
                    "EAN11": "10400000002603",
                    "MATNR": "000000000000120634"
                }, {
                    "EAN11": "10400000002610",
                    "MATNR": "000000000000120635"
                }, {
                    "EAN11": "10400000002627",
                    "MATNR": "000000000000120636"
                }, {
                    "EAN11": "10400000002634",
                    "MATNR": "000000000000120637"
                }, {
                    "EAN11": "10400000002641",
                    "MATNR": "000000000000120638"
                }, {
                    "EAN11": "10400000002658",
                    "MATNR": "000000000000120639"
                }, {
                    "EAN11": "10400000002665",
                    "MATNR": "000000000000120640"
                }, {
                    "EAN11": "10400000002672",
                    "MATNR": "000000000000120642"
                }, {
                    "EAN11": "10400000002689",
                    "MATNR": "000000000000120643"
                }, {
                    "EAN11": "10400000002696",
                    "MATNR": "000000000000120644"
                }, {
                    "EAN11": "10400000002702",
                    "MATNR": "000000000000120645"
                }, {
                    "EAN11": "10400000001118",
                    "MATNR": "000000000000110224"
                }, {
                    "EAN11": "10400000004485",
                    "MATNR": "000000000000110263"
                }, {
                    "EAN11": "2319373982102",
                    "MATNR": "000000000000140502"
                }, {
                    "EAN11": "2319373982089",
                    "MATNR": "000000000000140503"
                }, {
                    "EAN11": "2319373982096",
                    "MATNR": "000000000000140504"
                }, {
                    "EAN11": "2319373982119",
                    "MATNR": "000000000000140505"
                }, {
                    "EAN11": "2319373976521",
                    "MATNR": "000000000000140506"
                }, {
                    "EAN11": "2319373976538",
                    "MATNR": "000000000000140507"
                }, {
                    "EAN11": "10400000005680",
                    "MATNR": "000000000000120535"
                }, {
                    "EAN11": "10400000002788",
                    "MATNR": "000000000000120733"
                }, {
                    "EAN11": "10400000002795",
                    "MATNR": "000000000000120734"
                }, {
                    "EAN11": "10400000002801",
                    "MATNR": "000000000000120735"
                }, {
                    "EAN11": "10400000002818",
                    "MATNR": "000000000000120742"
                }, {
                    "EAN11": "10400000002573",
                    "MATNR": "000000000000120582"
                }, {
                    "EAN11": "20787003001442",
                    "MATNR": "000000000000140475"
                }, {
                    "EAN11": "20787003001466",
                    "MATNR": "000000000000140476"
                }, {
                    "EAN11": "20787003001473",
                    "MATNR": "000000000000140477"
                }, {
                    "EAN11": "10787003600648",
                    "MATNR": "000000000000140478"
                }, {
                    "EAN11": "10787003000790",
                    "MATNR": "000000000000140479"
                }, {
                    "EAN11": "10787003001025",
                    "MATNR": "000000000000140480"
                }, {
                    "EAN11": "10787003001087",
                    "MATNR": "000000000000140481"
                }, {
                    "EAN11": "10787003001162",
                    "MATNR": "000000000000140482"
                }, {
                    "EAN11": "10787003600495",
                    "MATNR": "000000000000140483"
                }, {
                    "EAN11": "20787003016071",
                    "MATNR": "000000000000140484"
                }, {
                    "EAN11": "787003002698",
                    "MATNR": "000000000000140485"
                }, {
                    "EAN11": "2319373976644",
                    "MATNR": "000000000000140508"
                }, {
                    "EAN11": "787003002681",
                    "MATNR": "000000000000140522"
                }, {
                    "EAN11": "10400000001101",
                    "MATNR": "000000000000110187"
                }, {
                    "EAN11": "10400000000555",
                    "MATNR": "000000000000120700"
                }, {
                    "EAN11": "10400000006328",
                    "MATNR": "000000000000200083"
                }, {
                    "EAN11": "10400000002023",
                    "MATNR": "000000000000120701"
                }, {
                    "EAN11": "10400000000388",
                    "MATNR": "000000000000120706"
                }, {
                    "EAN11": "10400000002771",
                    "MATNR": "000000000000120707"
                }, {
                    "EAN11": "787003002636",
                    "MATNR": "000000000000140472"
                }, {
                    "EAN11": "787003002643",
                    "MATNR": "000000000000140473"
                }, {
                    "EAN11": "787003002612",
                    "MATNR": "000000000000140474"
                }, {
                    "EAN11": "10400000002344",
                    "MATNR": "000000000000110214"
                }, {
                    "EAN11": "10400000004089",
                    "MATNR": "000000000000120608"
                }, {
                    "EAN11": "10400000004140",
                    "MATNR": "000000000000120695"
                }, {
                    "EAN11": "787003002841",
                    "MATNR": "000000000000140536"
                }, {
                    "EAN11": "10400000004072",
                    "MATNR": "000000000000120526"
                }, {
                    "EAN11": "787003002506",
                    "MATNR": "000000000000140532"
                }, {
                    "EAN11": "10400000004027",
                    "MATNR": "000000000000110199"
                }, {
                    "EAN11": "10400000004393",
                    "MATNR": "000000000000110200"
                }, {
                    "EAN11": "787003002544",
                    "MATNR": "000000000000140465"
                }, {
                    "EAN11": "10400000000517",
                    "MATNR": "000000000000120686"
                }, {
                    "EAN11": "10400000000524",
                    "MATNR": "000000000000120687"
                }, {
                    "EAN11": "10400000003327",
                    "MATNR": "000000000000120672"
                }, {
                    "EAN11": "10400000003334",
                    "MATNR": "000000000000120673"
                }, {
                    "EAN11": "10400000001736",
                    "MATNR": "000000000000110234"
                }, {
                    "EAN11": "10400000005697",
                    "MATNR": "000000000000120676"
                }, {
                    "EAN11": "10400000000531",
                    "MATNR": "000000000000120689"
                }, {
                    "EAN11": "787003002827",
                    "MATNR": "000000000000140533"
                }, {
                    "EAN11": "10400000002863",
                    "MATNR": "000000000000120824"
                }, {
                    "EAN11": "10400000002870",
                    "MATNR": "000000000000120825"
                }, {
                    "EAN11": "10400000002887",
                    "MATNR": "000000000000120826"
                }, {
                    "EAN11": "787003002919",
                    "MATNR": "000000000000140612"
                }, {
                    "EAN11": "10400000001132",
                    "MATNR": "000000000000110333"
                }, {
                    "EAN11": "10400000000111",
                    "MATNR": "000000000000120922"
                }, {
                    "EAN11": "10400000005734",
                    "MATNR": "000000000000120923"
                }, {
                    "EAN11": "10400000001453",
                    "MATNR": "000000000000110363"
                }, {
                    "EAN11": "10400000000661",
                    "MATNR": "000000000000120952"
                }, {
                    "EAN11": "10400000000678",
                    "MATNR": "000000000000120953"
                }, {
                    "EAN11": "10400000000395",
                    "MATNR": "000000000000120954"
                }, {
                    "EAN11": "10400000000128",
                    "MATNR": "000000000000120955"
                }, {
                    "EAN11": "2319374226076",
                    "MATNR": "000000000000140632"
                }, {
                    "EAN11": "10400000003426",
                    "MATNR": "000000000000120872"
                }, {
                    "EAN11": "10400000004171",
                    "MATNR": "000000000000120873"
                }, {
                    "EAN11": "10400000001149",
                    "MATNR": "000000000000110369"
                }, {
                    "EAN11": "10400000000685",
                    "MATNR": "000000000000120958"
                }, {
                    "EAN11": "10400000000692",
                    "MATNR": "000000000000120959"
                }, {
                    "EAN11": "10400000000708",
                    "MATNR": "000000000000120960"
                }, {
                    "EAN11": "10400000000715",
                    "MATNR": "000000000000120961"
                }, {
                    "EAN11": "10400000001248",
                    "MATNR": "000000000000110366"
                }, {
                    "EAN11": "10400000001255",
                    "MATNR": "000000000000110367"
                }, {
                    "EAN11": "10400000002368",
                    "MATNR": "000000000000110375"
                }, {
                    "EAN11": "10400000002375",
                    "MATNR": "000000000000110376"
                }, {
                    "EAN11": "10400000002382",
                    "MATNR": "000000000000110377"
                }, {
                    "EAN11": "787003003305",
                    "MATNR": "000000000000140692"
                }, {
                    "EAN11": "10400000004317",
                    "MATNR": "000000000000110393"
                }, {
                    "EAN11": "10400000004249",
                    "MATNR": "000000000000120992"
                }, {
                    "EAN11": "10400000000234",
                    "MATNR": "000000000000120887"
                }, {
                    "EAN11": "10400000004119",
                    "MATNR": "000000000000121003"
                }, {
                    "EAN11": "10400000003839",
                    "MATNR": "000000000000121004"
                }, {
                    "EAN11": "10400000000630",
                    "MATNR": "000000000000120893"
                }, {
                    "EAN11": "10400000003785",
                    "MATNR": "000000000000120982"
                }, {
                    "EAN11": "10400000003792",
                    "MATNR": "000000000000120983"
                }, {
                    "EAN11": "10400000003808",
                    "MATNR": "000000000000120984"
                }, {
                    "EAN11": "10400000003815",
                    "MATNR": "000000000000120985"
                }, {
                    "EAN11": "10400000003822",
                    "MATNR": "000000000000120986"
                }, {
                    "EAN11": "10400000002924",
                    "MATNR": "000000000000120996"
                }, {
                    "EAN11": "10400000002931",
                    "MATNR": "000000000000120997"
                }, {
                    "EAN11": "10400000002894",
                    "MATNR": "000000000000120993"
                }, {
                    "EAN11": "10400000002900",
                    "MATNR": "000000000000120994"
                }, {
                    "EAN11": "10400000002917",
                    "MATNR": "000000000000120995"
                }, {
                    "EAN11": "10400000002399",
                    "MATNR": "000000000000110394"
                }, {
                    "EAN11": "10400000002405",
                    "MATNR": "000000000000110395"
                }, {
                    "EAN11": "10400000002412",
                    "MATNR": "000000000000110396"
                }, {
                    "EAN11": "10400000002429",
                    "MATNR": "000000000000110397"
                }, {
                    "EAN11": "10400000000258",
                    "MATNR": "000000000000121001"
                }, {
                    "EAN11": "10400000002948",
                    "MATNR": "000000000000120998"
                }, {
                    "EAN11": "10400000000746",
                    "MATNR": "000000000000120999"
                }, {
                    "EAN11": "10400000000753",
                    "MATNR": "000000000000121002"
                }, {
                    "EAN11": "787003003343",
                    "MATNR": "000000000000140712"
                }, {
                    "EAN11": "10400000002832",
                    "MATNR": "000000000000120792"
                }, {
                    "EAN11": "10400000002849",
                    "MATNR": "000000000000120794"
                }, {
                    "EAN11": "10400000002030",
                    "MATNR": "000000000000120842"
                }, {
                    "EAN11": "10400000001231",
                    "MATNR": "000000000000110303"
                }, {
                    "EAN11": "10400000005444",
                    "MATNR": "000000000000240071"
                }, {
                    "EAN11": "10400000003419",
                    "MATNR": "000000000000120863"
                }, {
                    "EAN11": "10400000000647",
                    "MATNR": "000000000000120912"
                }, {
                    "EAN11": "10400000000654",
                    "MATNR": "000000000000120913"
                }, {
                    "EAN11": "10400000001125",
                    "MATNR": "000000000000110305"
                }, {
                    "EAN11": "10400000001859",
                    "MATNR": "000000000000110306"
                }, {
                    "EAN11": "787003003008",
                    "MATNR": "000000000000140603"
                }, {
                    "EAN11": "787003003152",
                    "MATNR": "000000000000140663"
                }, {
                    "EAN11": "787003003299",
                    "MATNR": "000000000000140675"
                }, {
                    "EAN11": "10400000006144",
                    "MATNR": "000000000000120915"
                }, {
                    "EAN11": "10400000002078",
                    "MATNR": "000000000000120916"
                }, {
                    "EAN11": "10400000002085",
                    "MATNR": "000000000000120917"
                }, {
                    "EAN11": "10400000000180",
                    "MATNR": "000000000000120806"
                }, {
                    "EAN11": "10400000000081",
                    "MATNR": "000000000000120814"
                }, {
                    "EAN11": "10400000000098",
                    "MATNR": "000000000000120816"
                }, {
                    "EAN11": "10400000000197",
                    "MATNR": "000000000000120818"
                }, {
                    "EAN11": "10400000005703",
                    "MATNR": "000000000000120819"
                }, {
                    "EAN11": "10400000005710",
                    "MATNR": "000000000000120821"
                }, {
                    "EAN11": "10400000005727",
                    "MATNR": "000000000000120822"
                }, {
                    "EAN11": "10400000002856",
                    "MATNR": "000000000000120823"
                }, {
                    "EAN11": "10400000001613",
                    "MATNR": "000000000000110364"
                }, {
                    "EAN11": "10400000001620",
                    "MATNR": "000000000000110365"
                }, {
                    "EAN11": "10400000000135",
                    "MATNR": "000000000000120962"
                }, {
                    "EAN11": "10400000004034",
                    "MATNR": "000000000000110357"
                }, {
                    "EAN11": "10400000003747",
                    "MATNR": "000000000000120934"
                }, {
                    "EAN11": "10400000003754",
                    "MATNR": "000000000000120935"
                }, {
                    "EAN11": "10400000003761",
                    "MATNR": "000000000000120936"
                }, {
                    "EAN11": "10400000003778",
                    "MATNR": "000000000000120937"
                }, {
                    "EAN11": "10400000000401",
                    "MATNR": "000000000000121076"
                }, {
                    "EAN11": "10400000003211",
                    "MATNR": "000000000000121077"
                }, {
                    "EAN11": "10400000003235",
                    "MATNR": "000000000000121079"
                }, {
                    "EAN11": "10400000003242",
                    "MATNR": "000000000000121080"
                }, {
                    "EAN11": "10400000003259",
                    "MATNR": "000000000000121081"
                }, {
                    "EAN11": "10400000003020",
                    "MATNR": "000000000000121044"
                }, {
                    "EAN11": "10400000000265",
                    "MATNR": "000000000000121029"
                }, {
                    "EAN11": "10400000003037",
                    "MATNR": "000000000000121045"
                }, {
                    "EAN11": "10400000003044",
                    "MATNR": "000000000000121046"
                }, {
                    "EAN11": "10400000003051",
                    "MATNR": "000000000000121047"
                }, {
                    "EAN11": "10400000003068",
                    "MATNR": "000000000000121048"
                }, {
                    "EAN11": "10400000003075",
                    "MATNR": "000000000000121049"
                }, {
                    "EAN11": "10400000003082",
                    "MATNR": "000000000000121050"
                }, {
                    "EAN11": "10400000003099",
                    "MATNR": "000000000000121051"
                }, {
                    "EAN11": "10400000003105",
                    "MATNR": "000000000000121052"
                }, {
                    "EAN11": "10400000003112",
                    "MATNR": "000000000000121054"
                }, {
                    "EAN11": "10400000003129",
                    "MATNR": "000000000000121055"
                }, {
                    "EAN11": "10400000004508",
                    "MATNR": "000000000000110416"
                }, {
                    "EAN11": "10400000000296",
                    "MATNR": "000000000000121095"
                }, {
                    "EAN11": "10400000000302",
                    "MATNR": "000000000000121096"
                }, {
                    "EAN11": "10400000005604",
                    "MATNR": "000000000000130168"
                }, {
                    "EAN11": "10400000005611",
                    "MATNR": "000000000000130171"
                }, {
                    "EAN11": "10400000006649",
                    "MATNR": "000000000000110419"
                }, {
                    "EAN11": "10400000000272",
                    "MATNR": "000000000000121064"
                }, {
                    "EAN11": "10400000000289",
                    "MATNR": "000000000000121065"
                }, {
                    "EAN11": "10400000003198",
                    "MATNR": "000000000000121074"
                }, {
                    "EAN11": "10400000003204",
                    "MATNR": "000000000000121075"
                }, {
                    "EAN11": "10400000003228",
                    "MATNR": "000000000000121078"
                }, {
                    "EAN11": "10400000004195",
                    "MATNR": "000000000000110353"
                }, {
                    "EAN11": "10400000004201",
                    "MATNR": "000000000000110354"
                }, {
                    "EAN11": "10400000004218",
                    "MATNR": "000000000000110355"
                }, {
                    "EAN11": "10400000004225",
                    "MATNR": "000000000000110356"
                }, {
                    "EAN11": "10400000001965",
                    "MATNR": "000000000000120932"
                }, {
                    "EAN11": "10400000000241",
                    "MATNR": "000000000000120933"
                }, {
                    "EAN11": "10400000001163",
                    "MATNR": "000000000000110443"
                }, {
                    "EAN11": "10400000001606",
                    "MATNR": "000000000000121092"
                }, {
                    "EAN11": "10400000005932",
                    "MATNR": "000000000000110453"
                }, {
                    "EAN11": "787003003916",
                    "MATNR": "000000000000140752"
                }, {
                    "EAN11": "10400000005628",
                    "MATNR": "000000000000130176"
                }, {
                    "EAN11": "10400000005666",
                    "MATNR": "000000000000150110"
                }, {
                    "EAN11": "10400000003266",
                    "MATNR": "000000000000121082"
                }, {
                    "EAN11": "10400000003273",
                    "MATNR": "000000000000121083"
                }, {
                    "EAN11": "10400000003358",
                    "MATNR": "000000000000121084"
                }, {
                    "EAN11": "10400000003365",
                    "MATNR": "000000000000121085"
                }, {
                    "EAN11": "10400000003372",
                    "MATNR": "000000000000121086"
                }, {
                    "EAN11": "10400000003389",
                    "MATNR": "000000000000121087"
                }, {
                    "EAN11": "10400000003396",
                    "MATNR": "000000000000121088"
                }, {
                    "EAN11": "10400000000470",
                    "MATNR": "000000000000121089"
                }, {
                    "EAN11": "10400000004263",
                    "MATNR": "000000000000121093"
                }, {
                    "EAN11": "10400000004270",
                    "MATNR": "000000000000121094"
                }, {
                    "EAN11": "10400000000876",
                    "MATNR": "000000000000121098"
                }, {
                    "EAN11": "10400000000883",
                    "MATNR": "000000000000121099"
                }, {
                    "EAN11": "787003003107",
                    "MATNR": "000000000000140652"
                }, {
                    "EAN11": "10400000002054",
                    "MATNR": "000000000000120903"
                }, {
                    "EAN11": "10400000001873",
                    "MATNR": "000000000000120904"
                }, {
                    "EAN11": "10400000001880",
                    "MATNR": "000000000000120905"
                }, {
                    "EAN11": "10400000002061",
                    "MATNR": "000000000000120906"
                }, {
                    "EAN11": "10400000001811",
                    "MATNR": "000000000000110383"
                }, {
                    "EAN11": "787003003244",
                    "MATNR": "000000000000140702"
                }, {
                    "EAN11": "787003003251",
                    "MATNR": "000000000000140704"
                }, {
                    "EAN11": "10400000000807",
                    "MATNR": "000000000000121018"
                }, {
                    "EAN11": "10400000000814",
                    "MATNR": "000000000000121019"
                }, {
                    "EAN11": "10400000000821",
                    "MATNR": "000000000000121020"
                }, {
                    "EAN11": "10400000000838",
                    "MATNR": "000000000000121021"
                }, {
                    "EAN11": "787003003367",
                    "MATNR": "000000000000140715"
                }, {
                    "EAN11": "10400000003341",
                    "MATNR": "000000000000120832"
                }, {
                    "EAN11": "10400000001064",
                    "MATNR": "000000000000120892"
                }, {
                    "EAN11": "787003003374",
                    "MATNR": "000000000000140716"
                }, {
                    "EAN11": "787003003381",
                    "MATNR": "000000000000140717"
                }, {
                    "EAN11": "787003003398",
                    "MATNR": "000000000000140718"
                }, {
                    "EAN11": "787003003404",
                    "MATNR": "000000000000140719"
                }, {
                    "EAN11": "787003003411",
                    "MATNR": "000000000000140720"
                }, {
                    "EAN11": "787003003459",
                    "MATNR": "000000000000140722"
                }, {
                    "EAN11": "787003003428",
                    "MATNR": "000000000000140723"
                }, {
                    "EAN11": "10400000002986",
                    "MATNR": "000000000000121022"
                }, {
                    "EAN11": "10400000002993",
                    "MATNR": "000000000000121023"
                }, {
                    "EAN11": "10400000001545",
                    "MATNR": "000000000000110313"
                }, {
                    "EAN11": "10400000004102",
                    "MATNR": "000000000000120957"
                }, {
                    "EAN11": "787003003190",
                    "MATNR": "000000000000140672"
                }, {
                    "EAN11": "787003003213",
                    "MATNR": "000000000000140673"
                }, {
                    "EAN11": "787003003220",
                    "MATNR": "000000000000140674"
                }, {
                    "EAN11": "787003002988",
                    "MATNR": "000000000000140592"
                }, {
                    "EAN11": "10400000003006",
                    "MATNR": "000000000000121024"
                }, {
                    "EAN11": "10400000003013",
                    "MATNR": "000000000000121025"
                }, {
                    "EAN11": "10400000000142",
                    "MATNR": "000000000000121032"
                }, {
                    "EAN11": "10400000002436",
                    "MATNR": "000000000000110403"
                }, {
                    "EAN11": "10400000001897",
                    "MATNR": "000000000000121033"
                }, {
                    "EAN11": "10400000001903",
                    "MATNR": "000000000000121034"
                }, {
                    "EAN11": "787003003312",
                    "MATNR": "000000000000140732"
                }, {
                    "EAN11": "787003003466",
                    "MATNR": "000000000000140733"
                }, {
                    "EAN11": "787003003015",
                    "MATNR": "000000000000140622"
                }, {
                    "EAN11": "787003003022",
                    "MATNR": "000000000000140623"
                }, {
                    "EAN11": "10400000001156",
                    "MATNR": "000000000000110370"
                }, {
                    "EAN11": "10400000001743",
                    "MATNR": "000000000000110413"
                }, {
                    "EAN11": "787003003336",
                    "MATNR": "000000000000140742"
                }, {
                    "EAN11": "787003003350",
                    "MATNR": "000000000000140743"
                }, {
                    "EAN11": "10400000003136",
                    "MATNR": "000000000000121056"
                }, {
                    "EAN11": "10400000003143",
                    "MATNR": "000000000000121057"
                }, {
                    "EAN11": "10400000003150",
                    "MATNR": "000000000000121058"
                }, {
                    "EAN11": "10400000003167",
                    "MATNR": "000000000000121059"
                }, {
                    "EAN11": "10400000003174",
                    "MATNR": "000000000000121060"
                }, {
                    "EAN11": "10400000003181",
                    "MATNR": "000000000000121061"
                }, {
                    "EAN11": "10400000005925",
                    "MATNR": "000000000000110293"
                }, {
                    "EAN11": "10400000005550",
                    "MATNR": "000000000000240060"
                }, {
                    "EAN11": "10400000003693",
                    "MATNR": "000000000000120833"
                }, {
                    "EAN11": "10400000003709",
                    "MATNR": "000000000000120834"
                }, {
                    "EAN11": "10400000003716",
                    "MATNR": "000000000000120835"
                }, {
                    "EAN11": "10400000003723",
                    "MATNR": "000000000000120836"
                }, {
                    "EAN11": "10400000003730",
                    "MATNR": "000000000000120837"
                }, {
                    "EAN11": "10400000005840",
                    "MATNR": "000000000000120838"
                }, {
                    "EAN11": "10400000000104",
                    "MATNR": "000000000000120840"
                }, {
                    "EAN11": "10400000001552",
                    "MATNR": "000000000000110373"
                }, {
                    "EAN11": "10400000001262",
                    "MATNR": "000000000000110374"
                }, {
                    "EAN11": "10400000001279",
                    "MATNR": "000000000000110378"
                }, {
                    "EAN11": "10400000004188",
                    "MATNR": "000000000000110343"
                }, {
                    "EAN11": "10400000005857",
                    "MATNR": "000000000000110344"
                }, {
                    "EAN11": "10400000005864",
                    "MATNR": "000000000000110345"
                }, {
                    "EAN11": "787003003053",
                    "MATNR": "000000000000140642"
                }, {
                    "EAN11": "10400000004232",
                    "MATNR": "000000000000110358"
                }, {
                    "EAN11": "787003003060",
                    "MATNR": "000000000000140662"
                }, {
                    "EAN11": "10400000002092",
                    "MATNR": "000000000000120942"
                }, {
                    "EAN11": "10400000002108",
                    "MATNR": "000000000000120943"
                }, {
                    "EAN11": "787003003121",
                    "MATNR": "000000000000140664"
                }, {
                    "EAN11": "787003003114",
                    "MATNR": "000000000000140665"
                }, {
                    "EAN11": "10400000001866",
                    "MATNR": "000000000000120883"
                }, {
                    "EAN11": "787003003145",
                    "MATNR": "000000000000140666"
                }, {
                    "EAN11": "787003003176",
                    "MATNR": "000000000000140667"
                }, {
                    "EAN11": "787003003169",
                    "MATNR": "000000000000140668"
                }, {
                    "EAN11": "10400000000869",
                    "MATNR": "000000000000121072"
                }, {
                    "EAN11": "10400000004096",
                    "MATNR": "000000000000120940"
                }, {
                    "EAN11": "10400000000722",
                    "MATNR": "000000000000120972"
                }, {
                    "EAN11": "10400000000739",
                    "MATNR": "000000000000120973"
                }, {
                    "EAN11": "787003003435",
                    "MATNR": "000000000000140714"
                }, {
                    "EAN11": "10400000002955",
                    "MATNR": "000000000000121005"
                }, {
                    "EAN11": "10400000002962",
                    "MATNR": "000000000000121007"
                }, {
                    "EAN11": "10400000002979",
                    "MATNR": "000000000000121012"
                }, {
                    "EAN11": "10400000000760",
                    "MATNR": "000000000000121014"
                }, {
                    "EAN11": "10400000000777",
                    "MATNR": "000000000000121015"
                }, {
                    "EAN11": "787003002995",
                    "MATNR": "000000000000140602"
                }, {
                    "EAN11": "10400000003662",
                    "MATNR": "000000000000120807"
                }, {
                    "EAN11": "10400000003679",
                    "MATNR": "000000000000120808"
                }, {
                    "EAN11": "10400000003686",
                    "MATNR": "000000000000120809"
                }, {
                    "EAN11": "10400000000012",
                    "MATNR": "000000000000120810"
                }, {
                    "EAN11": "10400000000029",
                    "MATNR": "000000000000120811"
                }, {
                    "EAN11": "10400000000036",
                    "MATNR": "000000000000120812"
                }, {
                    "EAN11": "10400000000043",
                    "MATNR": "000000000000120813"
                }, {
                    "EAN11": "10400000003860",
                    "MATNR": "000000000000121035"
                }, {
                    "EAN11": "10400000003877",
                    "MATNR": "000000000000121036"
                }, {
                    "EAN11": "10400000003884",
                    "MATNR": "000000000000121037"
                }, {
                    "EAN11": "10400000003891",
                    "MATNR": "000000000000121038"
                }, {
                    "EAN11": "10400000002443",
                    "MATNR": "000000000000110404"
                }, {
                    "EAN11": "10400000002450",
                    "MATNR": "000000000000110405"
                }, {
                    "EAN11": "10400000000784",
                    "MATNR": "000000000000121016"
                }, {
                    "EAN11": "10400000000791",
                    "MATNR": "000000000000121017"
                }, {
                    "EAN11": "10400000003846",
                    "MATNR": "000000000000121026"
                }, {
                    "EAN11": "10400000003853",
                    "MATNR": "000000000000121027"
                }, {
                    "EAN11": "10400000003907",
                    "MATNR": "000000000000121073"
                }, {
                    "EAN11": "10400000000845",
                    "MATNR": "000000000000121042"
                }, {
                    "EAN11": "10400000000852",
                    "MATNR": "000000000000121043"
                }, {
                    "EAN11": "10400000000203",
                    "MATNR": "000000000000120884"
                }, {
                    "EAN11": "10400000000210",
                    "MATNR": "000000000000120885"
                }, {
                    "EAN11": "10400000000227",
                    "MATNR": "000000000000120886"
                }, {
                    "EAN11": "10400000004928",
                    "MATNR": "000000000000121195"
                }, {
                    "EAN11": "10400000004935",
                    "MATNR": "000000000000121196"
                }, {
                    "EAN11": "10400000004942",
                    "MATNR": "000000000000121198"
                }, {
                    "EAN11": "10400000004959",
                    "MATNR": "000000000000121200"
                }, {
                    "EAN11": "10400000004522",
                    "MATNR": "000000000000110483"
                }, {
                    "EAN11": "10400000004966",
                    "MATNR": "000000000000121202"
                }, {
                    "EAN11": "10400000004539",
                    "MATNR": "000000000000110484"
                }, {
                    "EAN11": "10400000004973",
                    "MATNR": "000000000000121203"
                }, {
                    "EAN11": "10400000004546",
                    "MATNR": "000000000000110485"
                }, {
                    "EAN11": "10400000004980",
                    "MATNR": "000000000000121204"
                }, {
                    "EAN11": "10400000004553",
                    "MATNR": "000000000000110486"
                }, {
                    "EAN11": "10400000004560",
                    "MATNR": "000000000000110487"
                }, {
                    "EAN11": "787003003800",
                    "MATNR": "000000000000140772"
                }, {
                    "EAN11": "10400000006731",
                    "MATNR": "000000000000121305"
                }, {
                    "EAN11": "787003004142",
                    "MATNR": "000000000000140834"
                }, {
                    "EAN11": "10400000004997",
                    "MATNR": "000000000000121207"
                }, {
                    "EAN11": "10400000005000",
                    "MATNR": "000000000000121208"
                }, {
                    "EAN11": "10400000005567",
                    "MATNR": "000000000000240100"
                }, {
                    "EAN11": "10400000005574",
                    "MATNR": "000000000000240101"
                }, {
                    "EAN11": "10400000005581",
                    "MATNR": "000000000000240102"
                }, {
                    "EAN11": "10400000004591",
                    "MATNR": "000000000000110493"
                }, {
                    "EAN11": "10400000004607",
                    "MATNR": "000000000000110495"
                }, {
                    "EAN11": "787003003961",
                    "MATNR": "000000000000140822"
                }, {
                    "EAN11": "10400000004577",
                    "MATNR": "000000000000110490"
                }, {
                    "EAN11": "10400000005147",
                    "MATNR": "000000000000121223"
                }, {
                    "EAN11": "10400000005253",
                    "MATNR": "000000000000121247"
                }, {
                    "EAN11": "10400000004621",
                    "MATNR": "000000000000110497"
                }, {
                    "EAN11": "10400000005260",
                    "MATNR": "000000000000121248"
                }, {
                    "EAN11": "10400000005277",
                    "MATNR": "000000000000121249"
                }, {
                    "EAN11": "10400000005284",
                    "MATNR": "000000000000121250"
                }, {
                    "EAN11": "10400000006700",
                    "MATNR": "000000000000121257"
                }, {
                    "EAN11": "10400000006717",
                    "MATNR": "000000000000121261"
                }, {
                    "EAN11": "10400000006656",
                    "MATNR": "000000000000240106"
                }, {
                    "EAN11": "10400000006724",
                    "MATNR": "000000000000121262"
                }, {
                    "EAN11": "10400000005154",
                    "MATNR": "000000000000121232"
                }, {
                    "EAN11": "10400000005789",
                    "MATNR": "000000000000121236"
                }, {
                    "EAN11": "10400000006663",
                    "MATNR": "000000000000240107"
                }, {
                    "EAN11": "10400000006670",
                    "MATNR": "000000000000240109"
                }, {
                    "EAN11": "10400000006694",
                    "MATNR": "000000000000240111"
                }, {
                    "EAN11": "10400000006281",
                    "MATNR": "000000000000121267"
                }, {
                    "EAN11": "10400000001293",
                    "MATNR": "000000000000110473"
                }, {
                    "EAN11": "10400000004515",
                    "MATNR": "000000000000110474"
                }, {
                    "EAN11": "10400000004065",
                    "MATNR": "000000000000110476"
                }, {
                    "EAN11": "10400000006168",
                    "MATNR": "000000000000121146"
                }, {
                    "EAN11": "10400000006175",
                    "MATNR": "000000000000121147"
                }, {
                    "EAN11": "10400000006380",
                    "MATNR": "000000000000121281"
                }, {
                    "EAN11": "10400000006700",
                    "MATNR": "000000000000240120"
                }, {
                    "EAN11": "787003003787",
                    "MATNR": "000000000000140823"
                }, {
                    "EAN11": "10400000006496",
                    "MATNR": "000000000000121296"
                }, {
                    "EAN11": "10400000007677",
                    "MATNR": "000000000000240121"
                }, {
                    "EAN11": "10400000004614",
                    "MATNR": "000000000000110496"
                }, {
                    "EAN11": "10400000005222",
                    "MATNR": "000000000000121244"
                }, {
                    "EAN11": "10400000005239",
                    "MATNR": "000000000000121245"
                }, {
                    "EAN11": "10400000005246",
                    "MATNR": "000000000000121246"
                }, {
                    "EAN11": "10400000006717",
                    "MATNR": "000000000000240127"
                }, {
                    "EAN11": "10400000006748",
                    "MATNR": "000000000000121309"
                }, {
                    "EAN11": "10400000002115",
                    "MATNR": "000000000000121104"
                }, {
                    "EAN11": "10400000004287",
                    "MATNR": "000000000000121108"
                }, {
                    "EAN11": "10400000003433",
                    "MATNR": "000000000000121109"
                }, {
                    "EAN11": "10400000001705",
                    "MATNR": "000000000000121110"
                }, {
                    "EAN11": "10400000001712",
                    "MATNR": "000000000000121129"
                }, {
                    "EAN11": "787003004029",
                    "MATNR": "000000000000140836"
                }, {
                    "EAN11": "10400000001729",
                    "MATNR": "000000000000121130"
                }, {
                    "EAN11": "10400000004423",
                    "MATNR": "000000000000110465"
                }, {
                    "EAN11": "10400000000487",
                    "MATNR": "000000000000121153"
                }, {
                    "EAN11": "10400000004638",
                    "MATNR": "000000000000121154"
                }, {
                    "EAN11": "10400000004645",
                    "MATNR": "000000000000121155"
                }, {
                    "EAN11": "10400000004652",
                    "MATNR": "000000000000121156"
                }, {
                    "EAN11": "10400000004669",
                    "MATNR": "000000000000121157"
                }, {
                    "EAN11": "787003003664",
                    "MATNR": "000000000000140784"
                }, {
                    "EAN11": "10400000004911",
                    "MATNR": "000000000000121193"
                }, {
                    "EAN11": "787003003749",
                    "MATNR": "000000000000140785"
                }, {
                    "EAN11": "787003003923",
                    "MATNR": "000000000000140794"
                }, {
                    "EAN11": "10400000005741",
                    "MATNR": "000000000000121148"
                }, {
                    "EAN11": "10400000005758",
                    "MATNR": "000000000000121149"
                }, {
                    "EAN11": "10400000001651",
                    "MATNR": "000000000000121100"
                }, {
                    "EAN11": "10400000001668",
                    "MATNR": "000000000000121101"
                }, {
                    "EAN11": "10400000004676",
                    "MATNR": "000000000000121158"
                }, {
                    "EAN11": "10400000004683",
                    "MATNR": "000000000000121159"
                }, {
                    "EAN11": "10400000004690",
                    "MATNR": "000000000000121160"
                }, {
                    "EAN11": "10400000004706",
                    "MATNR": "000000000000121161"
                }, {
                    "EAN11": "10400000004713",
                    "MATNR": "000000000000121162"
                }, {
                    "EAN11": "10400000004720",
                    "MATNR": "000000000000121163"
                }, {
                    "EAN11": "10400000004737",
                    "MATNR": "000000000000121164"
                }, {
                    "EAN11": "10400000004744",
                    "MATNR": "000000000000121165"
                }, {
                    "EAN11": "10400000004751",
                    "MATNR": "000000000000121166"
                }, {
                    "EAN11": "10400000004768",
                    "MATNR": "000000000000121167"
                }, {
                    "EAN11": "10400000004775",
                    "MATNR": "000000000000121168"
                }, {
                    "EAN11": "10400000004782",
                    "MATNR": "000000000000121169"
                }, {
                    "EAN11": "10400000005017",
                    "MATNR": "000000000000121210"
                }, {
                    "EAN11": "10400000005024",
                    "MATNR": "000000000000121211"
                }, {
                    "EAN11": "10400000004799",
                    "MATNR": "000000000000121170"
                }, {
                    "EAN11": "10400000004805",
                    "MATNR": "000000000000121171"
                }, {
                    "EAN11": "10400000004812",
                    "MATNR": "000000000000121172"
                }, {
                    "EAN11": "10400000004829",
                    "MATNR": "000000000000121173"
                }, {
                    "EAN11": "10400000004836",
                    "MATNR": "000000000000121174"
                }, {
                    "EAN11": "10400000004843",
                    "MATNR": "000000000000121176"
                }, {
                    "EAN11": "10400000004850",
                    "MATNR": "000000000000121177"
                }, {
                    "EAN11": "10400000004867",
                    "MATNR": "000000000000121178"
                }, {
                    "EAN11": "10400000004874",
                    "MATNR": "000000000000121179"
                }, {
                    "EAN11": "10400000004881",
                    "MATNR": "000000000000121180"
                }, {
                    "EAN11": "10400000004898",
                    "MATNR": "000000000000121181"
                }, {
                    "EAN11": "10400000004904",
                    "MATNR": "000000000000121182"
                }, {
                    "EAN11": "10400000005031",
                    "MATNR": "000000000000121212"
                }, {
                    "EAN11": "10400000005048",
                    "MATNR": "000000000000121213"
                }, {
                    "EAN11": "10400000005055",
                    "MATNR": "000000000000121214"
                }, {
                    "EAN11": "10400000005062",
                    "MATNR": "000000000000121215"
                }, {
                    "EAN11": "10400000005079",
                    "MATNR": "000000000000121216"
                }, {
                    "EAN11": "10400000005086",
                    "MATNR": "000000000000121217"
                }, {
                    "EAN11": "10400000005093",
                    "MATNR": "000000000000121218"
                }, {
                    "EAN11": "10400000005109",
                    "MATNR": "000000000000121219"
                }, {
                    "EAN11": "10400000005116",
                    "MATNR": "000000000000121220"
                }, {
                    "EAN11": "10400000005123",
                    "MATNR": "000000000000121221"
                }, {
                    "EAN11": "787003003862",
                    "MATNR": "000000000000140804"
                }, {
                    "EAN11": "10400000004584",
                    "MATNR": "000000000000110492"
                }, {
                    "EAN11": "10400000005130",
                    "MATNR": "000000000000121222"
                }, {
                    "EAN11": "10400000005765",
                    "MATNR": "000000000000121234"
                }, {
                    "EAN11": "10400000005772",
                    "MATNR": "000000000000121235"
                }, {
                    "EAN11": "10400000006755",
                    "MATNR": "000000000000121310"
                }, {
                    "EAN11": "10400000006724",
                    "MATNR": "000000000000240134"
                }, {
                    "EAN11": "787003003985",
                    "MATNR": "000000000000140835"
                }, {
                    "EAN11": "787003004098",
                    "MATNR": "000000000000140837"
                }, {
                    "EAN11": "787003003992",
                    "MATNR": "000000000000140838"
                }, {
                    "EAN11": "787003004081",
                    "MATNR": "000000000000140839"
                }, {
                    "EAN11": "10400000006502",
                    "MATNR": "000000000000121302"
                }, {
                    "EAN11": "787003003763",
                    "MATNR": "000000000000140803"
                }, {
                    "EAN11": "10400000005161",
                    "MATNR": "000000000000121237"
                }, {
                    "EAN11": "10400000005178",
                    "MATNR": "000000000000121239"
                }, {
                    "EAN11": "10400000005185",
                    "MATNR": "000000000000121240"
                }, {
                    "EAN11": "10400000005192",
                    "MATNR": "000000000000121241"
                }, {
                    "EAN11": "10400000005208",
                    "MATNR": "000000000000121242"
                }, {
                    "EAN11": "10400000005215",
                    "MATNR": "000000000000121243"
                }, {
                    "EAN11": "10400000001675",
                    "MATNR": "000000000000121102"
                }, {
                    "EAN11": "10400000006151",
                    "MATNR": "000000000000121103"
                }, {
                    "EAN11": "10400000006519",
                    "MATNR": "000000000000121112"
                }, {
                    "EAN11": "10400000006526",
                    "MATNR": "000000000000121113"
                }, {
                    "EAN11": "10400000003280",
                    "MATNR": "000000000000121115"
                }, {
                    "EAN11": "10400000003297",
                    "MATNR": "000000000000121116"
                }, {
                    "EAN11": "10400000003303",
                    "MATNR": "000000000000121117"
                }, {
                    "EAN11": "10400000003914",
                    "MATNR": "000000000000121118"
                }, {
                    "EAN11": "10400000003921",
                    "MATNR": "000000000000121119"
                }, {
                    "EAN11": "10400000003938",
                    "MATNR": "000000000000121120"
                }, {
                    "EAN11": "10400000002467",
                    "MATNR": "000000000000110456"
                }, {
                    "EAN11": "10400000005291",
                    "MATNR": "000000000000121251"
                }, {
                    "EAN11": "10400000005307",
                    "MATNR": "000000000000121252"
                }, {
                    "EAN11": "10400000005314",
                    "MATNR": "000000000000121253"
                }, {
                    "EAN11": "10400000005321",
                    "MATNR": "000000000000121254"
                }, {
                    "EAN11": "10400000001682",
                    "MATNR": "000000000000121105"
                }, {
                    "EAN11": "10400000001699",
                    "MATNR": "000000000000121106"
                }, {
                    "EAN11": "10400000002122",
                    "MATNR": "000000000000121107"
                }, {
                    "EAN11": "10400000002474",
                    "MATNR": "000000000000110457"
                }, {
                    "EAN11": "10400000002481",
                    "MATNR": "000000000000110458"
                }, {
                    "EAN11": "10400000005949",
                    "MATNR": "000000000000110459"
                }, {
                    "EAN11": "10400000004324",
                    "MATNR": "000000000000110460"
                }, {
                    "EAN11": "10400000004331",
                    "MATNR": "000000000000110461"
                }, {
                    "EAN11": "10400000004041",
                    "MATNR": "000000000000110462"
                }, {
                    "EAN11": "10400000004430",
                    "MATNR": "000000000000110463"
                }, {
                    "EAN11": "10400000004058",
                    "MATNR": "000000000000110464"
                }, {
                    "EAN11": "10400000000319",
                    "MATNR": "000000000000121122"
                }, {
                    "EAN11": "10400000000326",
                    "MATNR": "000000000000121123"
                }, {
                    "EAN11": "10400000004300",
                    "MATNR": "000000000000121125"
                }, {
                    "EAN11": "10400000006533",
                    "MATNR": "000000000000121127"
                }, {
                    "EAN11": "10400000006632",
                    "MATNR": "000000000000240104"
                }, {
                    "EAN11": "787003003657",
                    "MATNR": "000000000000140782"
                }, {
                    "EAN11": "787003003671",
                    "MATNR": "000000000000140783"
                }, {
                    "EAN11": "787003003565",
                    "MATNR": "000000000000140786"
                }, {
                    "EAN11": "787003003626",
                    "MATNR": "000000000000140787"
                }, {
                    "EAN11": "787003003541",
                    "MATNR": "000000000000140788"
                }, {
                    "EAN11": "787003003701",
                    "MATNR": "000000000000140789"
                }, {
                    "EAN11": "787003003695",
                    "MATNR": "000000000000140790"
                }, {
                    "EAN11": "787003003756",
                    "MATNR": "000000000000140791"
                }, {
                    "EAN11": "787003003930",
                    "MATNR": "000000000000140792"
                }, {
                    "EAN11": "787003003947",
                    "MATNR": "000000000000140793"
                }, {
                    "EAN11": "10400000001286",
                    "MATNR": "000000000000110454"
                }, {
                    "EAN11": "787003002858",
                    "MATNR": "000000000000140762"
                }, {
                    "EAN11": "787003002865",
                    "MATNR": "000000000000140763"
                }, {
                    "EAN11": "787003003534",
                    "MATNR": "000000000000140764"
                }, {
                    "EAN11": "787003003558",
                    "MATNR": "000000000000140765"
                }, {
                    "EAN11": "787003003824",
                    "MATNR": "000000000000140766"
                }, {
                    "EAN11": "787003003831",
                    "MATNR": "000000000000140767"
                }, {
                    "EAN11": "787003003855",
                    "MATNR": "000000000000140768"
                }, {
                    "EAN11": "10400000006649",
                    "MATNR": "000000000000240105"
                }, {
                    "EAN11": "10400000006687",
                    "MATNR": "000000000000240110"
                }, {
                    "EAN11": "10400000004294",
                    "MATNR": "000000000000121124"
                }, {
                    "EAN11": "10400000000418",
                    "MATNR": "000000000000121128"
                }, {
                    "EAN11": "787003003848",
                    "MATNR": "000000000000140769"
                }, {
                    "EAN11": "10400000006359",
                    "MATNR": "000000000000121273"
                }, {
                    "EAN11": "10400000006397",
                    "MATNR": "000000000000121279"
                }, {
                    "EAN11": "10400000006823",
                    "MATNR": "000000000000121284"
                }, {
                    "EAN11": "10400000004416",
                    "MATNR": "000000000000121132"
                }, {
                    "EAN11": "10400000006595",
                    "MATNR": "000000000000121333"
                }, {
                    "EAN11": "10400000006809",
                    "MATNR": "000000000000121346"
                }, {
                    "EAN11": "10400000006786",
                    "MATNR": "000000000000121347"
                }, {
                    "EAN11": "10400000006793",
                    "MATNR": "000000000000121348"
                }, {
                    "EAN11": "10400000006199",
                    "MATNR": "000000000000121349"
                }, {
                    "EAN11": "10400000006182",
                    "MATNR": "000000000000121350"
                }, {
                    "EAN11": "787003004241",
                    "MATNR": "000000000000140852"
                }, {
                    "EAN11": "787003004258",
                    "MATNR": "000000000000140853"
                }, {
                    "EAN11": "787003004265",
                    "MATNR": "000000000000140854"
                }, {
                    "EAN11": "787003004203",
                    "MATNR": "000000000000140857"
                }, {
                    "EAN11": "787003004227",
                    "MATNR": "000000000000140858"
                }, {
                    "EAN11": "787003004234",
                    "MATNR": "000000000000140859"
                }, {
                    "EAN11": "787003004326",
                    "MATNR": "000000000000140860"
                }, {
                    "EAN11": "10400000006601",
                    "MATNR": "000000000000121334"
                }, {
                    "EAN11": "10400000006250",
                    "MATNR": "000000000000121335"
                }, {
                    "EAN11": "10400000006243",
                    "MATNR": "000000000000121336"
                }, {
                    "EAN11": "10400000006229",
                    "MATNR": "000000000000121340"
                }, {
                    "EAN11": "10400000006588",
                    "MATNR": "000000000000110553"
                }, {
                    "EAN11": "10400000006847",
                    "MATNR": "000000000000121408"
                }, {
                    "EAN11": "10400000006915",
                    "MATNR": "000000000000121409"
                }, {
                    "EAN11": "10400000006922",
                    "MATNR": "000000000000121411"
                }, {
                    "EAN11": "10400000006939",
                    "MATNR": "000000000000121412"
                }, {
                    "EAN11": "10400000006236",
                    "MATNR": "000000000000121413"
                }, {
                    "EAN11": "10400000006205",
                    "MATNR": "000000000000121422"
                }, {
                    "EAN11": "10400000006212",
                    "MATNR": "000000000000121423"
                }, {
                    "EAN11": "10400000006366",
                    "MATNR": "000000000000121425"
                }, {
                    "EAN11": "10400000006373",
                    "MATNR": "000000000000121426"
                }, {
                    "EAN11": "10400000006816",
                    "MATNR": "000000000000121427"
                }, {
                    "EAN11": "10400000006762",
                    "MATNR": "000000000000121428"
                }, {
                    "EAN11": "10400000006632",
                    "MATNR": "000000000000121417"
                }, {
                    "EAN11": "787003004319",
                    "MATNR": "000000000000140862"
                }, {
                    "EAN11": "10400000006687",
                    "MATNR": "000000000000121382"
                }, {
                    "EAN11": "10400000006540",
                    "MATNR": "000000000000121431"
                }, {
                    "EAN11": "10400000006663",
                    "MATNR": "000000000000121434"
                }, {
                    "EAN11": "787003004333",
                    "MATNR": "000000000000140863"
                }, {
                    "EAN11": "10400000006342",
                    "MATNR": "000000000000121402"
                }, {
                    "EAN11": "10400000006571",
                    "MATNR": "000000000000110560"
                }, {
                    "EAN11": "10400000006625",
                    "MATNR": "000000000000121436"
                }, {
                    "EAN11": "10400000006618",
                    "MATNR": "000000000000121437"
                }, {
                    "EAN11": "10400000006779",
                    "MATNR": "000000000000121441"
                }, {
                    "EAN11": "10400000006564",
                    "MATNR": "000000000000121443"
                }, {
                    "EAN11": "787003004128",
                    "MATNR": "000000000000140864"
                }, {
                    "EAN11": "10400000006670",
                    "MATNR": "000000000000121397"
                }, {
                    "EAN11": "10400000006656",
                    "MATNR": "000000000000121388"
                }, {
                    "EAN11": "10400000006694",
                    "MATNR": "000000000000121393"
                }, {
                    "EAN11": "10400000006557",
                    "MATNR": "000000000000121321"
                }, {
                    "EAN11": "10400000006267",
                    "MATNR": "000000000000121394"
                }, {
                    "EAN11": "10400000006274",
                    "MATNR": "000000000000121395"
                }, {
                    "EAN11": "787003004401",
                    "MATNR": "000000000000140892"
                }, {
                    "EAN11": "787003004104",
                    "MATNR": "000000000000140908"
                }, {
                    "EAN11": "787003004791",
                    "MATNR": "000000000000140910"
                }, {
                    "EAN11": "787003004807",
                    "MATNR": "000000000000140911"
                }, {
                    "EAN11": "10400000005505",
                    "MATNR": "000000000000240150"
                }, {
                    "EAN11": "10400000006908",
                    "MATNR": "000000000000121457"
                }, {
                    "EAN11": "10400000007196",
                    "MATNR": "000000000000240151"
                }, {
                    "EAN11": "10400000006946",
                    "MATNR": "000000000000121462"
                }, {
                    "EAN11": "787003004395",
                    "MATNR": "000000000000140884"
                }, {
                    "EAN11": "787003004371",
                    "MATNR": "000000000000140885"
                }, {
                    "EAN11": "787003004357",
                    "MATNR": "000000000000140872"
                }, {
                    "EAN11": "787003004364",
                    "MATNR": "000000000000140873"
                }, {
                    "EAN11": "787003004586",
                    "MATNR": "000000000000140893"
                }, {
                    "EAN11": "787003004593",
                    "MATNR": "000000000000140894"
                }, {
                    "EAN11": "20787003016088",
                    "MATNR": "000000000000140896"
                }, {
                    "EAN11": "787003004517",
                    "MATNR": "000000000000140897"
                }, {
                    "EAN11": "787003004524",
                    "MATNR": "000000000000140898"
                }, {
                    "EAN11": "787003004531",
                    "MATNR": "000000000000140899"
                }, {
                    "EAN11": "787003004548",
                    "MATNR": "000000000000140900"
                }, {
                    "EAN11": "787003004555",
                    "MATNR": "000000000000140901"
                }, {
                    "EAN11": "787003004562",
                    "MATNR": "000000000000140902"
                }, {
                    "EAN11": "10400000007691",
                    "MATNR": "000000000000121566"
                }, {
                    "EAN11": "787003004470",
                    "MATNR": "000000000000140903"
                }, {
                    "EAN11": "787003004487",
                    "MATNR": "000000000000140904"
                }, {
                    "EAN11": "787003004494",
                    "MATNR": "000000000000140905"
                }, {
                    "EAN11": "787003004609",
                    "MATNR": "000000000000140906"
                }, {
                    "EAN11": "787003004616",
                    "MATNR": "000000000000140907"
                }, {
                    "EAN11": "10400000007707",
                    "MATNR": "000000000000110612"
                }, {
                    "EAN11": "10400000007684",
                    "MATNR": "000000000000121575"
                }, {
                    "EAN11": "10787003180010",
                    "MATNR": "000000000000140912"
                }, {
                    "EAN11": "10787003180027",
                    "MATNR": "000000000000140913"
                }, {
                    "EAN11": "10787003000707",
                    "MATNR": "000000000000140915"
                }, {
                    "EAN11": "10787003016081",
                    "MATNR": "000000000000140886"
                }, {
                    "EAN11": "10400000007073",
                    "MATNR": "000000000000240163"
                }, {
                    "EAN11": "10400000007097",
                    "MATNR": "000000000000240165"
                }, {
                    "EAN11": "10787003115029",
                    "MATNR": "000000000000140887"
                }, {
                    "EAN11": "10787003016074",
                    "MATNR": "000000000000140888"
                }, {
                    "EAN11": "10787003016067",
                    "MATNR": "000000000000140889"
                }, {
                    "EAN11": "10787003000066",
                    "MATNR": "000000000000140890"
                }, {
                    "EAN11": "10787003016098",
                    "MATNR": "000000000000140891"
                }, {
                    "EAN11": "10400000006885",
                    "MATNR": "000000000000110569"
                }, {
                    "EAN11": "787003004388",
                    "MATNR": "000000000000140882"
                }],
                unidadesList: [{
                        "und": "KG",
                        "id": "34"
                    },
                    {
                        "und": "CS",
                        "id": "99"
                    },
                    {
                        "und": "LB",
                        "id": "36"
                    },
                    {
                        "und": "PAC",
                        "id": "99"
                    },
                    {
                        "und": "ST",
                        "id": "59"
                    },
                ],
                factura: {
                    "extension": {
                        "docuEntrega": null,
                        "placaVehiculo": null,
                        "observaciones": null,
                        "nombRecibe": null,
                        "nombEntrega": null,
                        "docuRecibe": null
                    },
                    "receptor": {
                        "descActividad": "Venta en supermercados",
                        "codActividad": "47111",
                        "correo": "dte@superselectos.com.sv",
                        "nit": "06141101690011",
                        "direccion": {
                            "complemento": "Pje San Jose #11-3 Puerto de La Libertad  La Libertad  ",
                            "municipio": "09",
                            "departamento": "05"
                        },
                        "nombreComercial": null,
                        "telefono": "22673708",
                        "nombre": "CALLEJA, S.A. DE C.V.",
                        "nrc": "1937"
                    },
                    "identificacion": {
                        "codigoGeneracion": "2393A95E-9688-4D9F-8CF6-9A0DACE63E0D",
                        "tipoContingencia": null,
                        "numeroControl": "DTE-03-S003P001-000000000003253",
                        "tipoOperacion": 1,
                        "ambiente": "01",
                        "fecEmi": "2023-10-10",
                        "tipoModelo": 1,
                        "tipoDte": "03",
                        "version": 3,
                        "tipoMoneda": "USD",
                        "motivoContin": null,
                        "horEmi": "00:31:49"
                    },
                    "resumen": {
                        "totalNoSuj": 0,
                        "ivaPerci1": 0,
                        "descuNoSuj": 0,
                        "totalLetras": "NOVECIENTOS TREINTA Y OCHO con 93",
                        "ivaRete1": 0,
                        "subTotalVentas": 830.9,
                        "subTotal": 830.9,
                        "reteRenta": 0,
                        "tributos": [{
                            "descripcion": "Impuesto al Valor Agregado 13%",
                            "codigo": "20",
                            "valor": 108.03
                        }],
                        "pagos": [{
                            "codigo": "05",
                            "periodo": 15,
                            "plazo": "01",
                            "montoPago": 938.93,
                            "referencia": null
                        }],
                        "descuExenta": 0,
                        "totalDescu": 0,
                        "numPagoElectronico": null,
                        "descuGravada": 0,
                        "porcentajeDescuento": 0,
                        "totalGravada": 830.9,
                        "montoTotalOperacion": 938.93,
                        "totalNoGravado": 0,
                        "saldoFavor": 0,
                        "totalExenta": 0,
                        "totalPagar": 938.93,
                        "condicionOperacion": 2
                    },
                    "cuerpoDocumento": [{
                        "descripcion": "YOGURT LIQUIDO FRESA  200 ML",
                        "montoDescu": 0,
                        "codigo": "140225",
                        "ventaGravada": 24.48,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 1,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 48,
                        "precioUni": 0.51
                    }, {
                        "descripcion": "YOGURT LIQUIDO BANANO FRESA 200 ML",
                        "montoDescu": 0,
                        "codigo": "140226",
                        "ventaGravada": 18.36,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 2,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 36,
                        "precioUni": 0.51
                    }, {
                        "descripcion": "YOGURT LIQUIDO MELOCOTON 200 ML",
                        "montoDescu": 0,
                        "codigo": "140228",
                        "ventaGravada": 18.36,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 3,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 36,
                        "precioUni": 0.51
                    }, {
                        "descripcion": "YOGURT LIQUIDO MANZANA 200 ML",
                        "montoDescu": 0,
                        "codigo": "140230",
                        "ventaGravada": 12.24,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 4,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 24,
                        "precioUni": 0.51
                    }, {
                        "descripcion": "YOGURT LIQUIDO ALOE VERA 200 ML",
                        "montoDescu": 0,
                        "codigo": "140231",
                        "ventaGravada": 18.36,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 5,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 36,
                        "precioUni": 0.51
                    }, {
                        "descripcion": "YOGURT LIQUIDO 4 PACK 200 ML",
                        "montoDescu": 0,
                        "codigo": "140232",
                        "ventaGravada": 46.25,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 6,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 99,
                        "numeroDocumento": null,
                        "cantidad": 25,
                        "precioUni": 1.85
                    }, {
                        "descripcion": "YOGURT LIQUIDO FRESA LIGHT 200 ML",
                        "montoDescu": 0,
                        "codigo": "140233",
                        "ventaGravada": 6.12,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 7,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 12,
                        "precioUni": 0.51
                    }, {
                        "descripcion": "YOGURT LIQ BANANO FRESA LIGHT 200ML",
                        "montoDescu": 0,
                        "codigo": "140234",
                        "ventaGravada": 6.12,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 8,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 12,
                        "precioUni": 0.51
                    }, {
                        "descripcion": "YOGURT LIQ MELOCOTON LIGHT 200 ML",
                        "montoDescu": 0,
                        "codigo": "140235",
                        "ventaGravada": 6.12,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 9,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 12,
                        "precioUni": 0.51
                    }, {
                        "descripcion": "YOGURT LIQUIDO FRESA 750 GR",
                        "montoDescu": 0,
                        "codigo": "140236",
                        "ventaGravada": 17.52,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 10,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 12,
                        "precioUni": 1.46
                    }, {
                        "descripcion": "YOGURT LIQUIDO PIÑA COLADA 750 GR",
                        "montoDescu": 0,
                        "codigo": "140238",
                        "ventaGravada": 8.76,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 11,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 6,
                        "precioUni": 1.46
                    }, {
                        "descripcion": "YOGURT LIQUIDO BANANO FRESA LIGHT 750 GR",
                        "montoDescu": 0,
                        "codigo": "140241",
                        "ventaGravada": 8.76,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 12,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 6,
                        "precioUni": 1.46
                    }, {
                        "descripcion": "YOGURT YESCOOL UVA PACK 25 UND",
                        "montoDescu": 0,
                        "codigo": "140446",
                        "ventaGravada": 4.75,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 13,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 99,
                        "numeroDocumento": null,
                        "cantidad": 1,
                        "precioUni": 4.75
                    }, {
                        "descripcion": "YOGURT YESCOOL FRESA PACK 6 UND",
                        "montoDescu": 0,
                        "codigo": "140448",
                        "ventaGravada": 54.05,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 14,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 99,
                        "numeroDocumento": null,
                        "cantidad": 47,
                        "precioUni": 1.15
                    }, {
                        "descripcion": "YOGURT YESCOOL BANANO F PACK 6 UND",
                        "montoDescu": 0,
                        "codigo": "140449",
                        "ventaGravada": 40.25,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 15,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 99,
                        "numeroDocumento": null,
                        "cantidad": 35,
                        "precioUni": 1.15
                    }, {
                        "descripcion": "YOGURT YESCOOL UVA PACK 6 UND",
                        "montoDescu": 0,
                        "codigo": "140450",
                        "ventaGravada": 40.25,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 16,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 99,
                        "numeroDocumento": null,
                        "cantidad": 35,
                        "precioUni": 1.15
                    }, {
                        "descripcion": "YOG LIQ VITALITE ARANDANO ACAI 212g",
                        "montoDescu": 0,
                        "codigo": "140250",
                        "ventaGravada": 6.96,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 17,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 12,
                        "precioUni": 0.58
                    }, {
                        "descripcion": "YOG LIQ VITALITE PAPAYA 212g",
                        "montoDescu": 0,
                        "codigo": "140252",
                        "ventaGravada": 6.96,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 18,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 12,
                        "precioUni": 0.58
                    }, {
                        "descripcion": "YOG LIQ VITALITE CIRUELA CHIA CANELA212g",
                        "montoDescu": 0,
                        "codigo": "150031",
                        "ventaGravada": 6.96,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 19,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 12,
                        "precioUni": 0.58
                    }, {
                        "descripcion": "YOGURT 4PACK KIDS",
                        "montoDescu": 0,
                        "codigo": "140260",
                        "ventaGravada": 20.25,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 20,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 99,
                        "numeroDocumento": null,
                        "cantidad": 15,
                        "precioUni": 1.35
                    }, {
                        "descripcion": "YOGURT BANANO FRESA  125 GR",
                        "montoDescu": 0,
                        "codigo": "140262",
                        "ventaGravada": 5.4,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 21,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 12,
                        "precioUni": 0.45
                    }, {
                        "descripcion": "YOGURT VAINILLA  125 GR",
                        "montoDescu": 0,
                        "codigo": "140266",
                        "ventaGravada": 5.4,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 22,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 12,
                        "precioUni": 0.45
                    }, {
                        "descripcion": "YOGURT 4PACK LIGHT 125 GR",
                        "montoDescu": 0,
                        "codigo": "140270",
                        "ventaGravada": 3.38,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 23,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 99,
                        "numeroDocumento": null,
                        "cantidad": 2,
                        "precioUni": 1.69
                    }, {
                        "descripcion": "YOGURT FRUTA FONDO FRESA 125 GR",
                        "montoDescu": 0,
                        "codigo": "140273",
                        "ventaGravada": 5.4,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 24,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 12,
                        "precioUni": 0.45
                    }, {
                        "descripcion": "YOGURT FRUTA FONDO MELOCOTON 125 GR",
                        "montoDescu": 0,
                        "codigo": "140274",
                        "ventaGravada": 5.4,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 25,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 12,
                        "precioUni": 0.45
                    }, {
                        "descripcion": "YOGURT NATURAL 1 KG",
                        "montoDescu": 0,
                        "codigo": "140280",
                        "ventaGravada": 19.68,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 26,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 8,
                        "precioUni": 2.46
                    }, {
                        "descripcion": "YOGURT BANANO FRESA 1 KG",
                        "montoDescu": 0,
                        "codigo": "140281",
                        "ventaGravada": 9.84,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 27,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 4,
                        "precioUni": 2.46
                    }, {
                        "descripcion": "YOGURT FRESA LIGHT 1 KG",
                        "montoDescu": 0,
                        "codigo": "140282",
                        "ventaGravada": 9.84,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 28,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 4,
                        "precioUni": 2.46
                    }, {
                        "descripcion": "YOGURT TUTTI FRUTI LIGHT 1 KG",
                        "montoDescu": 0,
                        "codigo": "140283",
                        "ventaGravada": 9.84,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 29,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 4,
                        "precioUni": 2.46
                    }, {
                        "descripcion": "BOLSA DE Q. MOZZARELLA RALLADO 200GRS",
                        "montoDescu": 0,
                        "codigo": "140296",
                        "ventaGravada": 59.5,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 30,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 25,
                        "precioUni": 2.38
                    }, {
                        "descripcion": "MOZZARELLA REBANADO 200 GRS",
                        "montoDescu": 0,
                        "codigo": "140302",
                        "ventaGravada": 16.9,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 31,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 10,
                        "precioUni": 1.69
                    }, {
                        "descripcion": "QUESO LAC AMERICANO BL 12 REB/180 G",
                        "montoDescu": 0,
                        "codigo": "140890",
                        "ventaGravada": 14.6,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 32,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 10,
                        "precioUni": 1.46
                    }, {
                        "descripcion": "QUESO LAC AMERICANO BL 16 REB/240 G",
                        "montoDescu": 0,
                        "codigo": "140891",
                        "ventaGravada": 18.1,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 33,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 10,
                        "precioUni": 1.81
                    }, {
                        "descripcion": "QUESO CREMA 230 GR",
                        "montoDescu": 0,
                        "codigo": "140357",
                        "ventaGravada": 47.16,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 34,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 36,
                        "precioUni": 1.31
                    }, {
                        "descripcion": "QUESO CREMA 125 GR",
                        "montoDescu": 0,
                        "codigo": "140358",
                        "ventaGravada": 9.24,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 35,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 12,
                        "precioUni": 0.77
                    }, {
                        "descripcion": "DIP CHILE 230 GRS",
                        "montoDescu": 0,
                        "codigo": "140365",
                        "ventaGravada": 16.2,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 36,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 12,
                        "precioUni": 1.35
                    }, {
                        "descripcion": "YOGURT LIQUIDO ALOE VERA 750 GR",
                        "montoDescu": 0,
                        "codigo": "140589",
                        "ventaGravada": 8.76,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 37,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 6,
                        "precioUni": 1.46
                    }, {
                        "descripcion": "YOGURT YESCOOL MANZANA PACK 6 UND",
                        "montoDescu": 0,
                        "codigo": "140763",
                        "ventaGravada": 1.15,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 38,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 99,
                        "numeroDocumento": null,
                        "cantidad": 1,
                        "precioUni": 1.15
                    }, {
                        "descripcion": "YOGURT LIQUIDO 8 PACK SAFARI FRESA MANZA",
                        "montoDescu": 0,
                        "codigo": "140662",
                        "ventaGravada": 36,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 39,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 99,
                        "numeroDocumento": null,
                        "cantidad": 15,
                        "precioUni": 2.4
                    }, {
                        "descripcion": "YOGURT YESCOOL GALLETA FRESA PACK 6 UND",
                        "montoDescu": 0,
                        "codigo": "140667",
                        "ventaGravada": 28.75,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 40,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 99,
                        "numeroDocumento": null,
                        "cantidad": 25,
                        "precioUni": 1.15
                    }, {
                        "descripcion": "YOGURT LIQUIDO 8 PACK 200 ML TEMPORADA",
                        "montoDescu": 0,
                        "codigo": "140458",
                        "ventaGravada": 35.4,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 41,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 99,
                        "numeroDocumento": null,
                        "cantidad": 10,
                        "precioUni": 3.54
                    }, {
                        "descripcion": "YOG GRIEGO LIQ. FRESA SIN AZUCAR 200 ML",
                        "montoDescu": 0,
                        "codigo": "140732",
                        "ventaGravada": 8.88,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 42,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 12,
                        "precioUni": 0.74
                    }, {
                        "descripcion": "YOGURT YESCOOL MELOCOTON PACK 6 UND",
                        "montoDescu": 0,
                        "codigo": "140765",
                        "ventaGravada": 28.75,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 43,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 99,
                        "numeroDocumento": null,
                        "cantidad": 25,
                        "precioUni": 1.15
                    }, {
                        "descripcion": "YOGURT YESCOOL KIWI SANDIA PACK 6 UND",
                        "montoDescu": 0,
                        "codigo": "140786",
                        "ventaGravada": 40.25,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 44,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 99,
                        "numeroDocumento": null,
                        "cantidad": 35,
                        "precioUni": 1.15
                    }, {
                        "descripcion": "YOGURT GRIEGO CREMOSO NATURAL 1 KG",
                        "montoDescu": 0,
                        "codigo": "140823",
                        "ventaGravada": 15.2,
                        "ventaNoSuj": 0,
                        "ventaExenta": 0,
                        "tributos": ["20"],
                        "numItem": 45,
                        "noGravado": 0,
                        "psv": 0,
                        "tipoItem": 1,
                        "codTributo": null,
                        "uniMedida": 59,
                        "numeroDocumento": null,
                        "cantidad": 4,
                        "precioUni": 3.8
                    }],
                    "otrosDocumentos": null,
                    "ventaTercero": null,
                    "apendice": null,
                    "documentoRelacionado": null,
                    "emisor": {
                        "descActividad": "Fabricación de productos lácteos excepto sorbetes y quesos",
                        "tipoEstablecimiento": "01",
                        "direccion": {
                            "complemento": "Siemens #1, Parque Industrial Santa Elen",
                            "municipio": "14",
                            "departamento": "06"
                        },
                        "codEstable": null,
                        "codPuntoVenta": null,
                        "nombre": "-",
                        "codActividad": "10501",
                        "codEstableMH": null,
                        "correo": "comunicacion@yes.com.sv",
                        "nit": "-",
                        "nombreComercial": "-",
                        "telefono": "(503) 2248-6600",
                        "nrc": "1619",
                        "codPuntoVentaMH": null
                    },
                    "firmaElectronica": "eyJhbGciOiJSUzUxMiJ9.ewogICJpZGVudGlmaWNhY2lvbiIgOiB7CiAgICAidmVyc2lvbiIgOiAzLAogICAgImFtYmllbnRlIiA6ICIwMSIsCiAgICAidGlwb0R0ZSIgOiAiMDMiLAogICAgIm51bWVyb0NvbnRyb2wiIDogIkRURS0wMy1TMDAzUDAwMS0wMDAwMDAwMDAwMDMyNTMiLAogICAgImNvZGlnb0dlbmVyYWNpb24iIDogIjIzOTNBOTVFLTk2ODgtNEQ5Ri04Q0Y2LTlBMERBQ0U2M0UwRCIsCiAgICAidGlwb01vZGVsbyIgOiAxLAogICAgInRpcG9PcGVyYWNpb24iIDogMSwKICAgICJ0aXBvQ29udGluZ2VuY2lhIiA6IG51bGwsCiAgICAibW90aXZvQ29udGluIiA6IG51bGwsCiAgICAiZmVjRW1pIiA6ICIyMDIzLTEwLTEwIiwKICAgICJob3JFbWkiIDogIjAwOjMxOjQ5IiwKICAgICJ0aXBvTW9uZWRhIiA6ICJVU0QiCiAgfSwKICAiZG9jdW1lbnRvUmVsYWNpb25hZG8iIDogbnVsbCwKICAiZW1pc29yIiA6IHsKICAgICJuaXQiIDogIjA2MTQwOTAyODQwMDI0IiwKICAgICJucmMiIDogIjE2MTkiLAogICAgIm5vbWJyZSIgOiAiTMOhY3Rlb3MgZGVsIENvcnJhbCwgUy5BLiBkZSBDLlYuIiwKICAgICJjb2RBY3RpdmlkYWQiIDogIjEwNTAxIiwKICAgICJkZXNjQWN0aXZpZGFkIiA6ICJGYWJyaWNhY2nDs24gZGUgcHJvZHVjdG9zIGzDoWN0ZW9zIGV4Y2VwdG8gc29yYmV0ZXMgeSBxdWVzb3MiLAogICAgIm5vbWJyZUNvbWVyY2lhbCIgOiAiTEFDVE9MQUMiLAogICAgInRpcG9Fc3RhYmxlY2ltaWVudG8iIDogIjAxIiwKICAgICJkaXJlY2Npb24iIDogewogICAgICAiZGVwYXJ0YW1lbnRvIiA6ICIwNiIsCiAgICAgICJtdW5pY2lwaW8iIDogIjE0IiwKICAgICAgImNvbXBsZW1lbnRvIiA6ICJTaWVtZW5zICMxLCBQYXJxdWUgSW5kdXN0cmlhbCBTYW50YSBFbGVuIgogICAgfSwKICAgICJ0ZWxlZm9ubyIgOiAiKDUwMykgMjI0OC02NjAwIiwKICAgICJjb3JyZW8iIDogImNvbXVuaWNhY2lvbkB5ZXMuY29tLnN2IiwKICAgICJjb2RFc3RhYmxlTUgiIDogbnVsbCwKICAgICJjb2RFc3RhYmxlIiA6IG51bGwsCiAgICAiY29kUHVudG9WZW50YU1IIiA6IG51bGwsCiAgICAiY29kUHVudG9WZW50YSIgOiBudWxsCiAgfSwKICAicmVjZXB0b3IiIDogewogICAgIm5pdCIgOiAiMDYxNDExMDE2OTAwMTEiLAogICAgIm5yYyIgOiAiMTkzNyIsCiAgICAibm9tYnJlIiA6ICJDQUxMRUpBLCBTLkEuIERFIEMuVi4iLAogICAgImNvZEFjdGl2aWRhZCIgOiAiNDcxMTEiLAogICAgImRlc2NBY3RpdmlkYWQiIDogIlZlbnRhIGVuIHN1cGVybWVyY2Fkb3MiLAogICAgIm5vbWJyZUNvbWVyY2lhbCIgOiBudWxsLAogICAgImRpcmVjY2lvbiIgOiB7CiAgICAgICJkZXBhcnRhbWVudG8iIDogIjA1IiwKICAgICAgIm11bmljaXBpbyIgOiAiMDkiLAogICAgICAiY29tcGxlbWVudG8iIDogIlBqZSBTYW4gSm9zZSAjMTEtMyBQdWVydG8gZGUgTGEgTGliZXJ0YWQgIExhIExpYmVydGFkICAiCiAgICB9LAogICAgInRlbGVmb25vIiA6ICIyMjY3MzcwOCIsCiAgICAiY29ycmVvIiA6ICJkdGVAc3VwZXJzZWxlY3Rvcy5jb20uc3YiCiAgfSwKICAib3Ryb3NEb2N1bWVudG9zIiA6IG51bGwsCiAgInZlbnRhVGVyY2VybyIgOiBudWxsLAogICJjdWVycG9Eb2N1bWVudG8iIDogWyB7CiAgICAibnVtSXRlbSIgOiAxLAogICAgInRpcG9JdGVtIiA6IDEsCiAgICAibnVtZXJvRG9jdW1lbnRvIiA6IG51bGwsCiAgICAiY2FudGlkYWQiIDogNDguMCwKICAgICJjb2RpZ28iIDogIjE0MDIyNSIsCiAgICAiY29kVHJpYnV0byIgOiBudWxsLAogICAgInVuaU1lZGlkYSIgOiA1OSwKICAgICJkZXNjcmlwY2lvbiIgOiAiWU9HVVJUIExJUVVJRE8gRlJFU0EgIDIwMCBNTCIsCiAgICAicHJlY2lvVW5pIiA6IDAuNTEsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiAyNC40OCwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAyLAogICAgInRpcG9JdGVtIiA6IDEsCiAgICAibnVtZXJvRG9jdW1lbnRvIiA6IG51bGwsCiAgICAiY2FudGlkYWQiIDogMzYuMCwKICAgICJjb2RpZ28iIDogIjE0MDIyNiIsCiAgICAiY29kVHJpYnV0byIgOiBudWxsLAogICAgInVuaU1lZGlkYSIgOiA1OSwKICAgICJkZXNjcmlwY2lvbiIgOiAiWU9HVVJUIExJUVVJRE8gQkFOQU5PIEZSRVNBIDIwMCBNTCIsCiAgICAicHJlY2lvVW5pIiA6IDAuNTEsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiAxOC4zNiwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAzLAogICAgInRpcG9JdGVtIiA6IDEsCiAgICAibnVtZXJvRG9jdW1lbnRvIiA6IG51bGwsCiAgICAiY2FudGlkYWQiIDogMzYuMCwKICAgICJjb2RpZ28iIDogIjE0MDIyOCIsCiAgICAiY29kVHJpYnV0byIgOiBudWxsLAogICAgInVuaU1lZGlkYSIgOiA1OSwKICAgICJkZXNjcmlwY2lvbiIgOiAiWU9HVVJUIExJUVVJRE8gTUVMT0NPVE9OIDIwMCBNTCIsCiAgICAicHJlY2lvVW5pIiA6IDAuNTEsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiAxOC4zNiwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiA0LAogICAgInRpcG9JdGVtIiA6IDEsCiAgICAibnVtZXJvRG9jdW1lbnRvIiA6IG51bGwsCiAgICAiY2FudGlkYWQiIDogMjQuMCwKICAgICJjb2RpZ28iIDogIjE0MDIzMCIsCiAgICAiY29kVHJpYnV0byIgOiBudWxsLAogICAgInVuaU1lZGlkYSIgOiA1OSwKICAgICJkZXNjcmlwY2lvbiIgOiAiWU9HVVJUIExJUVVJRE8gTUFOWkFOQSAyMDAgTUwiLAogICAgInByZWNpb1VuaSIgOiAwLjUxLAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogMTIuMjQsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogNSwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDM2LjAsCiAgICAiY29kaWdvIiA6ICIxNDAyMzEiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogNTksCiAgICAiZGVzY3JpcGNpb24iIDogIllPR1VSVCBMSVFVSURPIEFMT0UgVkVSQSAyMDAgTUwiLAogICAgInByZWNpb1VuaSIgOiAwLjUxLAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogMTguMzYsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogNiwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDI1LjAsCiAgICAiY29kaWdvIiA6ICIxNDAyMzIiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogOTksCiAgICAiZGVzY3JpcGNpb24iIDogIllPR1VSVCBMSVFVSURPIDQgUEFDSyAyMDAgTUwiLAogICAgInByZWNpb1VuaSIgOiAxLjg1LAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogNDYuMjUsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogNywKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDEyLjAsCiAgICAiY29kaWdvIiA6ICIxNDAyMzMiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogNTksCiAgICAiZGVzY3JpcGNpb24iIDogIllPR1VSVCBMSVFVSURPIEZSRVNBIExJR0hUIDIwMCBNTCIsCiAgICAicHJlY2lvVW5pIiA6IDAuNTEsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiA2LjEyLAogICAgInRyaWJ1dG9zIiA6IFsgIjIwIiBdLAogICAgInBzdiIgOiAwLjAsCiAgICAibm9HcmF2YWRvIiA6IDAuMAogIH0sIHsKICAgICJudW1JdGVtIiA6IDgsCiAgICAidGlwb0l0ZW0iIDogMSwKICAgICJudW1lcm9Eb2N1bWVudG8iIDogbnVsbCwKICAgICJjYW50aWRhZCIgOiAxMi4wLAogICAgImNvZGlnbyIgOiAiMTQwMjM0IiwKICAgICJjb2RUcmlidXRvIiA6IG51bGwsCiAgICAidW5pTWVkaWRhIiA6IDU5LAogICAgImRlc2NyaXBjaW9uIiA6ICJZT0dVUlQgTElRIEJBTkFOTyBGUkVTQSBMSUdIVCAyMDBNTCIsCiAgICAicHJlY2lvVW5pIiA6IDAuNTEsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiA2LjEyLAogICAgInRyaWJ1dG9zIiA6IFsgIjIwIiBdLAogICAgInBzdiIgOiAwLjAsCiAgICAibm9HcmF2YWRvIiA6IDAuMAogIH0sIHsKICAgICJudW1JdGVtIiA6IDksCiAgICAidGlwb0l0ZW0iIDogMSwKICAgICJudW1lcm9Eb2N1bWVudG8iIDogbnVsbCwKICAgICJjYW50aWRhZCIgOiAxMi4wLAogICAgImNvZGlnbyIgOiAiMTQwMjM1IiwKICAgICJjb2RUcmlidXRvIiA6IG51bGwsCiAgICAidW5pTWVkaWRhIiA6IDU5LAogICAgImRlc2NyaXBjaW9uIiA6ICJZT0dVUlQgTElRIE1FTE9DT1RPTiBMSUdIVCAyMDAgTUwiLAogICAgInByZWNpb1VuaSIgOiAwLjUxLAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogNi4xMiwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAxMCwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDEyLjAsCiAgICAiY29kaWdvIiA6ICIxNDAyMzYiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogNTksCiAgICAiZGVzY3JpcGNpb24iIDogIllPR1VSVCBMSVFVSURPIEZSRVNBIDc1MCBHUiIsCiAgICAicHJlY2lvVW5pIiA6IDEuNDYsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiAxNy41MiwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAxMSwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDYuMCwKICAgICJjb2RpZ28iIDogIjE0MDIzOCIsCiAgICAiY29kVHJpYnV0byIgOiBudWxsLAogICAgInVuaU1lZGlkYSIgOiA1OSwKICAgICJkZXNjcmlwY2lvbiIgOiAiWU9HVVJUIExJUVVJRE8gUEnDkUEgQ09MQURBIDc1MCBHUiIsCiAgICAicHJlY2lvVW5pIiA6IDEuNDYsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiA4Ljc2LAogICAgInRyaWJ1dG9zIiA6IFsgIjIwIiBdLAogICAgInBzdiIgOiAwLjAsCiAgICAibm9HcmF2YWRvIiA6IDAuMAogIH0sIHsKICAgICJudW1JdGVtIiA6IDEyLAogICAgInRpcG9JdGVtIiA6IDEsCiAgICAibnVtZXJvRG9jdW1lbnRvIiA6IG51bGwsCiAgICAiY2FudGlkYWQiIDogNi4wLAogICAgImNvZGlnbyIgOiAiMTQwMjQxIiwKICAgICJjb2RUcmlidXRvIiA6IG51bGwsCiAgICAidW5pTWVkaWRhIiA6IDU5LAogICAgImRlc2NyaXBjaW9uIiA6ICJZT0dVUlQgTElRVUlETyBCQU5BTk8gRlJFU0EgTElHSFQgNzUwIEdSIiwKICAgICJwcmVjaW9VbmkiIDogMS40NiwKICAgICJtb250b0Rlc2N1IiA6IDAuMCwKICAgICJ2ZW50YU5vU3VqIiA6IDAuMCwKICAgICJ2ZW50YUV4ZW50YSIgOiAwLjAsCiAgICAidmVudGFHcmF2YWRhIiA6IDguNzYsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogMTMsCiAgICAidGlwb0l0ZW0iIDogMSwKICAgICJudW1lcm9Eb2N1bWVudG8iIDogbnVsbCwKICAgICJjYW50aWRhZCIgOiAxLjAsCiAgICAiY29kaWdvIiA6ICIxNDA0NDYiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogOTksCiAgICAiZGVzY3JpcGNpb24iIDogIllPR1VSVCBZRVNDT09MIFVWQSBQQUNLIDI1IFVORCIsCiAgICAicHJlY2lvVW5pIiA6IDQuNzUsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiA0Ljc1LAogICAgInRyaWJ1dG9zIiA6IFsgIjIwIiBdLAogICAgInBzdiIgOiAwLjAsCiAgICAibm9HcmF2YWRvIiA6IDAuMAogIH0sIHsKICAgICJudW1JdGVtIiA6IDE0LAogICAgInRpcG9JdGVtIiA6IDEsCiAgICAibnVtZXJvRG9jdW1lbnRvIiA6IG51bGwsCiAgICAiY2FudGlkYWQiIDogNDcuMCwKICAgICJjb2RpZ28iIDogIjE0MDQ0OCIsCiAgICAiY29kVHJpYnV0byIgOiBudWxsLAogICAgInVuaU1lZGlkYSIgOiA5OSwKICAgICJkZXNjcmlwY2lvbiIgOiAiWU9HVVJUIFlFU0NPT0wgRlJFU0EgUEFDSyA2IFVORCIsCiAgICAicHJlY2lvVW5pIiA6IDEuMTUsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiA1NC4wNSwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAxNSwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDM1LjAsCiAgICAiY29kaWdvIiA6ICIxNDA0NDkiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogOTksCiAgICAiZGVzY3JpcGNpb24iIDogIllPR1VSVCBZRVNDT09MIEJBTkFOTyBGIFBBQ0sgNiBVTkQiLAogICAgInByZWNpb1VuaSIgOiAxLjE1LAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogNDAuMjUsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogMTYsCiAgICAidGlwb0l0ZW0iIDogMSwKICAgICJudW1lcm9Eb2N1bWVudG8iIDogbnVsbCwKICAgICJjYW50aWRhZCIgOiAzNS4wLAogICAgImNvZGlnbyIgOiAiMTQwNDUwIiwKICAgICJjb2RUcmlidXRvIiA6IG51bGwsCiAgICAidW5pTWVkaWRhIiA6IDk5LAogICAgImRlc2NyaXBjaW9uIiA6ICJZT0dVUlQgWUVTQ09PTCBVVkEgUEFDSyA2IFVORCIsCiAgICAicHJlY2lvVW5pIiA6IDEuMTUsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiA0MC4yNSwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAxNywKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDEyLjAsCiAgICAiY29kaWdvIiA6ICIxNDAyNTAiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogNTksCiAgICAiZGVzY3JpcGNpb24iIDogIllPRyBMSVEgVklUQUxJVEUgQVJBTkRBTk8gQUNBSSAyMTJnIiwKICAgICJwcmVjaW9VbmkiIDogMC41OCwKICAgICJtb250b0Rlc2N1IiA6IDAuMCwKICAgICJ2ZW50YU5vU3VqIiA6IDAuMCwKICAgICJ2ZW50YUV4ZW50YSIgOiAwLjAsCiAgICAidmVudGFHcmF2YWRhIiA6IDYuOTYsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogMTgsCiAgICAidGlwb0l0ZW0iIDogMSwKICAgICJudW1lcm9Eb2N1bWVudG8iIDogbnVsbCwKICAgICJjYW50aWRhZCIgOiAxMi4wLAogICAgImNvZGlnbyIgOiAiMTQwMjUyIiwKICAgICJjb2RUcmlidXRvIiA6IG51bGwsCiAgICAidW5pTWVkaWRhIiA6IDU5LAogICAgImRlc2NyaXBjaW9uIiA6ICJZT0cgTElRIFZJVEFMSVRFIFBBUEFZQSAyMTJnIiwKICAgICJwcmVjaW9VbmkiIDogMC41OCwKICAgICJtb250b0Rlc2N1IiA6IDAuMCwKICAgICJ2ZW50YU5vU3VqIiA6IDAuMCwKICAgICJ2ZW50YUV4ZW50YSIgOiAwLjAsCiAgICAidmVudGFHcmF2YWRhIiA6IDYuOTYsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogMTksCiAgICAidGlwb0l0ZW0iIDogMSwKICAgICJudW1lcm9Eb2N1bWVudG8iIDogbnVsbCwKICAgICJjYW50aWRhZCIgOiAxMi4wLAogICAgImNvZGlnbyIgOiAiMTUwMDMxIiwKICAgICJjb2RUcmlidXRvIiA6IG51bGwsCiAgICAidW5pTWVkaWRhIiA6IDU5LAogICAgImRlc2NyaXBjaW9uIiA6ICJZT0cgTElRIFZJVEFMSVRFIENJUlVFTEEgQ0hJQSBDQU5FTEEyMTJnIiwKICAgICJwcmVjaW9VbmkiIDogMC41OCwKICAgICJtb250b0Rlc2N1IiA6IDAuMCwKICAgICJ2ZW50YU5vU3VqIiA6IDAuMCwKICAgICJ2ZW50YUV4ZW50YSIgOiAwLjAsCiAgICAidmVudGFHcmF2YWRhIiA6IDYuOTYsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogMjAsCiAgICAidGlwb0l0ZW0iIDogMSwKICAgICJudW1lcm9Eb2N1bWVudG8iIDogbnVsbCwKICAgICJjYW50aWRhZCIgOiAxNS4wLAogICAgImNvZGlnbyIgOiAiMTQwMjYwIiwKICAgICJjb2RUcmlidXRvIiA6IG51bGwsCiAgICAidW5pTWVkaWRhIiA6IDk5LAogICAgImRlc2NyaXBjaW9uIiA6ICJZT0dVUlQgNFBBQ0sgS0lEUyIsCiAgICAicHJlY2lvVW5pIiA6IDEuMzUsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiAyMC4yNSwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAyMSwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDEyLjAsCiAgICAiY29kaWdvIiA6ICIxNDAyNjIiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogNTksCiAgICAiZGVzY3JpcGNpb24iIDogIllPR1VSVCBCQU5BTk8gRlJFU0EgIDEyNSBHUiIsCiAgICAicHJlY2lvVW5pIiA6IDAuNDUsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiA1LjQsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogMjIsCiAgICAidGlwb0l0ZW0iIDogMSwKICAgICJudW1lcm9Eb2N1bWVudG8iIDogbnVsbCwKICAgICJjYW50aWRhZCIgOiAxMi4wLAogICAgImNvZGlnbyIgOiAiMTQwMjY2IiwKICAgICJjb2RUcmlidXRvIiA6IG51bGwsCiAgICAidW5pTWVkaWRhIiA6IDU5LAogICAgImRlc2NyaXBjaW9uIiA6ICJZT0dVUlQgVkFJTklMTEEgIDEyNSBHUiIsCiAgICAicHJlY2lvVW5pIiA6IDAuNDUsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiA1LjQsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogMjMsCiAgICAidGlwb0l0ZW0iIDogMSwKICAgICJudW1lcm9Eb2N1bWVudG8iIDogbnVsbCwKICAgICJjYW50aWRhZCIgOiAyLjAsCiAgICAiY29kaWdvIiA6ICIxNDAyNzAiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogOTksCiAgICAiZGVzY3JpcGNpb24iIDogIllPR1VSVCA0UEFDSyBMSUdIVCAxMjUgR1IiLAogICAgInByZWNpb1VuaSIgOiAxLjY5LAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogMy4zOCwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAyNCwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDEyLjAsCiAgICAiY29kaWdvIiA6ICIxNDAyNzMiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogNTksCiAgICAiZGVzY3JpcGNpb24iIDogIllPR1VSVCBGUlVUQSBGT05ETyBGUkVTQSAxMjUgR1IiLAogICAgInByZWNpb1VuaSIgOiAwLjQ1LAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogNS40LAogICAgInRyaWJ1dG9zIiA6IFsgIjIwIiBdLAogICAgInBzdiIgOiAwLjAsCiAgICAibm9HcmF2YWRvIiA6IDAuMAogIH0sIHsKICAgICJudW1JdGVtIiA6IDI1LAogICAgInRpcG9JdGVtIiA6IDEsCiAgICAibnVtZXJvRG9jdW1lbnRvIiA6IG51bGwsCiAgICAiY2FudGlkYWQiIDogMTIuMCwKICAgICJjb2RpZ28iIDogIjE0MDI3NCIsCiAgICAiY29kVHJpYnV0byIgOiBudWxsLAogICAgInVuaU1lZGlkYSIgOiA1OSwKICAgICJkZXNjcmlwY2lvbiIgOiAiWU9HVVJUIEZSVVRBIEZPTkRPIE1FTE9DT1RPTiAxMjUgR1IiLAogICAgInByZWNpb1VuaSIgOiAwLjQ1LAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogNS40LAogICAgInRyaWJ1dG9zIiA6IFsgIjIwIiBdLAogICAgInBzdiIgOiAwLjAsCiAgICAibm9HcmF2YWRvIiA6IDAuMAogIH0sIHsKICAgICJudW1JdGVtIiA6IDI2LAogICAgInRpcG9JdGVtIiA6IDEsCiAgICAibnVtZXJvRG9jdW1lbnRvIiA6IG51bGwsCiAgICAiY2FudGlkYWQiIDogOC4wLAogICAgImNvZGlnbyIgOiAiMTQwMjgwIiwKICAgICJjb2RUcmlidXRvIiA6IG51bGwsCiAgICAidW5pTWVkaWRhIiA6IDU5LAogICAgImRlc2NyaXBjaW9uIiA6ICJZT0dVUlQgTkFUVVJBTCAxIEtHIiwKICAgICJwcmVjaW9VbmkiIDogMi40NiwKICAgICJtb250b0Rlc2N1IiA6IDAuMCwKICAgICJ2ZW50YU5vU3VqIiA6IDAuMCwKICAgICJ2ZW50YUV4ZW50YSIgOiAwLjAsCiAgICAidmVudGFHcmF2YWRhIiA6IDE5LjY4LAogICAgInRyaWJ1dG9zIiA6IFsgIjIwIiBdLAogICAgInBzdiIgOiAwLjAsCiAgICAibm9HcmF2YWRvIiA6IDAuMAogIH0sIHsKICAgICJudW1JdGVtIiA6IDI3LAogICAgInRpcG9JdGVtIiA6IDEsCiAgICAibnVtZXJvRG9jdW1lbnRvIiA6IG51bGwsCiAgICAiY2FudGlkYWQiIDogNC4wLAogICAgImNvZGlnbyIgOiAiMTQwMjgxIiwKICAgICJjb2RUcmlidXRvIiA6IG51bGwsCiAgICAidW5pTWVkaWRhIiA6IDU5LAogICAgImRlc2NyaXBjaW9uIiA6ICJZT0dVUlQgQkFOQU5PIEZSRVNBIDEgS0ciLAogICAgInByZWNpb1VuaSIgOiAyLjQ2LAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogOS44NCwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAyOCwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDQuMCwKICAgICJjb2RpZ28iIDogIjE0MDI4MiIsCiAgICAiY29kVHJpYnV0byIgOiBudWxsLAogICAgInVuaU1lZGlkYSIgOiA1OSwKICAgICJkZXNjcmlwY2lvbiIgOiAiWU9HVVJUIEZSRVNBIExJR0hUIDEgS0ciLAogICAgInByZWNpb1VuaSIgOiAyLjQ2LAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogOS44NCwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAyOSwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDQuMCwKICAgICJjb2RpZ28iIDogIjE0MDI4MyIsCiAgICAiY29kVHJpYnV0byIgOiBudWxsLAogICAgInVuaU1lZGlkYSIgOiA1OSwKICAgICJkZXNjcmlwY2lvbiIgOiAiWU9HVVJUIFRVVFRJIEZSVVRJIExJR0hUIDEgS0ciLAogICAgInByZWNpb1VuaSIgOiAyLjQ2LAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogOS44NCwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAzMCwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDI1LjAsCiAgICAiY29kaWdvIiA6ICIxNDAyOTYiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogNTksCiAgICAiZGVzY3JpcGNpb24iIDogIkJPTFNBIERFIFEuIE1PWlpBUkVMTEEgUkFMTEFETyAyMDBHUlMiLAogICAgInByZWNpb1VuaSIgOiAyLjM4LAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogNTkuNSwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAzMSwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDEwLjAsCiAgICAiY29kaWdvIiA6ICIxNDAzMDIiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogNTksCiAgICAiZGVzY3JpcGNpb24iIDogIk1PWlpBUkVMTEEgUkVCQU5BRE8gMjAwIEdSUyIsCiAgICAicHJlY2lvVW5pIiA6IDEuNjksCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiAxNi45LAogICAgInRyaWJ1dG9zIiA6IFsgIjIwIiBdLAogICAgInBzdiIgOiAwLjAsCiAgICAibm9HcmF2YWRvIiA6IDAuMAogIH0sIHsKICAgICJudW1JdGVtIiA6IDMyLAogICAgInRpcG9JdGVtIiA6IDEsCiAgICAibnVtZXJvRG9jdW1lbnRvIiA6IG51bGwsCiAgICAiY2FudGlkYWQiIDogMTAuMCwKICAgICJjb2RpZ28iIDogIjE0MDg5MCIsCiAgICAiY29kVHJpYnV0byIgOiBudWxsLAogICAgInVuaU1lZGlkYSIgOiA1OSwKICAgICJkZXNjcmlwY2lvbiIgOiAiUVVFU08gTEFDIEFNRVJJQ0FOTyBCTCAxMiBSRUIvMTgwIEciLAogICAgInByZWNpb1VuaSIgOiAxLjQ2LAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogMTQuNiwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAzMywKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDEwLjAsCiAgICAiY29kaWdvIiA6ICIxNDA4OTEiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogNTksCiAgICAiZGVzY3JpcGNpb24iIDogIlFVRVNPIExBQyBBTUVSSUNBTk8gQkwgMTYgUkVCLzI0MCBHIiwKICAgICJwcmVjaW9VbmkiIDogMS44MSwKICAgICJtb250b0Rlc2N1IiA6IDAuMCwKICAgICJ2ZW50YU5vU3VqIiA6IDAuMCwKICAgICJ2ZW50YUV4ZW50YSIgOiAwLjAsCiAgICAidmVudGFHcmF2YWRhIiA6IDE4LjEsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogMzQsCiAgICAidGlwb0l0ZW0iIDogMSwKICAgICJudW1lcm9Eb2N1bWVudG8iIDogbnVsbCwKICAgICJjYW50aWRhZCIgOiAzNi4wLAogICAgImNvZGlnbyIgOiAiMTQwMzU3IiwKICAgICJjb2RUcmlidXRvIiA6IG51bGwsCiAgICAidW5pTWVkaWRhIiA6IDU5LAogICAgImRlc2NyaXBjaW9uIiA6ICJRVUVTTyBDUkVNQSAyMzAgR1IiLAogICAgInByZWNpb1VuaSIgOiAxLjMxLAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogNDcuMTYsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogMzUsCiAgICAidGlwb0l0ZW0iIDogMSwKICAgICJudW1lcm9Eb2N1bWVudG8iIDogbnVsbCwKICAgICJjYW50aWRhZCIgOiAxMi4wLAogICAgImNvZGlnbyIgOiAiMTQwMzU4IiwKICAgICJjb2RUcmlidXRvIiA6IG51bGwsCiAgICAidW5pTWVkaWRhIiA6IDU5LAogICAgImRlc2NyaXBjaW9uIiA6ICJRVUVTTyBDUkVNQSAxMjUgR1IiLAogICAgInByZWNpb1VuaSIgOiAwLjc3LAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogOS4yNCwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAzNiwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDEyLjAsCiAgICAiY29kaWdvIiA6ICIxNDAzNjUiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogNTksCiAgICAiZGVzY3JpcGNpb24iIDogIkRJUCBDSElMRSAyMzAgR1JTIiwKICAgICJwcmVjaW9VbmkiIDogMS4zNSwKICAgICJtb250b0Rlc2N1IiA6IDAuMCwKICAgICJ2ZW50YU5vU3VqIiA6IDAuMCwKICAgICJ2ZW50YUV4ZW50YSIgOiAwLjAsCiAgICAidmVudGFHcmF2YWRhIiA6IDE2LjIsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogMzcsCiAgICAidGlwb0l0ZW0iIDogMSwKICAgICJudW1lcm9Eb2N1bWVudG8iIDogbnVsbCwKICAgICJjYW50aWRhZCIgOiA2LjAsCiAgICAiY29kaWdvIiA6ICIxNDA1ODkiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogNTksCiAgICAiZGVzY3JpcGNpb24iIDogIllPR1VSVCBMSVFVSURPIEFMT0UgVkVSQSA3NTAgR1IiLAogICAgInByZWNpb1VuaSIgOiAxLjQ2LAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogOC43NiwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiAzOCwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDEuMCwKICAgICJjb2RpZ28iIDogIjE0MDc2MyIsCiAgICAiY29kVHJpYnV0byIgOiBudWxsLAogICAgInVuaU1lZGlkYSIgOiA5OSwKICAgICJkZXNjcmlwY2lvbiIgOiAiWU9HVVJUIFlFU0NPT0wgTUFOWkFOQSBQQUNLIDYgVU5EIiwKICAgICJwcmVjaW9VbmkiIDogMS4xNSwKICAgICJtb250b0Rlc2N1IiA6IDAuMCwKICAgICJ2ZW50YU5vU3VqIiA6IDAuMCwKICAgICJ2ZW50YUV4ZW50YSIgOiAwLjAsCiAgICAidmVudGFHcmF2YWRhIiA6IDEuMTUsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogMzksCiAgICAidGlwb0l0ZW0iIDogMSwKICAgICJudW1lcm9Eb2N1bWVudG8iIDogbnVsbCwKICAgICJjYW50aWRhZCIgOiAxNS4wLAogICAgImNvZGlnbyIgOiAiMTQwNjYyIiwKICAgICJjb2RUcmlidXRvIiA6IG51bGwsCiAgICAidW5pTWVkaWRhIiA6IDk5LAogICAgImRlc2NyaXBjaW9uIiA6ICJZT0dVUlQgTElRVUlETyA4IFBBQ0sgU0FGQVJJIEZSRVNBIE1BTlpBIiwKICAgICJwcmVjaW9VbmkiIDogMi40LAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogMzYuMCwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiA0MCwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDI1LjAsCiAgICAiY29kaWdvIiA6ICIxNDA2NjciLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogOTksCiAgICAiZGVzY3JpcGNpb24iIDogIllPR1VSVCBZRVNDT09MIEdBTExFVEEgRlJFU0EgUEFDSyA2IFVORCIsCiAgICAicHJlY2lvVW5pIiA6IDEuMTUsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiAyOC43NSwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiA0MSwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDEwLjAsCiAgICAiY29kaWdvIiA6ICIxNDA0NTgiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogOTksCiAgICAiZGVzY3JpcGNpb24iIDogIllPR1VSVCBMSVFVSURPIDggUEFDSyAyMDAgTUwgVEVNUE9SQURBIiwKICAgICJwcmVjaW9VbmkiIDogMy41NCwKICAgICJtb250b0Rlc2N1IiA6IDAuMCwKICAgICJ2ZW50YU5vU3VqIiA6IDAuMCwKICAgICJ2ZW50YUV4ZW50YSIgOiAwLjAsCiAgICAidmVudGFHcmF2YWRhIiA6IDM1LjQsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSwgewogICAgIm51bUl0ZW0iIDogNDIsCiAgICAidGlwb0l0ZW0iIDogMSwKICAgICJudW1lcm9Eb2N1bWVudG8iIDogbnVsbCwKICAgICJjYW50aWRhZCIgOiAxMi4wLAogICAgImNvZGlnbyIgOiAiMTQwNzMyIiwKICAgICJjb2RUcmlidXRvIiA6IG51bGwsCiAgICAidW5pTWVkaWRhIiA6IDU5LAogICAgImRlc2NyaXBjaW9uIiA6ICJZT0cgR1JJRUdPIExJUS4gRlJFU0EgU0lOIEFaVUNBUiAyMDAgTUwiLAogICAgInByZWNpb1VuaSIgOiAwLjc0LAogICAgIm1vbnRvRGVzY3UiIDogMC4wLAogICAgInZlbnRhTm9TdWoiIDogMC4wLAogICAgInZlbnRhRXhlbnRhIiA6IDAuMCwKICAgICJ2ZW50YUdyYXZhZGEiIDogOC44OCwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiA0MywKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDI1LjAsCiAgICAiY29kaWdvIiA6ICIxNDA3NjUiLAogICAgImNvZFRyaWJ1dG8iIDogbnVsbCwKICAgICJ1bmlNZWRpZGEiIDogOTksCiAgICAiZGVzY3JpcGNpb24iIDogIllPR1VSVCBZRVNDT09MIE1FTE9DT1RPTiBQQUNLIDYgVU5EIiwKICAgICJwcmVjaW9VbmkiIDogMS4xNSwKICAgICJtb250b0Rlc2N1IiA6IDAuMCwKICAgICJ2ZW50YU5vU3VqIiA6IDAuMCwKICAgICJ2ZW50YUV4ZW50YSIgOiAwLjAsCiAgICAidmVudGFHcmF2YWRhIiA6IDI4Ljc1LAogICAgInRyaWJ1dG9zIiA6IFsgIjIwIiBdLAogICAgInBzdiIgOiAwLjAsCiAgICAibm9HcmF2YWRvIiA6IDAuMAogIH0sIHsKICAgICJudW1JdGVtIiA6IDQ0LAogICAgInRpcG9JdGVtIiA6IDEsCiAgICAibnVtZXJvRG9jdW1lbnRvIiA6IG51bGwsCiAgICAiY2FudGlkYWQiIDogMzUuMCwKICAgICJjb2RpZ28iIDogIjE0MDc4NiIsCiAgICAiY29kVHJpYnV0byIgOiBudWxsLAogICAgInVuaU1lZGlkYSIgOiA5OSwKICAgICJkZXNjcmlwY2lvbiIgOiAiWU9HVVJUIFlFU0NPT0wgS0lXSSBTQU5ESUEgUEFDSyA2IFVORCIsCiAgICAicHJlY2lvVW5pIiA6IDEuMTUsCiAgICAibW9udG9EZXNjdSIgOiAwLjAsCiAgICAidmVudGFOb1N1aiIgOiAwLjAsCiAgICAidmVudGFFeGVudGEiIDogMC4wLAogICAgInZlbnRhR3JhdmFkYSIgOiA0MC4yNSwKICAgICJ0cmlidXRvcyIgOiBbICIyMCIgXSwKICAgICJwc3YiIDogMC4wLAogICAgIm5vR3JhdmFkbyIgOiAwLjAKICB9LCB7CiAgICAibnVtSXRlbSIgOiA0NSwKICAgICJ0aXBvSXRlbSIgOiAxLAogICAgIm51bWVyb0RvY3VtZW50byIgOiBudWxsLAogICAgImNhbnRpZGFkIiA6IDQuMCwKICAgICJjb2RpZ28iIDogIjE0MDgyMyIsCiAgICAiY29kVHJpYnV0byIgOiBudWxsLAogICAgInVuaU1lZGlkYSIgOiA1OSwKICAgICJkZXNjcmlwY2lvbiIgOiAiWU9HVVJUIEdSSUVHTyBDUkVNT1NPIE5BVFVSQUwgMSBLRyIsCiAgICAicHJlY2lvVW5pIiA6IDMuOCwKICAgICJtb250b0Rlc2N1IiA6IDAuMCwKICAgICJ2ZW50YU5vU3VqIiA6IDAuMCwKICAgICJ2ZW50YUV4ZW50YSIgOiAwLjAsCiAgICAidmVudGFHcmF2YWRhIiA6IDE1LjIsCiAgICAidHJpYnV0b3MiIDogWyAiMjAiIF0sCiAgICAicHN2IiA6IDAuMCwKICAgICJub0dyYXZhZG8iIDogMC4wCiAgfSBdLAogICJyZXN1bWVuIiA6IHsKICAgICJ0b3RhbE5vU3VqIiA6IDAuMCwKICAgICJ0b3RhbEV4ZW50YSIgOiAwLjAsCiAgICAidG90YWxHcmF2YWRhIiA6IDgzMC45LAogICAgInN1YlRvdGFsVmVudGFzIiA6IDgzMC45LAogICAgImRlc2N1Tm9TdWoiIDogMC4wLAogICAgImRlc2N1RXhlbnRhIiA6IDAuMCwKICAgICJkZXNjdUdyYXZhZGEiIDogMC4wLAogICAgInBvcmNlbnRhamVEZXNjdWVudG8iIDogMC4wLAogICAgInRvdGFsRGVzY3UiIDogMC4wLAogICAgInRyaWJ1dG9zIiA6IFsgewogICAgICAiY29kaWdvIiA6ICIyMCIsCiAgICAgICJkZXNjcmlwY2lvbiIgOiAiSW1wdWVzdG8gYWwgVmFsb3IgQWdyZWdhZG8gMTMlIiwKICAgICAgInZhbG9yIiA6IDEwOC4wMwogICAgfSBdLAogICAgInN1YlRvdGFsIiA6IDgzMC45LAogICAgIml2YVBlcmNpMSIgOiAwLjAsCiAgICAiaXZhUmV0ZTEiIDogMC4wLAogICAgInJldGVSZW50YSIgOiAwLjAsCiAgICAibW9udG9Ub3RhbE9wZXJhY2lvbiIgOiA5MzguOTMsCiAgICAidG90YWxOb0dyYXZhZG8iIDogMC4wLAogICAgInRvdGFsUGFnYXIiIDogOTM4LjkzLAogICAgInRvdGFsTGV0cmFzIiA6ICJOT1ZFQ0lFTlRPUyBUUkVJTlRBIFkgT0NITyBjb24gOTMiLAogICAgInNhbGRvRmF2b3IiIDogMC4wLAogICAgImNvbmRpY2lvbk9wZXJhY2lvbiIgOiAyLAogICAgInBhZ29zIiA6IFsgewogICAgICAiY29kaWdvIiA6ICIwNSIsCiAgICAgICJtb250b1BhZ28iIDogOTM4LjkzLAogICAgICAicmVmZXJlbmNpYSIgOiBudWxsLAogICAgICAicGxhem8iIDogIjAxIiwKICAgICAgInBlcmlvZG8iIDogMTUKICAgIH0gXSwKICAgICJudW1QYWdvRWxlY3Ryb25pY28iIDogbnVsbAogIH0sCiAgImV4dGVuc2lvbiIgOiB7CiAgICAibm9tYkVudHJlZ2EiIDogbnVsbCwKICAgICJkb2N1RW50cmVnYSIgOiBudWxsLAogICAgIm5vbWJSZWNpYmUiIDogbnVsbCwKICAgICJkb2N1UmVjaWJlIiA6IG51bGwsCiAgICAib2JzZXJ2YWNpb25lcyIgOiBudWxsLAogICAgInBsYWNhVmVoaWN1bG8iIDogbnVsbAogIH0sCiAgImFwZW5kaWNlIiA6IG51bGwKfQ.EaylbuWb1JJ438KetmYWZdiIkFuMPUZ4QSNO99oR5P5oOpg7WwjV6jo0OFGc2mnkm-rVfLtdbFrrEOMK5nrWQZEKTUuaj_PRjZ7KEyISNyQ7cgVLAgmAHYMVoDcdhOjKKoINuBDJ_5CA0kMMIp6wQrTCX1wL67ptubjAJKXfHI2sXcDDJp78xwkSq1hUjH1eTqzZqAGfbV_j1tdgwkUJMogWENUcBq7sQR7U04aFs6S1kU-NrUf2Z0DkBEaWfh_u2j81Whk28ONR1fPQZnpg34m-dz133cebx44s4XDMQEh-7b1ZVy9I06yT0_8ZY71xIowj4h9Mdhc-qN-2jmF5Kw",
                    "selloRecibido": "20239C6537A7DA5445CD8C1A3343E631687BQFYC"
                },
            },
            methods: {
                conversorLineaPDF(d) {
                    let data = d.cuerpoDocumento.map(r => {
                        return {
                            'numItem': r.numItem,
                            'cantidad': r.cantidad,
                            'uniMedida': r.uniMedida,
                            'codigo': r.codigo,
                            'descripcion': r.descripcion,
                            'precioUni': r.precioUni,
                            'montoDescu': r.montoDescu,
                            'psv': r.psv,
                            'ventaNoSuj': r.ventaNoSuj,
                            'ventaExenta': r.ventaExenta,
                            'ventaGravada': r.ventaGravada
                        }
                    })
                    let enviar = [];

                    data.forEach(r => {
                        enviar.push([{
                                text: r.numItem,
                                fontSize: 7,
                                border: [0, 0, 0, 0],
                            },
                            {
                                text: r.cantidad,
                                fontSize: 7,
                                border: [0, 0, 0, 0],
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
                async getPDF() {

                    const qr = await this.getCodigoQR(this.factura.identificacion.codigoGeneracion, this.factura.identificacion.fecEmi);

                    const customColors = {
                        customOrange: '#ff4b00',
                        //customOrange: '#ff9a00',
                        customRed: '#FF0000',
                        customRed: '#FFFFFF',
                    };


                    var dd = {
                        pageSize: 'letter',
                        background: [{
                            image: logo_trasparente,
                            fit: [595.28, 841.89],
                            margin: [0, 240, 0, 0]
                        }, ],
                        footer: function(currentPage, pageCount) {
                            return {
                                text: `Página ${currentPage} de ${pageCount}`,
                                fontSize: 7,
                                alignment: 'center', // Alinea el texto al centro
                            };
                        },
                        pageMargins: [30, 9, 20, 25],
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
                                    widths: [100, '*', 70,50],
                                    body: [
                                        [{
                                                image: logo,
                                                width: 120,
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
                                                width: 50,
                                                alignment: 'center',
                                                border: [false, false, false, false]
                                            },
                                            {alignment:'right',
                                                border: [false, false, false, false],
                                                        text:  '\n'+this.getSupermercado(this.factura.identificacion.codigoGeneracion).BZIRK,
                                                        fontSize:12
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
                                                                text: this.factura.identificacion.codigoGeneracion,
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
                                                                text: this.factura.identificacion.numeroControl,
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
                                                                text: this.factura.selloRecibido,
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
                                                                text: this.factura.identificacion.tipoModelo,
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
                                                                text: this.factura.identificacion.tipoOperacion,
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
                                                                text: this.factura.identificacion.fecEmi + ' ' + this.factura.identificacion.horEmi,
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
                                                            text: 'Nombre o Razon social: ',
                                                            bold: true
                                                        }, this.factura.emisor.nombre]
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'NIT: ',
                                                            bold: true
                                                        }, this.factura.emisor.nit]
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'NRC: ',
                                                            bold: true
                                                        }, this.factura.emisor.nrc]
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'Actividad Economica: ',
                                                            bold: true
                                                        }, this.factura.emisor.descActividad]
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'Direccion:  ',
                                                            bold: true
                                                        }, this.factura.emisor.direccion.complemento]
                                                    },
                                                    {


                                                        text: this.getDepartamento(this.factura.emisor.direccion.departamento).toUpperCase() + ' - ' + this.getMunicipios(this.factura.emisor.direccion.departamento, this.factura.emisor.direccion.municipio).toUpperCase()
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'Numero de teléfono: ',
                                                            bold: true
                                                        }, this.factura.emisor.telefono]
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'Correo electrónico: ',
                                                            bold: true
                                                        }, this.factura.emisor.correo]
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'Nombre Comercial: ',
                                                            bold: true
                                                        }, this.factura.emisor.nombreComercial]
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'Tipo Establecimiento: ',
                                                            bold: true
                                                        }, this.factura.emisor.tipoEstablecimiento]
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
                                                        }, this.factura.receptor.nombre+' ( '+this.getSupermercado(this.factura.identificacion.codigoGeneracion).KUNNR+' )']
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'Nombre comercial: ',
                                                            bold: true
                                                        }, this.getSupermercado(this.factura.identificacion.codigoGeneracion).NAME2]
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'NIT: ',
                                                            bold: true
                                                        }, this.factura.receptor.nit]
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'NRC: ',
                                                            bold: true
                                                        }, this.factura.receptor.nrc]
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'Actividad económica: ',
                                                            bold: true
                                                        }, this.factura.receptor.descActividad]
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'Dirección: ',
                                                            bold: true
                                                        }, this.factura.receptor.direccion.complemento]
                                                    },
                                                    {
                                                        text: this.getDepartamento(this.factura.receptor.direccion.departamento) + ' ' + this.getMunicipios(this.factura.receptor.direccion.municipio)
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'Correo electrónico: ',
                                                            bold: true
                                                        }, this.factura.receptor.correo]
                                                    },
                                                    {
                                                        text: [{
                                                            text: 'Teléfono: ',
                                                            bold: true
                                                        }, this.factura.receptor.telefono]
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
                                    widths: ['3%', '3%', '4%', '5%', '11%', '38%', '7%', '4%', '7%', '6%', '6%', '7%'],
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
                                        ...this.conversorLineaPDF(this.factura),


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
                                                text: this.numberFormat(this.factura.resumen.subTotalVentas),
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
                                                text: this.numberFormat(this.factura.resumen.totalGravada),
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
                                                text: this.numberFormat(this.factura.resumen.totalNoSuj),
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
                                                text: this.numberFormat(this.factura.resumen.totalExenta),
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
                                                text: this.numberFormat(this.factura.resumen.totalNoGravado),
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
                                                text: (this.factura.resumen.tributos.find(r => r.codigo == '20')) ? this.factura.resumen.tributos.find(r => r.codigo == '20').valor : 0,
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
                                                text: this.numberFormat(this.factura.resumen.subTotal),
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
                                                text: this.numberFormat(this.factura.resumen.ivaPerci1),
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
                                                text: this.numberFormat(this.factura.resumen.ivaRete1),
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
                                                text: this.numberFormat(this.factura.resumen.reteRenta),
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
                                                text: this.numberFormat(this.factura.resumen.montoTotalOperacion),
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
                                                text: '$ ' + this.numberFormat(this.factura.resumen.totalPagar),
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
                                    widths: ['15%','35%','25%','26%'],
                                    body: [
                                        [{
                                                text: 'Valor en letras: ',
                                                fontSize: 7,
                                                border: [1, 1, 0, 0],
                                            }, {
                                                text: this.factura.resumen.totalLetras,
                                                fontSize: 7,
                                                border: [0, 1, 0, 0],
                                            },
                                            {
                                                text: 'Condición de la Operación: ',
                                                fontSize: 7,
                                                border: [0, 1, 0, 0],
                                            },
                                            {
                                                text: (this.factura.resumen.condicionOperacion==2)?'Crédito':'Contado',
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
                                                text: this.getSupermercado(this.factura.identificacion.codigoGeneracion).VBELN,
                                                fontSize: 7,
                                                border: [0, 0, 1, 1],
                                            }
                                        ],
                                    ]
                                }
                            },
                            {text:'\n'},
                            {
                                table: {
                                    widths: ['15%','35%','25%','26%'],
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
                    //pdfMake.createPdf(dd).open();
                    const pdfDocGenerator = pdfMake.createPdf(dd);
                        pdfDocGenerator.getBase64((data) => {
                            
                            /*axios.post('<?= route('conversor') ?>', {
                                     elpdf: data,
                                     id:'cc-'+this.factura.identificacion.codigoGeneracion
                                })
                                .then(res => {
                                   console.log(res);
                            
                                })
                                .catch(err => {
                                    console.error(err);
                                   app.loading = false;
                                   });*/


                            console.log(data);
                        });
                    
                   

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
                getDepartamento(d) {
                    let v = this.departamentos.find(r => r.codigo == d)
                    return (v) ? v.valor : ''
                },
                getMunicipios(d, m) {
                    let v = this.municipios.find(r => (r.codigo == m && r.cod_departamento == d))
                    return (v) ? v.valor : ''
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
                getSupermercado(f) {
                    let v = this.supemercados.find(r => (r.CAMPO1 == f ))
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
                }

            },
            computed: {},
            mounted() {

                this.getPDF()
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

        function generarCodigoDeBarras(numero) {
            JsBarcode("#barcode", numero, {
                format: "CODE128", // El formato de código de barras que desees (ejemplo: CODE128)
                displayValue: true, // Muestra el valor (número) junto al código de barras
                width: 2, // Ancho de las barras
                height: 50, // Alto del código de barras
            });
        }
    </script>
</body>

</html>