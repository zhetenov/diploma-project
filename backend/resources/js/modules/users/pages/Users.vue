<template>

    <div>
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">Users</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Users</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <div class="content">

            <div class="container-fluid">
               <div class="row">
                   <div class="col-md-12">
                       <div class="card">
                           <div class="card-header">
                               <h3 class="card-title">Upload data</h3>
                           </div>
                           <!-- /.card-header -->
                           <div class="card-body">
                               <div class="form-group">
                                   <label for="exampleInputFile">File input</label>
                                   <input type="file" id="exampleInputFile">

                                   <p class="help-block">Only csv, txt format</p>
                               </div>
                           </div>
                           <!-- /.card-body -->
                       </div>
                       <!-- /.card -->
                   </div>
               </div>

                <div class="row">

                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">All unique users</h3>

                                <div class="card-tools">
                                    <paginate
                                            :page-count="users.meta.last_page"
                                            :click-handler="fetchUsers"
                                            :prev-text="'Prev'"
                                            :next-text="'Next'"
                                            :container-class="'pagination'"
                                            :page-class="'page-link'"
                                            :break-view-class="'item'"
                                    >
                                    </paginate>
                                </div>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body table-responsive p-0" style="height: 300px;">
                                <table class="table table-hover" style="text-align:center;">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>USER ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>See statistics</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(user, index) in users.data">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ user.client_id}}</td>
                                        <td>{{ user.name }}</td>
                                        <td>{{ user.email }}</td>
                                        <td><a href=""><i style="color:green;" class="fab fa-shopify fa-lg"></i></a></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <!-- /.card -->
                    </div>

                </div>

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /.content -->

    </div>

</template>

<script>
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {

            }
        },
        computed: {
            ...mapGetters({
                users: 'getUsers',
            })
        },
        created() {
            this.fetchUsers()
        },
        methods: {
            fetchUsers(page = 1) {
                console.log(page);
                this.$store.dispatch('fetchUsers', page)
            }
        }
    }
</script>

<style>
    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
    }
    .page-link {
        position: relative;
        color: #0d6efd;
        background-color: #fff;
    }

</style>
