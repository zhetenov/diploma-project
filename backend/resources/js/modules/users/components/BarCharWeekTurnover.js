import { Bar, mixins } from 'vue-chartjs'

export default {
    extends: Bar,
    mixins: [mixins.reactiveProp],
    props: ['chartData', 'options'],
    mounted () {
        console.log(this.chartData);
        this.renderChart({
            labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
            datasets: []
        })
    },
    watch: {
        'chartData': {
            handler(newOption, oldOption) {
                console.log(this.chartData);
                this.renderChart({
                    labels: ['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday'],
                    datasets: [
                        {
                            label: 'Turnover groupped by week',
                            backgroundColor: '#f87979',
                            data: this.chartData.weekly_turnover
                        }
                    ]
                })
            },
            deep: true
        }
    }
}