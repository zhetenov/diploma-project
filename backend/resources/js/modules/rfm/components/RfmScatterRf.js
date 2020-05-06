import {mixins, Scatter} from 'vue-chartjs'

export default {
    extends: Scatter,
    mixins: [mixins.reactiveProp],
    props: ['chartData', 'options', 'copy'],
    mounted () {
        this.renderChart({
            datasets: [
                {
                    label: 'Scatter Dataset 1',
                    fill: false,
                    borderColor: '#f87979',
                    backgroundColor: '#f87979',
                    data: []
                },
                {
                    label: 'Scatter Dataset 2',
                    fill: false,
                    borderColor: '#7acbf9',
                    backgroundColor: '#7acbf9',
                    data: []
                },
                {
                    label: 'Scatter Dataset 2',
                    fill: false,
                    borderColor: '#7acbf9',
                    backgroundColor: '#7acbf9',
                    data: []
                },
                {
                    label: 'Scatter Dataset 2',
                    fill: false,
                    borderColor: '#7acbf9',
                    backgroundColor: '#7acbf9',
                    data: []
                }
            ]
        }, {responsive: true, maintainAspectRatio: false})
    },
    watch: {
        'chartData': {
            handler(newOption, oldOption) {
                console.log('asdasd',this.chartData);
                this.renderChart({
                    datasets: [
                        {
                            label: 'Very high',
                            fill: '+2',
                            borderColor: '#39f507',
                            backgroundColor: '#39f507',
                            data: this.chartData.manual.rf.v_high
                        },
                        {
                            label: 'High',
                            fill: '+2',
                            borderColor: '#0606f6',
                            backgroundColor: '#0606f6',
                            data: this.chartData.manual.rf.high,
                        },
                        {
                            label: 'Medium',
                            fill: '+2',
                            borderColor: '#eff70a',
                            backgroundColor: '#eff70a',
                            data: this.chartData.manual.rf.medium
                        },
                        {
                            label: 'Low',
                            fill: '+2',
                            borderColor: '#ff2011',
                            backgroundColor: '#ff2011',
                            data: this.chartData.manual.rf.low
                        }
                    ]
                }, {responsive: true,
                    maintainAspectRatio: false,
                    tooltips: {
                        callbacks: {
                            label: function(tooltipItem, data) {
                                return data.datasets[tooltipItem.datasetIndex].data[tooltipItem.index].u;
                            }
                        }
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    return value+' days';
                                }
                            }
                        }],
                        yAxes: [{
                            ticks: {
                                // Include a dollar sign in the ticks
                                callback: function(value, index, values) {
                                    return value+' buys';
                                }
                            }
                        }]
                    },
                    title: {
                        display: true,
                        text: 'Recency-Frequency Graph'
                    },
                    onClick: function(evt) {

                        let element = this.getElementAtEvent(evt);
                        if(element.length > 0) {
                            var datasetIndex = element[0]._datasetIndex;
                            var index = element[0]._index;
                            simplecopy(element[0]._chart.config.data.datasets[datasetIndex].data[index].u)
                            Vue.$toast.open({
                                message: 'Copied to Clipboard',
                                type: 'info',
                                position: 'top-right',
                                duration: 5000
                            });

                        }
                    }
                })
            },
            deep: true
        }
    }
}