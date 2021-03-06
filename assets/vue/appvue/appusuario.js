
var this_js_script = $('script[src*=appusuario]');
var my_var_1 = this_js_script.attr('data-my_var_1'); 
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
} 


Vue.config.devtools = true 
var v = new Vue({
   el:'#app',
    data:{
        url: my_var_1,
        addModal: false,
        editModal:false,
        passwordModal:false,
        //deleteModal:false,
        cargando:false,
        error:false,
        users:[],
        roles:[],
        planteles:[], 
        search: {text: ''},
        emptyResult:false,
        newUser:{
            usuario:'',
            nombre:'',
            apellidop:'',
            apellidom:'',
            rol:'',
            idplantel:'',
            activo:'', 
            smserror:''},
        chooseUser:{},
        formValidate:[],
        successMSG:'',

        //pagination
        currentPage: 0,
        rowCountPage:10,
        totalUsers:0,
        pageRange:2,
         directives: {columnSortable}
    },
     created(){
      this.showAll();
      this.allRol(); 
      this.allPlanteles();  
    },
    methods:{
         orderBy(sortFn) {
            // sort your array data like this.userArray
            this.users.sort(sortFn);
        },
      abrirAddModal() {
        $('#addRegister').modal('show');
      },
      abrirEditModal() {
        $('#editRegister').modal('show');
      },
      abrirChangeModal() {
        $('#changePassword').modal('show');
      },
         showAll(){ axios.get(this.url+"User/showAll").then(function(response){
                 if(response.data.users == null){
                     v.noResult()
                    }else{
                        v.getData(response.data.users);
                    }
            })
        },
        allRol(){
          axios.get(this.url +"User/showAllRoles")
          .then(response => (this.roles = response.data))

        }, 
         allPlanteles(){
           axios.get(this.url+"User/showAllPlanteles")
          .then(response => (
            this.planteles = response.data

            ))

        }, 
          searchUser(){
            var formData = v.formData(v.search);
              axios.post(this.url+"User/searchUser", formData).then(function(response){
                  if(response.data.users == null){
                      v.noResult()
                    }else{
                      v.getData(response.data.users);

                    }
            })
        },
          addUser(){
            v.cargando = true;
            v.error =  false;
            var formData = v.formData(v.newUser);
              axios.post(this.url+"User/addUser", formData).then(function(response){
                if(response.data.error){
                    v.formValidate = response.data.msg;
                    v.error = true;
                    v.cargando = false;
                }else{
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
        updateUser(){
          v.cargando = true;
          v.error = false;
            var formData = v.formData(v.chooseUser); axios.post(this.url+"User/updateUser", formData).then(function(response){
                if(response.data.error){
                    v.formValidate = response.data.msg;
                   v.error = true;
                   v.cargando = false;
                }else{
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
          passwordupdateUser(){
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.chooseUser); axios.post(this.url+"User/passwordupdateUser", formData).then(function(response){
                if(response.data.error){
                    v.formValidate = response.data.msg;
                    v.error = true;
                    v.cargando = false;
                }else{

                      swal({
                            position: 'center',
                            type: 'success',
                            title: 'Modificado!',
                            showConfirmButton: false,
                            timer: 3000
                          });
                    v.successMSG = response.data.success;
                    v.clearAll();
                    v.clearMSG();

                }
            })
        },
       /* deleteUser(){
             var formData = v.formData(v.chooseUser);
              axios.post(this.url+"user/deleteUser", formData).then(function(response){
                if(!response.data.error){
                     v.successMSG = response.data.success;
                    v.clearAll();
                    v.clearMSG();
                }
            })
        },*/
         formData(obj){
			var formData = new FormData();
		      for ( var key in obj ) {
		          formData.append(key, obj[key]);
		      }
		      return formData;
		},
        getData(users){
            v.emptyResult = false; // become false if has a record
            v.totalUsers = users.length //get total of user
            v.users = users.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination

             // if the record is empty, go back a page
            if(v.users.length == 0 && v.currentPage > 0){
            v.pageUpdate(v.currentPage - 1)
            v.clearAll();
            }
        },

        selectUser(user){
            v.chooseUser = user; 
        },
        clearMSG(){
            setTimeout(function(){
			 v.successMSG=''
			 },3000); // disappearing message success in 2 sec
        },
        clearAll(){
          $('#editRegister').modal('hide');
          $('#addRegister').modal('hide');
          $('#changePassword').modal('hide');
            v.newUser = {
            usuario:'',
            name:''};
            v.formValidate = false;
            v.addModal= false;
            v.editModal=false;
            v.passwordModal=false;
            v.deleteModal=false;
            v.cargando = false;
            v.error = false;
            v.refresh()

        },
        noResult(){

               v.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
                      v.users = null
                     v.totalUsers = 0 //remove current page if is empty

        },


        pageUpdate(pageNumber){
              v.currentPage = pageNumber; //receive currentPage number came from pagination template
                v.refresh()
        },
        refresh(){
             v.search.text ? v.searchUser() : v.showAll(); //for preventing

        }
    }
})
