<template>
    <div>
       <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">RFM</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">RFM</li>
                        </ol>
                    </div><!-- /.col -->

                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <div class="content">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Rfm graph</h3>
                                <div class="card-tools">
                                    <ul class="nav nav-pills ml-auto">
                                        <li class="nav-item">
                                            <a class="nav-link active" @click="calculateRfm"  data-toggle="tab" style="cursor: pointer;">Calculate</a>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                            <div class="card-content">
                                <div class="row">
                                    <div class="card-body">
                                        <div class="tab-content p-0">
                                            <Scatter :chartData="classifications" :height="300"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Users Classification</h3>
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
                            <div class="card-content">
                                <div class="row">
                                    <div class="card-body table-responsive p-0" >
                                        <table class="table table-hover" style="text-align:center;">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>USER ID</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Recency</th>
                                                <th>Frequency</th>
                                                <th>Monetary</th>
                                                <th>RFM Score</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <tr v-for="(user, index) in users.data">
                                                <td>{{ index + 1 }}</td>
                                                <td>{{ user.client_id}}</td>
                                                <td>{{ user.name }}</td>
                                                <td>{{ user.email }}</td>
                                                <td>{{ user.recency }}</td>
                                                <td>{{ user.frequency }}</td>
                                                <td>{{ user.monetary }}</td>
                                                <td>{{ user.score }}</td>

                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
            <!-- /.container-fluid -->

        </div>
    </div>
</template>

<script>
    import Scatter from '../components/RfmScatter'
    import {mapGetters} from 'vuex'

    export default {
        components: {
            Scatter
        },
        computed: {
            ...mapGetters({
                classifications: 'getClassifications',
                users: 'getUsersWithoutGraph',
            })
        },
        data() {
            return {

            }
        },
        name: "RFM",
        created() {
            this.$store.dispatch('fetchRfm')
            this.fetchUsers()
        },
        methods: {
            calculateRfm() {
                this.$store.dispatch('makeClassification')
                    .then(res => {
                        this.$store.dispatch('fetchRfm')
                    })
            },
            fetchUsers(page = 1) {
                this.$store.dispatch('fetchUsersWithoutGraph', page)
            },
        }
    }
</script>

<style scoped>

</style>
