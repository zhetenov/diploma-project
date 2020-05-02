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
                            borderColor: '#39f507',
                            backgroundColor: '#39f507',
                            data: this.chartData[0].v_high
                        },
                        {
                            label: 'High',
                            fill: '+2',
                            borderColor: '#0606f6',
                            backgroundColor: '#0606f6',
                            data: this.chartData[0].high,
                        },
                        {
                            label: 'Medium',
                            fill: '+2',
                            borderColor: '#eff70a',
                            backgroundColor: '#eff70a',
                            data: this.chartData[0].medium
                        },
                        {
                            label: 'Low',
                            fill: false,
                            borderColor: '#ff2011',
                            backgroundColor: '#ff2011',
                            data: this.chartData[0].low
                        }
                    ]
                }, {responsive: true, maintainAspectRatio: false})
            },
            deep: true
        }
    }
}