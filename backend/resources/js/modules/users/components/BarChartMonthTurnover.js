import { Bar, mixins } from 'vue-chartjs'

export default {
    extends: Bar,
    mixins: [mixins.reactiveProp],
    props: ['chartData', 'options'],
    mounted () {
        console.log(this.chartData);
        this.renderChart({
            labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: []
        })
    },
    watch: {
        'chartData': {
            handler(newOption, oldOption) {
                console.log(this.chartData);
                this.renderChart({
                    labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                    datasets: [
                        {
                            label: 'Turnover groupped by month',
                            backgroundColor: '#f87979',
                            data: this.chartData.annual_turnover
                        }
                    ]
                })
            },
            deep: true
        }
    }
}