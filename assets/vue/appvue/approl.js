
var this_js_script = $('script[src*=approl]');
var my_var_1 = this_js_script.attr('data-my_var_1'); 
if (typeof my_var_1 === "undefined") {
    var my_var_1 = 'some_default_value';
} 


Vue.component('modal',{ //modal
    template:`
   <transition name="modal">
      <div class="modal-mask">
        <div class="modal-wrapper">
          <div class="modal-dialog">
			    <div class="modal-content">
			      

			      <div class="modal-header">
				        <h5 class="modal-title"> <slot name="head"></slot></h5> 
               </div>

			      <div class="modal-body" style="background-color:#fff;">
			         <slot name="body"></slot>
			      </div>
			      <div class="modal-footer">

			         <slot name="foot"></slot>
			      </div>
			    </div>
          </div>
        </div>
      </div>
    </transition> 
    `
})
var v = new Vue({
   el:'#app',
    data:{
       url:my_var_1,
        addModal: false,
        editModal:false,
        //passwordModal:false,
        //deleteModal:false,
        cargando:false,
        error:false,
        roles:[],
        search: {text: ''},
        emptyResult:false,
        newRol:{
            rol:''
          },
        chooseRol:{},
        formValidate:[],
        successMSG:'',
        
        //pagination
        currentPage: 0,
        rowCountPage:5,
        totalRoles:0,
        pageRange:2,
         directives: {columnSortable}
    },
     created(){
      this.showAll(); 
    },
    methods:{
        orderBy(sortFn) {
            // sort your array data like this.userArray
            this.roles.sort(sortFn);
      }, 
      abrirAddModal() {
        $('#addRegister').modal('show');
      },
      abrirEditModal() {
        $('#editRegister').modal('show');
      },
         showAll(){ axios.get(this.url+"Rol/showAll").then(function(response){
                 if(response.data.roles == null){
                     v.noResult()
                    }else{
                        v.getData(response.data.roles);
                    }
            })
        },
          searchUser(){
            var formData = v.formData(v.search);
              axios.post(this.url+"Rol/searchRol", formData).then(function(response){
                  if(response.data.roles == null){
                      v.noResult()
                    }else{
                      v.getData(response.data.roles);
                    
                    }  
            })
        },
          addRol(){   
            v.cargando = true;
            v.error = false;
            var formData = v.formData(v.newRol);
              axios.post(this.url+"Rol/addRol", formData).then(function(response){
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
        updateRol(){
          v.cargando = true;
          v.error = false;
            var formData = v.formData(v.chooseRol); axios.post(this.url+"Rol/updateRol", formData).then(function(response){
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
        getData(roles){
            v.emptyResult = false; // become false if has a record
            v.totalRoles = roles.length //get total of user
            v.roles = roles.slice(v.currentPage * v.rowCountPage, (v.currentPage * v.rowCountPage) + v.rowCountPage); //slice the result for pagination
            
             // if the record is empty, go back a page
            if(v.roles.length == 0 && v.currentPage > 0){ 
            v.pageUpdate(v.currentPage - 1)
            v.clearAll();  
            }
        },
            
        selectRol(rol){
            v.chooseRol = rol; 
        },
        clearMSG(){
            setTimeout(function(){
			 v.successMSG=''
			 },3000); // disappearing message success in 2 sec
        },
        clearAll(){
          $('#editRegister').modal('hide');
          $('#addRegister').modal('hide');
            v.newRol = { 
            rol:'' };
            v.formValidate = false;
            v.addModal= false;
            v.editModal=false; 
            v.deleteModal=false;
            v.cargando = false;
            v.error = false;
            v.refresh()
            
        },
        noResult(){
          
               v.emptyResult = true;  // become true if the record is empty, print 'No Record Found'
                      v.roles = null 
                     v.totalRoles = 0 //remove current page if is empty
            
        },

       
        pageUpdate(pageNumber){
              v.currentPage = pageNumber; //receive currentPage number came from pagination template
                v.refresh()  
        },
        refresh(){
             v.search.text ? v.searchRol() : v.showAll(); //for preventing
            
        }
    }
})