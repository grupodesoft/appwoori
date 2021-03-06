
var this_js_script = $('script[src*=appgrupo]');
var my_var_1 = this_js_script.attr('data-my_var_1');
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
}
var my_var_2 = this_js_script.attr('data-my_var_2');
if (typeof my_var_2 === "undefined") {
    var my_var_2 = 'some_default_value';
}


Vue.config.devtools = true;
var v = new Vue({
    el: '#app',
    data: {
        url: my_var_1,
        idniveleducativo: my_var_2,
        addModal: false,
        editModal: false,
        cargando: false,
        error: false,
        //deleteModal:false,
        grupos: [],
        niveles: [],
        especialidades: [],
        turnos: [],
        search: {text: ''},
        emptyResult: false,
        newGrupo: {
            idespecialidad: '',
            idnivelestudio: '',
            idturno: '',
            nombregrupo: '',
            smserror: ''},
        chooseGrupo: {},
        formValidate: [],
        successMSG: '',

        //pagination
        currentPage: 0,
        rowCountPage: 10,
        totalGrupos: 0,
        pageRange: 2,
        directives: {columnSortable}
    },
    created() {
        this.showAll();
        this.showAllTurnos();
        this.showAllNiveles();
        this.showAllEspecialidades();
    },
    methods: {
        orderBy(sortFn) {
            // sort your array data like this.userArray
            this.grupos.sort(sortFn);
        }, abrirAddModal() {
            $('#addRegister').modal('show');
        },
        abrirEditModal() {
            $('#editRegister').modal('show');
        },
        showAll() {
            axios.get(this.url + "Grupo/showAll").then(function (response) {
                if (response.data.grupos == null) {
                    v.noResult()
                } else {
                    v.getData(response.data.grupos);
                }
            })
        },
        showAllEspecialidades() {
            axios.get(this.url + "Grupo/showAllEspecialidades/")
                    .then(response => (this.especialidades = response.data.especialidades));

        },
        showAllTurnos() {
            axios.get(this.url + "Grupo/showAllTurnos/")
                    .then(response => (this.turnos = response.data.turnos));

        },
        showAllNiveles() {
            axios.get(this.url + "Grupo/showAllNiveles/")
                    .then(response => (this.niveles = response.data.niveles));

        },
        searchGrupo() {
            var formData = v.formData(v.search);
            axios.post(this.url + "Grupo/searchGrupo", formData).then(function (response) {
                if (response.data.grupos == null) {
                    v.noResult()
                } else {
                    v.getData(response.data.grupos);

                }
            })
        },
        addGrupo() {
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.newGrupo);
            axios.post(this.url + "Grupo/addGrupo", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.error = true;
                    v.cargando = false;
                } else {
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Exito!',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    v.clearAll();
                    v.clearMSG();
                }
            })
        },
        updateGrupo() {
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.chooseGrupo);
            axios.post(this.url + "Grupo/updateGrupo", formData).then(function (response) {
                if (response.data.error) {
                    v.formValidate = response.data.msg;
                    v.error = true;
                    v.cargando = false;
                } else {
                    //v.successMSG = response.data.success;
                    swal({
                        position: 'center',
                        type: 'success',
                        title: 'Modificado!',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    v.clearAll();
                    v.clearMSG();

                }
            })
        },
        deleteGrupo(id) {
            Swal.fire({
                title: '¿Eliminar Grupo?',
                text: "Realmente desea eliminar el Grupo.",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Eliminar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {

                    axios.get(this.url + "Grupo/deleteGrupo", {
                        params: {
                            idgrupo: id
                        }
                    }).then(function (response) {
                          if (response.data.error == false) {
                            //v.noResult()
                            swal({
                                position: 'center',
                                type: 'success',
                                title: 'Eliminado!',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            v.clearAll();
                            v.clearMSG();
                        } else {
                            swal("Información",  response.data.msg.msgerror, "info")
                        }
                    }).catch((error) => {
                        swal("Información", "No se puede eliminar el Grupo", "info")
                    })
                }
            })
        },
        formData(obj) {
            var formData = new FormData();
            for (var key in obj) {
                formData.append(key, obj[key]);
            }
            return formData;
        },
        getData(grupos) {
            v.emptyResult = false; // become false if has a record
            v.totalGrupos = grupos.length //get total of user
            v.grupos = grupos.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

            // if the record is empty, go back a page
            if (v.grupos.length == 0 && v.currentPage > 0) {
                v.pageUpdate(v.currentPage - 1)
                v.clearAll();
            }
        },

        selectGrupo(grupo) {
            v.chooseGrupo = grupo; 
        },
        clearMSG() {
            setTimeout(function () {
                v.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            $('#editRegister').modal('hide');
            $('#addRegister').modal('hide');
            v.newGrupo = {
                idnivelestudio: '',
                idespecialidad: '',
                idturno: '',
                nombregrupo: '',
                smserror: ''};
            v.formValidate = false;
            v.addModal = false;
            v.editModal = false;
            v.cargando = false;
            v.error = false; 
              v.refresh();    
        },
        noResult() { 
            v.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
            v.grupos = null;
            v.totalGrupos = 0;//remove current page if is empty 
        }, 
        pageUpdate(pageNumber) {
            v.currentPage = pageNumber; //receive currentPage number came from pagination template
            v.refresh();
        },
        refresh() {
            v.search.text ? v.searchGrupo() : v.showAll(); //for preventing

        }
    }
})
