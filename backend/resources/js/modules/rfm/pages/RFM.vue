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
                    <div class="col-md-8">

                        <div class="card">
                            <div class="card-header">
                                <div  v-if="classifications.status" class="ribbon-wrapper">
                                    <div v-if="classifications.status == 'success'" class="ribbon bg-success">
                                        {{ classifications.status ? classifications.status: '' }}
                                    </div>
                                    <div v-if="classifications.status == 'processing'" class="ribbon bg-primary">
                                        {{ classifications.status ? classifications.status: '' }}
                                    </div>
                                </div>
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
                                        <ul class="nav nav-tabs" id="custom-content-below-tab" role="tablist">
                                            <li class="nav-item">
                                                <a class="nav-link active" id="custom-content-below-home-tab" data-toggle="pill" href="#custom-content-below-home" role="tab" aria-controls="custom-content-below-home" aria-selected="false">Manual way</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link" id="custom-content-below-profile-tab" data-toggle="pill" href="#custom-content-below-profile" role="tab" aria-controls="custom-content-below-profile" aria-selected="false">KMeans</a>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="custom-content-below-tabContent">
                                            <div class="tab-pane fade show active" id="custom-content-below-home" role="tabpanel" aria-labelledby="custom-content-below-home-tab">
                                                <div class="tab-content p-0">
                                                    <Scatter :chartData="classifications" :height="300"/>
                                                    <ScatterRf :chartData="classifications" :height="300"/>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="custom-content-below-profile" role="tabpanel" aria-labelledby="custom-content-below-profile-tab">
                                                <ScatterMl :chartData="classifications" :height="300" style="height: 300px"/>
                                                <ScatterMlRf :chartData="classifications" :height="300" style="height: 300px"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                        </div>
                        <!-- /.card -->
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">Statistics</h3>
                            </div>

                            <div class="card-content">
                                <div class="row">
                                    <div class="card-body">
                                        <div class="col-md-12">
                                            <p class="text-center">
                                                <strong>Manual Way</strong>
                                            </p>

                                            <div class="progress-group">
                                                Very high
                                                <span class="float-right"><b>{{classifications.stat ? classifications.stat.manual.vh : 0 }}</b>/{{ classifications.stat ?  classifications.stat.manual.amount : 0}}</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-success" v-if="classifications.stat" :style="'width:' + (classifications.stat.manual.vh * 100) / classifications.stat.manual.amount +'%'"></div>
                                                    <div class="progress-bar bg-success" v-else :style="'width: 0%'"></div>
                                                </div>
                                            </div>
                                            <!-- /.progress-group -->

                                            <div class="progress-group">
                                                High
                                                <span class="float-right"><b>{{classifications.stat ? classifications.stat.manual.h : 0 }}</b>/{{ classifications.stat ? classifications.stat.manual.amount : 0 }}</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-primary" v-if="classifications.stat" :style="'width:' + (classifications.stat.manual.h * 100) / classifications.stat.manual.amount +'%'"></div>
                                                    <div class="progress-bar bg-primary" v-else :style="'width:0%'"></div>
                                                </div>
                                            </div>

                                            <!-- /.progress-group -->
                                            <div class="progress-group">
                                                <span class="progress-text">Medium</span>
                                                <span class="float-right"><b>{{classifications.stat ? classifications.stat.manual.m : 0 }}</b>/{{classifications.stat ? classifications.stat.manual.amount : 0 }}</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-warning"   v-if="classifications.stat" :style="'width:' + (classifications.stat.manual.m * 100) / classifications.stat.manual.amount +'%'"></div>
                                                    <div class="progress-bar bg-warning" v-else :style="'width:0%'"></div>
                                                </div>
                                            </div>

                                            <!-- /.progress-group -->
                                            <div class="progress-group">
                                                Low
                                                <span class="float-right"><b>{{classifications.stat ? classifications.stat.manual.l: 0 }}</b>/{{classifications.stat ? classifications.stat.manual.amount:0 }}</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-danger"  v-if="classifications.stat" :style="'width:' + (classifications.stat.manual.l * 100) / classifications.stat.manual.amount +'%'"></div>
                                                    <div class="progress-bar bg-danger" v-else :style="'width:0%'"></div>
                                                </div>
                                            </div>
                                            <!-- /.progress-group -->
                                        </div>
                                        <br>
                                        <div class="col-md-12">
                                            <p class="text-center">
                                                <strong>Kmeans</strong>
                                            </p>

                                            <div class="progress-group">
                                                First Cluster
                                                <span class="float-right"><b>{{classifications.stat ? classifications.stat.ml.vh:0 }}</b>/{{classifications.stat ? classifications.stat.manual.amount:0 }}</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-success"   v-if="classifications.stat" :style="'width:' + (classifications.stat.ml.vh * 100) / classifications.stat.manual.amount +'%'"></div>
                                                    <div class="progress-bar bg-success" v-else  :style="'width:0%'"></div>
                                                </div>
                                            </div>
                                            <!-- /.progress-group -->

                                            <div class="progress-group">
                                                Second Cluster
                                                <span class="float-right"><b>{{classifications.stat ? classifications.stat.ml.h:0 }}</b>/{{classifications.stat ? classifications.stat.manual.amount:0 }}</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-primary"  v-if="classifications.stat" :style="'width:' + (classifications.stat.ml.h * 100) / classifications.stat.manual.amount +'%'"></div>
                                                    <div class="progress-bar bg-primary" v-else :style="'width:0%'"></div>
                                                </div>
                                            </div>

                                            <!-- /.progress-group -->
                                            <div class="progress-group">
                                                <span class="progress-text">Third Cluster</span>
                                                <span class="float-right"><b>{{classifications.stat ? classifications.stat.ml.m: 0 }}</b>/{{classifications.stat ? classifications.stat.manual.amount:0 }}</span>
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-warning" v-if="classifications.stat"  :style="'width:' + (classifications.stat.ml.m * 100) / classifications.stat.manual.amount +'%'"></div>
                                                    <div class="progress-bar bg-warning" v-else :style="'width: 0%'"></div>
                                                </div>
                                            </div>

                                            <!-- /.progress-group -->
                                            <div class="progress-group">
                                                Fourth Cluster
                                                <span class="float-right"><b>{{classifications.stat ? classifications.stat.ml.l:0 }}</b>/{{classifications.stat ? classifications.stat.manual.amount:0 }}</span>
                                                <div class="progress progress-sm">
                                                    <div v-if="classifications.stat" class="progress-bar bg-danger"  :style="'width:' + (classifications.stat.ml.l * 100) / classifications.stat.manual.amount +'%'"></div>
                                                    <div v-else class="progress-bar bg-danger"  :style="'width: 0%'"></div>
                                                </div>
                                            </div>
                                            <!-- /.progress-group -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- /.card-header -->
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline collapsed-card">
                            <div class="card-header">
                                <h3 class="card-title">Filters</h3>

                                <div class="card-tools">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse"><i class="fas fa-plus"></i>
                                    </button>
                                </div>
                                <!-- /.card-tools -->
                            </div>
                            <!-- /.card-header -->
                            <div class="card-body" style="display: none;">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <!-- text input -->
                                        <div class="form-group">
                                            <label>Name</label>
                                            <input type="text" v-model="filteredName" class="form-control" placeholder="Enter name">
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label>Email</label>
                                            <input type="email" v-model="filteredEmail" class="form-control" placeholder="Enter email">
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="e">RFM score</label>
                                    <input type="number" v-model="filteredRfmScore" step="0.1" min="1"  max="4" class="form-control" id="e" placeholder="Enter email">
                                </div>
                            </div>
                            <div class="card-footer">
                                <button type="submit" @click="filter" class="btn btn-primary">Search</button>
                            </div>
                            <!-- /.card-body -->
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h3 class="card-title">User Classification</h3>
                                <div class="card-tools">
                                    <a :href="`/api/users/without/graph/file?rfm=${filteredRfmScore ? filteredRfmScore : ''}&name=${filteredName ? filteredName: ''}&email=${filteredEmail ? filteredEmail : ''}`"><button class="btn btn-block btn-outline-info btn-flat">
                                        <i class="fas fa-save"></i> Download
                                    </button>
                                    </a>
                                </div>
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
                                        <th>Recency</th>
                                        <th>Frequency</th>
                                        <th>Monetary</th>
                                        <th>KMeans Score</th>
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
                                        <td>{{ user.ml }}</td>
                                        <td>{{ user.score }}</td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer clearfix">
                                <ul class="pagination pagination-sm m-0 float-right">
                                    <li class="page-item"><button :disabled="pageNumber == 1" class="dis page-link" @click="prevPage">Prev</button></li>
                                    <li class="page-item"><button :disabled="pageNumber == users.meta.last_page" class="dis page-link" @click="nextPage">Next</button></li>
                                </ul>
                            </div>
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
    import ScatterRf from '../components/RfmScatterRf'
    import ScatterMl from '../components/RfmScatterMl'
    import ScatterMlRf from '../components/RfmScatterMlRf'
    import {mapGetters} from 'vuex'

    export default {
        components: {
            Scatter,
            ScatterRf,
            ScatterMl,
            ScatterMlRf
        },
        computed: {
            ...mapGetters({
                classifications: 'getClassifications',
                users: 'getUsersWithoutGraph',
            }),
            fill() {
                if (this.classifications) {
                   this.manual.vh = this.classifications.manual.vh
                }
            }
        },
        data() {
            return {
                pageNumber: 1,
                filteredName: null,
                filteredEmail: null,
                filteredRfmScore: null,
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
                this.$store.dispatch('fetchUsersWithoutGraph',  {
                    page: page,
                    rfm: this.filteredRfmScore,
                    name: this.filteredName,
                    email: this.filteredEmail,
                })
            },
            nextPage(){
                this.fetchUsers(++this.pageNumber)
            },
            prevPage(){
                this.fetchUsers(--this.pageNumber)
            },
            filter() {
                this.$store.dispatch('fetchUsersWithoutGraph', {
                    page:1,
                    rfm: this.filteredRfmScore,
                    name: this.filteredName,
                    email: this.filteredEmail,
                })
            },
        }
    }
</script>

<style scoped>
    .dis:disabled {
        color: #000;

    }
    .dis:disabled:hover {
        background-color:#fff;
    }
</style>
