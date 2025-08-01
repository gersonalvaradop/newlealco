<!DOCTYPE html>
<html>

<head>
    <title>Inicio de Sesión</title>
    <script  src="<?= url('axios.min.js')?>"></script>
    <script  src="<?= url('vue.js')?>"></script>
    <script  src="<?= url('element-ui2.15.10.js')?>"></script>
    <link rel="stylesheet" href="<?=url('4.5.2_css_bootstrap.min.css')?>">
    <link rel="stylesheet" href="<?=url('element-ui@2.15.10_lib_theme-chalk_index.css')?>">
    <link rel="stylesheet" href="<?=url('animate.css_4.1.1_animate.min.css')?>" />
    <style >
        body {
            background-color: #000;
            overflow: hidden;
        }

        html,
        body {
            width: 100vw;
            height: 100vh;
            margin: 0;
        }

        #videoBG {
            position: fixed;
            z-index: -1;
            opacity: 0.2;
        }

        @media (min-aspect-ratio: 16/9) {
            #videoBG {
                width: 100%;
                height: auto;
            }
        }

        @media (max-aspect-ratio: 16/9) {
            #videoBG {
                width: auto;
                height: 100%;
            }
        }

        @media (max-width: 767px) {
            #videoBG {
                display: none;
            }

            body {
                background: url('poster.jpg');
                background-size: cover;
            }
        }
    </style>
</head>

<body>
    <?= $actualizar ?>
    <div id="app" class="animate__animated animate__fadeInLeft" style="height: 100vh;" v-loading="loading">
    <video id="videoBG" autoplay muted loop>
            <source src="fondo.mp4" type="video/mp4">
        </video>
        <div class="row justify-content-center">
            <div class="col-md-4 ">

                <form @submit.prevent="login" style="text-align: center;" class="mt-5">
                    <img src="<?= $logo ?>" class="w-50" alt="">
                    <div class="form-group">
                        <label for="email" class="text-white" >Usuario</label>
                        <input type="text" id="email" v-model="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="password" class="text-white">Contraseña</label>
                        <input type="password" id="password" v-model="password" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-outline-primary btn-block">Iniciar Sesión</button>
                </form>
            </div>
        </div>
       
    </div>


    <script >
        let app = new Vue({
            el: '#app',
            data: {
                loading: false,
                email: '',
                password: ''
            },
            methods: {
                login() {
                    this.loading = true;
                    // Realizar solicitud de inicio de sesión utilizando Axios
                    axios.post('<?= route('login.do') ?>', {
                            email: this.email,
                            password: this.password
                        })
                        .then(response => {
                            // Procesar la respuesta del servidor
                            console.log(response.data);
                            if (!response.data.login) {
                                app.no(response.data.message);

                            } else {
                                app.si(response.data.message);
                                window.location.href = './';

                            }
                            // Redirigir a la página de inicio después del inicio de sesión exitoso
                        })
                        .catch(error => {
                            // Mostrar mensaje de error en caso de fallo del inicio de sesión
                            // console.log(error);
                            app.no(error.response.data.message);
                        }).finally(t => {
                            app.loading = false;
                        });
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

            }
        });
    </script>
</body>

</html>