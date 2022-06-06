<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Demande de congé</div>
                    <form @submit.prevent=" create_demande()">

                        <div class="card-body">
                            <div class="form-group" >
                                 <strong>Du:</strong>
                            <input type="Date" name="Date_debut" v-model="form.Date_debut" id="Date_debut" class="form-control" :class="{ 'is-invalid': form.errors.has('Date_debut') }" style="width: 200px;">
                            <has-error :form="form" field="Date_debut"></has-error>
                             <strong>Au:</strong>
                             <input type="Date" name="Date_fin" v-model="form.Date_fin" id="Date_fin" class="form-control" :class="{ 'is-invalid': form.errors.has('Date_fin') }" style="width: 200px;">
                            <has-error :form="form" field="Date_fin"></has-error>
                        </div>
                        <div>
                          <div class="form-group">
                                <label>Type de congé : </label>
                                <select class='form-control' v-model="form.type" @change="showCerti($event)" >
                                 <!--click to show-->
                                    <option  value="1">Congé de Maladie</option>
                                    <option  value="2" >Congé de Maternité</option>
                                    <option  value="3">Congé Normal</option>
                                </select>
                            </div>
                            <!--show Upload button-->
                            <div id="showcerti" v-show="active">
                              <strong>Certificat:</strong>
                            <input type="file" class="form-control" v-on:change="onFileChange">
                            </div>
                              </div>
                            <form @submit="formSubmit" enctype="multipart/form-data">
                            <div class="form-group mt-4">
                            <textarea v-model="form.Commentaire" name="Commentaire" id="Commentaire"
                            placeholder="Commentaire pour les utilisateurs (Optionnel)"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('Commentaire') }"></textarea>
                            <has-error :form="form" field="Commentaire"></has-error>
                        </div>
                            </form>
                            <button class="btn btn-success mt-2" >Valider</button>
                    </div>
                    </form>
                        
                </div>
            </div>
        </div>
    </div>
</template>
   
<script>
import { exit } from 'process';
    export default {
        data() {
            return {             
                active: false,

                form: new Form({
                        date_debut:'',
                        date_fin:'',
                        type:'',
                        durée: '',
                        Commentaire:''
                    })
            };
        },
        methods: {
            onFileChange(e){
                console.log(e.target.files[0]);
                this.file = e.target.files[0];
            },
            formSubmit(e) {
                e.preventDefault();
                let currentObj = this;
   
                const config = {
                    headers: { 'content-type': 'multipart/form-data' }
                }
    
                let formData = new FormData();
                formData.append('file', this.file);
   
                axios.post('/formSubmit', formData, config)
                .then(function (response) {
                    currentObj.success = response.data.success;
                })
                .catch(function (error) {
                    currentObj.output = error;
                });
            },
            showCerti(event) {
                   if(event.target.value == 1){
                   this.active=true;
                   }else{
                   this.active=false; 
                }    
            },
            create_demande(){
                this.$Progress.start();
                this.form.post('api/demande_conge')
                .then(()=>{
                    swal.fire(
                        'Success',
                        'demande created',
                        'success'
                        )
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    toast({
                        type: 'success',
                        title: 'demande Created in successfully'
                        })
                this.$Progress.finish();
                })
                .catch(()=>{
                    
                });
                
            },
            
        },
        created() {
               
            Fire.$on('AfterCreate',() => {

        });
        //    setInterval(() => this.loadServices(), 3000);
            }
    }
</script>