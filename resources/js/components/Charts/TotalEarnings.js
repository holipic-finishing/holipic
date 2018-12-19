import { Line } from 'vue-chartjs'
import config from '../../config/index.js'
import Vue from 'vue'
import moment from "moment"


export default {
  extends: Line,
  props:['companyId'],
  data() {
    return {
      data: [],
      labels: [],
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

        //this.labels = res.data.labels;
        //this.data = res.data.data;
    
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

    let datasets = []

    var _this = this

    _.forEach(data, function(item, key){

        var color = ''
        switch(key) {
            case "€":
                color = _this.gradient1;
                break;
            case "$":
                color = _this.gradient2;
                break;
            case "VND":
                color = "green";
                break;
            default:
                color = "blue";
        }
        
        let tmp = {
              label: key,
              lineTension: 0.4,
              borderColor: color,
              pointBorderColor: color,
              pointBorderWidth: 2,
              pointRadius: 7,
              fill: false,
              pointBackgroundColor: '#FFF',
              borderWidth: 3,
              data: _this.showPrice(item)
        }
      datasets.push(tmp)

    })

         this.renderChart({
          labels: labels, 
          datasets:  datasets
            // {
            //   label: 'Open Rate',
            //   lineTension: 0.4,
            //   borderColor: this.gradient2,
            //   pointBorderColor: this.gradient2,
            //   pointBorderWidth: 2,
            //   pointRadius: 7,
            //   fill: false,
            //   pointBackgroundColor: '#FFF',
            //   borderWidth: 3,
            //   data: [10,20,50]
            // },
    
            // {
            //   label: 'Open Rate4',
            //   lineTension: 0.4,
            //   borderColor: this.gradient1,
            //   pointBorderColor: this.gradient1,
            //   pointBorderWidth: 2,
            //   pointRadius: 7,
            //   fill: false,
            //   pointBackgroundColor: '#FFF',
            //   borderWidth: 3,
            //   data: prices4
            // } 
            
        }, this.options)
    },
    
    renderData(data, labels) {
        
        // let Days = new Array();
        // let Prices = new Array();
        // let prices2 = new Array();
        // let prices3 = new Array();
        // let prices4 = new Array();
       

        // const origin = data["3"];
        // for (let i = 0; i < origin.length; i++) {
        //     Days.push(origin[i].date);
        //     Prices.push(this.getDefIfNotExist(data["2"][i] ));
        //     prices2.push(this.getDefIfNotExist(data["3"][i]));
        //     prices3.push(this.getDefIfNotExist(data["4"][i]));
        //    // prices4.push(this.getDefIfNotExist(data["5"][i]));
        // }
       
        // _.forEach(data, function(item, key){
        //     Days.push(item)
        //   _.forEach(Days, function(value, index) {

        //       // console.log(value)
        //   });

        //     // Days.push(moment(element.date, 'YYYY-MM-DD').format('DD-MM-YY'));
            
        //     // Prices.push(element.total)
        // });

        // this.days = Days;
        // this.prices = Prices;
        // this.prices2 = prices2;
        // this.prices3 = prices3;
        // this.prices4 = prices4;
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
                //this.renderChartData(response.data.data.data,this.days,this.prices, this.prices2, this.prices3, this.prices4, this.chartLabels)
                this.renderChartData(response.data.data.data, this.chartLabels)

            }
        })
    }
  }
}
