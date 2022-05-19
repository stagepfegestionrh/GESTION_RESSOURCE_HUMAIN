<template>
    <div class="container">
        <div class="row mt-5">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">Table des utilisateurs</h3>

                <div class="card-tools">
                    <button class="btn btn-success" @click="newModal">Ajouter <i class="fas fa-user-plus fa-fw"></i></button>
                </div>
              </div>
              <!-- /.card-header -->
              <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                  <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Enregistré à</th>
                        <th>Modifier</th>
                  </tr>


                  <tr v-for="user in users" :key="user.id">

                    <td>{{user.id}}</td>
                    <td>{{user.nom}}</td>
                    <td>{{user.email}}</td>
                    <td>{{user.type | upText}}</td>
                    <td>{{user.created_at | myDate}}</td>

                    <td>
                        <a href="#" @click="editModal(user)">
                            <i class="fa fa-edit blue"></i>
                        </a>
                        /
                        <a href="#" @click="deleteUser(user.id)">
                            <i class="fa fa-trash red"></i>
                        </a>

                    </td>
                  </tr>
                </tbody></table>
              </div>
              <!-- /.card-body -->
            </div>
            <!-- /.card -->
          </div>
        </div>

    <!-- Modal -->
            <div class="modal fade" id="addNew" tabindex="-1" role="dialog" aria-labelledby="addNewLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Add New</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Update User's Info</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateUser() : createUser()">
                <div class="modal-body">
                     <div class="form-group">
                        <input v-model="form.nom" type="text" name="nom"
                            placeholder="nom"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('nom') }">
                        <has-error :form="form" field="nom"></has-error>
                    </div>
                     <div class="form-group">
                        <input v-model="form.prenom" name="prenom" id="prenom"
                        placeholder="prénom"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('prenom') }">
                        <has-error :form="form" field="prenom"></has-error>
                    </div>
                    <div class="form-group">
                        <input type="" v-model="form.CNE" name="CNE" id="CNE"
                        placeholder="CNE"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('CNE') }">
                        <has-error :form="form" field="CNE"></has-error>
                    </div>
                     <div class="form-group">
                        <input v-model="form.Matricule" name="Matricule" id="Matricule"
                        placeholder="Matricule"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('Matricule') }">
                        <has-error :form="form" field="Matricule"></has-error>
                    </div>
                    <div class="form-group">
                        <input v-model="form.Telephone" name="Telephone" id="Telephone"
                        placeholder="Telephone"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('Telephone') }">
                        <has-error :form="form" field="Telephone"></has-error>
                    </div>
                    <div class="form-group">
                        <select  name="Sex" v-model="form.Sex" id="Sex" class="form-control" :class="{ 'is-invalid': form.errors.has('Sex') }">
                            <option value="Homme">Homme</option>
                            <option value="Femme">Femme</option>
                            <option value="Autre">Autre</option>
                        </select>
                        <has-error :form="form" field="Sex"></has-error>
                    </div>
                    <div class="form-group">
                        <input type="Date" name="Date_naissance" v-model="form.Date_naissance" id="Date_naissance" class="form-control" :class="{ 'is-invalid': form.errors.has('Date_naissance') }">
                        <has-error :form="form" field="Date_naissance"></has-error>
                    </div>
                    <div class="form-group">
                        <textarea v-model="form.Adresse" name="Adresse" id="Adresse"
                        placeholder="Adresse"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('Adresse') }"></textarea>
                        <has-error :form="form" field="Adresse"></has-error>
                    </div>

                     <div class="form-group">
                        <input v-model="form.email" type="email" name="email"
                            placeholder="Email Address"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>
                    <div class="form-group">
                        <input type="Date" placeholder="Date_recrutement" name="Date_recrutement" v-model="form.Date_recrutement" id="Date_recrutement" class="form-control" :class="{ 'is-invalid': form.errors.has('Date_recrutement') }">
                        <has-error :form="form" field="Date_recrutement"></has-error>
                    </div>
                    <div class="form-group">
                        <input v-model="form.Intitule" name="Intitule" id="Intitule"
                        placeholder="Intitule"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('Intitule') }">
                        <has-error :form="form" field="Intitule"></has-error>
                    </div>
                    <div class="form-group">
                        <textarea v-model="form.bio" name="bio" id="bio"
                        placeholder="Short bio for user (Optional)"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                        <has-error :form="form" field="bio"></has-error>
                    </div>


                    <div class="form-group">
                        <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                            
                            <option value="admin">Administrateur</option>
                            <option value="user">utilisateur standard</option>
                            <option value="author">Auteur</option>
                        </select>
                        <has-error :form="form" field="type"></has-error>
                    </div>

                    <div class="form-group">
                        <input v-model="form.password" type="password" name="password" id="password"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('password') }">
                        <has-error :form="form" field="password"></has-error>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    <button v-show="editmode" type="submit" class="btn btn-success">Update</button>
                    <button v-show="!editmode" type="submit" class="btn btn-primary">Create</button>
                </div>

                </form>

                </div>
            </div>
        </div>      
    </div>
</template>
<script>
import swal from 'sweetalert2';

    export default {
        data() {
            return {
                editmode: false,
                users : {},
                form: new Form({
                    id:'',
                    nom : '',
                    prenom : '',
                    CNE : '',
                    Matricule : '',
                    Telephone : '',
                    Sex : '',
                    Date_naissance : '',
                    Adresse : '',
                    email: '',
                    Date_recrutement: '',
                    Intitule: '',
                    password: '',
                    type: '',
                    bio: '',
                    photo: ''
                })
            }
        },
        methods: {
            updateUser(){
                this.$Progress.start();
                // console.log('Editing data');
                this.form.put('api/user/'+this.form.id)
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
            editModal(user){
                this.editmode = true;
                this.form.reset();
                $('#addNew').modal('show');
                this.form.fill(user);
            },
            newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            deleteUser(id){
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
                                this.form.delete('api/user/'+id).then(()=>{
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
            loadUsers(){
                axios.get("api/user").then(({ data }) => (this.users = data.data))
            },

            createUser(){
                this.$Progress.start();
               
                this.form.post('api/user')
                .then(()=>{
                    swal.fire(
                        'Success',
                        'user created',
                        'success'
                        )
                    Fire.$emit('AfterCreate');
                    $('#addNew').modal('hide')
                    toast({
                        type: 'success',
                        title: 'User Created in successfully'
                        })
                    this.$Progress.finish();
                })
                .catch(()=>{
                    
                })
            }
        },
        created() {
           this.loadUsers();
           Fire.$on('AfterCreate',() => {
               this.loadUsers();
           });
        //    setInterval(() => this.loadUsers(), 3000);
        }

    }
</script>
