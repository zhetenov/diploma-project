<template>
    <div>
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Statistics</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active">Statistics</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">

            <!-- Default box -->
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Dashboard</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Sales</span>
                                    <span class="info-box-number">{{ statistics.sales}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>

                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-coins"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Turnover</span>
                                    <span class="info-box-number">
                                     {{statistics.turnover}}
                </span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-sort-amount-up"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">Last Order</span>
                                    <span class="info-box-number">{{statistics.last_order}}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->

                        <!-- fix for small devices only -->
                        <div class="clearfix hidden-md-up"></div>

                        <!-- /.col -->
                        <div class="col-12 col-sm-6 col-md-3">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-users"></i></span>

                                <div class="info-box-content">
                                    <span class="info-box-text">New Members</span>
                                    <span class="info-box-number">{{ statistics.users }}</span>
                                </div>
                                <!-- /.info-box-content -->
                            </div>
                            <!-- /.info-box -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <BarChartMonthTurnover
                            :chartData="statistics.data"/>
                        </div>
                        <div class="col-md-6">
                            <BarChartWeekTurnover
                                :chartData="statistics.data"/>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <!-- /.card-footer-->
            </div>
            <!-- /.card -->

        </section>
    </div>
</template>

<script>
    import {mapGetters} from 'vuex'
    import BarChartMonthTurnover from '../components/BarChartMonthTurnover'
    import BarChartWeekTurnover from '../components/BarCharWeekTurnover'

    export default {
        components: {
            BarChartMonthTurnover,
            BarChartWeekTurnover
        },
        data() {
            return {
            }
        },
        computed: {
            ...mapGetters({
                statistics: 'getMainStatistics',
            })
        },
        created() {
            this.$store.dispatch('fetchStatistics')
        },
        methods: {

        }
    }
</script>

<style scoped>

</style>
