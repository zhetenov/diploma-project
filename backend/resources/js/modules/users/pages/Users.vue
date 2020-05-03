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
                    <UserInfo :data="currentUserData"/>
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
                                <CsvParser />
                           </div>
                           <!-- /.card-body -->
                       </div>
                       <!-- /.card -->
                   </div>
               </div>

                <div class="row">

                    <div class="col-lg-12">
                        <!-- /.card -->
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">User Classification</h3>
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered">
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
                                        <td>
                                            <a href="javascript:void(0)"
                                               class="btn btn-primary"
                                               @click="showModal(user.data)">
                                                Statistics
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-right">
                                    <li class="page-item"><button :disabled="pageNumber === 1" class="dis page-link" @click="prevPage">Prev</button></li>
                                    <li class="page-item"><button :disabled="pageNumber === users.meta.last_page" class="dis page-link" @click="nextPage">Next</button></li>
                                </ul>
                            </div>
                        </div>
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
    import CsvParser from '../components/CsvParser'
    import UserInfo from '../components/UserInfo'
    import PulseLoader from 'vue-spinner/src/PulseLoader.vue'

    export default {
        components: {
            CsvParser,
            UserInfo,
            PulseLoader
        },
        data() {
            return {
                currentUserData: null,
                pageNumber: 1
            }
        },
        computed: {
            ...mapGetters({
                users: 'getUsers',
                loading: 'getLoading',
            })
        },
        created() {
            this.fetchUsers()
        },
        methods: {
            fetchUsers(page = 1) {
                this.$store.dispatch('fetchUsers', page)
            },
            showModal(data) {
                this.currentUserData = data
                $('#modal-xl').modal('show')
            },
            nextPage(){
                this.fetchUsers(++this.pageNumber)
            },
            prevPage(){
                this.fetchUsers(--this.pageNumber)
            }
        }
    }
</script>

<style>
    .dis:disabled {
        color: #000;

    }
    .dis:disabled:hover {
        background-color:#fff;
    }
</style>
