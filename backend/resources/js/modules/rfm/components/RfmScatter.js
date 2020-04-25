import {mixins, Scatter} from 'vue-chartjs'

export default {
    extends: Scatter,
    mixins: [mixins.reactiveProp],
    props: ['chartData', 'options'],
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
                console.log(this.chartData);
                this.renderChart({
                    datasets: [
                        {
                            label: 'Very high',
                            fill: false,
                            borderColor: '#f87979',
                            backgroundColor: '#387979',
                            data: this.chartData[0].vHigh
                        },
                        {
                            label: 'High',
                            fill: '+2',
                            borderColor: '#7abbf9',
                            backgroundColor: '#7abbf9',
                            data: this.chartData[0].high,
                        },
                        {
                            label: 'Medium',
                            fill: '+2',
                            borderColor: '#7acbb9',
                            backgroundColor: '#7acbb9',
                            data: this.chartData[0].medium
                        },
                        {
                            label: 'Low',
                            fill: false,
                            borderColor: '#7acbf0',
                            backgroundColor: '#7acbf0',
                            data: this.chartData[0].low
                        }
                    ]
                }, {responsive: true, maintainAspectRatio: false})
            },
            deep: true
        }
    }
}