<template>
    <div class="container">
        <div class="row justify-content-center mt-5">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">Demande des Documents RH</div>
    
                    <div class="card-body">
                        <div v-if="success != ''" class="alert alert-success" role="alert">
                          {{success}}
                        
                        
                        </div>
                        
                    <div>
                      <div class="form-group " >
                            <label>Type de document :  </label>
                            <select class='form-control' v-model="form.type">
                                <option>Certificat de travail</option>
                                <option>Etat d'engagement</option>
                            </select>

                        </div>
                          
                        </div>
                          <div class="form-group " >
                            <label>Langue de document : </label>
                            <select class='form-control' v-model="form.type">
                                <option>Français</option>
                                <option>Arabe</option>
                            </select>

                        </div>
                        <div class="form-group mt-4">
                        <textarea v-model="form.bio" name="Commentaire" id="Commentaire"
                        placeholder="Commentaire pour les utilisateurs (Optionnel)"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('Commentaire') }"></textarea>
                        <has-error :form="form" field="Commentaire"></has-error>
                    </div>
                        <button class="btn btn-success mt-2">Valider</button>
                     
                        
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
              control:'',
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
            }
        }
    }
</script>