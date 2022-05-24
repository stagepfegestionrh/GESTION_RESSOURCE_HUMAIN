<template>
    <div class="container">
        <div class="row mt-5">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Table des divisions</h3>
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
                                    <th>Division</th>
                                    <th>Chef de division</th>
                                    <th>Modifier</th>
                                </tr>
                                <tr v-for="div in divisions" :key="div.id">
                                    <td>{{div.id}}</td>
                                    <td>{{div.Division}}</td>
                                    <td>{{div.Chefdivision}}</td>
                                    <td>
                                        <a href="#" @click="editModal(div)">
                                            <i class="fa fa-edit blue"></i>
                                        </a>
                                        /
                                        <a href="#" @click="deleteUser(div.id)">
                                            <i class="fa fa-trash red"></i>
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
                    <h5 class="modal-title" v-show="!editmode" id="addNewLabel">Ajouter une divison</h5>
                    <h5 class="modal-title" v-show="editmode" id="addNewLabel">Modification de la division</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form @submit.prevent="editmode ? updateUsDivision() : createDivision()">
                <div class="modal-body">
                     <div class="form-group">
                        <input v-model="form.name" type="text" name="name"
                            placeholder="Name"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('name') }">
                        <has-error :form="form" field="name"></has-error>
                    </div>

                     <div class="form-group">
                        <input v-model="form.email" type="email" name="email"
                            placeholder="Email Address"
                            class="form-control" :class="{ 'is-invalid': form.errors.has('email') }">
                        <has-error :form="form" field="email"></has-error>
                    </div>

                     <div class="form-group">
                        <textarea v-model="form.bio" name="bio" id="bio"
                        placeholder="Short bio for user (Optional)"
                        class="form-control" :class="{ 'is-invalid': form.errors.has('bio') }"></textarea>
                        <has-error :form="form" field="bio"></has-error>
                    </div>


                    <div class="form-group">
                        <select name="type" v-model="form.type" id="type" class="form-control" :class="{ 'is-invalid': form.errors.has('type') }">
                            <option value="">Select User Role</option>
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
export default {
        data() {
            return {
                editmode: false,
                divisions : {},
                form: new Form({
                    id:'',
                    Division : '',
                    Chefdivision: '',
                })
            }
        },
        methods: {
               loadDivisions(){
                axios.get("api/division").then(({ data }) => (this.divisions = data.data))
            },
                newModal(){
                this.editmode = false;
                this.form.reset();
                $('#addNew').modal('show');
            },
            newDivModal(){
                this.editmode = false;
                this.form.reset();
                $('#showService').madal('show');
            }

        },
         created() {
           this.loadDivisions();
           Fire.$on('AfterCreate',() => {
               this.loadDivisions();
           });
        //    setInterval(() => this.loadUsers(), 3000);
        }
            

}
</script>

<style>

</style>