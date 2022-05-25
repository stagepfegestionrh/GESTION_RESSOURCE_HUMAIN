<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Liste des Services</h3>
                        <div class="card-tools">
                            <button class="btn btn-success" @click="newModal">Ajouter <i class="fas fa-user-plus fa-fw"></i></button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body table-responsive p-0">
                        <table class="table table-hover">
                            <tbody>
                                <tr>
                                    <th>Division</th>
                                    <th>Service</th>
                                    <th>Chef de service</th>
                                    <th>Enregistré à</th>
                                    <th>Modifier</th>
                                </tr>
                                <tr v-for="service in services" :key="service.id">
                                    <td>{{service.division}}</td>
                                    <td>{{service.service}}</td>
                                    <td>{{service.Chef_Service}}</td>
                                    <td>{{service.created_at | myDate}}</td>
                                    <td>
                                        <a href="#" @click="editModal(service)">
                                            <i class="fa fa-edit blue"></i>
                                        </a>
                                        /
                                        <a href="#" @click="deleteService(service.id)">
                                            <i class="fa fa-trash red"></i>
                                        </a>
                                        /
                                         <a href="#" @click="showService(service.id)">
                                            <i class="fas fa-eye green"></i>
                                        </a>
                                    </td>
                                 </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
           <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Ajouter un service</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Modification du service</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateService() : create_Service()">
            
                <div class="col-sm-6">
                     <div class="form-group">
                            <label>Chef du service:</label>
                            <select class='form-control' style="width: 470px;" v-model="form.Chef_Service">
                                <option v-for="user in this.users" :key="user.id" :value="user.id">{{ user.nom+" "+user.prenom }}</option>
                            </select>
                        </div>
                
                    <div class="form-group">
                        <input v-model="form.service" type="text" name="Services"   placeholder="Services" style="width: 470px;"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('Service') }">
                        <has-error :form="form" field="Service"></has-error>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fermer</button>
                    <button v-show="editmode" type="submit" class="btn btn-success">Mise à jour</button>
                    <button v-show="!editmode" type="submit" class="btn btn-primary">Créer</button>
                </div>

                </form>

                </div>
            </div>
            </div>
    </div>
</template>

<script>
import Form from 'vform';
import swal from 'sweetalert2';

export default {
        data() {
            return {
                editmode: false,
                users : {},
                services : {},
                form: new Form({
                    division:'',
                    service : '',
                    Chef_Service: '',
                })

            }

        },
        methods: {
            loadServices(){
                axios.get("api/service").then(({ data }) => (this.services = data.data))
            },
             UserServices(){
                axios.get("api/UserServices").then(({ data }) => (this.users=data.data))
            },
            editModal(service){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(service);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteService(id){
                swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {


                        // Send request to the server
                        if (result.value) {
                                this.form.delete('api/service/'+id).then(()=>{
                                        swal.fire(
                                            'Deleted!',
                                            'Your file has been deleted.',
                                            'success'
                                        )
                                    Fire.$emit('AfterCreate');
                                }).catch(()=> {
                                    swal("Failed!", "There was something wronge.", "warning");
                                });
                         }
                    })
            },
            create_Service(){
                this.$Progress.start();
               
                this.form.post('api/service')
                .then(()=>{
                    swal.fire(
                        'Success',
                        'service created',
                        'success'
                        )
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    toast({
                        type: 'success',
                        title: 'service Created in successfully'
                        })
                this.$Progress.finish();
                })
                .catch(()=>{
                    
                });
            },
            updateService(){
                this.$Progress.start();
              //console.log('Editing data');
                this.form.put('api/service/'+this.form.id)
               .then(() => {
              // success
                    $('#addNew').modal('hide');
                    swal.fire(
                        'Updated!',
                        'Information has been updated.',
                        'success'
                    )
                    this.$Progress.finish();
                    Fire.$emit('AfterCreate');
               })
              .catch(() => {
                    this.$Progress.fail();
               });
            },
        },

            created() {
                this.loadServices();
                this.UserServices();
                Fire.$on('AfterCreate',() => {
                 this.loadServices();
                this.UserServices();

           });
        //    setInterval(() => this.loadServices(), 3000);
            }
}
            



</script>

<style>

</style>