import { Line } from 'vue-chartjs'
import config from '../../../config/index.js'
import Vue from 'vue'
import moment from "moment"
import {ChartConfig} from "../../../constants/chart-config"
import {hexToRgbA} from "../../../helpers/helpers"


export default {
  extends: Line,
  props:['companyId'],
  data() {
    return {
      data: [],
      labels: [],
      gradient1: null,
      gradient2: null,
      gradient3: null,
      gradient4: null,
      line1: null,
      line2:null,
      line3:null,
      line4:null,

      options: {
        scales: {
          yAxes: [{
            gridLines: {
              display: true,
              drawBorder: false
            },
            ticks: {
              stepSize: 500
              //display:false
            }
          }],
          xAxes: [{
            gridLines: {
              display: false,
              drawBorder: false
            }
          }]
        },
        legend: {
          display: true
        },
        responsive: true,
        maintainAspectRatio: false,
        days:[],
        prices:[],
        prices2:[],
        prices3:[],
        prices4:[]

      }
    }
  },
  created(){
    this.fetchData();

  },

  mounted() {
    
    this.$root.$on('companyChart', res => {

        this.renderData(res.data, res.labels);
        this.renderChartData(res.data, this.chartLabels)
    });
  },

  methods: {
    //renderChartData(data,days,prices, prices2,prices3, prices4, labels ){
    renderChartData(data, labels ){

    let ctx = this.$refs.canvas.getContext('2d')
    let _stroke = ctx.stroke
    ctx.stroke = function () {
      ctx.save()
      ctx.shadowColor = 'rgba(0,0,0,0.6)'
      ctx.shadowBlur = 8
      ctx.shadowOffsetX = 0
      ctx.shadowOffsetY = 4
      _stroke.apply(this, arguments)
      ctx.restore()
    }

    this.gradient1 = this.$refs.canvas.getContext('2d').createLinearGradient(1000, 0, 100, 0)

    this.gradient2 = this.$refs.canvas.getContext('2d').createLinearGradient(1000, 0, 100, 0)

    this.gradient3 = this.$refs.canvas.getContext('2d').createLinearGradient(1000, 0, 100, 0)

    this.gradient4 = this.$refs.canvas.getContext('2d').createLinearGradient(1000, 0, 100, 0)

    this.gradient1.addColorStop(0, hexToRgbA('#6eaeef', 0.1))
    this.gradient1.addColorStop(0.5, hexToRgbA('#0a6b99', 0.2))

    this.gradient2.addColorStop(0, hexToRgbA(ChartConfig.color.white, 0.1))
    this.gradient2.addColorStop(0.5, hexToRgbA('#F7981C', 0.2))

    this.gradient3.addColorStop(0, hexToRgbA(ChartConfig.color.white, 0.1))
    this.gradient3.addColorStop(0.5, hexToRgbA('#11e0c8', 0.2))

    this.gradient4.addColorStop(0, hexToRgbA(ChartConfig.color.white, 0.1))
    this.gradient4.addColorStop(0.5, hexToRgbA('#4a9e1e', 0.2))

    this.line1 = this.$refs.canvas.getContext('2d').createLinearGradient(1000, 0, 100, 0)
    this.line1.addColorStop(0, '#1E3C72')
    this.line1.addColorStop(1, '#3B7CFF')

    this.line2 = this.$refs.canvas.getContext('2d').createLinearGradient(1000, 0, 100, 0)
    this.line2.addColorStop(0, '#F7981C')
    this.line2.addColorStop(1, '#F56074')

    this.line3 = this.$refs.canvas.getContext('2d').createLinearGradient(1000, 0, 100, 0)
    this.line3.addColorStop(0, '#37b7a8')
    this.line3.addColorStop(1, '#13af9d')

    this.line4 = this.$refs.canvas.getContext('2d').createLinearGradient(1000, 0, 100, 0)
    this.line4.addColorStop(0, '#ed9b61')
    this.line4.addColorStop(1, '#bf6220')

    let datasets = []

    var _this = this

    _.forEach(data, function(item, key){

        var color = ''
        var line = ''

        switch(key) {
            case "€":
                color = _this.gradient1;
                line = _this.line1
                break;
            case "$":
                color = _this.gradient2;
                line = _this.line2;
                break;
            case "VND":
                color = _this.gradient3;
                line = _this.line3
                break;
            default:
                color = _this.gradient1;
                line = _this.line4
    }
        
        let tmp = {
              label: key,
              lineTension: 0.4,
              borderColor: line,
              pointBorderColor: line,
              pointBorderWidth: 2,
              pointRadius: 7,
              backgroundColor: color,
              pointBackgroundColor: '#FFF',
              borderWidth: 3,
              data: _this.showPrice(item),
              fill: true
        }
      datasets.push(tmp)

    })

        this.renderChart({
          labels: labels, 
          datasets:  datasets     
        }, this.options)
    },
    
    renderData(data, labels) {
        
         let Labels = new Array();

        _.forEach(labels, function(value, index) {
            Labels.push(moment(value['date'], 'YYYY-MM-DD').format('DD-MM-YY'));
        });

        this.chartLabels = Labels;   
    },

    getDefIfNotExist(value) {
        if (typeof value !== 'undefined')
            return value.total;
        return 0;
    },

    showPrice(data) {
      let dataPrices = new Array()

      _.forEach(data, function(item, key) {
           dataPrices.push(item)
      });

      return dataPrices; 
    },
    
    fetchData() {
        axios.get(config.API_URL+'company/information?companyId='+this.companyId)
        .then(response => {
            if(response && response.data.success) {
                
                this.renderData(response.data.data.data, response.data.data.labels)
                this.renderChartData(response.data.data.data, this.chartLabels)

            }
        })
    }
  }
}
