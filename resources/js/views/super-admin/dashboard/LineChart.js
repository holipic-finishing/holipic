import {
    Line
} from 'vue-chartjs'
import moment from "moment"
import {
    ChartConfig
} from "../../../constants/chart-config"
import {
    hexToRgbA
} from "../../../helpers/helpers"
import {
    get,
    getWithData
} from '../../../api/index.js'


export default {
    extends: Line,
    data() {
        return {
            dataUsd: [],
            dataIdr: [],
            labels: [],
            gradient1: null,
            gradient2: null,
            line: null,
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            display: false
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false,
                            drawTicks: false
                        }
                    }],
                    xAxes: [{
                        ticks: {
                            display: true,
                            beginAtZero: true
                        },
                        gridLines: {
                            display: false,
                            drawBorder: false
                        }
                    }]
                },
                legend: {
                    display: false
                }
            },
            chooes: ''
        }
    },
    created() {
        this.fetchData();
    },

    mounted() {

        this.$root.$on('companyChart', res => {
            this.getData(res.params)
            this.chooes = res.chooes
        });

        this.$root.$on('load-total-transactions', res => {
            this.getData(res.params)
        })
    },

    methods: {
        renderChartData(labels, dataUsd, dataIdr) {

            let gradientColor = ' '
            // this.gradient1 = this.$refs.canvas.getContext('2d').createLinearGradient(200, 200, 200, 200)
            // this.gradient1.addColorStop(0, hexToRgbA(ChartConfig.color.white, 0.2))
            // this.gradient1.addColorStop(0.5, hexToRgbA(ChartConfig.color.info, 0.2))
            //
            // this.gradient2 = this.$refs.canvas.getContext('2d').createLinearGradient(200, 0, 0, 0)
            // this.gradient2.addColorStop(0, hexToRgbA(ChartConfig.color.white, 0.2))
            // this.gradient2.addColorStop(0.5, hexToRgbA(ChartConfig.color.info, 0.2))
            this.gradient = this.$refs.canvas
              .getContext("2d")
              .createLinearGradient(0, 0, 0, 450);
            this.gradient2 = this.$refs.canvas
              .getContext("2d")
              .createLinearGradient(0, 0, 0, 450);

            this.gradient.addColorStop(0, "rgba(255, 0,0, 0.5)");
            this.gradient.addColorStop(0.5, "rgba(255, 0, 0, 0.25)");
            this.gradient.addColorStop(1, "rgba(255, 0, 0, 0)");

            this.gradient2.addColorStop(0, "rgba(0, 231, 255, 0.9)");
            this.gradient2.addColorStop(0.5, "rgba(0, 231, 255, 0.25)");
            this.gradient2.addColorStop(1, "rgba(0, 231, 255, 0)");

            this.renderChart({
                labels: labels,
                datasets: [{
                    label: 'Total Transaction USD',
                    data: dataUsd,
                    // backgroundColor: this.gradient1,
                    // backgroundColor: 'transparent',
                    // borderColor: 'rgba(1, 116, 188, 0.50)',
                    // pointBackgroundColor: 'rgba(171, 71, 188, 1)',
                    // lineTension: 0.4,
                    borderColor: "#FC2525",
                    pointBackgroundColor: "white",
                    borderWidth: 1,
                    pointBorderColor: "white",
                    backgroundColor: this.gradient,
                    // pointBorderColor: '#17a2b8',
                    // pointBorderWidth: 2,
                    // pointRadius: 2,
                    // pointBackgroundColor: '#FFF',
                    // borderWidth: 3,
                    fill: true
                },
                {
                    label: 'Total Transaction IDR',
                    data: dataIdr,
                    // backgroundColor: 'transparent',
                    // borderColor: ChartConfig.color.info,
                    // lineTension: 0.4,
                    borderColor: "#05CBE1",
                    pointBackgroundColor: "white",
                    pointBorderColor: "white",
                    borderWidth: 1,
                    backgroundColor: this.gradient2,
                    // pointBorderColor: '#17a2b8',
                    // pointBorderWidth: 2,
                    // pointRadius: 2,
                    // pointBackgroundColor: '#FFF',
                    // borderWidth: 3,
                    fill: true
                }]
            }, this.options);
        },

        fetchData() {
            let params = {
                defaultDay: 'default'
            }
            this.getData(params);
        },

        getData(params) {

            getWithData('super-admin-chart-report', params)
                .then((res) => {
                    if (res.success && res) {
                      // console.log(res);
                        if (this.chooes == "Week") {
                            var dataWeek = []
                            var totalIdr = 0
                            var totalUsd = 0
                            _.forEach(res.data, function (value, key) {
                                dataWeek.unshift(value);
                                totalUsd = totalUsd + parseFloat(value.totalUsd)
                                totalIdr = totalIdr + parseFloat(value.totalIdr)

                            });
                            totalUsd = totalUsd.toFixed(3)
                            totalIdr = totalIdr.toFixed(2)

                            this.$root.$emit('totalTransaction', {
                              totalUsd: totalUsd,
                              totalIdr: totalIdr
                            })
                            this.handleDataWeek(dataWeek);
                            this.getStartWeekAndEndWeekWithValue(dataWeek, this.chooes)



                        } else {
                            var totalIdr = 0
                            var totalUsd = 0
                            _.forEach(res.data, function (value, key) {
                                totalUsd = totalUsd + parseFloat(value.totalUsd)
                                totalIdr = totalIdr + parseFloat(value.totalIdr)
                            });
                            totalUsd = totalUsd.toFixed(3)
                            totalIdr = totalIdr.toFixed(2)
                            this.$root.$emit('totalTransaction',{
                            totalUsd: totalUsd,
                            totalIdr: totalIdr
                            })
                            this.handleDataDaily(res.data);
                            this.getStartTimeAndEndTimeWithValue(res.data, this.chooes)

                        }
                    }

                })
                .catch((err) => {
                    console.log(err)
                })
        },

        handleDataDaily(data) {
          // console.log(data);
            var lables = []
            var totalUsd = []
            var totalIdr = []
            _.forEach(data, function (value, key) {
                lables.push(key)
                totalUsd.push(value.totalUsd)
                totalIdr.push(value.totalIdr)
            });

            // console.log('IDR : '+totalIdr);
            // console.log('IDR : '+totalIdr);

            this.renderChartData(lables, totalUsd, totalIdr);

        },

        handleDataWeek(data) {
          // console.log(data);
            var lables = []
            var totalUsd = []
            var totalIdr = []
            _.forEach(data, function (value, key) {
                lables.push(moment(value['startOfWeek']).format('MM-DD') + ' / ' + moment(value['endOfWeek']).format('MM-DD'))
                totalUsd.push(value.totalUsd)
                totalIdr.push(value.totalIdr)
            });
            this.renderChartData(lables, totalUsd, totalIdr);

        },

        getStartWeekAndEndWeekWithValue(obj, typeTime) {
            var keys, firstKey, lastKey
            keys = Object.keys(obj)
            firstKey = Object.keys(obj)[0]
            lastKey = keys[keys.length - 1]
            var timeObj = {
                "firstTime": "",
                "lastTime": "",
                "typeTime": typeTime
            }

            _.forEach(obj, function (value, key) {
                if (key == firstKey) {
                    timeObj.firstTime = value.startOfWeek
                }
                if (key == lastKey) {
                    timeObj.lastTime = value.endOfWeek
                }
            })
            this.$root.$emit('load-time-in-menu-filter', timeObj)
        },

        getStartTimeAndEndTimeWithValue(obj, typeTime) {
            var keys, firstKey, lastKey
            keys = Object.keys(obj)
            firstKey = Object.keys(obj)[0]
            lastKey = keys[keys.length - 1]
            var timeObj = {
                "firstTime": firstKey,
                "lastTime": lastKey,
                "typeTime": typeTime
            }
            this.$root.$emit('load-time-in-menu-filter', timeObj)
        },


    }
}
