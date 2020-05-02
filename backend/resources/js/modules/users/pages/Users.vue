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
                        <div class="card">
                            <div class="card-header">
                                <PulseLoader :loading="loading"></PulseLoader>
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
                            <div class="card-body table-responsive p-0" >
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
                currentUserData: null
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
