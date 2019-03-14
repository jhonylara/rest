// AUTOR: Jhony Lara
// DATA: 13/03/2019
// https://www.linkedin.com/in/jhonylara/
// "Sempre achei que o tempo não passava, hoje me arrependo de o tempo ter passado." 
var app = new Vue({
    el: "#root",
    data: {
            usuarios: [],
            novoUsuario: {email: "", username: "", nome: "", senha: ""},
            usuarioSel: {},
            loginUsuario: '',
            loginSenha: '',
            logado : '',
            chave : 'jhony12ed21d1t14',
            nome : '',
            pesquisaNome: ''
    },

    mounted: function(){
        //Quando loga a primeira vez no navegador
        if (!localStorage.logado){
            localStorage.setItem('logado', 'nao');
            location.reload();
        }
        this.retornarUsuarios();
    },
    

    methods: {
        //Requisicao que busca todos usuarios
        retornarUsuarios: function(){
            //Passa a chave padrao
            var form_data = new FormData();           
            form_data.append('logado', localStorage.getItem('logado'));
            form_data.append('chave', 'jhony12ed21d1t14');
            axios.post("http://localhost/rest/api/usuarios", form_data).then(function(response){
                if(response.status != 200){
                    app.limparAvisos();
                    localStorage.setItem('erro', 'true');
                    localStorage.setItem('mensagemErro', response.data + ' ERRO');
                    location.reload();
                } else{
                    app.usuarios = response.data;
                    app.limparAvisos();
                }
            });
        },

        //Requisicao que inclui usuario
        incluirUsuario: function(){
            //Validacao dos inputs
            if(app.novoUsuario.nome == null || app.novoUsuario.email == null || app.novoUsuario.senha == null ||  app.novoUsuario.username == null ||
                   app.novoUsuario.nome == '' || app.novoUsuario.email == '' || app.novoUsuario.senha == '' ||  app.novoUsuario.username == '' ){
                app.limparAvisos();
                localStorage.setItem('erro', 'true');
                localStorage.setItem('mensagemErro', 'todos os campos são obrigatorios para incluir usuario');
                location.reload();
            }else{
                //Passa a chave padrao
                var formData = app.toFormData(app.novoUsuario);
                formData.append('chave', app.chave);
                axios.post("http://localhost/rest/api/adicionarUsuario", formData,).then(function(response){

                    app.novoUsuario = {email: "", username: "", nome: "", senha: ""};

                    if(response.status != 200){
                        app.limparAvisos();
                        localStorage.setItem('erro', 'true');
                        localStorage.setItem('mensagemErro', response.data + ' ERRO');
                        location.reload();
                    } else{
                        app.limparAvisos();
                        localStorage.setItem('sucesso', 'true');
                        localStorage.setItem('mensagemSucesso', 'Usuario incluido com sucesso');
                        location.reload();
                        app.retornarUsuarios();
                    }
                });
            }
        },

        //Requisicao que altera usuario
        alterarUsuario: function(){
            //Validacao dos inputs
            if(app.usuarioSel.nome == null || app.usuarioSel.email == null || app.usuarioSel.senha == null || app.usuarioSel.id == null || app.usuarioSel.username == null||
                   app.usuarioSel.nome == '' || app.usuarioSel.email == '' || app.usuarioSel.senha == '' ||  app.usuarioSel.username == '' ){
                app.limparAvisos();
                localStorage.setItem('erro', 'true');
                localStorage.setItem('mensagemErro', 'todos os campos são obrigatorios para alterar usuario');
                location.reload();
            }else{
            //Passa a chave padrao
            var formData = app.toFormData(app.usuarioSel);
            formData.append('chave', app.chave);
            axios.post("http://localhost/rest/api/alterarUsuario", formData).then(function(response){               
                app.usuarioSel = {};
                if(response.status != 200){
                    app.limparAvisos();
                    localStorage.setItem('erro', 'true');
                    localStorage.setItem('mensagemErro', response.data + ' ERRO');
                    location.reload();
                } else{
                    app.limparAvisos();
                    localStorage.setItem('sucesso', 'true');
                    localStorage.setItem('mensagemSucesso', 'Usuario alterado com sucesso');
                    app.retornarUsuarios();
                    location.reload();
                }
            });
            }
        },

        //Requisicao quando efetua remoção de usuario
        deletarUsuario: function(){
            var formData = app.toFormData(app.usuarioSel);
            //Se a pessoa "se excluir" desloga
            if(app.usuarioSel.username == localStorage.username){
                localStorage.setItem('nome', '');
                localStorage.setItem('username', '');
                localStorage.setItem('logado', 'nao');
            }
            //Passa a chave padrao
            formData.append('chave', app.chave);
            axios.post("http://localhost/rest/api/deletarUsuario", formData).then(function(response){				
                app.usuarioSel = {};
                if(response.status != 200){
                    app.limparAvisos();
                    localStorage.setItem('erro', 'true');
                    localStorage.setItem('mensagemErro', response.data + ' ERRO');
                    location.reload(); 
                } else{
                    app.limparAvisos();
                    localStorage.setItem('sucesso', 'true');
                    localStorage.setItem('mensagemSucesso', 'Usuario deletado com sucesso');
                    app.retornarUsuarios();
                    location.reload();
                }
            });
        },

        //Requisicao quando efetua pesquisa
        validarLogin: function(){
            //Validacao dos inputs
            if(app.loginUsuario == null || app.loginSenha == null ||  app.loginUsuario == '' ||  app.loginSenha == '' ){
                app.limparAvisos();
                localStorage.setItem('erro', 'true');
                localStorage.setItem('mensagemErro', 'Preencha login e senha!');
                location.reload();
            }else{
                //Passa a chave padrao
                var form_data = new FormData();           
                form_data.append('username', app.loginUsuario);
                form_data.append('senha', app.loginSenha);
                form_data.append('chave', 'jhony12ed21d1t14');

                axios.post("http://localhost/rest/api/autenticacao", form_data).then(function(response){
                    if(response.data == 'erroauth'){
                        app.limparAvisos();
                        localStorage.setItem('erro', 'true');
                        localStorage.setItem('mensagemErro','Login e senha não conferem');
                        location.reload();
                    }else{
                        if (response.data.username == 'admin') {
                            localStorage.setItem('logado', 'admin');
                            localStorage.setItem('nome', response.data.nome);
                            localStorage.setItem('username', response.data.username);
                            location.reload();

                        }else{
                            localStorage.setItem('logado', 'user');
                            localStorage.setItem('nome', response.data.nome);
                            localStorage.setItem('username', response.data.username);
                            location.reload();

                        }
                    }
                });
            }
        },

        //Requisicao quando efetua pesquisa
        filtrarUsuarios: function(){
            var form_data = new FormData();     
            //Passa a chave padrao
            form_data.append('logado', localStorage.getItem('logado'));
            form_data.append('chave', 'jhony12ed21d1t14');
            form_data.append('pesquisa', app.pesquisaNome);

            axios.post("http://localhost/rest/api/buscaUsuarios", form_data).then(function(response){
                if(response.status != 200){
                    console.log(response.data.message); 
                } else{
                    app.usuarios = response.data;
                }
            });
        },
        
        //Reseta se a pessoa sai do sistema
        sairLogin: function(){
            localStorage.setItem('logado', 'nao');
            localStorage.setItem('nome', '');
            app.limparAvisos();
            location.reload();
        },

        // Pegar o usuario da td
        selecionaUsuario(usuario){
            app.usuarioSel = usuario;
        },

        // Função pronta para montar obj
        toFormData: function(obj){
            var form_data = new FormData();
            for ( var key in obj ) {
                form_data.append(key, obj[key]);
            } 
            return form_data;
        },

        // Usado internamente evitar codigo
        limparAvisos: function(){
            localStorage.setItem('erro', 'false');
            localStorage.setItem('mensagemErro', '');
            localStorage.setItem('sucesso', 'false');
            localStorage.setItem('mensagemSucesso', '');
        },    

        // Usado nas divs de erro e sucesso
        fecharAvisos: function(){
            app.limparAvisos();
            location.reload();
        },  
        
    }
});

