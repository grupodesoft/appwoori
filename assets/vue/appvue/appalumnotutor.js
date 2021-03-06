
var this_js_script = $('script[src*=appalumnotutor]');
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
        idalumno: my_var_2,
        addModal: false,
        editModal: false,
        cargando: false,
        error: false,
        //deleteModal:false,
        tutores: [],
        tutoresdisponibles: [],
        search: {text: ''},
        emptyResult: false,
        newTutor: {
            idalumno: my_var_2,
            idtutor: '',
            smserror: ''},
        chooseAlumno: {},
        formValidate: [],
        successMSG: '',

        //pagination
        currentPage: 0,
        rowCountPage: 10,
        totalTutores: 0,
        pageRange: 2,
        directives: {columnSortable}
    },
    created() {
        this.showAll();
        this.showAllTutoresDisponibles();
    },
    methods: {
        orderBy(sortFn) {
            // sort your array data like this.userArray
            this.tutores.sort(sortFn);
        },
        abrirAddModal() {
            $('#addTutor').modal('show');
        },
        showAll() {
            axios.get(this.url + "Alumno/showAllTutores/" + this.idalumno).then(function (response) {
                if (response.data.tutores == null) {
                    v.noResult()
                } else {
                    v.getData(response.data.tutores);
                }
            })
        },
        showAllTutoresDisponibles() {

            axios.get(this.url + "Alumno/showAllTutoresDisponibles/")
                    .then(response => (this.tutoresdisponibles = response.data.tutores));

        },
        searchTutor() {
            var formData = v.formData(v.search);
            axios.post(this.url + "Alumno/searchTutor/" + this.idalumno, formData).then(function (response) {
                if (response.data.tutores == null) {
                    v.noResult()
                } else {
                    v.getData(response.data.tutores);

                }
            })
        },
        addTutor() {
            v.error = false;
            v.cargando = true;
            var formData = v.formData(v.newTutor);
            axios.post(this.url + "Alumno/addTutorAlumno", formData).then(function (response) {
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
                        timer: 1500
                    });

                    v.clearAll();
                    v.clearMSG();
                }
            })
        },
        deleteTutor(id) {
            Swal.fire({
                title: 'Quitar Tutor?',
                text: "Realmente desea quitar el Tutor.",
                type: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Quitar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.value) {

                    axios.get(this.url + "Alumno/deleteTutor", {
                        params: {
                            id: id
                        }
                    }).then(function (response) {
                        if (response.data.error == false) {
                            //v.noResult()
                            v.clearAll();
                            v.clearMSG();
                            swal({
                                position: 'center',
                                type: 'success',
                                title: 'Quitado!',
                                showConfirmButton: false,
                                timer: 1500
                            });

                        } else {
                            swal("Información", response.data.msg.msgerror, "info")
                            v.cargando = false;
                        }
                    }).catch((error) => {
                        swal("Información", "No se puede quitar el Tutor..", "info")
                        v.cargando = false;
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
        getData(tutores) {
            v.emptyResult = false; // become false if has a record
            v.totalTutores = tutores.length //get total of user
            v.tutores = tutores.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

            // if the record is empty, go back a page
            if (v.tutores.length == 0 && v.currentPage > 0) {
                v.pageUpdate(v.currentPage - 1)
                v.clearAll();
            }
        },

        selectTutor(tutor) {
            v.chooseTutor = tutor;
            //console.log(alumno);
        },
        clearMSG() {
            setTimeout(function () {
                v.successMSG = ''
            }, 3000); // disappearing message success in 2 sec
        },
        clearAll() {
            $('#addTutor').modal('hide');
            v.newTutor = {
                idalumno: my_var_2,
                idtutor: '',
                smserror: ''};
            v.formValidate = false;
            v.addModal = false;
            v.editModal = false;
            //v.passwordModal=false;
            v.deleteModal = false;
            v.cargando = false;
            v.error = false;
            v.refresh();

        },
        noResult() {

            v.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
            v.tutores = null;
            v.totalTutores = 0 //remove current page if is empty

        },

        pageUpdate(pageNumber) {
            v.currentPage = pageNumber; //receive currentPage number came from pagination template
            v.refresh();
        },
        refresh() {
            v.search.text ? v.searchTutor() : v.showAll(); //for preventing

        }
    }
})
