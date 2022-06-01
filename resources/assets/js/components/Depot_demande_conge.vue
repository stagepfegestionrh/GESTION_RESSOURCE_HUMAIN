<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Demande de congé</div>
    
                    <div class="card-body">
                        <div v-if="success != ''" class="alert alert-success" role="alert">
                          {{success}}
                        
                        
                        </div>
                        <div class="form-group" >
                             <strong>Du:</strong>
                        <input type="Date" name="Date_debut" v-model="form.Date_debut" id="Date_debut" class="form-control" :class="{ 'is-invalid': form.errors.has('Date_debut') }" style="width: 200px;">
                        <has-error :form="form" field="Date_debut"></has-error>
                         <strong>Au:</strong>
                         <input type="Date" name="Date_fin" v-model="form.Date_debut" id="Date_fin" class="form-control" :class="{ 'is-invalid': form.errors.has('Date_fin') }" style="width: 200px;">
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
                        <textarea v-model="form.bio" name="Commentaire" id="Commentaire"
                        placeholder="Commentaire pour les utilisateurs (Optionnel)"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('Commentaire') }"></textarea>
                        <has-error :form="form" field="Commentaire"></has-error>
                    </div>
                        <button class="btn btn-success mt-2">Valider</button>
                        </form>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
   
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },
        data() {
            return {
              name: '',
              file: '',
              success: '',
              active: false,
          
             form: new Form({
                    Date_debut:'',
                    Date_fin:'',
                    type:'',
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
            
        }
    }
</script>