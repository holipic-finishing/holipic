import { Line, mixins } from 'vue-chartjs'
import config from '../../config/index.js'
import Vue from 'vue'
import moment from "moment";
const { reactiveProp } = mixins

export default {
  extends: Line,
  props:['companyId'],
  mixins: [reactiveProp],
  data() {
    return {
      data: [],
      gradient1: null,
      gradient2: null,
      options: {
        scales: {
          yAxes: [{
            gridLines: {
              display: true,
              drawBorder: false
            },
            ticks: {
              stepSize: 500
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
        days:null,
        prices:null

      }
    }
  },
  created(){
    this.fetchData();
  },
  mounted() {
    
    this.$root.$on('companyChart', res => {
        console.log(res)
        this.renderData(res)
        this.renderChartData(this.days,this.prices)
    });


  },
  methods: {
    renderChartData(days,prices){

    let ctx = this.$refs.canvas.getContext('2d')
    let _stroke = ctx.stroke
    ctx.stroke = function () {
      ctx.save()
      ctx.shadowColor = 'rgba(0,0,0,0.6)'
      ctx.shadowBlur = 22
      ctx.shadowOffsetX = 0
      ctx.shadowOffsetY = 15
      _stroke.apply(this, arguments)
      ctx.restore()
    }

    this.gradient1 = this.$refs.canvas.getContext('2d').createLinearGradient(1000, 0, 100, 0)
    this.gradient2 = this.$refs.canvas.getContext('2d').createLinearGradient(1000, 0, 100, 0)

    this.gradient1.addColorStop(0, '#1E3C72')
    this.gradient1.addColorStop(1, '#3B7CFF')

    this.gradient2.addColorStop(0, '#F7981C')
    this.gradient2.addColorStop(1, '#F56074')


     this.renderChart({
          labels: days,
          datasets: [
            {
              label: 'Open Rate',
              lineTension: 0.4,
              borderColor: this.gradient2,
              pointBorderColor: this.gradient2,
              pointBorderWidth: 2,
              pointRadius: 7,
              fill: false,
              pointBackgroundColor: '#FFF',
              borderWidth: 3,
              data: prices
            },
            {
              label: 'Open Rate2',
              lineTension: 0.4,
              borderColor: this.gradient1,
              pointBorderColor: this.gradient1,
              pointBorderWidth: 2,
              pointRadius: 7,
              fill: false,
              pointBackgroundColor: '#FFF',
              borderWidth: 3,
              data: [2000,5000]
            }
            
          ]
        }, this.options)
    },
    renderData(data) {
        let Days = new Array();
        let Prices = new Array();
        data.forEach(element => {
            
            Days.push(moment(element.date, 'YYYY-MM-DD').format('DD-MM-YY'));
            
            Prices.push(element.total)
        });
        this.days = Days
        this.prices = Prices
    },
    
    fetchData() {
        axios.get(config.API_URL+'company/total-amount?companyId='+this.companyId)
        .then(response => {
            if(response && response.data.success) {
                this.renderData(response.data.data)
                this.renderChartData(this.days,this.prices)
            }
        })
    }
  }
}
