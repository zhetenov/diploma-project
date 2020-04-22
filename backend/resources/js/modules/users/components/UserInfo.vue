<template>
    <div>
        <div class="modal fade" id="modal-xl">
            <div class="modal-dialog modal-xl">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">User statistics</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-12">
                                <BarChartMonthTurnover
                                     :height="100"
                                     :chart-data="data"
                                     :options="getOptions"
                                />
                            </div>
                            <div class="col-md-12">
                                <BarChartWeeklyTurnover
                                        :height="100"
                                        :chart-data="data"
                                        :options="getOptions"
                                />
                            </div>
                            <div class="col-md-12">
                                <BarChartMonthTransactions
                                        :height="100"
                                        :chart-data="data"
                                        :options="getOptions"
                                />
                            </div>
                            <div class="col-md-12">
                                <BarChartWeeklyTransaction
                                        :height="100"
                                        :chart-data="data"
                                        :options="getOptions"
                                />
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
        <!-- /.modal -->
    </div>
</template>

<script>
    import BarChartMonthTurnover from './BarChartMonthTurnover'
    import BarChartMonthTransactions from './BarChartMonthTransactions'
    import BarChartWeeklyTurnover from './BarCharWeekTurnover'
    import BarChartWeeklyTransaction from './BarChartWeeklyTransactions'

    export default {
        components: {
            BarChartMonthTurnover,
            BarChartWeeklyTurnover,
            BarChartMonthTransactions,
            BarChartWeeklyTransaction
        },
        name: "UserInfo",
        props: {
            data: {required: true}
        },
        data() {
            return {

            };
        },
        computed: {

        },
        methods: {
            getOptions() {
                return {
                    responsive: true,
                    maintainAspectRatio: true,
                    scaleShowLabels : false,
                    scales: {
                        xAxes: [{
                            display: false
                        }]
                    },
                    title: {
                        display: true,
                        text: 'good'
                    },
                    label: data.annual_turnover
                }
            },
            click() {
                console.log(this.data)
            }
        }
    }
</script>

<style scoped>
</style>